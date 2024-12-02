<?php
include_once '../../database/db_connection.php';

// Get the JSON data from the request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Validate the required fields
if (isset($data['mealId'])) {
    $mealId = $data['mealId'];

    // Prepare and bind the DELETE statement
    $stmt = $mysqli->prepare("DELETE FROM meal_planner WHERE id = ?");
    $stmt->bind_param("s", $mealId);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Meal removed successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error removing meal: " . $stmt->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request. Meal ID not provided."]);
}
