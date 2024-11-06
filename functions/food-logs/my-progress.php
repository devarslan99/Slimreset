<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2 class="text-center mb-5">
                My Progress
            </h2>
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div id="chartContainer">
                            <canvas id="weightChart"></canvas>
                        </div>
                        <h4 class="main-color">
                            Weight loss/per day
                        </h4>
                        <h5 class="mt-3">
                            You are losing 0.5 to 1lb per day
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="mb-4">
                            <h4 class="main-color">
                                Start date
                            </h4>
                            <h5 class="mt-3">
                                October 5, 2024
                            </h5>
                        </div>
                        <div class="mb-4">
                            <h4 class="main-color">
                                Projected date to goal
                            </h4>
                            <h5 class="mt-3">
                                November 1st, 2024
                            </h5>
                        </div>
                        <div class="mb-4">
                            <h4 class="main-color">
                                Stabilization begins
                            </h4>
                            <h5 class="mt-3">
                                November 1st, 2024
                            </h5>
                        </div>
                        <h4 class="main-color">
                            Maintenance begins
                        </h4>
                        <h5 class="mt-3">
                            November 1st, 2024
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weight tracker -->
        <div class="col-md-4">
            <div class="row">
                <h2 class="text-center mb-3" style="color:#946cfc;">
                    Weight Tracker</h2>
                <div class="row mt-2">
                    <div class="card shadow-none">
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
    </div>
</div>