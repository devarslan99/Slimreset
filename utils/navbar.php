<?php
include_once '../database/db_connection.php';

$user_one_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null; //55 => coach, saqlain
$login_user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
$client_user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

$user_two_id = null;
$row = null;
if ($login_user_role == 'coach') {
    // $user_two_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;
    $query = "SELECT client_id FROM client_coach_assignments WHERE coach_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_one_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_two_id = $row['client_id'];
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
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
// print_r("Client id" . " " . $user_one_id . " " . "Coach id" . " " . $user_two_id);
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

    .bread-crum-Link {
        color: #333;
        user-select: none;
    }

    .menu {
        ul {
            list-style: none;
            margin: 0;

            li,
            li a {
                color: #000000;
                cursor: pointer;
                transition: color 200ms;
                text-decoration: none;
                white-space: nowrap;

                &:hover {
                    color: #946CFC;
                }

                a {
                    display: flex;
                    align-items: center;
                    height: 100%;
                    width: 100%;
                }
            }

            .link {
                &::before {
                    padding-right: 0;
                    display: none;
                }
            }
        }

        >ul {
            display: flex;
            height: var(--menu-height);
            align-items: center;
            background-color: none !important;

            li {
                position: relative;

                ul {
                    visibility: hidden;
                    opacity: 0;
                    padding: 10px;
                    min-width: 160px;
                    background-color: #ffffff;
                    position: absolute;
                    top: 50px;
                    left: 50%;
                    transform: translateX(-50%);
                    transition: opacity 200ms, visibility 200ms;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

                    li {
                        margin: 0;
                        padding: 8px 16px;
                        display: flex;
                        align-items: center;
                        justify-content: flex-start;
                        height: 30px;
                        padding-right: 40px;

                        ul {
                            top: 0;
                            left: 70%;
                            transform: translate(0);
                        }

                        &:hover {
                            color: #946CFC;
                        }
                    }
                }

                &:hover {
                    >ul {
                        opacity: 1;
                        visibility: visible;
                    }
                }
            }
        }
    }

    @media (max-width: 650px) {
        .menu>ul li ul ul ul {
            top: 60px;
            left: -10px;
        }
    }

    @media (max-width: 400px) {

        .menu,
        .menu .btn {
            display: none;
        }
    }

    .navbar-container {
        display: flex;
        align-items: center;
    }

    .scrollable-nav {
        overflow-x: auto;
        white-space: nowrap;
        flex-grow: 1;
        padding: 0 10px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .scrollable-nav::-webkit-scrollbar {
        display: none;
    }

    .scrollable-nav ul {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .scroll-btn {
        background-color: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .responsive-section {
        flex-basis: 0;
        flex-grow: 1;
        overflow-x: auto;
        padding: 1rem;
        transition: width 0.3s ease;
    }

    @media (max-width: 991.98px) {
        .responsive-section {
            display: none;
        }
    }

    .meal-plan-popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .meal-plan-popup-content {
        position: relative;
        background-color: #fff;
        padding: 30px 20px;
        border-radius: 20px;
        width: 400px;
        max-width: 90%;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .meal-plan-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .meal-plan-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
        color: #333;
    }

    .meal-plan-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
    }

    .meal-plan-buttons button {
        background-color: transparent;
        border: none;
        color: #333;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s;
    }

    .meal-plan-buttons button:hover {
        color: #946CFC;
    }

    .scrollable-nav {
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        -ms-overflow-style: none;
        scrollbar-width: none;
        cursor: grab;
    }

    .scrollable-nav::-webkit-scrollbar {
        display: none;
    }

    .toggle-icon-responsive {
        display: none !important;
    }

    @media (max-width: 991px) {
        .toggle-icon-responsive {
            display: block !important;
        }
    }

    #notification-list {
        max-height: 380px;
        overflow-y: auto;
        border: 1px solid #946CFC;
        list-style: none;
        margin: 0;
        scrollbar-width: thin;
        scrollbar-color: #946CFC #f9f9f9;
    }

    #notification-list::-webkit-scrollbar {
        width: 8px;
    }

    #notification-list::-webkit-scrollbar-track {
        background: #f9f9f9;
    }

    #notification-list::-webkit-scrollbar-thumb {
        background-color: #946CFC;
        border-radius: 10px;
    }

    #notification-list::-webkit-scrollbar-thumb:hover {
        background-color: #7C56E6;
    }

    .page-wrapper {
        background: #fff !important;
    }
</style>

<?php
$currentPath = $_SERVER['REQUEST_URI'];
// Admin section
$showDashboard = strpos($currentPath, "dashboard/dashboard.php") !== false;
$showAddUser = strpos($currentPath, "users/create.php") !== false;
$showViewUser = strpos($currentPath, "users/view.php") !== false || strpos($currentPath, "users/edit.php") !== false;
$showAssignCoach = strpos($currentPath, "coach/assign.php") !== false;
$showViewCoach = strpos($currentPath, "coach/view.php") !== false || strpos($currentPath, "coach/edit.php") !== false;
$showFoodCat = strpos($currentPath, "food_category/create.php") !== false;
$showViewCat = strpos($currentPath, "food_category/view.php") !== false || strpos($currentPath, "food_category/edit.php") !== false;
$showFoodRecom = strpos($currentPath, "food_recommendation/create.php") !== false;
$showViewRecom = strpos($currentPath, "food_recommendation/view.php") !== false || strpos($currentPath, "food_recommendation/edit.php") !== false;

// Coach section
$showInviteClient = strpos($currentPath, "clients/invite_clients.php") !== false;
$showMyClients = strpos($currentPath, "clients/view.php") !== false || strpos($currentPath, "clients/summary.php") !== false;
$showMealType = strpos($currentPath, "clients/add-meal-type.php") !== false;
$showViewMealType = strpos($currentPath, "clients/view-meal-type.php") !== false || strpos($currentPath, "clients/edit-meal-type.php") !== false;
$showFoodGroup = strpos($currentPath, "clients/add-food-group.php") !== false;
$showViewFoodGroup = strpos($currentPath, "clients/view-food-group.php") !== false || strpos($currentPath, "clients/edit-food-group.php") !== false;
$showProtein = strpos($currentPath, "clients/add-protein.php") !== false;
$showViewProtein = strpos($currentPath, "clients/view-protein.php") !== false || strpos($currentPath, "clients/edit-protein.php") !== false;
$showVeggie = strpos($currentPath, "clients/add-veggie.php") !== false;
$showViewVeggie = strpos($currentPath, "clients/view-veggie.php") !== false || strpos($currentPath, "clients/edit-veggie.php") !== false;
$showFruit = strpos($currentPath, "clients/add-fruit.php") !== false;
$showViewFruit = strpos($currentPath, "clients/view-fruit.php") !== false || strpos($currentPath, "clients/edit-fruit.php") !== false;
?>

<div class="page-header row">
    <div class="header-logo-wrapper col-auto">
        <div class="logo-wrapper">
            <a href="../dashboard/dashboard.php">
                <img class="img-fluid for-light" src="../assets/images/logo/logo.png" alt="" />
                <img class="img-fluid for-dark" src="../assets/images/logo/logo_light.png" alt="" />
            </a>
        </div>
    </div>
    <div class="responsive-section">
        <nav>
            <div class="navbar-container">
                <div class="scrollable-nav">
                    <ul class="d-flex align-items-center gap-4">
                        <li><a class="bread-crum-Link <?php echo $showDashboard ? 'main-color fw-bold' : '' ?>" href="../dashboard/dashboard.php">Dashboard</a></li>
                        <?php
                        $role = $_SESSION['role'];
                        if ($role == "admin") {
                        ?>
                            <li><a class="bread-crum-Link <?php echo $showAddUser ? 'main-color fw-bold' : '' ?>" href="../users/create.php">Add User</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewUser ? 'main-color fw-bold' : '' ?>" href="../users/view.php">View Users</a></li>
                            <li><a class="bread-crum-Link <?php echo $showAssignCoach ? 'main-color fw-bold' : '' ?>" href="../coach/assign.php">Assign Coach</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewCoach ? 'main-color fw-bold' : '' ?>" href="../coach/view.php">View Coach</a></li>
                            <li><a class="bread-crum-Link <?php echo $showFoodCat ? 'main-color fw-bold' : '' ?>" href="../food_category/create.php">Add Food Category</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewCat ? 'main-color fw-bold' : '' ?>" href="../food_category/view.php">View Food Category</a></li>
                            <li><a class="bread-crum-Link <?php echo $showFoodRecom ? 'main-color fw-bold' : '' ?>" href="../food_recommendation/create.php">Add Food Recommendation</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewRecom ? 'main-color fw-bold' : '' ?>" href="../food_recommendation/view.php">View Food Recommendation</a></li>
                            <li><a class="bread-crum-Link" href="../functions/logout.php">Logout</a></li>
                        <?php
                        } else if ($role == "client") {
                        ?>
                            <li><a class="bread-crum-Link <?php echo $showMyClients ? 'main-color fw-bold' : '' ?>" href="../clients/summary.php?id=<?php echo $_SESSION['user_id'] ?>">My Profile</a></li>
                        <?php
                        } else if ($role == "coach") {
                        ?>
                            <li><a class="bread-crum-Link <?php echo $showInviteClient ? 'main-color fw-bold' : '' ?>" href="../clients/invite_clients.php">Invite Clients</a></li>
                            <li><a class="bread-crum-Link <?php echo $showMyClients ? 'main-color fw-bold' : '' ?>" href="../clients/view.php">My Clients</a></li>
                            <li><a class="bread-crum-Link <?php echo $showMealType ? 'main-color fw-bold' : '' ?>" href="../clients/add-meal-type.php">Add Meal</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewMealType ? 'main-color fw-bold' : '' ?>" href="../clients/view-meal-type.php">View Meal</a></li>
                            <li><a class="bread-crum-Link <?php echo $showFoodGroup ? 'main-color fw-bold' : '' ?>" href="../clients/add-food-group.php">Add Food</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewFoodGroup ? 'main-color fw-bold' : '' ?>" href="../clients/view-food-group.php">View Food</a></li>
                            <li><a class="bread-crum-Link <?php echo $showProtein ? 'main-color fw-bold' : '' ?>" href="../clients/add-protein.php">Add Protein</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewProtein? 'main-color fw-bold' : '' ?>" href="../clients/view-protein.php">View Protein</a></li>
                            <li><a class="bread-crum-Link <?php echo $showVeggie ? 'main-color fw-bold' : '' ?>" href="../clients/add-veggie.php">Add Veggie</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewVeggie ? 'main-color fw-bold' : '' ?>" href="../clients/view-veggie.php">View Veggie</a></li>
                            <li><a class="bread-crum-Link <?php echo $showFruit ? 'main-color fw-bold' : '' ?>" href="../clients/add-fruit.php">Add Fruit</a></li>
                            <li><a class="bread-crum-Link <?php echo $showViewFruit ? 'main-color fw-bold' : '' ?>" href="../clients/view-fruit.php">View Fruit</a></li>
                            <li><a class="bread-crum-Link" href="../functions/logout.php">Logout</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>

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
                <!-- Add custom class for responsive display -->
                <div class="toggle-sidebar toggle-icon-responsive">
                    <svg class="stroke-icon sidebar-toggle status_toggle middle">
                        <use href="../assets/svg/icon-sprite.svg#toggle-icon"></use>
                    </svg>
                </div>
            </div>


            <div class="nav-right col-xxl-8 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                <ul class="nav-menus gap-4">
                    <li class="cart-nav onhover-dropdown bg-none" style="background: none !important;"></li>
                    <li class="cart-nav onhover-dropdown bg-none" style="background: none !important;"></li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'client') : ?>
                        <li class="menu new-entry-bg-none ">
                            <ul>
                                <li>
                                    <button class="btn btn-primary rounded-pill px-3 py-2" style="background-color: #946CFC; border: none;">
                                        + new entry
                                    </button>
                                    <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
                                    <ul class="rounded-2 main-bg">
                                        <li><a class="dropdown-item text-white" href="#" onclick="openWeightModal('weightModal')">Weight</a></li>
                                        <li class="text-white">
                                            Meal
                                            <ul class="rounded-2 main-bg">
                                                <li class="link text-white">Food
                                                    <ul class="rounded-2 main-bg">
                                                        <li><a class="dropdown-item text-white" href="#" onclick="openModal('Breakfast')">Breakfast</a></li>
                                                        <li><a class="dropdown-item text-white" href="#" onclick="openModal('Lunch')">Lunch</a></li>
                                                        <li><a class="dropdown-item text-white" href="#" onclick="openModal('Dinner')">Dinner</a>
                                                        </li>
                                                        <li><a class="dropdown-item text-white" href="#" onclick="openModal('Snacks')">Snacks</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li><a class="dropdown-item text-white" href="#" onclick="openWaterModal('waterModal')">Water</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item text-white" href="#" onclick="openBowelMovementsModal('bowelMovementsModal')">Bowel</a></li>
                                        <li class="link text-white">Activity</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (strpos($_SERVER['REQUEST_URI'], 'summary.php') !== false) : ?>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'coach') : ?>
                            <li class="menu new-entry-bg-none">
                                <ul>
                                    <li>
                                        <button class="btn btn-primary rounded-pill px-3 py-2" style="background-color: #946CFC; border: none;">
                                            + new entry
                                        </button>
                                        <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
                                        <ul class="rounded-2 main-bg">
                                            <li><a class="dropdown-item text-white" href="#" onclick="openWeightModal('weightModal')">Weight</a></li>
                                            <li class="text-white">
                                                Meal
                                                <ul class="rounded-2 main-bg">
                                                    <li class="link text-white">Food
                                                        <ul class="rounded-2 main-bg">
                                                            <li><a class="dropdown-item text-white" href="#" onclick="openModal('Breakfast')">Breakfast</a></li>
                                                            <li><a class="dropdown-item text-white" href="#" onclick="openModal('Lunch')">Lunch</a></li>
                                                            <li><a class="dropdown-item text-white" href="#" onclick="openModal('Dinner')">Dinner</a></li>
                                                            <li><a class="dropdown-item text-white" href="#" onclick="openModal('Snacks')">Snacks</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openWaterModal('waterModal')">Water</a></li>
                                                </ul>
                                            </li>
                                            <li><a class="dropdown-item text-white" href="#" onclick="openBowelMovementsModal('bowelMovementsModal')">Bowel</a></li>
                                            <li class="link text-white">Activity</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>


                    <?php if (!$login_user_role === "admin") : ?>
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

                    <?php endif; ?>

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
                            <a href="../dashboard/dashboard.php">
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

<!--Food Modal -->
<div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Food</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="food_type">
                <input type="text" id="foodSearch" class="form-control" placeholder="Search for food..." oninput="fetchFoodData()">
                <!-- Display search results -->
                <ul class="list-group mt-3" id="searchResults"></ul>
            </div>
        </div>
    </div>
</div>

<!-- Weight modal  -->
<div class="modal fade" id="weightModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Weight</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-2 mt-2" id="weight-form">
                    <label>Record Weight (Lbs)</label>
                    <input type="number" class="form-control" placeholder="Enter Your Weight For The Mentioned Date" name="weight">
                    <button type="submit" class="btn btn-primary mt-2">Record
                        Weight</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- bowel movements modal  -->
<div class="modal fade" id="bowelMovementsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Bowel Movements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-2 mt-2" id="bowel-form">
                    <label>Record Bowel Movements</label>
                    <input type="number" class="form-control" placeholder="Enter Number of Bowel Movements For The Mentioned Date" name="bowel">
                    <button type="submit" class="btn btn-primary mt-2">Record
                        Bowel Movement</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Weight modal  -->
<div class="modal fade" id="waterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Water</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-2 mt-2" id="water-form">
                    <label>Record Water Consumed</label>
                    <input type="number" class="form-control" placeholder="Enter Oz of Water Consumed For The Mentioned Date" name="water">
                    <button type="submit" class="btn btn-primary mt-2">Record
                        Water Consumption</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Pop-up modal, appears after adding the meal-->
<div class="meal-plan-popup-overlay" id="meal-plan-popup-overlay">
    <div class="meal-plan-popup-content">
        <div class="meal-plan-close" onclick="closeMealPlanPopup()">X</div>

        <div class="meal-plan-message-box">
            <h2 class="meal-plan-title">Did you eat based on today’s plan?</h2>
        </div>

        <div class="meal-plan-buttons">
            <button onclick="confirmMealPlan()">yes, confirm</button>
            <button onclick="customMealPlan()">no, custom meal</button>
        </div>
    </div>
</div>


<script src="../assets/js/jquery.min.js"></script>

<!-- Script to open and close pop-up modal -->
<script>
    function showMealPlanModal() {
        $('#meal-plan-popup-overlay').css('display', 'flex');
    }

    $('.meal-plan-buttons button, .meal-plan-close').on('click', function() {
        location.reload();
    })
</script>

<!-- SCRIPT TO SEARCH AND ADD FOOD -->
<script>
    // Open modal with selected food type
    function openModal(foodOption) {
        document.getElementById('modalTitle').innerText = "Add " + foodOption;
        document.getElementById('foodSearch').value = ''; // Clear search input
        document.getElementById('searchResults').innerHTML = ''; // Clear previous results
        var modal = new bootstrap.Modal(document.getElementById('foodModal'));
        document.getElementById('food_type').value = foodOption; // Clear search input
        modal.show();
    }

    // Fetch food data from Edamam API
    function fetchFoodData() {
        const query = document.getElementById('foodSearch').value;
        if (query.length < 3) return; // Avoid too many requests for short queries

        fetch(`https://api.edamam.com/api/food-database/v2/parser?app_id=f73b06f6&app_key=562df73d9c2324199c25a9b8088540ba&ingr=${query}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const searchResults = document.getElementById('searchResults');
                searchResults.innerHTML = ''; // Clear previous results

                // Edamam stores food items in the 'parsed' and 'hints' arrays
                const foodItems = [...data.parsed, ...data.hints.map(hint => hint.food)];
                const validFoodItems = foodItems.filter(item => item.nutrients && Object.keys(item.nutrients).length > 0);
                validFoodItems.forEach(item => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.innerHTML = item.label || `${item.food.label}`;
                    li.onclick = () => selectFoodItem(item, li); // Pass the selected item and the li element
                    searchResults.appendChild(li);
                });
            })
            .catch(error => console.error('Error fetching food data:', error));
    }

    // Select food item and display its details directly beneath the clicked item
    function selectFoodItem(food, listItem) {
        // Remove any existing expanded sections
        const existingExpandedRow = document.querySelector('.expanded-row');
        if (existingExpandedRow) existingExpandedRow.remove();

        // Create the expanded row to show details
        const expandedRow = document.createElement('div');
        expandedRow.classList.add('expanded-row');

        // Add content to expanded row
        expandedRow.innerHTML = `
                    <h6>${food.label}</h6>
                    <p>Enter amount:</p>
                    <input type="number" id="foodAmount" class="form-control mb-2" value="1" placeholder="Amount" onchange="updateNutritionValues()">

                    <!-- Dropdown for weighing unit -->
                    <select id="weighingUnit" class="form-control mb-2" onchange="updateNutritionValues()">
                    </select>

                    <!-- Display nutritional info -->
                    <div id="nutritionInfo">
                        <p>Calories: <span id="calories">${food.nutrients.ENERC_KCAL || '0'}</span></p>
                        <p>Total Fat: <span id="fat">${food.nutrients.FAT || '0g'}</span></p>
                        <p>Sat. Fat: <span id="satFat">${food.nutrients.FASAT || '0g'}</span></p>
                        <p>Cholest.: <span id="cholesterol">${food.nutrients.CHOLE || '0mg'}</span></p>
                        <p>Sodium: <span id="sodium">${food.nutrients.NA || '0mg'}</span></p>
                        <p>Carb.: <span id="carbs">${food.nutrients.CHOCDF || '0g'}</span></p>
                        <p>Fiber: <span id="fiber">${food.nutrients.FIBTG || '0g'}</span></p>
                        <p>Sugars: <span id="sugars">${food.nutrients.SUGAR || '0g'}</span></p>
                        <p>Protein: <span id="protein">${food.nutrients.PROCNT || '0g'}</span></p>
                    </div>

                    <!-- Button to add food to the database -->
                    <button type="button" class="btn btn-success mt-3" onclick="addFoodToDatabase('${food.foodId}', '${food.label}')">Add Food</button>
                `;

        // Insert the expanded row directly after the selected list item
        listItem.insertAdjacentElement('afterend', expandedRow);

        // Store the default calories per serving in a global variable for calculations
        expandedRow.dataset.caloriesPerServing = food.nutrients.ENERC_KCAL || 0;
        expandedRow.dataset.defaultServingSize = food.servingSize || 1; // Default serving size in the dataset
        expandedRow.dataset.defaultWeightGrams = food.servingWeight || 100; // Default weight in grams

        // Store nutritional data in the row for dynamic calculations
        expandedRow.dataset.fat = food.nutrients.FAT || 0;
        expandedRow.dataset.saturatedFat = food.nutrients.FASAT || 0;
        expandedRow.dataset.cholesterol = food.nutrients.CHOLE || 0;
        expandedRow.dataset.sodium = food.nutrients.NA || 0;
        expandedRow.dataset.carbs = food.nutrients.CHOCDF || 0;
        expandedRow.dataset.fiber = food.nutrients.FIBTG || 0;
        expandedRow.dataset.sugars = food.nutrients.SUGAR || 0;
        expandedRow.dataset.protein = food.nutrients.PROCNT || 0;

        // Populate the weighingUnit dropdown dynamically
        populateWeighingUnits(food);
    }

    // Populate weighing units dynamically
    function populateWeighingUnits(food) {
        const unitSelect = document.getElementById('weighingUnit');
        unitSelect.innerHTML = ''; // Clear previous options

        // Default to "grams" if no specific serving units are available
        let units = ['g', 'oz', 'lb'];

        if (food.servingUnit) {
            units = [food.servingUnit, 'g', 'oz', 'lb'];
        }

        units.forEach(unit => {
            const option = document.createElement('option');
            option.value = unit;
            option.text = unit.charAt(0).toUpperCase() + unit.slice(1);
            unitSelect.appendChild(option);
        });
    }

    // Update nutritional values dynamically based on selected unit and amount
    function updateNutritionValues() {
        const amount = document.getElementById('foodAmount').value || 1;
        const unit = document.getElementById('weighingUnit').value;
        const expandedRow = document.querySelector('.expanded-row');

        if (!expandedRow) return;

        const caloriesPerServing = expandedRow.dataset.caloriesPerServing;
        const defaultServingSize = expandedRow.dataset.defaultServingSize;
        const defaultWeightGrams = expandedRow.dataset.defaultWeightGrams;

        // Conversion factors for other units
        const unitToGrams = {
            g: 1,
            oz: 28.35,
            lb: 453.59
        };

        // Calculate the factor to adjust based on the selected unit and amount
        const weightInGrams = unitToGrams[unit] * amount;

        // Scaling factor for nutritional values
        const scalingFactor = weightInGrams / defaultWeightGrams;

        // Dynamically update all nutritional values
        document.getElementById('calories').innerText = (caloriesPerServing * scalingFactor).toFixed(2);
        document.getElementById('fat').innerText = (expandedRow.dataset.fat * scalingFactor).toFixed(2) + 'g';
        document.getElementById('satFat').innerText = (expandedRow.dataset.saturatedFat * scalingFactor).toFixed(2) + 'g';
        document.getElementById('cholesterol').innerText = (expandedRow.dataset.cholesterol * scalingFactor).toFixed(2) + 'mg';
        document.getElementById('sodium').innerText = (expandedRow.dataset.sodium * scalingFactor).toFixed(2) + 'mg';
        document.getElementById('carbs').innerText = (expandedRow.dataset.carbs * scalingFactor).toFixed(2) + 'g';
        document.getElementById('fiber').innerText = (expandedRow.dataset.fiber * scalingFactor).toFixed(2) + 'g';
        document.getElementById('sugars').innerText = (expandedRow.dataset.sugars * scalingFactor).toFixed(2) + 'g';
        document.getElementById('protein').innerText = (expandedRow.dataset.protein * scalingFactor).toFixed(2) + 'g';
    }

    // Add the selected food to the database
    function addFoodToDatabase(foodId, label) {
        var food_type = document.getElementById('food_type').value;
        var selected_date = document.getElementById('selected_date').value;
        var modal = bootstrap.Modal.getInstance(document.getElementById('foodModal'));
        const foodData = {
            foodId: foodId,
            label: label,
            food_type: food_type,
            amount: document.getElementById('foodAmount').value,
            unit: document.getElementById('weighingUnit').value,
            calories: document.getElementById('calories').innerText,
            totalFat: document.getElementById('fat').innerText,
            satFat: document.getElementById('satFat').innerText,
            cholesterol: document.getElementById('cholesterol').innerText,
            sodium: document.getElementById('sodium').innerText,
            carbs: document.getElementById('carbs').innerText,
            fiber: document.getElementById('fiber').innerText,
            sugars: document.getElementById('sugars').innerText,
            protein: document.getElementById('protein').innerText,
            selected_date: selected_date,
            loginUserRole: "<?php echo $login_user_role ?>",
            userId: "<?php echo $client_user_id ?>"
        };

        // Send food data to the server (you'll need to define the actual endpoint)
        fetch('../functions/food_history/store.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(foodData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == "success") {
                    modal.hide();
                    Swal.fire("Success", "Food added successfully!", "success")
                        .then(() => {
                            showMealPlanModal();
                        });
                } else {
                    swal("Error", "Failed to add food.", "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>

<!-- Script to display notification icon on summary page -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const notificationDropdown = document.querySelector(".custom-notification-dropdown");
        notificationDropdown.classList.remove("d-none");

        // function toggleNotificationVisibility() {
        //     const path = window.location.pathname;
        //     if (path.includes("summary.php")) {} else {
        //         notificationDropdown.classList.add("d-none");
        //     }
        // }
        // toggleNotificationVisibility();
        // window.addEventListener("popstate", toggleNotificationVisibility);
    });
</script>

<!-- Script to open weight modal and store weight -->
<script>
    // Function to open the weight modal
    function openWeightModal() {
        $('#weightModal').modal('show');
    }

    $(document).ready(function() {
        $('#weight-form').on('submit', function(e) {
            e.preventDefault();

            // Get weight and selected_date values
            var weight = $('input[name="weight"]').val();
            var selected_date = document.getElementById('selected_date').value;

            if (!weight || !selected_date) {
                Swal.fire({
                    title: 'Error',
                    text: "Please enter both weight and date.",
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                });
                return;
            }

            $.ajax({
                url: '../functions/weight/store.php',
                type: 'POST',
                data: {
                    weight: weight,
                    selected_date: selected_date,
                    loginUserRole: "<?php echo $login_user_role ?>",
                    userId: "<?php echo $client_user_id ?>"
                },
                success: function(response) {
                    if (response === 'Success') {
                        Swal.fire({
                            title: 'Success',
                            text: "Weight Recorded",
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            $('#weightModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: "Failed to Record Weight",
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: "An error occurred while processing your request. Please try again.",
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });
    });
</script>

<!-- Script to open bowel movements modal and store bowel movements -->
<script>
    function openBowelMovementsModal() {
        $('#bowelMovementsModal').modal('show');
    }

    $(document).ready(function() {
        $('#bowel-form').on('submit', function(e) {
            e.preventDefault();
            var bowel = $('input[name="bowel"]').val();
            var selected_date = document.getElementById('selected_date').value;

            $.ajax({
                url: '../functions/bowel/store.php',
                type: 'POST',
                data: {
                    bowel: bowel,
                    selected_date: selected_date,
                    loginUserRole: "<?php echo $login_user_role ?>",
                    userId: "<?php echo $client_user_id ?>"
                },
                success: function(response) {
                    if (response === 'Success') {
                        Swal.fire({
                            title: 'Success',
                            text: "Bowel Movement Recorded",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            $('#weightModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: "Failed to Record Bowel Movement",
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: "An error occurred while processing your request. Please try again.",
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });
    });
</script>

<!-- Script to open water modal and store bowel movements -->
<script>
    function openWaterModal() {
        $('#waterModal').modal('show');
    }
    $(document).ready(function() {
        $('#water-form').on('submit', function(e) {
            e.preventDefault();
            var water = $('input[name="water"]').val();
            var selected_date = document.getElementById('selected_date').value;

            $.ajax({
                url: '../functions/water/store.php',
                type: 'POST',
                data: {
                    water: water,
                    selected_date: selected_date,
                    loginUserRole: "<?php echo $login_user_role ?>",
                    userId: "<?php echo $client_user_id ?>"
                },
                success: function(response) {
                    if (response === 'Success') {
                        Swal.fire({
                            title: 'Success',
                            text: "Water Consumption Recorded",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            $('#waterModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: "Failed to Record Water Consumption",
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: "An error occurred while processing your request. Please try again.",
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });
    });
</script>

<script>
    function scrollNav(direction) {
        const nav = document.querySelector('.scrollable-nav');
        const scrollAmount = 200; // Adjust for scroll speed

        if (direction === 'left') {
            nav.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        } else {
            nav.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    }

    // Selecting the scrollable navigation container
    const scrollableNav = document.querySelector('.scrollable-nav');

    let isDragging = false;
    let startX;
    let scrollLeft;

    scrollableNav.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX - scrollableNav.offsetLeft;
        scrollLeft = scrollableNav.scrollLeft;
    });

    scrollableNav.addEventListener('mouseleave', () => {
        isDragging = false;
    });

    scrollableNav.addEventListener('mouseup', () => {
        isDragging = false;
    });

    scrollableNav.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - scrollableNav.offsetLeft;
        const walk = (x - startX) * 2;
        scrollableNav.scrollLeft = scrollLeft - walk;
    });

    scrollableNav.addEventListener('wheel', (e) => {
        e.preventDefault();
        scrollableNav.scrollLeft += e.deltaY;
    });
</script>