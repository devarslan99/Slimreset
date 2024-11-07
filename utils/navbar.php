<?php
include_once '../database/db_connection.php';

$user_one_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null; //55 => coach, saqlain
$login_user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

$user_two_id = null;
$row = null;
if ($login_user_role == 'coach') {
    $user_two_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;
    $query = "SELECT first_name,role FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_two_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
} elseif ($login_user_role == 'client') {
    $query = "SELECT coach_id FROM client_coach_assignments WHERE client_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_one_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_two_id = $row['coach_id'];
    }

    $query = "SELECT first_name,role FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_two_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

?>

<style>
    .bell-font-size {
        font-size: 24px;
        background-color: #fff !important;
    }

    .fa-times {
        font-size: 24px;
    }

    .fa-times:hover {
        color: rgb(148, 108, 252) !important;
    }

    .notification-hover:hover {
        background-color: #f0f0f0;
    }

    .onhover-show-div li+li {
        margin-top: 0px !important;
    }
</style>
<style>
    .notification-counter {
        position: absolute;
        top: -10px;
        right: -8px;
        background-color: red;
        color: white;
        font-size: 0.8rem;
        padding: 2px 8px;
        border-radius: 50%;
        display: none;
    }

    .new-entry-bg-none {
        background: none !important;
    }
</style>
<div class="page-header row">
    <div class="header-logo-wrapper col-auto">
        <div class="logo-wrapper">
            <a href="../dashboard/dashboard.php">
                <img class="img-fluid for-light" src="../assets/images/logo/logo.png" alt="" />
                <img class="img-fluid for-dark" src="../assets/images/logo/logo_light.png" alt="" />
            </a>
        </div>
    </div>
    <div class="col-4 col-xl-4 page-title">
        <h4 class="f-w-700">
            <?php
            if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/dashboard/dashboard.php") {
                echo "Dashboard";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/users/create.php") {
                echo "Users";
            } else if (strpos($_SERVER['REQUEST_URI'], "/clients/view_details.php?id=") !== false) {
                echo "Clients";
            } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/users/edit.php?id=") !== false) {
                echo "Users";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/users/view.php") {
                echo "Users";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/clients/view.php") {
                echo "Clients";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/dashboard/account.php") {
                echo "Account";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/clients/summary.php") {
                echo "My Profile";
            } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/clients/summary.php") !== false) {
                echo "My Profile";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/clients/invite_clients.php") {
                echo "Clients";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/coach/assign.php") {
                echo "Coach";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/coach/view.php") {
                echo "Coach";
            } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/coach/edit.php?id=") !== false) {
                echo "Coach";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_category/create.php") {
                echo "Food Category";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_category/view.php") {
                echo "Food Category";
            } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/food_category/edit.php?id=") !== false) {
                echo "Food Category";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_recommendation/create.php") {
                echo "Food Recommendation";
            } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_recommendation/view.php") {
                echo "Food Recommendation";
            } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/food_recommendation/edit.php?id=") !== false) {
                echo "Food Recommendation";
            }

            ?>
        </h4>
        <nav>
            <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
                <li class="breadcrumb-item"><a href="../dashboard/dashboard.php"> <i data-feather="home"> </i></a></li>
                <li class="breadcrumb-item f-w-400">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/dashboard/dashboard.php") {
                        echo "Dashboard";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/users/create.php") {
                        echo "Users";
                    } else if (strpos($_SERVER['REQUEST_URI'], "projects/slimreset/users/edit.php?id=") !== false) {
                        echo "Users";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/users/view.php") {
                        echo "Users";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/dashboard/account.php") {
                        echo "Account";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/clients/view.php") {
                        echo "Clients";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/clients/view_details.php?id=") !== false) {
                        echo "Clients";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/clients/summary.php") {
                        echo "My Profile";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/clients/summary.php") !== false) {
                        echo "My Profile";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/clients/invite_clients.php") {
                        echo "Clients";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/coach/assign.php") {
                        echo "Coach";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/coach/view.php") {
                        echo "Coach";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/coach/edit.php?id=") !== false) {
                        echo "Coach";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_category/create.php") {
                        echo "Food Category";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_category/view.php") {
                        echo "Food Category";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/food_category/edit.php?id=") !== false) {
                        echo "Food Category";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_recommendation/create.php") {
                        echo "Food Recommendation";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_recommendation/view.php") {
                        echo "Food Recommendation";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/food_recommendation/edit.php?id=") !== false) {
                        echo "Food Recommendation";
                    }
                    ?>
                </li>
                <li class="breadcrumb-item f-w-400 active">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/dashboard/dashboard.php") {
                        echo "Home";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/users/create.php") {
                        echo "Create Users";
                    } else if (strpos($_SERVER['REQUEST_URI'], "projects/slimreset/users/edit.php?id=") !== false) {
                        echo "Edit Users";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/users/view.php") {
                        echo "View Users";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/dashboard/account.php") {
                        echo "Account Settings";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/clients/view.php") {
                        echo "View Clients";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/clients/view_details.php?id=") !== false) {
                        echo "Clients";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/clients/invite_clients.php") {
                        echo "Invite clients";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/coach/assign.php") {
                        echo "Add";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/coach/view.php") {
                        echo "View";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/coach/edit.php?id=") !== false) {
                        echo "Edit";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_category/create.php") {
                        echo "Add";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_category/view.php") {
                        echo "View";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/food_category/edit.php?id=") !== false) {
                        echo "Edit";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_recommendation/create.php") {
                        echo "Add";
                    } else if ($_SERVER['REQUEST_URI'] == "/projects/slimreset/food_recommendation/view.php") {
                        echo "View";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/projects/slimreset/food_recommendation/edit.php?id=") !== false) {
                        echo "Edit";
                    }
                    ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="header-wrapper col m-0">
        <div class="row">
            <div class="header-logo-wrapper col-auto p-0">
                <div class="logo-wrapper">
                    <a href="dashboard.php">
                        <img class="img-fluid" src="../assets/images/logo/logo.png" alt="">
                    </a>
                </div>
                <div class="toggle-sidebar">
                    <svg class="stroke-icon sidebar-toggle status_toggle middle">
                        <use href="../assets/svg/icon-sprite.svg#toggle-icon"></use>
                    </svg>
                </div>
            </div>

            <div class="nav-right col-xxl-8 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                <ul class="nav-menus gap-4">
                    <li class="cart-nav onhover-dropdown"></li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'client') : ?>
                        <li class="new-entry-bg-none profile-nav onhover-dropdown px-0 py-0">
                            <button class="btn btn-primary rounded-pill px-3" style="background-color: #946CFC; border: none;">
                                + new entry
                            </button>
                            <!-- Dropdown Menu -->
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="#"><span>Weight</span></a></li>
                                <li style="padding: 5px 0 0 10px !important;">
                                    <!-- "Meal" item with nested dropdown -->
                                    <a href="#" class="meal-link"><span>Meal</span></a>
                                    <ul class="nested-dropdown">
                                        <li><a href="#"><span>Food</span></a></li>
                                        <li><a href="#"><span>Water</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="#"><span>Bowel</span></a></li>
                                <li><a href="#"><span>Activity</span></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>


                    <li class="custom-notification-dropdown onhover-dropdown px-0 py-0 d-none">
                        <div class="d-flex custom-notification align-items-center position-relative">
                            <i class="fa fa-bell-o bell-font-size" aria-hidden="true"></i>
                            <!-- Counter Badge -->
                            <span id="notification-counter" class="notification-counter">0</span>
                        </div>
                        <ul class="custom-notification-list onhover-show-div" id="notification-list">
                            <!-- Notifications will be dynamically inserted here via JS -->
                        </ul>
                    </li>

                    <?php
                    if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $sql = "SELECT id,first_name,last_name FROM users WHERE id = $user_id";

                        $result = mysqli_query($mysqli, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                    ?>

                            <div class="card-header">
                                <h4><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></h4>
                            </div>

                    <?php }
                    } ?>

                    <li class="profile-nav onhover-dropdown px-0 py-0">
                        <div class="d-flex profile-media align-items-center">
                            <a href="../dashboard/profile.php">
                                <img class="img-30" src="<?php echo $_SESSION['profile_image'] ?>" alt="">
                            </a>
                            <div class="flex-grow-1">
                                <span>
                                    <?php echo $_SESSION['full_name'] ?>
                                </span>
                                <p class="mb-0 font-outfit"><?php echo $_SESSION['role'] ?> <i class="fa fa-angle-down"></i></p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li><a href="../dashboard/account.php"><i data-feather="settings"></i><span>Settings
                                    </span></a>
                            </li>
                            <li><a href="../functions/logout.php"><i data-feather="log-out"></i><span>Log out</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- Script to display notification icon on summary page -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const notificationDropdown = document.querySelector(".custom-notification-dropdown");

        function toggleNotificationVisibility() {
            const path = window.location.pathname;
            if (path.includes("summary.php")) {
                notificationDropdown.classList.remove("d-none");
            } else {
                notificationDropdown.classList.add("d-none");
            }
        }
        toggleNotificationVisibility();
        window.addEventListener("popstate", toggleNotificationVisibility);
    });
</script>