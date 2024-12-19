<?php
// Mock data for users and chat messages
$users = [
    ["name" => "Sonia Thibault"],
    ["name" => "Kimberly Wieland"],
    ["name" => "Kirsty Gbobjani"],
    ["name" => "Svetlana Uglesic"],
    ["name" => "Rick Brash"],
    ["name" => "Sophia Duhela"],
    ["name" => "John Hanlon"],
    ["name" => "Chi Ilya-Ndule"],
    ["name" => "Shaila Williams"],
    ["name" => "Shabnam Nasser"],
];

$messages = [
    ["user" => "Gamar Jama", "time" => "6 Nov 2024", "message" => "Is it ok to stop taking the shots while I have a flu and fever"],
    ["user" => "My SlimCoach", "time" => "6 Nov 2024", "message" => "Morning Gamar, yes eat the best you can based on protocol but get better first ❤️🙏"],
    ["user" => "Gamar Jama", "time" => "Yesterday", "message" => "I have a question will Plan B still be effective while on the shots?"],
    ["user" => "Gamar Jama", "time" => "4 hours ago", "message" => "??"],
    ["user" => "My SlimCoach", "time" => "4 hours ago", "message" => "Hi Gamar. Yes it should be fine as the hcg is at a very low dose 👍"],
    ["user" => "Gamar Jama", "time" => "2 minutes ago", "message" => "Ok Perfect thank you so much"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Chat UI</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .chat-app {
            display: flex;
            height: 100vh;
        }

        .users-panel {
            width: 30%;
            max-width: 300px;
            background: #fff;
            border-right: 1px solid #ddd;
            overflow-y: auto;
        }

        .users-panel .user {
            padding: 15px;
            border-bottom: 1px solid #f1f1f1;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .users-panel .user:hover {
            background: #f9f9f9;
        }

        .users-panel .user .icon {
            margin-right: 10px;
        }

        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .chat-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .message {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .message .time {
            font-size: 12px;
            color: gray;
            margin-bottom: 5px;
        }

        .message .user {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .message .text {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            line-height: 1.5;
        }

        .message.my-coach .text {
            background: #e2f3f5;
            color: #0c5460;
        }

        .chat-footer {
            display: flex;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ddd;
            background: #f9f9f9;
        }

        .chat-footer input {
            flex: 1;
            margin-right: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .chat-footer button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-footer button:hover {
            background-color: #0056b3;
        }

        /* Scroll styling */
        .chat-body::-webkit-scrollbar,
        .users-panel::-webkit-scrollbar {
            width: 8px;
        }

        .chat-body::-webkit-scrollbar-thumb,
        .users-panel::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 4px;
        }

        .chat-body::-webkit-scrollbar-track,
        .users-panel::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
    </style>

    <div class="chat-app">
        <div class="users-panel">
            <?php foreach ($users as $user): ?>
                <div class="user">
                    <i class="fa fa-user-circle icon fa-lg"></i>
                    <span><?php echo $user['name']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="chat-container">
            <div class="chat-header">
                Chat
            </div>
            <div class="chat-body">
                <?php foreach ($messages as $message): ?>
                    <div class="message <?php echo $message['user'] === 'My SlimCoach' ? 'my-coach' : ''; ?>">
                        <div class="time"> <?php echo $message['time']; ?> </div>
                        <div class="user"> <?php echo $message['user']; ?> </div>
                        <div class="text"> <?php echo $message['message']; ?> </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="chat-footer">
                <input type="text" class="form-control" placeholder="Type a message here...">
                <button><i class="fa fa-paper-plane"></i></button>
            </div>
        </div>
    </div>