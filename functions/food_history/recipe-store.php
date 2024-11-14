<?php
include_once '../../database/db_connection.php';
session_start();
$user_id = $_SESSION['user_id'];
// Get the JSON data from the request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Prepare and bind
$stmt = $mysqli->prepare("INSERT INTO recipe_items (foodId, label,amount, unit, calories, totalFat, satFat, cholesterol, sodium, carbs, fiber, sugars, protein,user_id,created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");
$stmt->bind_param("sssssssssssssss", $data['foodId'], $data['label'], $data['amount'], $data['unit'], $data['calories'], $data['totalFat'], $data['satFat'], $data['cholesterol'], $data['sodium'], $data['carbs'], $data['fiber'], $data['sugars'], $data['protein'],$user_id,$data['selected_date']);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Recipe item stored successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error storing recipe item: " . $stmt->error]);
}