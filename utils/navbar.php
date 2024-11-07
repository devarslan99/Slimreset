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
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
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
<style>
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
                            left: 100%;
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
                        <li class="menu new-entry-bg-none">
                            <ul>
                                <li>
                                    <button class="btn btn-primary rounded-pill px-3" style="background-color: #946CFC; border: none;">
                                        + new entry
                                    </button>
                                    <ul class="rounded-2">
                                        <li><a class="dropdown-item" href="#" onclick="openWeightModal('weightModal')">Weight</a></li>
                                        <li>
                                            Meal
                                            <ul>
                                                <li class="link">Food
                                                    <ul>
                                                        <li><a class="dropdown-item" href="#" onclick="openModal('Breakfast')">Breakfast</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="openModal('Lunch')">Lunch</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="openModal('Dinner')">Dinner</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#" onclick="openModal('Snacks')">Snacks</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li><a class="dropdown-item" href="#" onclick="openWaterModal('waterModal')">Water</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item" href="#" onclick="openBowelMovementsModal('bowelMovementsModal')">Bowel</a></li>
                                        <li class="link">Activity</li>
                                    </ul>
                                </li>
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

<script src="../assets/js/jquery.min.js"></script>

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
        const foodData = {
            foodId: foodId, // Include food_id
            label: label, // Include label
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
                    location.reload();
                } else {
                    location.reload();
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

<!-- weight script -->
<script>
    $(document).ready(function() {
        $('#weight-form').on('submit', function(e) {
            e.preventDefault();
            var weight = $('input[name="weight"]').val();
            var selected_date = document.getElementById('selected_date').value;

            $.ajax({
                url: '../functions/weight/store.php',
                type: 'POST',
                data: {
                    weight: weight,
                    selected_date: selected_date
                },
                success: function(response) {
                    if (response === 'Success') {
                        Swal.fire({
                            title: 'Success',
                            text: "Weight Recorded",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: "Failed to Record Weight",
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
                    selected_date: selected_date
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
                    selected_date: selected_date
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
                            // Hide the modal only after the success alert is shown
                            $('#weightModal').modal('hide');
                            // Reload the page after user confirms the success alert
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
                    selected_date: selected_date
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
                        });
                        location.reload();
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