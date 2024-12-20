<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Chat UI</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .header {
            background-color: #946cfc;
            color: white;
            padding:20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header .back-button {
            display: none;
            font-size: 18px;
            cursor: pointer;
        }

        .user-list {
            height: 100vh;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            background-color: #f8f9fa;
            padding: 0;
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .user-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .user-item .info {
            margin-left: 10px;
            flex: 1;
        }

        .user-item h6 {
            font-size: 14px;
            margin: 0;
            font-weight: 600;
        }

        .user-item small {
            color: #888;
        }

        .user-item .badge {
            font-size: 12px;
            background-color: orange;
            color: white;
            border-radius: 5px;
            padding: 2px 5px;
        }

        .chat-section {
            display: flex;
            flex-direction: column;
            height: 100vh;
            padding: 0;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .chat-message {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .chat-message img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .chat-message .message-content {
            margin-left: 10px;
            padding: 10px;
            border-radius: 10px;
            max-width: 80%;
        }

        .chat-message.user-message .message-content {
            background-color: #f1f1f1;
            text-align: left;
        }

        .chat-message.coach-message .message-content {
            background-color: #ebe4ff;
            text-align: left;
        }

        .chat-message h6 {
            font-size: 14px;
            font-weight: bold;
        }

        .chat-message small {
            color: #999;
            margin-left: 10px;
        }

        #messageForm {
            border-top: 1px solid #ddd;
            padding: 10px;
        }

        .chatBtn {
            background-color: #946cfc !important;
            color: #fff;
        }

            /* Custom Scrollbar Styles */
        #chatMessages {
            scrollbar-width: thin; 
            scrollbar-color: #946cfc #f1f1f1; 
        }

        /* Chrome, Edge, Safari */
        #chatMessages::-webkit-scrollbar {
            width: 8px; 
        }

        #chatMessages::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }

        #chatMessages::-webkit-scrollbar-thumb {
            background-color: #946cfc; 
            border-radius: 10px; 
            border: 2px solid #f1f1f1; 
        }

        #chatMessages::-webkit-scrollbar-thumb:hover {
            background-color: #7a55e0;
        }
        /* Scroll to Bottom Button */
        .scroll-to-bottom {
            position: fixed;
            bottom: 80px;
            right: 20px;
            background-color: #946cfc;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .scroll-to-bottom:hover {
            background-color: #7a55e0;
        }

        .scroll-to-bottom.visible {
            opacity: 1;
            visibility: visible;
        }

        .scroll-to-bottom {
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }


        /* Responsive Styles */
        @media (max-width: 768px) {
            .user-list {
                display: none;
            }

            .chat-section {
                display: none;
                width: 100%;
            }

            .user-list.active {
                display: block;
            }

            .chat-section.active {
                display: flex;
            }

            .header .back-button {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .chat-message img {
                width: 30px;
                height: 30px;
            }

            .chat-message .message-content {
                font-size: 14px;
            }

            #messageForm {
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- User List Section -->
            <div class="col-md-4 col-lg-3 bg-light user-list active" id="userList">
                <div class="header">
                    <span>Chats</span>  
                    <span>SlimReset</span>
                </div>
                <div class="user-item" onclick="selectUser('Sonia Thibault', 'user1')">
                    <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg" alt="User Image">
                    <div class="info">
                        <h6>Sonia Thibault <span class="badge">Main PM</span></h6>
                        <small>2 hours ago</small>
                    </div>
                </div>
                <div class="user-item" onclick="selectUser('John Doe', 'user2')">
                    <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg" alt="User Image">
                    <div class="info">
                        <h6>John Doe <span class="badge">Main PM</span></h6>
                        <small>1 hour ago</small>
                    </div>
                </div>
            </div>

            <!-- Chat Section -->
            <div class="col-md-8 col-lg-9 chat-section" id="chatSection">
                <div class="header">
                    <span class="back-button" onclick="showUserList()">
                    <i class="fa fa-arrow-left"></i>
                    </span>
                    <span>Messages</span>
                </div>
                <div class="chat-messages" id="chatMessages">
                    <div class="chat-message user-message">
                        <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg" alt="User Image">
                        <div class="message-content">
                            <h6>Gamar Jama <small>6 Nov 2024</small></h6>
                            <p>Is it ok to stop taking the shots while I have a flu and fever?</p>
                        </div>
                    </div>
                    <div class="chat-message coach-message">
                        <img src="coach.png" alt="Coach Image">
                        <div class="message-content">
                            <h6>My SlimCoach <small>6 Nov 2024</small></h6>
                            <p>Morning Gamar, yes eat the best you can based on protocol but get better first ❤️🙏</p>
                        </div>
                    </div>
                </div>

                <div class="scroll-to-bottom" id="scrollToBottom" onclick="scrollToLastMessage()">
                    <i class="fa fa-arrow-down"></i>
                </div>

                <form id="messageForm" class="d-flex align-items-center">
                    <input type="text" id="messageInput" class="form-control mr-2" placeholder="Type a message..." required>
                    <button type="submit" class="btn chatBtn"><i class="fa fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function selectUser(userName, userId) {
            $('#userList').removeClass('active');
            $('#chatSection').addClass('active');
        }

        function showUserList() {
            $('#chatSection').removeClass('active');
            $('#userList').addClass('active');
        }
    </script>
</body>
</html>

<!-- script to load selected user chat section or chat -->
<script>
    // Show/Hide Scroll to Bottom Button
    function toggleScrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        const scrollToBottomBtn = document.getElementById('scrollToBottom');

        // Show the button only when scrolled away from the bottom
        if (chatMessages.scrollHeight - chatMessages.scrollTop > chatMessages.clientHeight + 100) {
            scrollToBottomBtn.classList.add('visible');
        } else {
            scrollToBottomBtn.classList.remove('visible');
        }
    }

    // Scroll to the last message instantly
    function scrollToLastMessageInstant() {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    // Function to handle chat section reset
    function resetChatSection() {
        const scrollToBottomBtn = document.getElementById('scrollToBottom');
        scrollToBottomBtn.classList.remove('visible'); // Hide the scroll button
        scrollToLastMessageInstant(); // Instantly scroll to the bottom
    }

    // Function to restore state on page load
    function restoreState() {
        const activeSection = localStorage.getItem('activeSection') || 'userList';
        const selectedUser = localStorage.getItem('selectedUser');

        if (activeSection === 'chat' && selectedUser) {
            document.getElementById('userList').classList.remove('active');
            document.getElementById('chatSection').classList.add('active');
            loadChatMessages(selectedUser);
            setTimeout(resetChatSection, 0); // Reset chat section and scroll
        } else {
            document.getElementById('userList').classList.add('active');
            document.getElementById('chatSection').classList.remove('active');
        }
    }

    // Function to handle user selection
    function selectUser(userName, userId) {
        localStorage.setItem('activeSection', 'chat');
        localStorage.setItem('selectedUser', userId);
        document.getElementById('userList').classList.remove('active');
        document.getElementById('chatSection').classList.add('active');
        loadChatMessages(userId);
        setTimeout(resetChatSection, 0); // Reset chat section and scroll
    }

    // Function to load chat messages dynamically
    function loadChatMessages(userId) {
        const messages = {
            user1: `
                <div class="chat-message user-message">
                    <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg" alt="User Image">
                    <div class="message-content">
                        <h6>Sonia Thibault <small>6 Nov 2024</small></h6>
                        <p>Hi, how are you doing?</p>
                    </div>
                </div>
                <div class="chat-message coach-message">
                    <img src="coach.png" alt="Coach Image">
                    <div class="message-content">
                        <h6>My SlimCoach <small>6 Nov 2024</small></h6>
                        <p>I’m doing great! How can I help you?</p>
                    </div>
                </div>
            `,
            user2: `
                <div class="chat-message user-message">
                    <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg" alt="User Image">
                    <div class="message-content">
                        <h6>John Doe <small>6 Nov 2024</small></h6>
                        <p>Hello, I need help with my diet plan.</p>
                    </div>
                </div>
                <div class="chat-message coach-message">
                    <img src="coach.png" alt="Coach Image">
                    <div class="message-content">
                        <h6>My SlimCoach <small>6 Nov 2024</small></h6>
                        <p>Sure! Let’s create a custom plan for you.</p>
                    </div>
                </div>
            `
        };

        const chatMessages = document.getElementById('chatMessages');
        chatMessages.innerHTML = messages[userId] || '<p>No messages yet.</p>';
    }

    // Add scroll event listener to chat messages
    document.getElementById('chatMessages').addEventListener('scroll', toggleScrollToBottom);

    // Restore state when the page loads
    document.addEventListener('DOMContentLoaded', restoreState);

    // Append new message on form submission
    document.getElementById('messageForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const chatMessages = document.getElementById('chatMessages');
        const messageInput = document.getElementById('messageInput');
        const newMessage = messageInput.value.trim();

        if (newMessage) {
            const formattedDate = new Date().toLocaleDateString('en-US', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

            const newMessageHTML = `
                <div class="chat-message user-message">
                    <img src="https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg" alt="User Image">
                    <div class="message-content">
                        <h6>You <small>${formattedDate}</small></h6>
                        <p>${newMessage}</p>
                    </div>
                </div>
            `;
            chatMessages.insertAdjacentHTML('beforeend', newMessageHTML);
            messageInput.value = '';
            resetChatSection(); 
        }
    });
</script>




<!-- script to scroll to bottom with arrow -->
<script>
    function toggleScrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        const scrollToBottomBtn = document.getElementById('scrollToBottom');

        if (chatMessages.scrollHeight - chatMessages.scrollTop > chatMessages.clientHeight + 100) {
            scrollToBottomBtn.classList.add('visible');
        } else {
            scrollToBottomBtn.classList.remove('visible');
        }
    }

    // Scroll to the last message with animation
    function scrollToLastMessage() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTo({
            top: chatMessages.scrollHeight,
            behavior: 'smooth',
        });
    }

    // Add event listener for scrolling
    document.getElementById('chatMessages').addEventListener('scroll', toggleScrollToBottom);

    // Scroll to last message on page load or when messages are loaded
    document.addEventListener('DOMContentLoaded', () => {
        scrollToLastMessage();
    });

</script>
