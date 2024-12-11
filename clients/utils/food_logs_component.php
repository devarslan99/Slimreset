<style>
    @media (min-width: 1200px) {
        .lg-border-left-my-tracker {
            border-left: 5px solid #ddd;
        }
    }

    /* Style the modal and close button */

    .modal .fade {
        width: 100%;
        min-height: 100vh;
    }

    .modal-header .close {
        font-size: 1.5rem;
        color: #ff6b6b;
        opacity: 1;
        border: none;
        background: none;
        outline: none;
        cursor: pointer;
    }

    .modal-header .close:hover {
        color: #ff3d3d;
    }

    /* Center the modal */
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    /* Responsive form styling */
    .modal-body form {
        margin: 0 auto;
        max-width: 100%;
    }

    @media (max-width: 768px) {
        .modal-content {
            padding: 10px;
        }
    }
</style>

<div class="row ">
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <h2 class="text-center mb-3">
                    Let's track your day
                </h2>
                <div class="row">
                    <?php
                    $user_id = $_GET['id'];
                    $login_user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
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

                        $total_calories = isset($row['total_calories']) ? (int) $row['total_calories'] : 0;
                        $total_protein = isset($row['total_protein']) ? (int) $row['total_protein'] : 0;
                        $total_water = isset($row['total_water']) ? (int) $row['total_water'] : 0;
                        $total_bowel_movement = isset($row['total_bowel_movement']) ? (int) $row['total_bowel_movement'] : 0;

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
                        ];
                        
                        if ($login_user_role === "client") {
                            $metrics[] = [
                                'label' => 'bowel </br> Movements ',
                                'total' => $total_bowel_movement,
                                'max' => null,
                                'unit' => '',  
                                'color' => '', 
                            ];
                        } else {
                            $metrics[] = [
                                'label' => 'bowel </br> Movements </br> ',
                                'total' => $total_bowel_movement,
                                'max' => 2,
                                'unit' => 'bm',
                                'color' => 'green'
                            ];
                        }
                        

                        foreach ($metrics as $metric) {
                            $remaining = $metric['max'] - $metric['total'];
                    ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <div class="d-flex flex-column align-items-center justify-content-center p-1" style="min-width: 170px; height:100%; border-radius: 20px; border: 1px solid #946CFC; text-align: center;">
                                    <span style="font-size: 20px; display: block;"><?php echo $metric['label']; ?></span>
                                    <h1 class="my-2" style="font-weight: 800; color:#000;">
                                        <?php
                                        if ($metric['label'] === 'bowel </br> Movements ') {
                                            echo $metric['total'] . ' bm';
                                        } else {
                                            echo $metric['total'] . ' ' . $metric['unit']; 
                                        }
                                        ?>
                                    </h1>
                                    <?php if (isset($metric['max'])): ?>
                                        <span class="my-2" style="font-size: 20px; display: block;">of <span style="font-weight: bold;color:#000"><?php echo $metric['max']; ?></span> <?php echo $metric['unit']; ?></span>
                                        <span style="font-size: 20px; font-weight: 500; color: <?php echo $metric['color']; ?>; display: block;">
                                            <span style="font-weight:800;"> <?php echo ($metric['max'] - $metric['total']) . ' ' . $metric['unit'] . ' left'; ?> </span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                    <?php
                        }
                    } else {
                        echo "Error executing query: " . mysqli_error($mysqli);
                    }

                    ?>
                </div>
                <div class="col-md-12 mt-3 ">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="">
                                <div class="main-color text-center my-3">
                                    <i class="fa fa-calendar me-2 fw-bold fs-4" id="calendar-icon-2" style="cursor: pointer;"></i>
                                    <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $prev_date; ?>">
                                        <i class="fa fa-angle-left fw-bold fs-4"></i>
                                    </a>
                                    <h3 class="text-center mx-2 d-inline main-color">
                                        <?php echo date('M d, Y', strtotime($selected_date)); ?>
                                    </h3>
                                    <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $next_date; ?>">
                                        <i class="fa fa-angle-right fw-bold fs-4"></i>
                                    </a>

                                    <!-- Hidden input field for Flatpickr calendar -->
                                    <input type='text' id="datepicker-2" style="display:none; width:0px;height:0px;outline:none;border:none;display:'block">

                                </div>
                            </div>
                        </div>
                        <!-- Food logs data -->
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
                                            <td>
                                                <button class="btn btn-primary edit-btn" onclick="openFoodUpdateModal('<?php echo $mealType ?>','<?php echo $row['label']; ?>', '<?php echo $row['id']; ?>')">
                                                    <i class="fa fa-pencil"></i>
                                                </button>

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
                                <h2 style="color: #946cfc;">breakfast</h2>
                                <hr />
                                <div class="card bg-shadow-none">
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-breakfast" role="grid">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Food Name</th>
                                                        <th>Food Quantity
                                                        </th>
                                                        <th>Calories</th>
                                                        <th>Protein</th>
                                                        <th>Fat</th>
                                                        <th>Action</th>
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
                                <div class="card bg-shadow-none">
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-lunch" role="grid">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Food Name</th>
                                                        <th>Food Quantity
                                                        </th>
                                                        <th>Calories</th>
                                                        <th>Protein</th>
                                                        <th>Fat</th>
                                                        <th>Action</th>
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
                                <div class="card bg-shadow-none">
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-dinner" role="grid">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Food Name</th>
                                                        <th>Food Quantity
                                                        </th>
                                                        <th>Calories</th>
                                                        <th>Protien</th>
                                                        <th>Fat</th>
                                                        <th>Action</th>
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
                                <div class="card bg-shadow-none">
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-snack" role="grid">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Food Name</th>
                                                        <th>Food Quantity </th>
                                                        <th>Calories</th>
                                                        <th>Protein</th>
                                                        <th>Fat</th>
                                                        <th>Action</th>
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
                </div>
            </div>
            <!-- Weight tracker -->
            <div class="col-xl-4 lg-border-left-my-tracker">
                <div class="row">
                    <h2 class="text-center mb-3">Weight Tracker</h2>
                    <div class="row mt-2">
                        <div class="card bg-shadow-none">
                            <div class="card-body">
                                <div class="">
                                    <?php
                                    $percentage = ($goal_weight > 0) ? ($current_weight / $goal_weight) * 100 : 0;
                                    ?>
                                    <h1 class="text-center h1 fw-bold mt-3 main-color">
                                        <?php echo $current_weight; ?>lbs
                                    </h1>
                                    <p class="text-center mt-2">
                                        <strong class="font-weight:800;color:#000;"><?php echo $goal_weight; ?>lbs</strong> goal weight
                                    </p>
                                </div>
                                <div class="row text-center my-4 justify-content-center">
                                    <div class="col-auto">
                                        <div class="stat-item">
                                            <span class="fw-bold h4"><?php echo $weight_lost; ?>lbs</span>
                                            <p class="mb-0">lost</p>
                                        </div>
                                    </div>
                                    <div class="col-auto position-relative">
                                        <div class="vertical-line"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat-item">
                                            <span class="fw-bold h4"><?php echo $weight_to_goal; ?>lbs</span>
                                            <p class="mb-0">to go</p>
                                        </div>
                                    </div>
                                    <div class="col-auto position-relative">
                                        <div class="vertical-line"></div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat-item">
                                            <span class="fw-bold h4"><?php echo $days_left; ?>d</span>
                                            <p class="mb-0">to go</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-container">
                                    <table style="width:100%;margin-top:20px;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Days</th>
                                                <th class="text-center">Weight</th>
                                                <th class="text-center">Loss</th>
                                                <th class="text-center">Protein</th>
                                                <th class="text-center">Calories</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $last_5_days = [];
                                            $last_5_weights = array_slice($weights, -5);
                                            $last_5_dates = array_slice($dates, -5);
                                            for ($i = 0; $i < 5; $i++) {
                                                $date = date('Y-m-d', strtotime("-$i days"));
                                                $last_5_days[] = $date;
                                            }
                                            $logged_weights = [];
                                            foreach ($weight_history as $entry) {
                                                $log_date = date('Y-m-d', strtotime($entry['created_at']));
                                                $logged_weights[$log_date] = $entry['weight'];
                                            }
                                            foreach ($last_5_days as $index => $date) {
                                                $day_of_month = date('d', strtotime($date));
                                                $day_name = date('D', strtotime($date));
                                                $display_date = "<a href='?id=" . $_GET['id'] . "&date={$date}'>{$day_of_month}<br/>{$day_name}</a>";

                                                $logged_weight = isset($logged_weights[$date]) ? $logged_weights[$date] : '-';
                                                $loss = $index > 0 && isset($logged_weights[$last_5_days[$index - 1]]) ? round($logged_weights[$last_5_days[$index - 1]] - ($logged_weights[$date] ?? 0), 2) : '-';

                                                // Determine the arrow icon for loss or gain
                                                $arrow = '';
                                                if ($loss !== '-') {
                                                    // If weight is lost: Green Down Arrow
                                                    if ($loss > 0) {
                                                        $arrow = "<span style='color: green;'>↓</span>";
                                                    }
                                                    // If weight is gained or no loss: Red Up Arrow
                                                    elseif ($loss <= 0) {
                                                        $arrow = "<span style='color: red;'>↑</span>";
                                                    }
                                                }

                                                $protein = isset($protein_data[$date]) ? $protein_data[$date] : '-';
                                                $calories = $calories_sum[$date] ?? '-';

                                                echo "<tr class='text-center' style='border-bottom:1px solid #000'>";
                                                echo "<td class='text-center'><p style='font-size:18px;padding-bottom:10px;padding-top:10px;'>{$display_date}</p></td>";
                                                echo "<td class='text-center'><p style='font-size:18px;padding-bottom:10px;padding-top:10px;'>{$logged_weight}</p></td>";
                                                echo "<td class='text-center'><p style='font-size:22px'>{$loss} {$arrow}</p></td>";
                                                echo "<td class='text-center'><p style='font-size:22px;'>" . number_format((float) ($protein ?? 0), 2, '.', '') . "</p></td>";
                                                echo "<td class='text-center'><p style='font-size:22px;'>" . number_format((float) ($calories ?? 0), 2, '.', '') . "</p></td>";
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

<!-- Edit Meal Modal -->
<div class="modal fade" id="mealEditModal" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTitle">Edit Meal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="mealEditType">
                <input type="hidden" id="idForMealUpdate">
                <input type="text" id="mealEditSearch" class="form-control" placeholder="Search for meal..." oninput="fetchFoodDataForModal()">
                <!-- Display search results -->
                <ul class="list-group mt-3" id="editSearchResults"></ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Script for datepicker -->
<script>
    $(document).ready(function() {
        flatpickr("#datepicker-2", {
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                var userId = "<?php echo $_GET['id']; ?>";
                window.location.href = "?id=" + userId + "&date=" + dateStr;
            }
        });

        $("#calendar-icon-2").click(function() {
            $("#datepicker-2").toggle();
            $("#datepicker-2").focus();
        });
    });
</script>

<!-- SCRIPT TO SEARCH AND UPDATE FOOD -->
<script>
    // Open the modal for a specific meal type and ID
    function openFoodUpdateModal(mealType, label, mealId) {
        const modal = new bootstrap.Modal(document.getElementById('mealEditModal'));
        modal.show();

        const mealIdInput = document.getElementById('mealId');
        const foodSearchInput = document.getElementById('mealEditSearch');
        const searchResults = document.getElementById('editSearchResults');
        document.getElementById("idForMealUpdate").value = mealId;
        document.getElementById('mealEditType').value = mealType;

        foodSearchInput.value = label;

        searchResults.innerHTML = '';

        // Trigger search based on the label
        fetchFoodDataForModal();
    }


    // Fetch food data dynamically
    function fetchFoodDataForModal() {
        const query = document.getElementById('mealEditSearch').value;

        if (query.length < 3) return; // Avoid too many requests for short queries

        fetch(`https://api.edamam.com/api/food-database/v2/parser?app_id=f73b06f6&app_key=562df73d9c2324199c25a9b8088540ba&ingr=${query}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const searchResults = document.getElementById('editSearchResults');
                searchResults.innerHTML = '';

                const foodItems = [...data.parsed, ...data.hints.map(hint => hint.food)];
                const validFoodItems = foodItems.filter(item => item.nutrients && Object.keys(item.nutrients).length > 0);

                validFoodItems.forEach(item => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.innerHTML = item.label || `${item.food.label}`;
                    li.onclick = () => selectFoodItemForModal(item, li);
                    searchResults.appendChild(li);
                });
            })
            .catch(error => console.error('Error fetching food data:', error));
    }

    // Select a food item
    function selectFoodItemForModal(food, listItem) {
        const existingExpandedRow = document.querySelector('#searchResults .expanded-row');
        if (existingExpandedRow) existingExpandedRow.remove();

        const expandedRow = document.createElement('div');
        expandedRow.classList.add('expanded-row');
        expandedRow.innerHTML = `
                    <h6>${food.label}</h6>
                    <p>Enter amount:</p>
                    <input type="number" id="foodAmount" class="form-control mb-2" value="1" placeholder="Amount" onchange="updateNutritionValuesForModal()">

                    <!-- Dropdown for weighing unit -->
                    <select id="weighingUnit" class="form-control mb-2" onchange="updateNutritionValuesForModal()">
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

                    <!-- Button to update food to the database -->
                    <button type="button" class="btn btn-success my-3" onclick="updateFoodToDatabase('${food.foodId}', '${food.label}')">Update Food</button>
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
        populateWeighingUnitsForModal(food);
    }

    // Populate weighing units dynamically
    function populateWeighingUnitsForModal(food) {
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
    function updateNutritionValuesForModal() {
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
    function updateFoodToDatabase(foodId, label) {
        var mealEditType = document.getElementById('mealEditType').value;
        var selected_date = document.getElementById('selected_date').value;
        var modal = bootstrap.Modal.getInstance(document.getElementById('mealEditModal'));
        const updatedMealId = document.getElementById("idForMealUpdate").value;
        const foodData = {
            foodId: foodId,
            id: updatedMealId,
            label: label,
            food_type: mealEditType,
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
            loginUserRole: "<?php echo $login_user_role ?>",
            userId: "<?php echo $client_user_id ?>"
        };

        // Update food data to the server (you'll need to define the actual endpoint)
        fetch('../functions/food_history/update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(foodData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == "success") {
                    modal.hide();
                    Swal.fire("Success", "Food update successfully!", "success")
                        .then(() => location.reload())
                } else {
                    swal("Error", "Failed to update food.", "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>