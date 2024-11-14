<style>
    @media (min-width: 1200px) {
        .lg-border-left-my-tracker {
            border-left: 5px solid #ddd;
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

                        $total_calories = number_format((float) ($row['total_calories'] ?? 0), 2, '.', '');
                        $total_protein = number_format((float) ($row['total_protein'] ?? 0), 2, '.', '');
                        $total_water = number_format((float) ($row['total_water'] ?? 0), 2, '.', '');
                        $total_bowel_movement = number_format((float) ($row['total_bowel_movement'] ?? 0), 2, '.', '');

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
                                <div class="d-flex flex-column align-items-center justify-content-center p-1" style="min-width: 170px; border-radius: 20px; border: 1px solid #946CFC; text-align: center;">
                                    <span style="font-size: 20px; display: block;"><?php echo $metric['label']; ?></span>
                                    <h1 class="my-2" style="font-weight: 800;color:#000;">
                                        <?php echo $metric['total'] . ' ' . $metric['unit']; ?>
                                    </h1>
                                    <span class="my-2" style="font-size: 20px; display: block;">of <span style="font-weight: bold;color:#000"><?php echo $metric['max']; ?></span> <?php echo $metric['unit']; ?></span>
                                    <span style="font-size: 20px; font-weight: 500; color: <?php echo $metric['color']; ?>; display: block;">
                                        <span style="font-weight:800;"> <?php echo $remaining . ' ' . $metric['unit'] . ' left'; ?> </span>
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
                                <h2 style="color: #946cfc;">Breakfast</h2>
                                <hr />
                                <div class="card bg-shadow-none">
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
                                                        <th>Protein</th>
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
                                <div class="card bg-shadow-none">
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
                                <div class="card bg-shadow-none">
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
                                <div class="card bg-shadow-none">
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-1" role="grid">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Food Name</th>
                                                        <th>Food Quantity </th>
                                                        <th>Calories</th>
                                                        <th>Protein</th>
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
                </div>
            </div>
            <!-- Weight tracker -->
            <div class="col-xl-4 lg-border-left-my-tracker">
                <div class="row">
                    <h2 class="text-center mb-3">
                        Weight Tracker</h2>
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
                                        <?php echo $goal_weight; ?> goal weight
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
                                                <th class="text-center">
                                                    Days
                                                </th>
                                                <th class="text-center">
                                                    Weight
                                                </th>
                                                <th class="text-center">
                                                    Loss</th>
                                                <th class="text-center">
                                                    Protein</th>
                                                <th class="text-center">
                                                    Calories</th>
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
                                                $display_date = $day_of_month . "<br/>" . $day_name;
                                                $logged_weight = isset($logged_weights[$date]) ? $logged_weights[$date] : '-';
                                                $loss = $index > 0 && isset($logged_weights[$last_5_days[$index - 1]]) ?
                                                    round($logged_weights[$last_5_days[$index - 1]] - ($logged_weights[$date] ?? 0), 2) : '-';
                                                $protein = isset($protein_data[$date]) ? $protein_data[$date] : '-';
                                                $calories = $calories_sum[$date] ?? '-';

                                                echo "<tr class='text-center' style='border-bottom:1px solid #000'>";
                                                echo "<td class='text-center'><p style='font-size:18px;padding-bottom:10px;padding-top:10px;'>{$display_date}</p></td>";
                                                echo "<td class='text-center'><p style='font-size:18px;padding-bottom:10px;padding-top:10px;'>{$logged_weight}</p></td>";
                                                echo "<td class='text-center'><p style='font-size:22px'>{$loss}</p></td>";
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

<!-- WEIGHT TRACKER AND FOOD LOGS-->

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        // Initialize Flatpickr
        flatpickr("#datepicker-2", {
            dateFormat: "Y-m-d", // Set the date format to YYYY-MM-DD
            onChange: function(selectedDates, dateStr, instance) {
                // When a date is selected, update the URL with the selected date
                var userId = "<?php echo $_GET['id']; ?>"; // Get the user ID from the URL
                window.location.href = "?id=" + userId + "&date=" + dateStr; // Redirect to the new URL with the selected date
            }
        });

        // Toggle calendar popup on calendar icon click
        $("#calendar-icon-2").click(function() {
            $("#datepicker-2").toggle(); // Show the hidden datepicker input
            // Open the calendar automatically when the user clicks on the calendar icon
            $("#datepicker-2").focus(); // Focus to trigger the Flatpickr calendar
        });
    });
</script>