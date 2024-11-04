<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="text-center mb-3">
                    Let's track your meal
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
                <div class="col-md-12 mt-5">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
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

<!-- WEIGHT TRACKER AND FOOD LOGS-->