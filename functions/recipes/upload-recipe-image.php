<?php
// Define the upload directory
$uploadDir = 'assets/images/recipe_images';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Create the upload directory if it doesn't exist
}

$data = json_decode(file_get_contents("php://input"), true);
$response = ['status' => 'error', 'message' => 'An error occurred.'];

// Check if image data exists
if (isset($data['image'])) {
    $imageData = $data['image'];

    // If the image is a base64 string (local upload), decode and save
    if (strpos($imageData, 'data:image/') === 0) {
        // Remove prefix (base64 encoded image data)
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = str_replace('data:image/jpg;base64,', '', $imageData);
        $imageData = str_replace('data:image/webp;base64,', '', $imageData);
        $imageData = base64_decode($imageData);

        // Generate a unique name for the image
        $uniqueName = uniqid('recipe_', true) . '.png';  // Change .png to .jpg or .webp if needed
        $filePath = $uploadDir . $uniqueName;

        // Save the image
        if (file_put_contents($filePath, $imageData)) {
            // Image saved successfully, return the file path
            $response = [
                'status' => 'success',
                'filePath' => $filePath  // Return the file path to the frontend
            ];
        } else {
            $response['message'] = 'Failed to save the image.';
        }
    } else {
        // If no local image was uploaded, use the default image URL
        $response = [
            'status' => 'success',
            'filePath' => $imageData  // The image URL (from the API) will be used
        ];
    }

    // Here you would insert the food data into the database, including the image URL/path
    // Assuming the insert logic is implemented below:
    // $foodId = ...;
    // $label = ...;
    // $foodImage = $response['filePath']; // Save the image path/URL to the database

} else {
    $response['message'] = 'No image data received.';
}

echo json_encode($response);
?>
