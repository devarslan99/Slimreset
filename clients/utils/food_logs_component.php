<div class="row">
    <div class="container">
        <div class="row">
            <?php
            $user_id = $_GET['id'];
            $selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

            $prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
            $next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));

            // Prepare and execute the SQL query
            $sql = "SELECT (SELECT SUM(calories) FROM food_items WHERE user_id = $user_id AND DATE(created_at) = '$selected_date') AS total_calories,
            (SELECT SUM(protein) FROM food_items WHERE user_id = $user_id AND DATE(created_at) = '$selected_date') AS total_protein,
            (SELECT SUM(water) FROM water_records WHERE user_id = $user_id AND DATE(created_at) = '$selected_date') AS total_water,
            (SELECT SUM(bowel_movement) FROM bowel_movements WHERE user_id = $user_id AND DATE(created_at) = '$selected_date') AS total_bowel_movement";

            $result = mysqli_query($mysqli, $sql);

            if ($result) {
                $row = mysqli_fetch_assoc($result);

                $total_calories = $row['total_calories'] ?? 0;
                $total_protein = $row['total_protein'] ?? 0;
                $total_water = $row['total_water'] ?? 0;
                $total_bowel_movement = $row['total_bowel_movement'] ?? 0;

                $metrics = [
                    [
                        'label' => 'Calories',
                        'total' => $total_calories,
                        'max' => 800,
                        'unit' => 'Kal',
                        'color' => 'red'
                    ],
                    [
                        'label' => 'Protein',
                        'total' => $total_protein,
                        'max' => 10.5,
                        'unit' => 'oz',
                        'color' => 'green'
                    ],
                    [
                        'label' => 'Water',
                        'total' => $total_water,
                        'max' => 12,
                        'unit' => 'cups',
                        'color' => 'green'
                    ],
                    [
                        'label' => 'BM',
                        'total' => $total_bowel_movement,
                        'max' => 2,
                        'unit' => 'bm',
                        'color' => 'green'
                    ]
                ];

                foreach ($metrics as $metric) {
                    $remaining = $metric['max'] - $metric['total'];
            ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <div class="d-flex flex-column align-items-center justify-content-center p-3" style="min-width: 200px; border-radius: 20px; border: 1px solid #946CFC; text-align: center;">
                            <span style="font-size: 20px; display: block;"><?php echo $metric['label']; ?></span>
                            <h1 class="my-2" style="font-weight: bold;">
                                <?php echo $metric['total'] . ' ' . $metric['unit']; ?>
                            </h1>
                            <span class="my-2" style="font-size: 20px; display: block;">of <?php echo $metric['max'] . ' ' . $metric['unit']; ?></span>
                            <span style="font-size: 20px; font-weight: 500; color: <?php echo $metric['color']; ?>; display: block;">
                                <?php echo $remaining . ' ' . $metric['unit'] . ' left'; ?>
                            </span>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "Error executing query: " . mysqli_error($mysqli);
            }
            ?>
        </div>
    </div>

    <!-- WEIGHT TRACKER AND FOOD LOGS-->
    <div class="col-md-12 mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="col-md-12 mb-5">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="d-flex justify-content-start align-items-start mb-2 mb-md-0 flex-fill flex-sm-50 flex-md-33 flex-lg-25">
                            <h2 style="color:#000;">Food Journal</h2>
                        </div>
                        <div class="d-flex justify-content-start align-items-start mb-2 mb-md-0 flex-fill flex-sm-50 flex-md-33 flex-lg-25">
                            <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $prev_date; ?>" class="btn btn-primary mx-2">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <h3 class="text-center mx-2">
                                <?php echo date('l M d, Y', strtotime($selected_date)); ?>
                            </h3>
                            <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
                            <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $next_date; ?>" class="btn btn-primary mx-2">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                        
                        <!-- Display this section only to the client -->
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] === 'client') : ?>
                            <div class="d-flex justify-content-start align-items-start mb-2 mb-md-0 flex-fill flex-sm-50 flex-md-33 flex-lg-25">
                                <div class="dropdown">
                                    <button class="btn new-meal dropdown-toggle d-flex align-items-center justify-content-center w-100" style="border: 1px solid #946CFC; border-radius: 50px; padding: 8px 32px 8px 16px;" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        + New Meal
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#" onclick="openModal('Breakfast')">Breakfast</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="openModal('Lunch')">Lunch</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="openModal('Dinner')">Dinner</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="openModal('Snacks')">Snacks</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="row">
                    <?php
                    $user_id = $_GET['id'];

                    $total_calories = 0;
                    function formatValue($value)
                    {
                        if (is_numeric($value)) {
                            if (floor($value) == $value) {
                                return number_format($value, 0);
                            } else {
                                return number_format($value, 2);
                            }
                        }
                        return $value; // Return the original value if it's not numeric
                    }
                    $selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
                    function displayFoodItems($mealType, $selected_date)
                    {
                        global $mysqli, $user_id, $total_calories;
                        $sql = "SELECT * FROM food_items WHERE user_id = '$user_id' AND type = '$mealType' AND created_at = '$selected_date'";
                        $result = mysqli_query($mysqli, $sql);
                        $serial_number = 1;

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $total_calories += floatval($row['calories']);
                    ?>
                                <tr role="row" class="odd" id="customer_<?php echo $row['id']; ?>">
                                    <td><?php echo $serial_number; ?></td>
                                    <td><?php echo $row['label']; ?></td>
                                    <td><?php echo formatValue($row['amount']) . ' ' . $row['unit']; ?>
                                    </td>
                                    <td><?php echo formatValue($row['calories']) . ' Kal'; ?>
                                    </td>
                                    <td><?php echo formatValue($row['protein']); ?>
                                    </td>
                                    <td><?php echo formatValue($row['totalFat']); ?>
                                    </td>
                                    <td><?php echo formatValue($row['carbs']); ?>
                                    </td>
                                    <td><?php echo formatValue($row['sugars']); ?>
                                    </td>
                                </tr>
                    <?php
                                $serial_number++;
                            }
                        }
                        mysqli_free_result($result);
                    }
                    ?>

                    <!-- Display Breakfast -->
                    <div class="col-md-12">
                        <h2 style="color:#946cfc;">Breakfast</h2>
                        <hr />
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive theme-scrollbar">
                                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                        <table class="display dataTable no-footer" id="basic-1" role="grid">
                                            <thead>
                                                <th>#</th>
                                                <th>Food Name</th>
                                                <th>Food Quantity
                                                </th>
                                                <th>Calories</th>
                                                <th>Protien</th>
                                                <th>Fat</th>
                                                <th>Carbs</th>
                                                <th>Sugar</th>
                                            </thead>
                                            <tbody>
                                                <?php displayFoodItems('breakfast', $selected_date); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Lunch -->
                    <div class="col-md-12">
                        <h2 style="color:#946cfc;">Lunch</h2>
                        <hr />
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive theme-scrollbar">
                                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                        <table class="display dataTable no-footer" id="basic-1" role="grid">
                                            <thead>
                                                <th>#</th>
                                                <th>Food Name</th>
                                                <th>Food Quantity
                                                </th>
                                                <th>Calories</th>
                                                <th>Protien</th>
                                                <th>Fat</th>
                                                <th>Carbs</th>
                                                <th>Sugar</th>
                                            </thead>
                                            <tbody>
                                                <?php displayFoodItems('lunch', $selected_date); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Dinner -->
                    <div class="col-md-12">
                        <h2 style="color:#946cfc;">Dinner</h2>
                        <hr />
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive theme-scrollbar">
                                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                        <table class="display dataTable no-footer" id="basic-1" role="grid">
                                            <thead>
                                                <th>#</th>
                                                <th>Food Name</th>
                                                <th>Food Quantity
                                                </th>
                                                <th>Calories</th>
                                                <th>Protien</th>
                                                <th>Fat</th>
                                                <th>Carbs</th>
                                                <th>Sugar</th>
                                            </thead>
                                            <tbody>
                                                <?php displayFoodItems('dinner', $selected_date); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Snacks -->
                    <div class="col-md-12">
                        <h2 style="color:#946cfc;">Snacks</h2>
                        <hr />
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive theme-scrollbar">
                                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                        <table class="display dataTable no-footer" id="basic-1" role="grid">
                                            <thead>
                                                <th>#</th>
                                                <th>Food Name</th>
                                                <th>Food Quantity
                                                </th>
                                                <th>Calories</th>
                                                <th>Protien</th>
                                                <th>Fat</th>
                                                <th>Carbs</th>
                                                <th>Sugar</th>
                                            </thead>
                                            <tbody>
                                                <?php displayFoodItems('snacks', $selected_date); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h2 class="text-center mb-3" style="color:#946cfc;">
                        Weight Tracker</h2>
                    <div class="row mt-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <?php
                                    $percentage = ($goal_weight > 0) ? ($current_weight / $goal_weight) * 100 : 0;
                                    ?>
                                    <canvas id="myGauge"></canvas>
                                    <h2 class="text-center mt-3">
                                        <?php echo $current_weight; ?>lb
                                        / <?php echo $goal_weight; ?> lb
                                    </h2>
                                    <p class="text-center mt-2">
                                        <?php echo $goal_weight - $current_weight ?>lbs
                                        to go!
                                    </p>
                                </div>

                                <div class="table-container">
                                    <table style="width:100%;margin-top:20px;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    Dates
                                                </th>
                                                <th class="text-center">
                                                    Logged</th>
                                                <th class="text-center">
                                                    Loss/Day</th>
                                                <th class="text-center">
                                                    Calories</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $last_8_days = [];
                                            for ($i = 0; $i < 8; $i++) {
                                                $date = date('Y-m-d', strtotime("-$i days"));
                                                $last_8_days[] = $date;
                                            }

                                            // Create a map of logged weights by date for easy lookup
                                            $logged_weights = [];
                                            foreach ($weight_history as $entry) {
                                                $log_date = date('Y-m-d', strtotime($entry['created_at']));
                                                $logged_weights[$log_date] = $entry['weight'];
                                            }

                                            // Loop through the last 8 days and display data
                                            foreach ($last_8_days as $index => $date) {
                                                $day_of_month = date('d', strtotime($date)); // Get day of the month
                                                $day_name = date('D', strtotime($date));
                                                $display_date = $day_of_month . "<br/>" . $day_name;
                                                $logged_weight = isset($logged_weights[$date]) ? $logged_weights[$date] . 'lb' : '-';
                                                $loss = $index > 0 && isset($logged_weights[$last_8_days[$index - 1]]) ?
                                                    round($logged_weights[$last_8_days[$index - 1]] - ($logged_weights[$date] ?? 0), 2) . ' lb' : '-';
                                                $calories = $calories_sum[$date] ?? 0;

                                                echo "<tr class='text-center' style='border-bottom:1px solid #000'>";
                                                echo "<td class='text-center'><p style='font-size:18px;padding-bottom:10px;padding-top:10px;'>
                                                    <a href='?id={$_GET['id']}&date={$date}'>{$display_date}</a>
                                                    </p></td>";
                                                echo "<td class='text-center'><p style='font-size:22px;color:skyblue;'>{$logged_weight}<p></td>";
                                                echo "<td class='text-center'><p style='font-size:22px;'>{$loss}</p></td>";
                                                echo "<td class='text-center'><p style='font-size:22px;'>{$calories} Kal</p></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Food</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="food_type">
                <input type="text" id="foodSearch" class="form-control" placeholder="Search for food..." oninput="fetchFoodData()">
                <!-- Display search results -->
                <ul class="list-group mt-3" id="searchResults"></ul>
            </div>
        </div>
    </div>
</div>


<!-- SCRIPT TO SEARCH AND ADD FOOD -->
<script>
    // Open modal with selected food type
    function openModal(foodOption) {
        document.getElementById('modalTitle').innerText = "Add " + foodOption;
        document.getElementById('foodSearch').value = ''; // Clear search input
        document.getElementById('searchResults').innerHTML = ''; // Clear previous results
        var modal = new bootstrap.Modal(document.getElementById('foodModal'));
        document.getElementById('food_type').value = foodOption; // Clear search input
        modal.show();
    }

    // Fetch food data from Edamam API
    function fetchFoodData() {
        const query = document.getElementById('foodSearch').value;
        if (query.length < 3) return; // Avoid too many requests for short queries

        fetch(`https://api.edamam.com/api/food-database/v2/parser?app_id=f73b06f6&app_key=562df73d9c2324199c25a9b8088540ba&ingr=${query}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log("Food", data)
                const searchResults = document.getElementById('searchResults');
                searchResults.innerHTML = ''; // Clear previous results

                // Edamam stores food items in the 'parsed' and 'hints' arrays
                const foodItems = [...data.parsed, ...data.hints.map(hint => hint.food)];
                const validFoodItems = foodItems.filter(item => item.nutrients && Object.keys(item.nutrients).length > 0);
                validFoodItems.forEach(item => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.innerHTML = item.label || `${item.food.label}`;
                    li.onclick = () => selectFoodItem(item, li); // Pass the selected item and the li element
                    searchResults.appendChild(li);
                });
            })
            .catch(error => console.error('Error fetching food data:', error));
    }

    // Select food item and display its details directly beneath the clicked item
    function selectFoodItem(food, listItem) {
        // Remove any existing expanded sections
        const existingExpandedRow = document.querySelector('.expanded-row');
        if (existingExpandedRow) existingExpandedRow.remove();

        // Create the expanded row to show details
        const expandedRow = document.createElement('div');
        expandedRow.classList.add('expanded-row');

        // Add content to expanded row
        expandedRow.innerHTML = `
            <h6>${food.label}</h6>
            <p>Enter amount:</p>
            <input type="number" id="foodAmount" class="form-control mb-2" value="1" placeholder="Amount" onchange="updateNutritionValues()">

            <!-- Dropdown for weighing unit -->
            <select id="weighingUnit" class="form-control mb-2" onchange="updateNutritionValues()">
            </select>

            <!-- Display nutritional info -->
            <div id="nutritionInfo">
                <p>Calories: <span id="calories">${food.nutrients.ENERC_KCAL || '0'}</span></p>
                <p>Total Fat: <span id="fat">${food.nutrients.FAT || '0g'}</span></p>
                <p>Sat. Fat: <span id="satFat">${food.nutrients.FASAT || '0g'}</span></p>
                <p>Cholest.: <span id="cholesterol">${food.nutrients.CHOLE || '0mg'}</span></p>
                <p>Sodium: <span id="sodium">${food.nutrients.NA || '0mg'}</span></p>
                <p>Carb.: <span id="carbs">${food.nutrients.CHOCDF || '0g'}</span></p>
                <p>Fiber: <span id="fiber">${food.nutrients.FIBTG || '0g'}</span></p>
                <p>Sugars: <span id="sugars">${food.nutrients.SUGAR || '0g'}</span></p>
                <p>Protein: <span id="protein">${food.nutrients.PROCNT || '0g'}</span></p>
            </div>

            <!-- Button to add food to the database -->
            <button type="button" class="btn btn-success mt-3" onclick="addFoodToDatabase('${food.foodId}', '${food.label}')">Add Food</button>
        `;

        // Insert the expanded row directly after the selected list item
        listItem.insertAdjacentElement('afterend', expandedRow);

        // Store the default calories per serving in a global variable for calculations
        expandedRow.dataset.caloriesPerServing = food.nutrients.ENERC_KCAL || 0;
        expandedRow.dataset.defaultServingSize = food.servingSize || 1; // Default serving size in the dataset
        expandedRow.dataset.defaultWeightGrams = food.servingWeight || 100; // Default weight in grams

        // Store nutritional data in the row for dynamic calculations
        expandedRow.dataset.fat = food.nutrients.FAT || 0;
        expandedRow.dataset.saturatedFat = food.nutrients.FASAT || 0;
        expandedRow.dataset.cholesterol = food.nutrients.CHOLE || 0;
        expandedRow.dataset.sodium = food.nutrients.NA || 0;
        expandedRow.dataset.carbs = food.nutrients.CHOCDF || 0;
        expandedRow.dataset.fiber = food.nutrients.FIBTG || 0;
        expandedRow.dataset.sugars = food.nutrients.SUGAR || 0;
        expandedRow.dataset.protein = food.nutrients.PROCNT || 0;

        // Populate the weighingUnit dropdown dynamically
        populateWeighingUnits(food);
    }

    // Populate weighing units dynamically
    function populateWeighingUnits(food) {
        const unitSelect = document.getElementById('weighingUnit');
        unitSelect.innerHTML = ''; // Clear previous options

        // Default to "grams" if no specific serving units are available
        let units = ['g', 'oz', 'lb'];

        if (food.servingUnit) {
            units = [food.servingUnit, 'g', 'oz', 'lb'];
        }

        units.forEach(unit => {
            const option = document.createElement('option');
            option.value = unit;
            option.text = unit.charAt(0).toUpperCase() + unit.slice(1);
            unitSelect.appendChild(option);
        });
    }

    // Update nutritional values dynamically based on selected unit and amount
    function updateNutritionValues() {
        const amount = document.getElementById('foodAmount').value || 1;
        const unit = document.getElementById('weighingUnit').value;
        const expandedRow = document.querySelector('.expanded-row');

        if (!expandedRow) return;

        const caloriesPerServing = expandedRow.dataset.caloriesPerServing;
        const defaultServingSize = expandedRow.dataset.defaultServingSize;
        const defaultWeightGrams = expandedRow.dataset.defaultWeightGrams;

        // Conversion factors for other units
        const unitToGrams = {
            g: 1,
            oz: 28.35,
            lb: 453.59
        };

        // Calculate the factor to adjust based on the selected unit and amount
        const weightInGrams = unitToGrams[unit] * amount;

        // Scaling factor for nutritional values
        const scalingFactor = weightInGrams / defaultWeightGrams;

        // Dynamically update all nutritional values
        document.getElementById('calories').innerText = (caloriesPerServing * scalingFactor).toFixed(2);
        document.getElementById('fat').innerText = (expandedRow.dataset.fat * scalingFactor).toFixed(2) + 'g';
        document.getElementById('satFat').innerText = (expandedRow.dataset.saturatedFat * scalingFactor).toFixed(2) + 'g';
        document.getElementById('cholesterol').innerText = (expandedRow.dataset.cholesterol * scalingFactor).toFixed(2) + 'mg';
        document.getElementById('sodium').innerText = (expandedRow.dataset.sodium * scalingFactor).toFixed(2) + 'mg';
        document.getElementById('carbs').innerText = (expandedRow.dataset.carbs * scalingFactor).toFixed(2) + 'g';
        document.getElementById('fiber').innerText = (expandedRow.dataset.fiber * scalingFactor).toFixed(2) + 'g';
        document.getElementById('sugars').innerText = (expandedRow.dataset.sugars * scalingFactor).toFixed(2) + 'g';
        document.getElementById('protein').innerText = (expandedRow.dataset.protein * scalingFactor).toFixed(2) + 'g';
    }

    // Add the selected food to the database
    function addFoodToDatabase(foodId, label) {
        var food_type = document.getElementById('food_type').value;
        var selected_date = document.getElementById('selected_date').value;
        const foodData = {
            foodId: foodId, // Include food_id
            label: label, // Include label
            food_type: food_type,
            amount: document.getElementById('foodAmount').value,
            unit: document.getElementById('weighingUnit').value,
            calories: document.getElementById('calories').innerText,
            totalFat: document.getElementById('fat').innerText,
            satFat: document.getElementById('satFat').innerText,
            cholesterol: document.getElementById('cholesterol').innerText,
            sodium: document.getElementById('sodium').innerText,
            carbs: document.getElementById('carbs').innerText,
            fiber: document.getElementById('fiber').innerText,
            sugars: document.getElementById('sugars').innerText,
            protein: document.getElementById('protein').innerText,
            selected_date: selected_date,
        };

        // Send food data to the server (you'll need to define the actual endpoint)
        fetch('../functions/food_history/store.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(foodData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == "success") {
                    location.reload();
                } else {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>