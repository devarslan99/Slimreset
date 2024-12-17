<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php" ?>

<style>
    #myGauge {
        max-width: 400px;
        max-height: 400px;
        margin: 0 auto;
    }

    #my-plan .nav {
        justify-content: center;
    }

    .nav-link {
        margin: 0 10px;
        border-radius: 5px;
        color: #000;
        transition: color 0.3s ease-in-out;
        position: relative
    }

    .nav-link.active::after {
        content: "";
        display: block;
        width: 100%;
        height: 2px;
        background-color: #936CFB;
        position: absolute;
        bottom: -5px;
        left: 0;
        transition: background-color 0.3s ease-in-out, width 0.3s ease-in-out;
    }

    .nav-2.active::after {
        content: "";
        display: block;
        width: 50%;
        height: 2px;
        background-color: #936CFB;
        position: absolute;
        bottom: 15px;
        left: 55px;
        transition: background-color 0.3s ease-in-out, width 0.3s ease-in-out;
    }

    .nav-link:hover h6 {
        color: #936CFB;
        transition: color 0.3s ease-in-out;
    }

    .nav-link.active {
        background: none !important;
    }

    .nav-link.active h6,
    .nav-link.active h1 {
        color: #946CFC !important;
        font-weight: 800;
    }

    .nav-link h6 {
        color: #000;
    }

    .nav-link:hover h6,
    .nav-link:hover h1 {
        color: #936CFB !important;
        transition: color 0.3s ease-in-out;
    }

    .tab-content {
        margin-top: 20px;
    }

    .category-section {
        flex: 1;
        min-width: 0;
    }

    .responsive-font {
        font-size: 1rem;
    }

    @media (max-width: 767.98px) {
        .responsive-font {
            font-size: 0.85rem;
        }
    }

    .category-section {
        min-width: 150px;
        flex-grow: 1;
    }

    @media (max-width: 576px) {

        .category-section {
            flex-basis: 100%;
        }
    }

    @media (min-width: 576px) and (max-width: 768px) {

        .category-section {
            flex-basis: 50%;
        }
    }

    @media (min-width: 768px) {

        .category-section {
            flex-basis: 33.33%;
        }
    }

    .select-margin {
        margin-left: -22px !important;
    }

    #viewAllSection,
    #gutGuidedSection {
        transition: opacity 0.3s ease;
    }

    .view-all-checkboxes input[type="checkbox"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 15px;
        height: 15px;
        border: 2px solid #000;
        border-radius: 3px;
        outline: none;
        cursor: pointer;
        position: relative;
        background-color: transparent;
    }

    .view-all-checkboxes input[type="checkbox"]:checked {
        background-color: transparent;
        border-color: #000;
    }

    .view-all-checkboxes input[type="checkbox"]:checked::after {
        content: '✔';
        font-size: 12px;
        position: absolute;
        top: -3px;
        left: 0px;
        color: black;
    }

    .fa-star {
        color: black;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .fa-star.active {
        color: yellow;
    }

    .tab-button {
        padding: 0;
        font-weight: bold;
    }

    .tab-button:hover {
        color: #936CFB;
    }

    .line {
        color: #ccc;
    }

    .phase-tab {
        font-weight: 600;
        gap: 5px
    }

    /* Add some styling for the active phase button */
    .tab-button.active {
        color: #936CFB;
        border: 0;
    }
</style>

<style>
    /* Client Plan Section */
    .client-plan-wrapper {
        position: relative;
        padding: 10px;
        margin: 10px 0;
    }

    .client-plan-title {
        font-size: 1.2rem;
        color: #000;
    }

    /* Three Dots Icon */
    .three-dots-icon {
        font-size: 18px;
        cursor: pointer;
        color: #000;
        transition: color 0.3s ease;
        border: 2px solid;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .three-dots-icon:hover {
        color: #936CFB;
    }

    /* Phase Popup */
    .phase-popup {
        position: absolute;
        top: 35px;
        right: 0;
        background: linear-gradient(135deg, #9a50ff, #6f30ff);
        border-radius: 10px;
        padding: 15px;
        width: 140px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        z-index: 1000;
    }

    .new-label {
        color: #fff;
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 10px;
        text-align: center;
    }

    .phase-btn {
        background: transparent;
        border: none;
        color: #fff;
        padding: 8px;
        font-size: 1rem;
        cursor: pointer;
        text-align: center;
        font-weight: bold;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .phase-btn:hover {
        background: #fff;
        color: #6f30ff;
        border-radius: 5px;
    }


    #edit-view-box {
        display: none;
        gap: 10px;
        font-weight: 600;
    }

    #edit-view-box a {
        text-decoration: underline;
    }

    /* Sidebar Navigation */
    .sidebar-nav {
        flex-direction: column; 
        width: 200px;
        height: 100vh; 
        background-color: #936CFB; 
        padding: 15px; 
        position: fixed;
        top: 0;
        left: 0;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 1000; 
        gap: 40PX;
    }

    .sidebar-nav .nav-link {
        display: block; 
        width: calc(100% - 30px);
        box-sizing: border-box;
        padding: 10px 15px;
        border-radius: 5px; 
        margin-bottom: 5px; 
        color: #fff; 
        transition: background-color 0.3s, color 0.3s;
        text-align: center;
    }

    .sidebar-nav .nav-link.active {
        color: #fff !important;
        font-weight: bold;
        background-color: #5d42a5 !important;
    }

    .sidebar-nav .nav-link:hover {
        background-color: #5d42a5; 
        color: #fff;
    }

    /* Adjust content to the right of the sidebar */
    .page-body-wrapper {
        margin-left: 200px;
    }

    .page-body {
        margin-top: 51px !important;
    }

    /* For smaller screens */@media (max-width: 768px) {
        .sidebar-nav {
            position: fixed;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .sidebar-nav.active {
            transform: translateX(0);
        }

        .page-body-wrapper {
            margin-left: 0;
        }

        .sidebar-overlay {
            display: block; 
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999; 
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .sidebar-overlay.active {
            visibility: visible;
            opacity: 1;
        }
    }
 
    /* General styling for the toggle button */
    .sidebar-toggle-btn {
        background-color: #5d42a5;
        color: #fff; 
        border: none; 
        border-radius: 5px; 
        font-size: 1.5rem;
        cursor: pointer; 
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
        transition: background-color 0.3s, transform 0.2s ease-in-out;
        margin-bottom: 20px;
        margin-left: 20px;
    }

    /* Hover effect */
    .sidebar-toggle-btn:hover {
        background-color: #936CFB; /* Lighter background on hover */
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
<div class="sidebar-overlay"></div>

    <?php include_once "../utils/loader.php" ?>
    <div class="page-wrapper compact-wrapper" style="background: #ffffff !important;" id="pageWrapper">
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

                            ?>
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="horizontal-wizard-wrapper">
                                            <div class="row g-3">
                                                <div class="col-12 main-horizontal-header">
                                                    <button class="sidebar-toggle-btn d-md-none" aria-expanded="false" aria-controls="horizontal-wizard-tab">☰ Tabs Menu</button>

                                                    <div class="nav nav-pills sidebar-nav" id="horizontal-wizard-tab" role="tablist" aria-orientation="vertical">
                                                        <div class="logo-wrapper">
                                                            <a href="../dashboard/dashboard.php">
                                                                <img class="img-fluid for-light" src="../assets/images/logo/logo.png" alt="" />
                                                                <img class="img-fluid for-dark" src="../assets/images/logo/logo_light.png" alt="" />
                                                            </a>
                                                        </div>
                                                        <a class="nav-link active" id="wizard-info-tab" data-bs-toggle="pill" href="#wizard-info" role="tab" aria-controls="wizard-info" aria-selected="true">
                                                            Profile
                                                        </a>
                                                        <a class="nav-link" id="wizard-weight-tracker-tab" data-bs-toggle="pill" href="#wizard-weight-tracker" role="tab" aria-controls="wizard-weight-tracker" aria-selected="false">
                                                            My Progress
                                                        </a>
                                                        <a class="nav-link" id="my-plan-tab" data-bs-toggle="pill" href="#my-plan" role="tab" aria-controls="my-plan" aria-selected="false">
                                                            My Plan
                                                        </a>
                                                        <a class="nav-link" id="recipes-tab" data-bs-toggle="pill" href="#recipes" role="tab" aria-controls="recipes" aria-selected="false">
                                                            Recipes
                                                        </a>
                                                        <a class="nav-link" id="inquiry-wizard-tab" data-bs-toggle="pill" href="#inquiry-wizard" role="tab" aria-controls="inquiry-wizard" aria-selected="false">
                                                            Coaching
                                                        </a>
                                                        <a class="nav-link" id="successful-wizard-tab" data-bs-toggle="pill" href="#successful-wizard" role="tab" aria-controls="successful-wizard" aria-selected="false">
                                                            Messages
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
                                                            <?php 
                                                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'client') : ?>
                                                                <?php include_once '../functions/food-logs/client_my_progress/my-progress.php'; ?>
                                                            <?php else : ?>
                                                                <?php include_once '../functions/food-logs/my-progress.php'; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="tab-pane fade" id="my-plan" role="tabpanel" aria-labelledby="my-plan-tab">
                                                            <div class="container-fluid">
                                                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                                                    <div class="nav nav-pills mx-2" role="tablist">
                                                                        <a class="nav-link active nav-2" id="choose-food-tab" data-bs-toggle="pill" href="#choose-food" role="tab" aria-controls="choose-food" aria-selected="true">
                                                                            <div style="display:flex;align-items:center;gap:10px;">
                                                                                <h1 class="fs-1 fw-bolder">1</h1>
                                                                                <div>
                                                                                    <h6 class="responsive-font">choose Food</h6>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    <div class="nav nav-pills mx-2" role="tablist">
                                                                        <a class="nav-link nav-2" id="my-planner-tab" data-bs-toggle="pill" href="#my-planner" role="tab" aria-controls="my-planner" aria-selected="false" tabindex="-1">
                                                                            <div style="display:flex;align-items:center;gap:10px;">
                                                                                <h1 class="fs-1 fw-bolder">2</h1>
                                                                                <div>
                                                                                    <h6 class="responsive-font">my Planner</h6>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    <div class="nav nav-pills mx-2" role="tablist">
                                                                        <a class="nav-link nav-2" id="my-tracker-tab" data-bs-toggle="pill" href="#my-tracker" role="tab" aria-controls="my-tracker" aria-selected="false" tabindex="-1">
                                                                            <div style="display:flex;align-items:center;gap:10px;">
                                                                                <h1 class="fs-1 fw-bolder">3</h1>
                                                                                <div>
                                                                                    <h6 class="responsive-font">my Tracker</h6>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="tab-content mt-5">
                                                                    <div class="tab-pane fade active show" id="choose-food" role="tabpanel" aria-labelledby="choose-food-tab">
                                                                        <div class="row">
                                                                            <div class="col-lg-9">
                                                                                <h1 class="text-center">Choose Your Food Preferences</h1>
                                                                                <div class="phase-main-box d-flex justify-content-between align-items-center px-5">
                                                                                    <div class="d-flex justify-content-center align-items-center my-4">
                                                                                            <label class="form-label me-2 fs-6 responsive-font">View all</label>
                                                                                            <div class="form-check form-switch">
                                                                                                <input class="form-check-input custom-switch" type="checkbox" id="preferenceSwitch" role="switch">
                                                                                                <label class="form-label ms-2 fs-6 fw-medium responsive-font">Gut guided</label>
                                                                                            </div>
                                                                                    </div>
                                                                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'client') : ?>
                                                                                   
                                                                                    <div class=" align-items-center phase-tab" id="phaseTabs">
                                                                                        <div class="client-plan-wrapper d-flex align-items-center justify-content-between">
                                                                                            <label class="form-label me-2 fs-6 responsive-font">client plan</label>
                                                                                            <div class="three-dots-wrapper">
                                                                                            <i class="fa fa-ellipsis-h three-dots-icon" onclick="toggleDropdown()"></i>
                                                                                                <div class="phase-popup" id="phasePopup">
                                                                                                    <button class="phase-btn" onclick="selectPhase(1)">Phase 1</button>
                                                                                                    <button class="phase-btn" onclick="selectPhase(2)">Phase 2</button>
                                                                                                    <button class="phase-btn" onclick="selectPhase(3)">Phase 3</button>
                                                                                                    <button class="phase-btn" onclick="selectPhase(4)">Phase 4</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php endif; ?>

                                                                                    <div id="edit-view-box">
                                                                                        <a href="#">edit</a>
                                                                                        <p>view as client</p>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Food Categories Section for view all-->
                                                                                <div id="viewAllSection" style="display: block;">
                                                                                    <?php include_once '../functions/food-logs/view_all_food.php' ?>
                                                                                </div>

                                                                                <!-- Food Categories Section for gut guided -->
                                                                                <div id="gutGuidedSection" style="display: none;">
                                                                                    <?php include_once '../functions/food-logs/gut_guided_food.php' ?>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Recipe Column -->
                                                                            <div class="col-lg-3">
                                                                                <?php include '../functions/food-logs/recipies.php' ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="my-planner" role="tabpanel" aria-labelledby="my-planner-tab">
                                                                        <!-- My Planner Content -->
                                                                        <?php include_once '../functions/food-logs/my-planner.php'  ?>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="my-tracker" role="tabpanel" aria-labelledby="my-tracker-tab">
                                                                        <!-- My Tracker Content -->
                                                                        <?php include_once '../clients/utils/food_logs_component.php' ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="recipes" role="tabpanel" aria-labelledby="recipes-tab">
                                                            <!-- Recipes Content -->
                                                            <?php include_once '../functions/recipes/my-recipes.php' ?>
                                                        </div>

                                                        <!-- Coaching Tab Content -->
                                                        <div class="tab-pane fade" id="inquiry-wizard" role="tabpanel">
                                                            <!-- Inquiry Content -->
                                                        </div>

                                                        <!-- Messages Tab Content -->
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
                    </div>
                </div>
            <?php } ?>
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

            if (window.innerWidth <= 991) { // Assuming mobile screen width is 768px or less
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

    <!-- Redirecting to food logs if we have date and adjusting of my tracker view page -->
    <script>
        function saveActiveTab(tabId) {
            localStorage.setItem('activeTab', tabId);
        }

        // Function to activate the saved tab if there is a date in the URL
        function activateSavedTab() {
            const activeTabId = localStorage.getItem('activeTab');

            if (activeTabId) {
                document.querySelectorAll('.nav-link.active').forEach(link => link.classList.remove('active'));
                document.querySelectorAll('.tab-pane.active.show').forEach(tab => tab.classList.remove('active', 'show'));

                if (activeTabId === 'my-planner' || activeTabId === 'my-tracker' || activeTabId === 'choose-food') {
                    const myPlanTabLink = document.querySelector('#my-plan-tab');
                    const myPlanTabContent = document.querySelector('#my-plan');

                    if (myPlanTabLink && myPlanTabContent) {
                        myPlanTabLink.classList.add('active');
                        myPlanTabContent.classList.add('active', 'show');
                    }
                }

                const targetTabLink = document.querySelector(`#${activeTabId}-tab`);
                const targetTabContent = document.querySelector(`#${activeTabId}`);

                if (targetTabLink && targetTabContent) {
                    targetTabLink.classList.add('active');
                    targetTabContent.classList.add('active', 'show');
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    const tabId = this.getAttribute('aria-controls');
                    saveActiveTab(tabId);

                    if (tabId === 'my-plan') {
                        // Activate "Choose Food" tab
                        const chooseFoodTabLink = document.querySelector('#choose-food-tab');
                        const myPlannerTabLink = document.querySelector('#my-planner-tab'); 
                        const myTrackerTabLink = document.querySelector('#my-tracker-tab'); 
                        const chooseFoodTabContent = document.querySelector('#choose-food');

                        if (chooseFoodTabLink && chooseFoodTabContent) {
                            chooseFoodTabLink.classList.add('active');
                            myPlannerTabLink.classList.remove('active');
                            myTrackerTabLink.classList.remove('active');
                            chooseFoodTabContent.classList.add('active', 'show');

                            // Save "choose-food" to local storage
                            saveActiveTab('choose-food');
                        }
                    }
                });
            });
            activateSavedTab();
        });
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
                    this.querySelector("h6").style.color = "#000"; // Set active text color

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

    <!-- Script to switch view all to gut guided-->
    <script>
        const preferenceSwitch = document.getElementById('preferenceSwitch');
        const viewAllSection = document.getElementById('viewAllSection');
        const gutGuidedSection = document.getElementById('gutGuidedSection');

        preferenceSwitch.addEventListener('change', function() {
            if (preferenceSwitch.checked) {
                // Show Gut guided section, hide View all section
                viewAllSection.style.display = 'none';
                gutGuidedSection.style.display = 'block';
            } else {
                // Show View all section, hide Gut guided section
                viewAllSection.style.display = 'block';
                gutGuidedSection.style.display = 'none';
            }
        });
    </script>

    <!-- JavaScript to toggle the star color on click -->
    <script>
        document.querySelectorAll('.fa-star').forEach(star => {
            star.addEventListener('click', () => {
                star.classList.toggle('active'); // Toggle yellow color
            });
        });
    </script>

    <!-- script to hide phase tabs for gut guided content  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preferenceSwitch = document.getElementById('preferenceSwitch');
            const phaseTabs = document.getElementById('phaseTabs');
            const editViewBox = document.getElementById('edit-view-box');

            // Add event listener
            preferenceSwitch.addEventListener('change', function() {
                if (preferenceSwitch.checked) {
                    phaseTabs.style.display = 'none';
                    editViewBox.style.display = 'flex';
                } else {
                    phaseTabs.style.display = 'flex';
                    editViewBox.style.display = 'none';
                }
            });
        });
    </script>

    <!-- script to handle phase tabs content to load in container for both medium and large sceen devices-->
    <script>
        function toggleDropdown() {
            const popup = document.getElementById('phasePopup');
            popup.style.display = popup.style.display === 'flex' ? 'none' : 'flex';
        }

        // Close the popup if the user clicks outside
        window.addEventListener('click', function(event) {
            const popup = document.getElementById('phasePopup');
            const icon = document.querySelector('.three-dots-icon');

            // Check if the click is outside the popup and the three-dot icon
            if (popup.style.display === 'flex' && !popup.contains(event.target) && !icon.contains(event.target)) {
                popup.style.display = 'none';
            }
        });

        // Load content for selected phase
        function selectPhase(phase) {
            const popup = document.getElementById('phasePopup');
            popup.style.display = 'none'; // Hide popup

            // Existing functionality to load phase content
            const filePath = phase === 1 ? '../functions/food-logs/view_all_food.php' :
                `../functions/food-logs/view_all_food_phase_${phase}.php`;

            fetch(filePath)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('viewAllSection').innerHTML = data;
                })
                .catch(error => console.error('Error loading content:', error));
        }


    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.querySelector(".sidebar-nav");
        const toggleBtn = document.querySelector(".sidebar-toggle-btn");
        const overlay = document.querySelector(".sidebar-overlay");
        const sidebarLinks = document.querySelectorAll(".sidebar-nav .nav-link");

        // Show sidebar on toggle button click
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");

            toggleBtn.setAttribute(
                "aria-expanded",
                sidebar.classList.contains("active").toString()
            );
        });

        // Hide sidebar when clicking on the overlay
        overlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });

        // Hide sidebar when a tab is clicked
        sidebarLinks.forEach(link => {
            link.addEventListener("click", () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove("active");
                    overlay.classList.remove("active");
                }
            });
        });
    });

    </script>


</body>

</html>