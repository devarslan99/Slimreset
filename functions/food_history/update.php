<?php
include_once '../../database/db_connection.php';
session_start();

// Get the JSON data from the request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Validate and sanitize inputs
$loginUserRole = mysqli_real_escape_string($mysqli, $data['loginUserRole'] ?? '');
$user_id = ($loginUserRole === 'coach') ? mysqli_real_escape_string($mysqli, $data['userId']) : $_SESSION['user_id'];
$foodId = mysqli_real_escape_string($mysqli, $data['foodId']);
$label = mysqli_real_escape_string($mysqli, $data['label']);
$food_type = mysqli_real_escape_string($mysqli, $data['food_type']);
$amount = mysqli_real_escape_string($mysqli, $data['amount']);
$unit = mysqli_real_escape_string($mysqli, $data['unit']);
$calories = mysqli_real_escape_string($mysqli, $data['calories']);
$totalFat = mysqli_real_escape_string($mysqli, $data['totalFat']);
$satFat = mysqli_real_escape_string($mysqli, $data['satFat']);
$cholesterol = mysqli_real_escape_string($mysqli, $data['cholesterol']);
$sodium = mysqli_real_escape_string($mysqli, $data['sodium']);
$carbs = mysqli_real_escape_string($mysqli, $data['carbs']);
$fiber = mysqli_real_escape_string($mysqli, $data['fiber']);
$sugars = mysqli_real_escape_string($mysqli, $data['sugars']);
$protein = mysqli_real_escape_string($mysqli, $data['protein']);
$selected_date = mysqli_real_escape_string($mysqli, $data['selected_date']);
$id = mysqli_real_escape_string($mysqli, $data['id']);


if (!empty($id)) {
    $stmt = $mysqli->prepare("UPDATE food_items SET foodId=?, label=?, type=?, amount=?, unit=?, calories=?, totalFat=?, satFat=?, cholesterol=?, sodium=?, carbs=?, fiber=?, sugars=?, protein=?, user_id=?, created_at=? WHERE id=?");
    $stmt->bind_param("ssssssssssssssssi", $foodId, $label, $food_type, $amount, $unit, $calories, $totalFat, $satFat, $cholesterol, $sodium, $carbs, $fiber, $sugars, $protein, $user_id, $selected_date, $id);
} else {
    $stmt = $mysqli->prepare("INSERT INTO food_items (foodId, label, type, amount, unit, calories, totalFat, satFat, cholesterol, sodium, carbs, fiber, sugars, protein, user_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssss", $foodId, $label, $food_type, $amount, $unit, $calories, $totalFat, $satFat, $cholesterol, $sodium, $carbs, $fiber, $sugars, $protein, $user_id, $selected_date);
}

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => !empty($id) ? "Food item updated successfully." : "Food item stored successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error processing food item: " . $stmt->error]);
}

$stmt->close();
