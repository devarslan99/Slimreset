<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
include_once __DIR__ . '/../../database/db_connection.php';

class ChatServer implements MessageComponentInterface
{
    protected $clients;
    protected $mysqli;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        global $mysqli;
        $this->mysqli = $mysqli;

        if ($this->mysqli->connect_error) {
            die("Database connection failed: " . $this->mysqli->connect_error);
        }
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        // Get the list of previous messages for the current chat
        $params = $conn->httpRequest->getUri()->getQuery();
        parse_str($params, $query);
        $from_user_id = $query['from_user_id'];
        $to_user_id = $query['to_user_id'];

        // Fetch previous messages and send them to the connected user
        $messages = $this->getPreviousMessages($from_user_id, $to_user_id);
        foreach ($messages as $message) {
            $conn->send(json_encode($message));
        }

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if ($data === null) {
            echo "Failed to decode JSON. Invalid format.\n";
            return;
        }

        // Check if the message format is correct
        if (isset($data['from_user_id'], $data['to_user_id'], $data['message'])) {
            $sender_id = $data['from_user_id'];
            $receiver_id = $data['to_user_id'];
            $message = $data['message'];

            // Get or create the chat ID between the sender and receiver
            $chat_id = $this->getChatId($sender_id, $receiver_id);
            if (!$chat_id) {
                $chat_id = $this->createChat($sender_id, $receiver_id);
            }

            // Save the message to the database
            $this->saveMessageToDatabase($chat_id, $sender_id, $receiver_id, $message);

            // Prepare notification data
            $notificationData = $this->prepareNotificationData($sender_id, $receiver_id, $message);

            // Broadcast the chat message to the sender and receiver only
            $this->sendMessageToClients($sender_id, $receiver_id, $message);

            // Broadcast the notification to all clients
            foreach ($this->clients as $client) {
                $client->send(json_encode($notificationData));
            }
        } else {
            echo "Invalid message format received.\n";
        }
    }

    private function sendMessageToClients($sender_id, $receiver_id, $message)
    {
        $chatMessageData = [
            'type' => 'chat',
            'from_user_id' => $sender_id,
            'to_user_id' => $receiver_id,
            'message' => $message,
            'sent_at' => date('Y-m-d H:i:s')
        ];

        // Send the message to both the sender and the receiver
        foreach ($this->clients as $client) {
            if ($client->resourceId === $sender_id || $client->resourceId === $receiver_id) {
                $client->send(json_encode($chatMessageData));
            }
        }
    }

    private function prepareNotificationData($sender_id, $receiver_id, $message)
    {
        // Fetch sender details to create a notification
        $senderData = $this->getUserDetails($sender_id, $receiver_id);

        return [
            'type' => 'notification',
            'sender_id' => $senderData['sender_id'],
            'receiver_id' => $senderData['receiver_id'],
            'message_id' => $senderData['message_id'],
            'sender_name' => $senderData['sender_name'],
            'sender_profile_image' => $senderData['sender_profile_image'],
            'message' => $message,
            'sent_at' => date('Y-m-d H:i:s'),
            'is_read' => 0
        ];
    }

    private function getUserDetails($sender_id, $receiver_id)
    {
        $query = "
        SELECT 
        m.id AS message_id,
        m.message,
        m.sent_at,
        m.is_read,
        u_sender.id AS sender_id,
        u_receiver.id AS receiver_id,
        CONCAT(u_sender.first_name, ' ', u_sender.last_name) AS sender_name,
        u_sender.profile_image AS sender_profile_image
    FROM 
        messages m
    JOIN 
        users u_sender ON m.sender_id = u_sender.id
    JOIN 
        users u_receiver ON m.receiver_id = u_receiver.id
    WHERE 
        (m.sender_id = ? AND m.receiver_id = ?) 
        OR 
        (m.sender_id = ? AND m.receiver_id = ?)
        AND
        m.is_read = 0
    ORDER BY 
        m.sent_at DESC
    LIMIT 5
    ";

        // Prepare the statement
        $stmt = $this->mysqli->prepare($query);

        // Bind parameters - we now need four integers: sender_id and receiver_id twice
        $stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);

        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the result
        return $result->fetch_assoc();
    }

    // Fetch previous messages from the database with user details
    private function getPreviousMessages($user_one_id, $user_two_id)
    {
        $query = "
            SELECT 
                m.id AS message_id,
                m.message,
                m.sent_at,
                m.is_read,
                u_sender.id AS sender_id,
                u_receiver.id AS receiver_id,
                CONCAT(u_sender.first_name, ' ', u_sender.last_name) AS sender_name,
                u_sender.profile_image AS sender_profile_image
            FROM 
                messages m
            JOIN 
                users u_sender ON m.sender_id = u_sender.id
            JOIN 
                users u_receiver ON m.receiver_id = u_receiver.id
            WHERE 
                (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?)
            ORDER BY 
                m.sent_at ASC
        ";

        $stmt = $this->mysqli->prepare($query);

        // Bind parameters for sender and receiver (4 parameters total)
        $stmt->bind_param("iiii", $user_one_id, $user_two_id, $user_two_id, $user_one_id);

        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();

        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = [
                'type' => 'previous-messages',
                'message_id' => $row['message_id'],
                'sender_id' => $row['sender_id'],
                'receiver_id' => $row['receiver_id'],
                'message' => $row['message'],
                'sent_at' => $row['sent_at'],
                'is_read' => $row['is_read'],
                'sender_name' => $row['sender_name'],
                'sender_profile_image' => $row['sender_profile_image']
            ];
        }

        return $messages;
    }


    // Get or create chat between users
    private function getChatId($user_one_id, $user_two_id)
    {
        $query = "SELECT id FROM chats WHERE (user_one_id = ? AND user_two_id = ?) OR (user_one_id = ? AND user_two_id = ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param("iiii", $user_one_id, $user_two_id, $user_two_id, $user_one_id);
        $stmt->execute();
        $stmt->bind_result($chat_id);
        $stmt->fetch();
        $stmt->close();

        return $chat_id ? $chat_id : null;
    }

    private function createChat($user_one_id, $user_two_id)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO chats (user_one_id, user_two_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_one_id, $user_two_id);
        $stmt->execute();
        return $this->mysqli->insert_id;
    }

    private function saveMessageToDatabase($chat_id, $sender_id, $receiver_id, $message)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO messages (chat_id, sender_id, receiver_id, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $chat_id, $sender_id, $receiver_id, $message);
        $stmt->execute();
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
