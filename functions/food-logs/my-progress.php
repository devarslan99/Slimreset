<?php

$user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

$query = "
    SELECT 
        users.*, 
        weight_records.weight, 
        weight_records.created_at AS weight_date, 
        medical_intake.goal_weight, 
        medical_intake.course_time 
    FROM 
        users
    LEFT JOIN 
        weight_records ON users.id = weight_records.user_id
    LEFT JOIN 
        medical_intake ON users.id = medical_intake.user_id
    WHERE 
        users.role = 'client' 
        AND users.id = ?";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$current_weight = null;
$goal_weight = null;
$account_creation_date = null;
$course_time = null;
$weights = [];
$dates = [];

while ($row = $result->fetch_assoc()) {
    $startDate = $row['created_at'];
    if ($current_weight === null) {
        $current_weight = $row['weight'];
        $goal_weight = $row['goal_weight'];
        $account_creation_date = $row['created_at'];
        $course_time = $row['course_time'];
    }
    $weights[] = $row['weight'];
    $dates[] = date('M d', strtotime($row['weight_date']));
}

$course_end_date = date('Y-m-d', strtotime("$account_creation_date +$course_time days"));
$formatted_end_date = date('M d', strtotime($course_end_date));

function formatDate($dateString)
{
    $date = new DateTime($dateString);
    return $date->format('F j, Y');
}

?>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
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
                        <div class="mb-4 lg-mt-col">
                            <h4 class="main-color">
                                Start date
                            </h4>
                            <h5 class="mt-3">
                                <?php echo formatDate($startDate); ?>
                            </h5>
                        </div>
                        <div class="mb-4">
                            <h4 class="main-color">
                                Projected date to goal
                            </h4>
                            <h5 class="mt-3">
                                <?php echo formatDate($course_end_date) ?>
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
        <div class="col-lg-4 lg-mt-col">
            <div class="row">
                <h2 class="text-center">
                    Weight Tracker</h2>
                <div class="row">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="">
                                <?php
                                $percentage = ($goal_weight > 0) ? ($current_weight / $goal_weight) * 100 : 0;
                                ?>
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
                                        $last_5_days = [];
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
                                            $logged_weight = isset($logged_weights[$date]) ? $logged_weights[$date] . 'lb' : '-';
                                            $loss = $index > 0 && isset($logged_weights[$last_5_days[$index - 1]]) ?
                                                round($logged_weights[$last_5_days[$index - 1]] - ($logged_weights[$date] ?? 0), 2) . ' lb' : '-';
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const currentWeight = <?php echo isset($current_weight) ? $current_weight : 0; ?>;
    const goalWeight = <?php echo isset($goal_weight) ? $goal_weight : 0; ?>;
    const accountCreationDate = '<?php echo !empty($account_creation_date) ? date('M d', strtotime($account_creation_date)) : "Jan 01"; ?>';
    const courseEndDate = '<?php echo !empty($course_end_date) ? date('M d', strtotime($course_end_date)) : "Dec 31"; ?>';

    const weights = [<?php echo implode(",", $weights); ?>];

    const dates = [<?php echo '"' . implode('","', $dates) . '"'; ?>];

    const ctxchart = document.getElementById('weightChart').getContext('2d');
    const weightChart = new Chart(ctxchart, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Weight (lbs)',
                data: weights,
                borderColor: '#3e95cd',
                fill: true,
                backgroundColor: 'rgba(62, 149, 205, 0.2)',
                tension: 0.2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    min: Math.min(...weights) - 5,
                    max: Math.max(...weights) + 5,
                    title: {
                        display: true,
                        text: 'Weight (lbs)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                annotation: {
                    annotations: {
                        goalWeightLine: {
                            type: 'line',
                            yMin: goalWeight,
                            yMax: goalWeight,
                            borderColor: 'green',
                            borderWidth: 2,
                            label: {
                                content: `Goal Weight: ${goalWeight} lbs`,
                                enabled: true,
                                position: 'start',
                                backgroundColor: 'rgba(0, 255, 0, 0.2)'
                            }
                        },
                        currentWeightLine: {
                            type: 'line',
                            yMin: currentWeight,
                            yMax: currentWeight,
                            borderColor: 'red',
                            borderWidth: 2,
                            label: {
                                content: `Starting Weight: ${currentWeight} lbs`,
                                enabled: true,
                                position: 'end',
                                backgroundColor: 'rgba(255, 0, 0, 0.2)'
                            }
                        }
                    }
                }
            }
        }
    });
</script>