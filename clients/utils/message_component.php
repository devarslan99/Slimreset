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
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">

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

        .chat-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .chat-footer input {
            padding: 10px;
            border-radius: 15px;
            width: 100%;
        }

        .send-button {
            border-radius: 15px;
            padding: 14px;
            width: 100%;
            background: grey;
            color: #fff;
            transition: .3s all ease-in-out;
            cursor: not-allowed
        }

        .send-button:hover {
            color: #fff;
            background: #946CFC;
        }

        .send-button.disabled {
            background: grey;
            cursor: not-allowed;
        }

        .send-button.disabled:hover {
            background: grey;
        }

        .assigned-person {
            color: #946CFC !important;
        }

        .input-container {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
        }

        .form-control {
            padding-right: 30px;
            width: 100%;
        }

        #clip-icon {
            position: absolute;
            right: 20px;
            cursor: pointer;
            font-size: 25px;
            color: #555;
            transition: .3s all ease-in-out;
        }

        #clip-icon:hover {
            color: #946CFC;
        }

        .col-auto {
            flex: 0 0 auto;
        }

        .text-green {
            color: green !important;
        }

        .filepond--credits {
            display: none !important;
        }

        .modal-title {
            color: #946CFC;
        }

        .upload-btn {
            color: white;
            background: gray !important;
            transition: .3s all ease-in-out;
        }

        .upload-btn:hover {
            background: #946CFC !important;
            color: white;
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
            <div class="input-container">
                <input type="text" id="message-input" class="form-control" placeholder="Type your message" oninput="handleInputChange()">
                <i class="fa fa-paperclip d-none" id="clip-icon" aria-hidden="true"></i>
            </div>

            <div class="col-auto" style="flex: 0 0 8rem;">
                <button id="send-button" class="btn send-button disabled">Send</button>
            </div>
        </div>
    </div>

    <!-- File Upload Modal -->
    <div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileUploadModalLabel">Upload Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger mb-3">You can upload up to <strong>5 images</strong> only.</p>
                    <input type="file" id="filepond-input" class="filepond" name="filepond" />
                    <div id="file-upload-error" class="text-danger mt-2" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn upload-btn" id="upload-button" disabled>Upload</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>

    <!-- Script to select and display images -->
    <script>
        document.getElementById('clip-icon').addEventListener('click', () => {
            const modal = new bootstrap.Modal(document.getElementById('fileUploadModal'));
            modal.show();
        });

        FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

        const fileInput = document.getElementById('filepond-input');
        const errorContainer = document.getElementById('file-upload-error');

        const pond = FilePond.create(fileInput, {
            allowMultiple: true,
            maxFiles: 5,
            maxFileSize: '5MB',
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'],

            labelIdle: 'Drag & Drop your files or <span class="filepond--label-action text-green">Browse</span>',
            labelMaxFilesExceeded: 'You can only upload up to 5 files.',
            labelFileProcessingError: 'Error uploading file.',
            labelFileTypeNotAllowed: 'File type not allowed. Please upload JPEG, PNG, or WebP images.',
            labelMaxFileSizeExceeded: 'File is too large. Maximum file size is 5MB.',

            onupdatefiles: (fileItems) => {
                if (fileItems.length > 5) {
                    errorContainer.textContent = 'You cannot upload more than 5 files.';
                    errorContainer.style.display = 'block';

                    fileItems.slice(5).forEach((excessFile) => {
                        pond.removeFile(excessFile.id);
                    });
                } else {
                    errorContainer.style.display = 'none';
                }
                toggleUploadButton();
            },

            onaddfile: (error) => {
                if (error) {
                    errorContainer.textContent = error.main || 'An error occurred.';
                    errorContainer.style.display = 'block';
                }
                toggleUploadButton();
            },
            onremovefile: () => {
                toggleUploadButton();
            },
        });

        document.getElementById('fileUploadModal').addEventListener('hidden.bs.modal', () => {
            pond.removeFiles();
            errorContainer.style.display = 'none';
            toggleUploadButton();
        });

        function toggleUploadButton() {
            const sendButton = document.getElementById('upload-button');
            const isFileValid = pond.getFiles().length > 0 && errorContainer.style.display === 'none';

            if (isFileValid) {
                sendButton.disabled = false;
                sendButton.classList.remove('disabled');
                sendButton.style.backgroundColor = '#946CFC';
                sendButton.style.cursor = 'pointer';
            } else {
                sendButton.disabled = true;
                sendButton.classList.add('disabled');
                sendButton.style.backgroundColor = 'gray';
                sendButton.style.cursor = 'not-allowed';
            }
        }
    </script>

    <!-- Script to display send button as disable -->
    <script>
        function handleInputChange() {
            const messageInput = document.getElementById('message-input');
            const sendButton = document.getElementById('send-button');

            if (messageInput.value.trim() !== '') {
                sendButton.classList.remove('disabled');
                sendButton.style.cursor = 'pointer';
            } else {
                sendButton.classList.add('disabled');
                sendButton.style.cursor = 'not-allowed';
            }
        }
    </script>
</body>

</html>