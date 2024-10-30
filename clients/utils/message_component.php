<?php

include_once __DIR__ . '/../../database/db_connection.php';

$user_one_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
$login_user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

$user_two_id = null;
$row = null;
if ($login_user_role == 'coach') {
    $user_two_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;
    $query = "SELECT first_name,role FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_two_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
} elseif ($login_user_role == 'client') {
    $query = "SELECT coach_id FROM client_coach_assignments WHERE client_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_one_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_two_id = $row['coach_id'];
    }

    $query = "SELECT first_name,role FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_two_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .chat-box {
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background: #f8f9fa;
            height: 40vh;
            position: relative;
            background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
        }

        .message {
            display: flex;
            margin: 15px 0;
            align-items: center;
        }

        .message.user1 {
            justify-content: flex-end;
            align-self: flex-start;
        }

        .message.user1 .message-content {
            background-color: #E7FDCC;
            color: #333;
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 60%;
        }

        .message.user2 {
            justify-content: flex-start;
            align-self: flex-start;
        }

        .message.user2 .message-content {
            background-color: #f0f0f0;
            color: #6c757d;
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 60%;
        }

        .message .timestamp {
            font-size: 0.8rem;
            margin-top: 5px;
            color: #6c757d;
            text-align: end;
        }

        .chat-footer input {
            padding: 10px;
            border-radius: 15px;
            width: 100%;
        }

        .send-button {
            border-radius: 15px;
            padding: 11px;
            width: 100%;
        }

        .assigned-person {
            color: #946CFC !important;
        }
    </style>
</head>

<body>

    <div class="container shadow p-4 rounded-4 mb-3">
        <div class="row">
            <div class="col-md-12">
                <div class="chat-header">
                    <h2>Chat with your <span class="assigned-person"><?php echo ucfirst($row['role']) . ' ' . ucfirst($row['first_name']) ?></span></h2>
                </div>
            </div>
        </div>
        <div id="chat-box" class="chat-box my-3"></div>

        <div class="chat-footer row g-2">
            <div class="col">
                <input type="text" id="message-input" class="form-control" placeholder="Type your message">
            </div>
            <div class="col-auto" style="flex: 0 0 8rem;">
                <button id="send-button" class="btn btn-primary send-button">Send</button>
            </div>
        </div>
    </div>

</body>

</html>