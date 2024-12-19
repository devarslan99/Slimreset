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
$maintenance_end_date = date('Y-m-d', strtotime("$course_end_date +$course_time days"));

$weight_lost = 0;
if (!empty($weights)) {
    $oldest_weight = $weights[0];
    $current_weight = end($weights);

    $weight_lost = $oldest_weight - $current_weight;
}

$weight_to_goal = $current_weight - $goal_weight;

$current_date = new DateTime();
$end_date = new DateTime($course_end_date);
$days_left = $current_date < $end_date ? $current_date->diff($end_date)->days : 0;

function formatDate($dateString)
{
    $date = new DateTime($dateString);
    return $date->format('F j, Y');
}


// Fetch protein data for the last 5 days
$last_5_days = [];
for ($i = 0; $i < 5; $i++) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $last_5_days[] = $date;
}

$placeholders = implode(',', array_fill(0, count($last_5_days), '?'));

$query_protein = "
    SELECT 
        DATE(created_at) AS record_date, 
        SUM(protein) AS total_protein 
    FROM 
        food_items 
    WHERE 
        user_id = ? 
        AND DATE(created_at) IN ($placeholders)
    GROUP BY 
        record_date
";

$stmt_protein = $mysqli->prepare($query_protein);
$params = array_merge([$user_id], $last_5_days);
$stmt_protein->bind_param(str_repeat('s', count($params)), ...$params);
$stmt_protein->execute();
$result_protein = $stmt_protein->get_result();

$protein_data = [];
while ($row = $result_protein->fetch_assoc()) {
    $protein_data[$row['record_date']] = $row['total_protein'];
}
?>

<style>
    .custom-tabs {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        width: 100%;
    }

    .custom-tabs .custom-tab-item {
        list-style: none;
        margin-right: 10px;
    }

    .custom-tabs .custom-tab-button {
        background-color: transparent;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-weight: bold;
        color: #333;
        text-transform: lowercase;
        transition: all 0.3s ease;
    }

    .custom-tabs .custom-tab-button:hover {
        color: #936CFB;
    }

    .custom-tabs .custom-tab-button.active {
        color: #936CFB;
        border-bottom: 2px solid #936CFB;
    }

    .custom-tab-content {
        display: none;
        border-radius: 5px;
    }

    .custom-tab-content.active {
        display: block;
    }
</style>

<div class="container">
    <div class="row">
        <!-- Left Side Tabs -->
        <div class="col-lg-8">
            <h2 class="fw-bold text-center mb-4">My Progress</h2>
            <div class="d-flex flex-column">
                <!-- Custom Tabs -->
                <ul class="custom-tabs" id="myProgressTabs">
                    <li class="custom-tab-item">
                        <button class="custom-tab-button active" data-target="my_progress_weight_loss">Weight Loss</button>
                    </li>
                    <li class="custom-tab-item">
                        <button class="custom-tab-button" data-target="my_progress_intolerances">Intolerances</button>
                    </li>
                    <li class="custom-tab-item">
                        <button class="custom-tab-button" data-target="my_progress_nutrients">Nutrient Deficiencies</button>
                    </li>
                    <li class="custom-tab-item">
                        <button class="custom-tab-button" data-target="my_progress_toxins">Toxins</button>
                    </li>
                </ul>

                <!-- Custom Tab Content -->
                <div class="col-md-9" style="width:100%;">
                    <div id="my_progress_weight_loss" class="custom-tab-content active">
                        <div class="row">
                            <div id="chartContainer" style="height: 515px !important;">
                                <canvas id="weightChart" style="height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div id="my_progress_intolerances" class="custom-tab-content">
                        <?php include 'intolerances.php'; ?>
                    </div>

                    <div id="my_progress_nutrients" class="custom-tab-content">
                        <p>Nutrient deficiencies content coming soon...</p>
                    </div>

                    <div id="my_progress_toxins" class="custom-tab-content">
                        <p>Toxins content coming soon...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weight tracker -->
        <div class="col-lg-4 lg-mt-col lg-border-left">
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
                                <h1 class="text-center h1 fw-bold mt-3 " style="color: #000000;">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const currentWeight = <?php echo isset($current_weight) ? $current_weight : 0; ?>;
    const goalWeight = <?php echo isset($goal_weight) ? $goal_weight : 0; ?>;
    const accountCreationDate = '<?php echo !empty($account_creation_date) ? date('M d', strtotime($account_creation_date)) : "Jan 01"; ?>';
    const courseEndDate = '<?php echo !empty($course_end_date) ? date('M d', strtotime($course_end_date)) : "Dec 31"; ?>';

    const weights = [<?php echo implode(",", $weights); ?>];

    const dates = [<?php echo '"' . implode('","', $dates) . '"'; ?>];

    const calories = weights.map(w => w * 10);

    const ctxchart = document.getElementById('weightChart').getContext('2d');
    const weightChart = new Chart(ctxchart, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: 'Weight',
                    data: weights,
                    borderColor: '#5657e7',
                    backgroundColor: '#e3e4fc',
                    borderWidth: 3,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#5657e7',
                    pointRadius: 5,
                    fill: true
                },
                {
                    label: 'Calories',
                    data: calories,
                    borderColor: '#f69566',
                    backgroundColor: 'rgba(255, 87, 51, 0.2)',
                    borderWidth: 3,
                    tension: 0.4, // Smooth curve
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#f69566',
                    pointRadius: 5,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date',
                        font: { weight: 'bold' },
                        color: '#333'
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Values',
                        font: { weight: 'bold' },
                        color: '#333'
                    },
                    beginAtZero: false,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll('.custom-tab-button');
        const tabContents = document.querySelectorAll('.custom-tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.dataset.target;

                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to the clicked button and corresponding content
                this.classList.add('active');
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>