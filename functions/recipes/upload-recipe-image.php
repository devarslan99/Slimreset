<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'image' file and 'uniqueFileName' are present
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && isset($_POST['uniqueFileName'])) {
        
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $uniqueFileName = $_POST['uniqueFileName'];  // Access the correct key

        // Check file size (5MB limit)
        $maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if ($_FILES['image']['size'] > $maxSize) {
            echo json_encode(['status' => 'error', 'message' => 'File size exceeds the 5MB limit.']);
            exit; // Stop further processing if file is too large
        }

        // Check file type (must be PNG, JPG, or WEBP)
        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Allowed types: PNG, JPG, WEBP']);
            exit;
        }

        $uploadDir = '../../assets/images/recipe_images/uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);  // Create the directory if it doesn't exist
        }

        // Sanitize file name
        $uniqueFileName = preg_replace('/[^a-zA-Z0-9_-]/', '.', $uniqueFileName);
        $destPath = $uploadDir . '/' . $uniqueFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Return a JSON response
            echo json_encode([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'filePath' => $destPath
            ]);
        } else {
            // Return error as JSON
            echo json_encode([
                'status' => 'error',
                'message' => 'Error moving the uploaded file.'
            ]);
        }
    } else {
        // Return error if no file uploaded or other issues
        echo json_encode([
            'status' => 'error',
            'message' => 'No file uploaded or an error occurred.'
        ]);
    }
} else {
    // Invalid request method
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
