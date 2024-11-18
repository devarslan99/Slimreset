<?php
include_once '../../database/db_connection.php';
session_start();
// Get the JSON data from the request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);
$loginUserRole = mysqli_real_escape_string($mysqli, $data['loginUserRole'] ?? '');
$user_id = ($loginUserRole === 'coach') ? mysqli_real_escape_string($mysqli, $data['userId']) : $_SESSION['user_id'];

// Prepare and bind
$stmt = $mysqli->prepare("INSERT INTO food_items (foodId, label,type, amount, unit, calories, totalFat, satFat, cholesterol, sodium, carbs, fiber, sugars, protein,user_id,created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");
$stmt->bind_param("ssssssssssssssss", $data['foodId'], $data['label'], $data['food_type'], $data['amount'], $data['unit'], $data['calories'], $data['totalFat'], $data['satFat'], $data['cholesterol'], $data['sodium'], $data['carbs'], $data['fiber'], $data['sugars'], $data['protein'],$user_id,$data['selected_date']);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Food item stored successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error storing food item: " . $stmt->error]);
}