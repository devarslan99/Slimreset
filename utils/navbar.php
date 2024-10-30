<?php
include_once '../database/db_connection.php';

$user_one_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
$login_user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

$user_two_id = null;
$row = null;

// Fetch the ID of the coach based on the logged-in client
if ($login_user_role == 'client') {
    $query = "SELECT coach_id FROM client_coach_assignments WHERE client_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_one_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_two_id = $row['coach_id'];
    }
}

// Initialize an array for unread messages
$unreadMessages = [];
if ($user_one_id && $user_two_id) {
    // Query to fetch unread messages for the logged-in client from their coach
    $query = "
        SELECT 
            m.id AS message_id,
            m.message,
            m.sent_at,
            u_sender.id AS sender_id,
            CONCAT(u_sender.first_name, ' ', u_sender.last_name) AS sender_name,
            u_sender.profile_image AS sender_profile_image
        FROM 
            messages m
        JOIN 
            users u_sender ON m.sender_id = u_sender.id
        WHERE 
            m.is_read = 0 
            AND m.receiver_id = ? 
            AND m.sender_id = ?
        ORDER BY 
            m.sent_at DESC;
    ";

    // Prepare and execute the statement to get unread messages for the client
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $user_one_id, $user_two_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($message = $result->fetch_assoc()) {
            $unreadMessages[] = $message;
        }
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
            if ($_SERVER['REQUEST_URI'] == "/dashboard/dashboard.php") {
                echo "Dashboard";
            } else if ($_SERVER['REQUEST_URI'] == "/users/create.php") {
                echo "Users";
            } else if (strpos($_SERVER['REQUEST_URI'], "/clients/view_details.php?id=") !== false) {
                echo "Clients";
            } else if (strpos($_SERVER['REQUEST_URI'], "/users/edit.php?id=") !== false) {
                echo "Users";
            } else if ($_SERVER['REQUEST_URI'] == "/users/view.php") {
                echo "Users";
            } else if ($_SERVER['REQUEST_URI'] == "/clients/view.php") {
                echo "Clients";
            } else if ($_SERVER['REQUEST_URI'] == "/dashboard/account.php") {
                echo "Account";
            }

            ?>
        </h4>
        <nav>
            <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
                <li class="breadcrumb-item"><a href="../dashboard/dashboard.php"> <i data-feather="home"> </i></a></li>
                <li class="breadcrumb-item f-w-400">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/dashboard/dashboard.php") {
                        echo "Dashboard";
                    } else if ($_SERVER['REQUEST_URI'] == "/users/create.php") {
                        echo "Users";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/users/edit.php?id=") !== false) {
                        echo "Users";
                    } else if ($_SERVER['REQUEST_URI'] == "/users/view.php") {
                        echo "Users";
                    } else if ($_SERVER['REQUEST_URI'] == "/dashboard/account.php") {
                        echo "Account";
                    } else if ($_SERVER['REQUEST_URI'] == "/clients/view.php") {
                        echo "Clients";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/clients/view_details.php?id=") !== false) {
                        echo "Clients";
                    }
                    ?>
                </li>
                <li class="breadcrumb-item f-w-400 active">
                    <?php
                    if ($_SERVER['REQUEST_URI'] == "/dashboard/dashboard.php") {
                        echo "Home";
                    } else if ($_SERVER['REQUEST_URI'] == "/users/create.php") {
                        echo "Create Users";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/users/edit.php?id=") !== false) {
                        echo "Edit Users";
                    } else if ($_SERVER['REQUEST_URI'] == "/users/view.php") {
                        echo "View Users";
                    } else if ($_SERVER['REQUEST_URI'] == "/dashboard/account.php") {
                        echo "Account Settings";
                    } else if ($_SERVER['REQUEST_URI'] == "/clients/view.php") {
                        echo "Clients";
                    } else if (strpos($_SERVER['REQUEST_URI'], "/clients/view_details.php?id=") !== false) {
                        echo "Clients";
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
                    <li class="custom-notification-dropdown onhover-dropdown px-0 py-0">
                        <div class="d-flex custom-notification align-items-center">
                            <i class="fa fa-bell-o bell-font-size" aria-hidden="true"></i>
                        </div>
                        <ul class="custom-notification-list onhover-show-div" id="notification-list">
                            <!-- Notifications will be dynamically inserted here via JS -->
                        </ul>
                    </li>

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