<?php 

include_once "../../database/db_connection.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Get POST data and sanitize inputs
    $category = isset($_POST['category']) ? mysqli_real_escape_string($mysqli, $_POST['category']) : ''; 
    $itemId = isset($_POST['itemId']) ? intval($_POST['itemId']) : null;

    // Check if category and item ID are provided
    if (empty($category) || empty($itemId)) {
        echo json_encode(['status' => 'error', 'message' => 'Category and item ID are required.']);
        exit;
    }

    // Map category names to database column names
    $categoryMap = [
        'meal-type' => 'meal_type_id',
        'food-group' => 'food_group_id',
        'veggie' => 'veggie_id',
        'protein' => 'protein_id',
        'fruit' => 'fruit_id'
    ];

    // Check if the category is valid
    if (!array_key_exists($category, $categoryMap)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid category type.']);
        exit;
    }

    // Get the corresponding column name for the category
    $column = $categoryMap[$category];

    // Construct the SQL query
    $query = "SELECT * FROM recipe_items WHERE $column = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $itemId); // Bind the item ID as an integer
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Collect each row as an associative array
        }

        $stmt->close();

        // Return data as JSON
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

?>
