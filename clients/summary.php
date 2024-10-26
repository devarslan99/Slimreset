<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php" ?>
<style>
    #myGauge {
        max-width: 400px;
        max-height: 400px;
        margin: 0 auto;
    }
</style>

<?php
include_once '../database/db_connection.php';
$user_id = $_GET['id'];
// Fetch goal weight
$goal_sql = "SELECT goal_weight FROM medical_intake WHERE user_id = $user_id";
$goal_result = mysqli_query($mysqli, $goal_sql);
$goal_weight = mysqli_fetch_assoc($goal_result)['goal_weight'] ?? 0;

// Fetch the latest weight
$latest_weight_sql = "SELECT weight, created_at FROM weight_records WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 1";
$latest_weight_result = mysqli_query($mysqli, $latest_weight_sql);
$latest_weight_data = mysqli_fetch_assoc($latest_weight_result);
$current_weight = $latest_weight_data['weight'] ?? 0;
$current_date = $latest_weight_data['created_at'] ?? null;

// Fetch weight records for the last 8 days
$weight_history_sql = "SELECT weight, created_at FROM weight_records WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 8 DAY ORDER BY created_at ASC";
$weight_history_result = mysqli_query($mysqli, $weight_history_sql);
$weight_history = mysqli_fetch_all($weight_history_result, MYSQLI_ASSOC);

// Fetch total calories for the last 8 days
$calories_sql = "SELECT SUM(calories) as total_calories, DATE(created_at) as log_date FROM food_items WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 8 DAY GROUP BY log_date";
$calories_result = mysqli_query($mysqli, $calories_sql);
$calories_data = mysqli_fetch_all($calories_result, MYSQLI_ASSOC);
$calories_sum = [];
foreach ($calories_data as $cal) {
    $calories_sum[$cal['log_date']] = $cal['total_calories'];
}

// Calculate weight loss per day
$loss_per_day = [];
foreach ($weight_history as $index => $entry) {
    if ($index > 0) {
        $previous_weight = $weight_history[$index - 1]['weight'];
        $current_day_weight = $entry['weight'];
        $loss_per_day[] = round($previous_weight - $current_day_weight, 2);
    } else {
        $loss_per_day[] = 0;
    }
}
?>

<body>
    <?php include_once "../utils/loader.php" ?>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include_once "../utils/navbar.php" ?>
        <div class="page-body-wrapper">
            <?php include_once "../utils/sidebar.php" ?>
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="edit-profile">
                        <div class="row">
                            <?php
                            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                                $user_id = $_GET['id'];
                                $sql = "SELECT id,first_name,last_name FROM users WHERE id = $user_id";

                                $result = mysqli_query($mysqli, $sql);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                            ?>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4><?php echo $row['first_name'] ?><?php echo $row['last_name'] ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="horizontal-wizard-wrapper">
                                                    <div class="row g-3">
                                                        <div class="col-12 main-horizontal-header">
                                                            <div class="nav nav-pills horizontal-options" id="horizontal-wizard-tab" role="tablist" aria-orientation="vertical">
                                                                <a class="nav-link active" id="wizard-info-tab" data-bs-toggle="pill" href="#wizard-info" role="tab" aria-controls="wizard-info" aria-selected="true">
                                                                    <div class="horizontal-wizard">
                                                                        <div class="stroke-icon-wizard"></div>
                                                                        <div class="horizontal-wizard-content">
                                                                            <h6>Profile</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="nav-link" id="wizard-weight-tracker-tab" data-bs-toggle="pill" href="#wizard-weight-tracker" role="tab" aria-controls="wizard-weight-tracker" aria-selected="true">
                                                                    <div class="horizontal-wizard">
                                                                        <div class="stroke-icon-wizard"></div>
                                                                        <div class="horizontal-wizard-content">
                                                                            <h6>Weight Tracker</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="nav-link" id="bank-wizard-tab" data-bs-toggle="pill" href="#bank-wizard" role="tab" aria-controls="bank-wizard" aria-selected="false" tabindex="-1">
                                                                    <div class="horizontal-wizard">
                                                                        <div class="stroke-icon-wizard"></div>
                                                                        <div class="horizontal-wizard-content">
                                                                            <h6>Food Logs</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="nav-link" id="inquiry-wizard-tab" data-bs-toggle="pill" href="#inquiry-wizard" role="tab" aria-controls="inquiry-wizard" aria-selected="false" tabindex="-1">
                                                                    <div class="horizontal-wizard">
                                                                        <div class="stroke-icon-wizard"></div>
                                                                        <div class="horizontal-wizard-content">
                                                                            <h6>Meal Planner</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="nav-link" id="dev-saq-recipes-tab" data-bs-toggle="pill" href="#dev-saq-recipes" role="tab" aria-controls="dev-saq-recipes" aria-selected="false" tabindex="-1">
                                                                    <div class="horizontal-wizard">
                                                                        <div class="stroke-icon-wizard"></div>
                                                                        <div class="horizontal-wizard-content">
                                                                            <h6>Recipes</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <a class="nav-link" id="successful-wizard-tab" data-bs-toggle="pill" href="#successful-wizard" role="tab" aria-controls="successful-wizard" aria-selected="false" tabindex="-1">
                                                                    <div class="horizontal-wizard">
                                                                        <div class="stroke-icon-wizard"></div>
                                                                        <div class="horizontal-wizard-content">
                                                                            <h6>Messages </h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        <div class="col-12">
                                                            <div class="tab-content dark-field" id="horizontal-wizard-tabContent">
                                                                <div class="tab-pane fade active show" id="wizard-info" role="tabpanel" aria-labelledby="wizard-info-tab">
                                                                    <?php include_once "../clients/utils/profile_component.php" ?>
                                                                </div>
                                                                <div class="tab-pane fade active show" id="wizard-weight-tracker" role="tabpanel" aria-labelledby="wizard-weight-tracker-tab">
                                                                </div>
                                                                <div class="tab-pane fade" id="bank-wizard" role="tabpanel" aria-labelledby="bank-wizard-tab">
                                                                    <?php include_once "../clients/utils/food_logs_component.php" ?>
                                                                </div>
                                                                <div class="tab-pane fade" id="inquiry-wizard" role="tabpanel">
                                                                </div>
                                                                <div class="tab-pane fade" id="dev-saq-recipes" role="tabpanel">
                                                                </div>
                                                                <div class="tab-pane fade" id="successful-wizard" role="tabpanel">
                                                                    <?php include_once("../clients/utils/message_component.php") ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <?php include_once "../utils/footer.php" ?>
        </div>
    </div>
    <?php include_once "../utils/scripts.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function updateWrapperClass() {
            const pageWrapper = document.getElementById('pageWrapper');

            if (window.innerWidth <= 768) { // Assuming mobile screen width is 768px or less
                pageWrapper.classList.remove('horizontal-wrapper');
                pageWrapper.classList.add('compact-wrapper');
            } else {
                pageWrapper.classList.remove('compact-wrapper');
                pageWrapper.classList.add('horizontal-wrapper');
            }
        }

        // Run on page load
        updateWrapperClass();

        // Run on window resize
        window.addEventListener('resize', updateWrapperClass);
    </script>
    <!-- WEIGHT TRACKER GAUGE SCRIPT -->
    <script>
        const ctx = document.getElementById('myGauge').getContext('2d');

        // Create a gauge chart using Chart.js
        const gaugeChart = new Chart(ctx, {
            type: 'doughnut', // Use a doughnut chart to create a gauge effect
            data: {
                labels: ['Current Weight', 'Remaining Weight'],
                datasets: [{
                    data: [<?php echo $percentage; ?>, 100 - <?php echo $percentage; ?>], // Current vs Remaining
                    backgroundColor: ['#007bff', '#e9ecef'], // Blue for current, light gray for remaining
                    borderWidth: 0 // Remove border
                }]
            },
            options: {
                responsive: true,
                cutout: '70%', // Cut out the center to make it look like a gauge
                plugins: {
                    tooltip: {
                        enabled: false // Disable tooltips
                    },
                    legend: {
                        display: false // Disable legend
                    }
                }
            }
        });
    </script>

    <!-- NUTRIENTS GAUGES SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Doughnut Chart for Calories
            var caloriesCtx = document.getElementById('calories_gauge').getContext('2d');
            var caloriesChart = new Chart(caloriesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Calories Consumed', 'Remaining'],
                    datasets: [{
                        label: 'Calories',
                        data: [<?php echo $total_calories; ?>, 800 - <?php echo $total_calories; ?>],
                        backgroundColor: ['#FF6384', '#FFCDD2'],
                        hoverBackgroundColor: ['#FF6384', '#FFCDD2']
                    }]
                },
            });

            // Doughnut Chart for Protein
            var proteinCtx = document.getElementById('protein_gauge').getContext('2d');
            var proteinChart = new Chart(proteinCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Protein Consumed', 'Remaining'],
                    datasets: [{
                        label: 'Protein',
                        data: [<?php echo $total_protein; ?>, 10.5 - <?php echo $total_protein; ?>],
                        backgroundColor: ['#36A2EB', '#AED6F1'],
                        hoverBackgroundColor: ['#36A2EB', '#AED6F1']
                    }]
                },
            });

            // Doughnut Chart for Water
            var waterCtx = document.getElementById('water_gauge').getContext('2d');
            var waterChart = new Chart(waterCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Water Consumed', 'Remaining'],
                    datasets: [{
                        label: 'Water',
                        data: [<?php echo $total_water; ?>, 12 - <?php echo $total_water; ?>],
                        backgroundColor: ['#4BC0C0', '#D1F2EB'],
                        hoverBackgroundColor: ['#4BC0C0', '#D1F2EB']
                    }]
                },
            });

            // Doughnut Chart for Bowel Movements
            var bowelCtx = document.getElementById('bowel_gauge').getContext('2d');
            var bowelChart = new Chart(bowelCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Bowel Movements', 'Remaining'],
                    datasets: [{
                        label: 'Bowel Movements',
                        data: [<?php echo $total_bowel_movement; ?>, 2 - <?php echo $total_bowel_movement; ?>],
                        backgroundColor: ['#FFCE56', '#FDEBD0'],
                        hoverBackgroundColor: ['#FFCE56', '#FDEBD0']
                    }]
                },
            });
        });
    </script>
</body>

</html>