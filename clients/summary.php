<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php" ?>
<style>
    #myGauge {
        max-width: 400px;
        max-height: 400px;
        margin: 0 auto;
    }

    /* Center the sub-tabs and give them spacing */
    #my-plan .nav {
        justify-content: center;
        /* Center the tabs horizontally */
    }

    .nav-link {
        margin: 0 10px;
        /* Add spacing between the tabs */
        padding: 10px 20px;
        /* Add padding inside each tab */
        border-radius: 5px;
        /* Rounded corners for the tabs */
        background-color: #f8f9fa;
        /* Default tab color */
        color: #000;
        /* Default tab text color */
        transition: background-color 0.3s, color 0.3s;
        /* Smooth transition for background and text color */
    }

    .nav-link.active {
        background-color: #007bff;
        /* Active tab color */
    }

    /* Target only the h6 inside the active nav-link */
    .nav-link.active h6 {
        color: #fff !important;
        /* Active tab text color */
    }

    /* Reset color for h6 in inactive tabs */
    .nav-link h6 {
        color: #000;
        /* Default tab text color */
    }

    .nav-link:hover {
        background-color: #e2e6ea;
        /* Hover effect */
    }

    /* Add spacing around the entire tab content */
    .tab-content {
        margin-top: 20px;
        /* Space above the tab content */
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
                            if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $sql = "SELECT id,first_name,last_name FROM users WHERE id = $user_id";

                                $result = mysqli_query($mysqli, $sql);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                            ?>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></h4>
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
                                                                <a class="nav-link" id="wizard-weight-tracker-tab" data-bs-toggle="pill" href="#wizard-weight-tracker" role="tab" aria-controls="wizard-weight-tracker" aria-selected="false">
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
                                                                <a class="nav-link" id="my-plan-tab" data-bs-toggle="pill" href="#my-plan" role="tab" aria-controls="my-plan" aria-selected="false" tabindex="-1">
                                                                    <div class="horizontal-wizard">
                                                                        <div class="stroke-icon-wizard"></div>
                                                                        <div class="horizontal-wizard-content">
                                                                            <h6>My Plan</h6>
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
                                                                <a class="nav-link" id="successful-wizard-tab" data-bs-toggle="pill" href="#successful-wizard" role="tab" aria-controls="successful-wizard" aria-selected="false" tabindex="-1">
                                                                    <div class="horizontal-wizard">
                                                                        <div class="stroke-icon-wizard"></div>
                                                                        <div class="horizontal-wizard-content">
                                                                            <h6>Messages</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <hr />

                                                        <!-- Main content -->
                                                        <div class="col-12">
                                                            <div class="tab-content dark-field" id="horizontal-wizard-tabContent">
                                                                <div class="tab-pane fade active show" id="wizard-info" role="tabpanel" aria-labelledby="wizard-info-tab">
                                                                    <?php include_once "../clients/utils/profile_component.php" ?>
                                                                </div>
                                                                <div class="tab-pane fade" id="wizard-weight-tracker" role="tabpanel" aria-labelledby="wizard-weight-tracker-tab">
                                                                    <!-- Weight Tracker Content -->
                                                                </div>
                                                                <div class="tab-pane fade" id="bank-wizard" role="tabpanel" aria-labelledby="bank-wizard-tab">
                                                                    <?php include_once "../clients/utils/food_logs_component.php" ?>
                                                                </div>
                                                                <div class="tab-pane fade" id="my-plan" role="tabpanel" aria-labelledby="my-plan-tab">
                                                                    <div class="d-flex justify-content-center mt-3">
                                                                        <div class="nav nav-pills mx-2" role="tablist">
                                                                            <a class="nav-link active" id="choose-food-tab" data-bs-toggle="pill" href="#choose-food" role="tab" aria-controls="choose-food" aria-selected="true">
                                                                                <h6>Choose Food</h6>
                                                                            </a>
                                                                        </div>
                                                                        <div class="nav nav-pills mx-2" role="tablist">
                                                                            <a class="nav-link" id="my-tracker-tab" data-bs-toggle="pill" href="#my-tracker" role="tab" aria-controls="my-tracker" aria-selected="false" tabindex="-1">
                                                                                <h6>My Tracker</h6>
                                                                            </a>
                                                                        </div>
                                                                        <div class="nav nav-pills mx-2" role="tablist">
                                                                            <a class="nav-link" id="my-planner-tab" data-bs-toggle="pill" href="#my-planner" role="tab" aria-controls="my-planner" aria-selected="false" tabindex="-1">
                                                                                <h6>My Planner</h6>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-content">
                                                                        <div class="tab-pane fade active show" id="choose-food" role="tabpanel" aria-labelledby="choose-food-tab">
                                                                            <!-- Content for Choose Food -->
                                                                            <div class="tab-pane fade active show" id="choose-food" role="tabpanel" aria-labelledby="choose-food-tab">
                                                                                <div class="row">
                                                                                    <div class="col-md-8">
                                                                                        <!-- Left Section Content -->
                                                                                        <h5 class="text-center h1 mt-2">Choose Your Food Preferences</h5>
                                                                                        <div class="form-group mt-3 d-flex justify-content-center align-items-center">
                                                                                            <label for="preferenceSwitch" class="form-label me-2 mb-0">View all</label>
                                                                                            <div class="form-check form-switch me-2">
                                                                                                <input class="form-check-input" type="checkbox" id="preferenceSwitch" role="switch">
                                                                                                <label for="preferenceSwitch" class="form-label me-2 mb-0">Gut guided</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-4">
                                                                                        <!-- Right Section Content -->
                                                                                        <h5>Selected Foods</h5>
                                                                                        <ul id="selectedFoodList" class="list-group">
                                                                                            <!-- Dynamically populated list of selected foods -->
                                                                                            <li class="list-group-item">Apples</li>
                                                                                            <li class="list-group-item">Bananas</li>
                                                                                        </ul>
                                                                                        <button class="btn btn-danger mt-3">Clear Selection</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="tab-pane fade" id="my-tracker" role="tabpanel" aria-labelledby="my-tracker-tab">
                                                                            <!-- Content for My Tracker -->
                                                                        </div>
                                                                        <div class="tab-pane fade" id="my-planner" role="tabpanel" aria-labelledby="my-planner-tab">
                                                                            <!-- Content for My Planner -->
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="tab-pane fade" id="inquiry-wizard" role="tabpanel">
                                                                    <!-- Inquiry Content -->
                                                                </div>
                                                                <div class="tab-pane fade" id="dev-saq-recipes" role="tabpanel">
                                                                    <!-- Recipes Content -->
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

    <!-- Redirecting to food logs if we have date -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('date')) {
                document.querySelector('.nav-link.active').classList.remove('active');
                document.querySelector('.tab-pane.active.show').classList.remove('active', 'show');

                const foodLogsTab = document.getElementById('bank-wizard-tab');
                const foodLogsContent = document.getElementById('bank-wizard');

                if (foodLogsTab && foodLogsContent) {
                    foodLogsTab.classList.add('active');
                    foodLogsContent.classList.add('active', 'show');
                }
            }
        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabLinks = document.querySelectorAll("#my-plan .nav-link");

            tabLinks.forEach(link => {
                link.addEventListener("click", function() {
                    // Remove active class from all links
                    tabLinks.forEach(tab => {
                        tab.classList.remove("active");
                        tab.querySelector("h6").style.color = "#000"; // Reset text color
                    });

                    // Add active class to the clicked link
                    this.classList.add("active");
                    this.querySelector("h6").style.color = "#fff"; // Set active text color

                    // Hide all tab content
                    const tabContents = document.querySelectorAll("#my-plan .tab-pane");
                    tabContents.forEach(content => {
                        content.classList.remove("active", "show");
                    });

                    // Show the corresponding tab content
                    const activeTabContentId = this.getAttribute("href");
                    document.querySelector(activeTabContentId).classList.add("active", "show");
                });
            });
        });
    </script>

</body>

</html>