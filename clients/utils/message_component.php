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

    <script>
        let ws = new WebSocket('ws://localhost:8080?from_user_id=' + <?php echo $user_one_id; ?> + '&to_user_id=' + <?php echo $user_two_id; ?>);

        let userOneId = <?php echo $user_one_id; ?>;
        let userTwoId = <?php echo $user_two_id; ?>;

        ws.onopen = function() {
            console.log('WebSocket connection opened.');
        };

        document.addEventListener("DOMContentLoaded", function() {
            var tab = document.getElementById("successful-wizard-tab");
            if (tab) {
                tab.addEventListener("click", function() {
                    let chatBox = document.getElementById('chat-box');
                    chatBox.scrollTop = chatBox.scrollHeight;

                    $.ajax({
                        type: "GET",
                        url: "utils/chatAllowed.php?id=<?php echo $user_two_id ?>",
                        dataType: "json",
                        success: function(response) {
                            if (response.status === 'success') {
                                let chatBox = document.getElementById('chat-box');
                                chatBox.scrollTop = chatBox.scrollHeight;
                            } else {
                                console.error("Error:", response.message);
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                }).then(() => {
                                    var wizardInfoTab = document.getElementById("wizard-info-tab");
                                    if (wizardInfoTab) {
                                        wizardInfoTab.click();
                                    }
                                });
                            }
                        }
                    });
                });

                tab.addEventListener("click", function() {
                    let from_user_id = <?php echo $user_one_id; ?>;
                    let to_user_id = <?php echo $user_two_id; ?>;

                    markMessagesAsRead(from_user_id, to_user_id);
                });
            }

            let activeTab = null;

            window.onfocus = function() {
                if (activeTab === "successful-wizard-tab") {
                    markMessagesAsRead(userOneId, userTwoId)
                }
            };

            tab.addEventListener("click", function() {
                activeTab = "successful-wizard-tab";
            });
        });

        // Displays the conversation messages
        function renderMessage(data, isOwnMessage) {
            let chatBox = document.getElementById('chat-box');
            let newMessage = document.createElement('div');
            newMessage.className = isOwnMessage ? 'message user1' : 'message user2';

            let messageText = data.message || "No message content";

            let timestamp = new Date(data.sent_at).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            }) || "Unknown time";

            newMessage.innerHTML = `
            <div class="message-content">
                <p>${messageText}</p>
                <div class="timestamp">${timestamp}</div>
            </div>`;

            chatBox.appendChild(newMessage);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Displays the notifications
        function addNotificationToPanel(notification) {
            if (notification.is_read === 0) {
                const notificationPanel = document.querySelector('.custom-notification-list');

                const noUnreadMsg = document.querySelector('.no-unread-msg');
                if (noUnreadMsg) {
                    noUnreadMsg.remove();
                }

                const notificationItem = document.createElement('li');
                notificationItem.classList.add('notification-hover');
                notificationItem.id = 'notification-' + notification.message_id;

                notificationItem.innerHTML = `
                    <div class="custom-notification-item d-flex justify-content-between align-items-center">
                        <div class="custom-notification-content">
                            <div class="d-flex align-items-center gap-2">
                                <img src="${notification.sender_profile_image}" class="custom-avatar" alt="Avatar">
                                <span class="sender-name">${notification.sender_name}</span>
                            </div>
                            <div class="custom-message mt-2">
                                <span>${notification.message}</span>
                            </div>
                        </div>
                        <i class="fa fa-times" aria-hidden="true" style="cursor: pointer;" onclick="dismissMessage(${notification.message_id})"></i>
                    </div>`;
                notificationPanel.appendChild(notificationItem);
            }
        }

        function removeFirstDots(path) {
            if (path.startsWith('../')) {
                return path.substring(3);
            }
            return path;
        }

        const DEFAULT_IMAGE_URL = 'https://avatar.iran.liara.run/public/33';

        ws.onmessage = function(event) {
            let data = JSON.parse(event.data);
            if (Array.isArray(data)) {
                data.forEach(msg => {
                    renderMessage(msg, msg.sender_id === userOneId);
                    if (msg.is_read === 0 && msg.receiver_id === userOneId) {
                        let notificationData = {
                            sender_profile_image: removeFirstDots(msg.sender_profile_image) || DEFAULT_IMAGE_URL,
                            sender_name: msg.sender_name,
                            message: msg.message,
                            sent_at: msg.sent_at,
                            is_read: msg.is_read,
                            message_id: msg.message_id
                        };
                        addNotificationToPanel(notificationData);
                    }
                });
            } else {
                renderMessage(data, data.sender_id === userOneId);
                if (data.is_read === 0 && data.receiver_id === userOneId) {
                    let notificationData = {
                        sender_profile_image: removeFirstDots(data.sender_profile_image) || DEFAULT_IMAGE_URL,
                        sender_name: data.sender_name,
                        message: data.message,
                        sent_at: data.sent_at,
                        is_read: data.is_read,
                        message_id: data.message_id
                    };
                    addNotificationToPanel(notificationData);
                }
            }
        };

        function sendMessage() {
            let messageInput = document.getElementById('message-input').value;
            if (messageInput.trim() !== '') {
                let messageData = {
                    from_user_id: userOneId,
                    to_user_id: userTwoId,
                    message: messageInput,
                    sent_at: new Date().toISOString()
                };
                ws.send(JSON.stringify(messageData));

                let chatBox = document.getElementById('chat-box');
                chatBox.scrollTop = chatBox.scrollHeight;

                document.getElementById('message-input').value = '';
            }
        }

        // Checks for notifications
        function checkNotifications() {
            const notificationPanel = document.querySelector('.custom-notification-list');
            if (notificationPanel.children.length === 0) {
                const noUnreadMsg = document.createElement('li');
                noUnreadMsg.classList.add('no-unread-msg');
                noUnreadMsg.innerHTML = `
                    <div class="d-flex justify-content-center">
                        <span>No unread messages</span>
                    </div>
                `;
                notificationPanel.appendChild(noUnreadMsg);
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            checkNotifications();
        });

        document.getElementById('send-button').onclick = function() {
            sendMessage();
        };

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        })

        function markMessagesAsRead(fromUserId, toUserId) {
            $.ajax({
                type: "POST",
                url: "utils/markAsRead.php",
                data: {
                    from_user_id: fromUserId,
                    to_user_id: toUserId
                },
                success: function(response) {
                    console.log("Messages marked as read: ", response.message);
                },
                error: function(err) {
                    console.error("Error marking messages as read:", err);
                }
            });
        }

        function dismissMessage(id) {
            $.ajax({
                type: "POST",
                url: "../functions/coach/fetch_notifications.php",
                data: {
                    id: id
                },
                success: function(response) {
                    let jsonResponse;

                    try {
                        if (typeof response === "string") {
                            jsonResponse = JSON.parse(response);
                        } else {
                            jsonResponse = response;
                        }

                        if (jsonResponse.success) {
                            const notificationItem = document.getElementById('notification-' + jsonResponse.id);
                            if (notificationItem) {
                                notificationItem.remove();
                            }
                            checkNotifications();
                        } else {
                            console.error("Failed to dismiss the message: ", jsonResponse.error);
                        }
                    } catch (e) {
                        console.error("Error parsing JSON: ", e);
                        console.error("Full response: ", response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Failed to dismiss the message: ", error);
                }
            });
        }
    </script>

</body>

</html>