<?php
include_once '../../database/db_connection.php';

// Get the JSON data from the request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Prepare and bind
$stmt = $mysqli->prepare("INSERT INTO meal_planner (foodId,label, date, day, mealName, image ,amount, unit, meal_type_id, food_group_id, veggie_id, protein_id, fruit_id, calories, totalFat, satFat, cholesterol, sodium, carbs, fiber, sugars, protein, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssssssssssssss", $data['foodId'], $data['label'], $data['date'], $data['day'], $data['mealName'], $data['image'], $data['amount'], $data['unit'], $data['meal_type_id'], $data['food_group_id'], $data['veggie_id'], $data['protein_id'], $data['fruit_id'], $data['calories'], $data['totalFat'], $data['satFat'], $data['cholesterol'], $data['sodium'], $data['carbs'], $data['fiber'], $data['sugars'], $data['protein'], $data['user_id']);

// Execute the statement
if ($stmt->execute()) {
    $insertedId = $stmt->insert_id;

    echo json_encode(["status" => "success", "message" => "Recipe item stored successfully.", "id" => $insertedId]);
} else {
    echo json_encode(["status" => "error", "message" => "Error storing recipe item: " . $stmt->error]);
}
