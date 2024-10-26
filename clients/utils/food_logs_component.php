<div class="row">
    <div class="col-md-8">
        <!-- FOOD CHARTS -->
        <div class="row">
            <?php
            $user_id = $_GET['id'];
            $selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
            // Prepare the SQL query
            $sql = "SELECT (SELECT SUM(calories) FROM food_items WHERE user_id = $user_id AND DATE(created_at) = '$selected_date') AS total_calories,
        (SELECT SUM(protein) FROM food_items WHERE user_id = $user_id AND DATE(created_at) = '$selected_date') AS total_protein,
        (SELECT SUM(water) FROM water_records WHERE user_id = $user_id AND DATE(created_at) = '$selected_date') AS total_water,
        (SELECT SUM(bowel_movement) FROM bowel_movements WHERE user_id = $user_id AND DATE(created_at) = '$selected_date') AS total_bowel_movement";

            // Execute the query
            $result = mysqli_query($mysqli, $sql);
            // Check if the query was successful
            if ($result) {
                $row = mysqli_fetch_assoc($result);

                $total_calories = $row['total_calories'] ? $row['total_calories'] : 0;
                $total_protein = $row['total_protein'] ? $row['total_protein'] : 0;
                $total_water = $row['total_water'] ? $row['total_water'] : 0;
                $total_bowel_movement = $row['total_bowel_movement'] ? $row['total_bowel_movement'] : 0;
                ?>
                <div class="col-md-3">
                    <canvas id="calories_gauge"></canvas>
                    <h2 class="text-center">
                        <?php echo $total_calories ?> Kal
                    </h2>
                    <p class="text-center">of 800 kal</p>
                </div>
                <div class="col-md-3">
                    <canvas id="protein_gauge"></canvas>
                    <h2 class="text-center">
                        <?php echo $total_protein ?> oz
                    </h2>
                    <p class="text-center">of 10.5 oz</p>
                </div>
                <div class="col-md-3">
                    <canvas id="water_gauge"></canvas>
                    <h2 class="text-center">
                        <?php echo $total_water ?> cups
                    </h2>
                    <p class="text-center">of 12 cups</p>
                </div>
                <div class="col-md-3">
                    <canvas id="bowel_gauge"></canvas>
                    <h2 class="text-center">
                        <?php echo $total_bowel_movement ?> bm
                    </h2>
                    <p class="text-center">of 2 bm</p>
                </div>
                <?php
            } else {
                echo "Error executing query: " . mysqli_error($mysqli);
            }
            ?>
        </div>
        <div class="row" style="margin-top:20px;">
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
            $prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
            $next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));
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
    <!-- WEIGHT TRACKER -->
    <div class="col-md-4">
        <h2 class="text-center mb-3" style="color:#946cfc;">
            Weight Tracker</h2>
        <div class="row">
            <div class="col-md-3">
                <center>
                    <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $prev_date; ?>" class="btn btn-primary"><i
                            class="fa fa-angle-left"></i></a>
                </center>
            </div>
            <div class="col-md-6">
                <h3 class="text-center">
                    <?php echo date('l M d, Y', strtotime($selected_date)); ?>
                </h3>
                <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
            </div>
            <div class="col-md-3">
                <center>
                    <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $next_date; ?>" class="btn btn-primary"><i
                            class="fa fa-angle-right"></i></a>
                </center>
            </div>
        </div>
        <div class="row mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="speedometer">
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
                                    echo "<td class='text-center'><p style='font-size:18px;padding-bottom:10px;padding-top:10px;'>{$display_date}</p></td>";
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