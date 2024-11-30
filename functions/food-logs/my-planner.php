<?php
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));
?>

<style>
    .popup-overlay {
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
    

    .popup-content {
        position: relative;
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 30px;
        width: 500px;
        min-height: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 5px;
    }

    .close-popup {
        position: absolute;
        right: 25px;
        top: 5px;
        cursor: pointer;
        color: #333;
        font-weight: bold;
        background-color: #946cfc;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 20px;
        color: #fff;
        border-radius: 50%;
    }


    .meal-detail {
        display: flex;
        justify-content: space-between;
        height: 100%;
        margin-top: 20px;
    }

    .meal-detail .ingredients,
    .meal-detail .details {
        display: flex;
        flex-direction: column;
        gap: 10px;

    }

    .meal-detail .ingredients h2 {
        font-weight: 700;
        color: #946cfc;
        font-size: 2em;
        margin: 0;
    }

    .view-recipe {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .view-recipe .star {
        font-size: 1.9em;
        color: #eaea0c;
        cursor: pointer;
    }

    .view-recipe-btn {
        text-decoration: none;
        font-size: 1.2em;
        background-color: #e7e7113b;
        padding: 12px;
        border-radius: 20px;
        color: #946cfc;
        font-weight: 800;
    }

    /* Grocery Popup Overlay */
    .grocery-popup-overlay {
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

    /* Grocery Popup Content */
    .grocery-popup-content {
        position: relative;
        background-color: #fff;
        padding: 30px;
        border-radius: 20px;
        width: 600px;
        max-width: 90%;
        display: flex;
        flex-direction: column;
        gap: 5px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Close Button */
    .grocery-close-popup {
        position: absolute;
        right: 20px;
        top: 15px;
        cursor: pointer;
        color: #fff;
        font-weight: bold;
        background-color: #946cfc;
        width: 25px;
        height: 25px;
        text-align: center;
        line-height: 25px;
        border-radius: 50%;
    }

    .grocery-list-box {
        max-height: 60vh;
        overflow-y: auto;
        padding-right: 15px;
        margin-top: 20px;
    }

    /* Custom scrollbar styles for webkit browsers */
    .grocery-list-box::-webkit-scrollbar {
        width: 8px;
    }

    .grocery-list-box::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        border-radius: 10px;
    }

    .grocery-list-box::-webkit-scrollbar-thumb {
        background-color: #946cfc;
        border-radius: 10px;
        border: 2px solid #f1f1f1;
    }

    .grocery-list-box::-webkit-scrollbar-thumb:hover {
        background-color: #7f4bc9;
    }

    /* Grocery List Styles */
    .grocery-list-title {
        font-size: 1.8em;
        font-weight: bold;
        color: #946cfc;
    }

    /* Two-column Layout */
    .grocery-columns {
        display: flex;
        gap: 20px;
    }

    .day-data-section
    {
        color: #3c0cba;
        background: #ccb8ff4f;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
    }

    .label-name{
        margin-bottom: 4px;
        background: #946cfc;
        color: #fff;
        padding: 2px 5px;
        text-align: center;
        border-radius: 4px;
    }

    /* PDF Icon */
    .grocery-pdf-icon {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        padding-right:15px;
    }

    .grocery-pdf-icon i {
        cursor: pointer;
        font-size: 32px;
        color: #946cfc;
    }

    .day-header {
        font-weight: bold;
        color: #6b4ce6;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .day-Name {
        text-transform: lowercase;
        font-size: 1rem;
    }

    .date-text {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
    }

    .cal-info {
        color: #000;
        font-size: 0.9rem;
    }
    .col-lg-9
    {
        padding-right:0px;
    }

    .col-lg-9 {
        padding-right: 0px;
    }

    .day-column {
        position: relative;
        border-left: 2px solid #ddd;
        /* padding: 0 20px 0 20px; */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .day-column::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 4px;
        background-color: #ddd;
    }

    .meal-section {
        width: 100%;
        padding: 0px 5px;
    }

    .meal-card,
    .empty-card {
        border: none;
        border-top: 4px solid #ddd;
        padding: 10px 0;
        text-align: center;
        /* min-height: 120px; */
        position: relative;
    }

    .meal-card-rec {
        text-align: center;
        min-height: 120px;
        position: relative;
    }

    .empty-card {
        border-top: 4px solid #ddd;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .add-more {
        border: 1px dashed #ddd;
        border-radius: 0.375rem;
        width: 100%;
        height: 145px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .meal-card img {
        width: 100%;
        border-radius: 5px;
        height: 65px;
        object-fit: cover;
    }

    .meal-name {
        font-weight: bold;
        color: #333;
        margin-top: 5px;
        text-transform:capitalize;

        white-space: nowrap;          
        overflow: hidden;            
        text-overflow: ellipsis;  
        width: 100%;
        max-width: 150px;  
        padding:0 10px
    }

    .meal-name-sub {
        font-weight: bold;
        color: #333;
    }

    .meal-info-container {
        display: flex;
        align-items: end;
        justify-content: center;
    }

    .meal-info {
        display:flex;
        align-items:center;
        justify-content:center;
        font-size: 0.85rem;
        color: #666;
        height:40%;
    }

    .plus-sign {
        font-size: 2rem;
        color: #ccc;
    }

    .nutrition-label {
        background-color: #E9F8E3;
        color: #00BF63;
        font-weight: bold;
        font-size: 0.8rem;
        padding: 2px 6px;
        border-radius: 2px;
        position: absolute;
        left: -45px;
        top: 45px;
        transform: rotate(-90deg);
    }

    .breakfast-label {
        background-color: blue;
        color: white;
        font-weight: bold;
        font-size: 0.8rem;
        padding: 2px 6px;
        border-radius: 2px;
        position: absolute;
        left: -69px;
        top: 70px;
        transform: rotate(-90deg);
    }

    .lunch-label {
        background-color: blue;
        color: white;
        font-weight: bold;
        font-size: 0.8rem;
        padding: 2px 6px;
        border-radius: 2px;
        position: absolute;
        left: -56px;
        top: 70px;
        transform: rotate(-90deg);
    }

    .dinner-label {
        background-color: blue;
        color: white;
        font-weight: bold;
        font-size: 0.8rem;
        padding: 2px 6px;
        border-radius: 2px;
        position: absolute;
        left: -58px;
        top: 70px;
        transform: rotate(-90deg);
    }

    .snack-label {
        background-color: blue;
        color: white;
        font-weight: bold;
        font-size: 0.8rem;
        padding: 2px 6px;
        border-radius: 2px;
        position: absolute;
        left: -56px;
        top: 70px;
        transform: rotate(-90deg);
    }

    .recipe-img-card {
        object-fit:cover;
    }

    .meal-card-container {
        overflow: hidden;
        height:150px
    }

    .custom-border {
        border: 1px solid #946CFC;
    }


    .AddToCart i {
        font-size: 18px;
        color:gray;
    }
    
    .AddToCart i.black-icon {
        color: black; 
        transition: color 0.3s ease; 
    }
    
    .black-icon:hover {
        color: #00BF63 !important; 
        cursor: pointer;
    }

    /* Shake Effect for Full Section */
    .shake-effect {
        animation: shake 0.5s ease-out;
    }

    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
        100% { transform: translateX(0); }
    }

    /* Red Border when Section is Full */
    .meal-box {
        position: relative;
        transition: border 0.3s ease;
        height:145px;
    }

    .meal-box:hover .meal-box-close-btn 
    {
        display:flex;
    }

    /* When the border is added temporarily */
    .meal-box.temp-border {
        border: 2px solid red;
    }

    .meal-box-close-btn
    {
        position: absolute;
        top:-5px;
        right:-5px;
        border-radius: 50%;
        text-align: center;
        width: 25px;
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #9d87f5;
        color: #fff;
        border:2px solid #f2f2f2;
        display:none;
    }

    .meal-box-close-btn .fa-times
    {
        font-size: 12px;
        color:#fff;
    }
    .meal-box-close-btn .fa-times:hover
    {
        color:#fff;
    }

    .reset-filter-btn {
        padding:2px 10px ;
    }
</style>

    <div class="row">
        <div class="col-lg-9">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col text-center mb-3 mb-sm-0">
                        <h1 class="mb-0 fs-2 fs-md-1">Let's plan your meals</h1>
                    </div>

                    <div class="col-auto d-none d-sm-inline-flex">
                        <span class="grocery-list rounded-2 d-inline-flex align-items-center fs-6 fw-bold cursor-pointer">
                            <i class="fa fa-shopping-cart me-2 fs-5 fw-bold"></i>
                            Grocery List
                        </span>
                    </div>

                    <div class="col-12 text-center d-sm-none">
                        <span class="grocery-list rounded-2 d-inline-flex align-items-center fs-6 fw-bold">
                            <i class="fa fa-shopping-cart me-2 fs-5 fw-bold"></i>
                            Grocery List
                        </span>
                    </div>
                    <div class="main-color text-center my-3 d-flex justify-content-center align-items-center">
                        <div id="calendar-icon"><i class="fa fa-calendar me-2 fw-bold fs-4"  style="cursor: pointer;"></i></div>
                        <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $prev_date; ?>">
                            <i class="fa fa-angle-left fw-bold fs-4"></i>
                        </a>
                        <h3 class="text-center mx-2 d-inline main-color">
                            <?php echo date('M d, Y', strtotime($selected_date)); ?>
                        </h3>
                        <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $next_date; ?>">
                            <i class="fa fa-angle-right fw-bold fs-4"></i>
                        </a>

                        <!-- Hidden input field for Flatpickr calendar -->

                        <input type='text' id="datepicker" style="display: none; width: 0px; height: 0px; outline: none; border: none; display: block;">
                    </div>
                </div>

                <!-- pop up box For Recipe -->
                <div class="popup-overlay" id="popup-overlay">
                    <div class="popup-content">
                        <div class="close-popup" onclick="closePopup()">X</div>
                        <div class="meal-detail">
                            <div class="ingredients">
                                <h2>veggie omelette</h2>
                                <strong>ingredients</strong>
                                <span>egg</span>
                                <span>your choice of veg</span>
                            </div>
                            <div class="details">
                                <div><strong>calories</strong> 120 kcal</div>
                                <div><strong>protein</strong> 1.5 oz</div>
                                <div><strong>prep</strong> 5 min</div>
                                <div><strong>cook</strong> 20 min</div>
                            </div>
                        </div>
                        <div class="view-recipe">
                            <span class="star">★</span>
                            <a href="#" class="view-recipe-btn">view full recipe</a>
                        </div>
                    </div>
                </div>
                
                <!-- Grocery List Popup Overlay -->
                <div class="grocery-popup-overlay" id="grocery-popup-overlay">
                    <div class="grocery-popup-content">
                        <div class="grocery-close-popup" onclick="closeGroceryPopup()">X</div>
                        <!-- dynamically content will display here -->
                        <div class="grocery-list-box">
                            <h2 class="grocery-list-title">grocery list</h2>
                            
                            <div class="list-box">
                                <span class="label-name">
                                    Breakfast
                                </span>
                                
                                <div class="recipe-name-date d-flex justify-content-between align-items-center mb-2">
                                    <h3 class="fw-bold mb-0">Cheese Pizza</h3>
                                    <p class="text-muted mb-0">Nov 12</p>
                                </div>

                                <div class="row">
                                    <!-- Left Column with Calories and Total Fat -->
                                    <div class="col-md-6 mb-3">
                                        <div class="left">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-bold mb-1">Calories</h5>
                                                <p class="mb-0">2.74g</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-bold  mb-1">Total Fat</h5>
                                                <p class="mb-0">0.74g</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column with Carbohydrates and Protein -->
                                    <div class="col-md-6 mb-3">
                                        <div class="right ">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-bold mb-1">Carbohydrates</h5>
                                                <p class="mb-0">15g</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-bold mb-1">Protein</h5>
                                                <p class="mb-0">8g</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="list-box">
                                <span class="label-name" data-label="Breakfast">
                                    Breakfast
                                </span>
                                
                                <div class="recipe-name-date d-flex justify-content-between align-items-center mb-2">
                                    <h3 class="fw-bold mb-0">Cheese Pizza</h3>
                                    <p class="text-muted mb-0">Nov 12</p>
                                </div>

                                <div class="row">
                                    <!-- Left Column with Calories and Total Fat -->
                                    <div class="col-md-6 mb-3">
                                        <div class="left">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-bold mb-1">Calories</h5>
                                                <p class="mb-0">2.74g</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-bold  mb-1">Total Fat</h5>
                                                <p class="mb-0">0.74g</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column with Carbohydrates and Protein -->
                                    <div class="col-md-6 mb-3">
                                        <div class="right ">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-bold mb-1">Carbohydrates</h5>
                                                <p class="mb-0">15g</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <h5 class="fw-bold mb-1">Protein</h5>
                                                <p class="mb-0">8g</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                
                        </div>
                        <!-- PDF Icon -->
                        <div class="grocery-pdf-icon">
                            <i class="fa fa-file-pdf-o" id="mealListPdfBtn"></i>
                        </div>
                    </div>
                </div>

                <!-- 2nd Grocery List Popup Box -->
                <div class="grocery-popup-overlay" id="grocery-popup-overlay-2">
                    <div class="grocery-popup-content">
                        <div class="grocery-close-popup" onclick="closeGroceryPopup2()">X</div>
                        
                        <h2 class="grocery-list-title">Grocery List</h2>
                        <!-- Grocery List Content -->
                        <div class="grocery-list-box grocery-list-box-2">
                            
                            <!-- Columns for Aisles -->
                            <div class="grocery-columns">
                                <!-- Left Column -->
                                <div class="grocery-column">
                                    <div class="grocery-aisle">
                                        <h3>Vegetable Aisle</h3>
                                        <ul>
                                            <li>
                                                <input type="checkbox" checked>
                                                <span>Eggs, <strong>3</strong></span>
                                            </li>
                                            <li>
                                                <input type="checkbox" checked>
                                                <span>Chicken Breast, <strong>3</strong></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Repeat as needed -->
                                </div>
                                
                                <!-- Right Column -->
                                <div class="grocery-column">
                                    <div class="grocery-aisle">
                                        <h3>Vegetable Aisle</h3>
                                        <ul>
                                            <li>
                                                <input type="checkbox" checked>
                                                <span>Eggs, <strong>3</strong></span>
                                            </li>
                                            <li>
                                                <input type="checkbox" checked>
                                                <span>Chicken Breast, <strong>3</strong></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- PDF Icon -->
                        <div class="grocery-pdf-icon">
                            <i class="fa fa-file-pdf-o" onclick="GroceryListPdf(mealDataArray)"></i>
                        </div>
                    </div>
                </div>

                <div class="container mt-4">
                    <div class="row" id="empty-card-slots">
                        <!-- The empty card slots will display dynamically from jQuery -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-center">Recipes</h1>
                <button id="plannerResetFilterBtn" class='btn btn-primary rounded-pill py-2 reset-filter-btn'>Reset filter</button>
            </div>
            <!-- Dropdowns -->
            <div class="my-3">
                <div class="row g-2">
                    <div class="col-12 col-sm-6 col-md-4">
                        <select class="custom-select w-100" id="my-planner-filter-protein">
                          
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <select class="custom-select w-100" id="my-planner-filter-veggie">
                            
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <select class="custom-select w-100" id="my-planner-filter-fruit">
                            
                        </select>
                    </div>
                </div>
            </div>

            <!-- Category Checkboxes -->
            <div class="d-flex flex-wrap gap-3 recipe-checkboxes">
                <div class="custom-checkbox">
                    <input type="checkbox" id="breakfastCheckBox" onchange="handleMyPlannerCheckboxChange(event)">
                    <label for="breakfastCheckBox">Breakfast</label>
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" id="lunchCheckBox" onchange="handleMyPlannerCheckboxChange(event)">
                    <label for="lunchCheckBox">Lunch/Dinner</label>
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" id="snacksCheckBox" onchange="handleMyPlannerCheckboxChange(event)">
                    <label for="snacksCheckBox">Snacks</label>
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" id="beveragesCheckBox" onchange="handleMyPlannerCheckboxChange(event)">
                    <label for="beveragesCheckBox">Beverages</label>
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" id="flavouringsCheckBox" onchange="handleMyPlannerCheckboxChange(event)">
                    <label for="flavouringsCheckBox">Flavorings</label>
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" id="dessertCheckBox" onchange="handleMyPlannerCheckboxChange(event)">
                    <label for="dessertCheckBox">Dessert</label>
                </div>
            </div>

            <!-- Recipe Cards -->
            <div class="d-flex flex-wrap mt-3 gap-2" id="meal-cards">
                <!-- Recipe Card will came here dynamically from jQuery -->
            </div>
        </div>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.72/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.72/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<?php
    include_once "../database/db_connection.php";

    $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

    $recipes = [];
    if ($user_id) {
        $stmt = mysqli_prepare($mysqli, "SELECT * FROM recipe_items ORDER BY id DESC");
        // mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $recipes = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
        mysqli_stmt_close($stmt);
    }
    $recipes_json = json_encode($recipes);


    
    $meal_planner = [];
    if ($user_id) {
        $stmt = mysqli_prepare($mysqli, "SELECT * FROM meal_planner ORDER BY id DESC");
        // mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result2 = mysqli_stmt_get_result($stmt);
        $recipesplanner = $result2 ? mysqli_fetch_all($result2, MYSQLI_ASSOC) : [];
        mysqli_stmt_close($stmt);
    }
    $meal_planner_json = json_encode($recipesplanner);
?>


<script>
    // Embed PHP JSON data into JavaScript
    const savedMealCards = <?php echo $meal_planner_json ?: '[]'; ?>;

    function repopulateMealSection () {
        const slotContainer = document.getElementById('empty-card-slots')
        console.log(slotContainer.children)
    }
    document.addEventListener("DOMContentLoaded", () => {
        repopulateMealSection()
        
            // savedMealCards.forEach(meal => {
            //     const mealSection = document.querySelector(`.meal-section[data-label="${meal.label}"]`); // Select the correct meal section by label
            //     if (!mealSection) return;

            //     const mealCard = document.createElement('div');
            //     mealCard.classList.add('meal-card');
            //     mealCard.innerHTML = `
            //         <div class="custom-border rounded meal-box" 
            //             data-meal-name="${meal.mealName}" 
            //             data-meal-calories="${meal.mealInfo.calories}" 
            //             data-meal-size="${meal.mealInfo.size}" 
            //             data-meal-carbs="${meal.carbs}" 
            //             data-meal-fats="${meal.fats}" 
            //             onclick="showBox(this)" data-id="${meal.foodId}">
            //             <img src="${meal.image}" alt="${meal.mealName}">
            //             <div class="meal-name">${meal.mealName}</div>
            //             <div class="meal-info">${meal.mealInfo.calories}<br>${meal.mealInfo.size}</div>
            //             <div class="meal-box-close-btn"><i class="fa fa-times"></i></div>
            //         </div>
            //     `;

            //     // Append the meal card to the appropriate section
            //     mealSection.appendChild(mealCard);

            //     // Add event listener to close button
            //     const closeButton = mealCard.querySelector('.meal-box-close-btn');
            //     closeButton.addEventListener('click', function(e) {
            //         e.stopPropagation();
            //         Swal.fire({
            //             title: 'Are you sure?',
            //             text: "Do you really want to remove this meal?",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonText: 'Yes, remove it!',
            //             cancelButtonText: 'No, cancel',
            //             reverseButtons: true
            //         }).then((result) => {
            //             if (result.isConfirmed) {
            //                 mealCard.remove();
            //                 // Handle removal from your arrays and database
            //                 removeMealData(meal.foodId);
            //             }
            //         });
            //     });
            // });
    });

</script>

<!-- Script of display meal-card and script of filtering all meal-cards -->
<script>

    // Function to display meal cards
    let PlannerRecipes = <?php echo $recipes_json; ?>;
    function displayMealCardRecipe(recipes) {

        $.each(recipes, function (index, meal) {
            
            const meal_Image = meal.image && meal.image.startsWith('https://www.') 
            ? meal.image 
            : `../assets/images/recipe_images/uploads/${meal.image}`;

            const calories = Math.round(meal.calories);
            const protein = Math.round(meal.protein);
            const carbs = Math.round(meal.carbs);

            const mealCard = `
                <div
                    class="meal-card-rec" 
                    data-meal-fats="${meal.satFat}" 
                    data-meal-carbs="${carbs}"
                    data-food-id="${meal.foodId}" 
                    data-label="${meal.label}" 
                    data-image="${meal.image}" 
                    data-amount="${meal.amount}" 
                    data-unit="${meal.unit}" 
                    data-meal-type-id="${meal.meal_type_id}" 
                    data-food-group-id="${meal.food_group_id}" 
                    data-veggie-id="${meal.veggie_id}" 
                    data-protein-id="${meal.protein_id}" 
                    data-fruit-id="${meal.fruit_id}" 
                    data-calories="${meal.calories}" 
                    data-total-fat="${meal.totalFat}" 
                    data-cholesterol="${meal.cholesterol}" 
                    data-sodium="${meal.sodium}" 
                    data-fiber="${meal.fiber}" 
                    data-sugars="${meal.sugars}" 
                    data-protein="${meal.protein}"
                    >
                    <div class="custom-border rounded meal-card-container">
                        <img class="recipe-img-card" src="${meal_Image}" onerror="this.src='https://propertywiselaunceston.com.au/wp-content/themes/property-wise/images/no-image@2x.png';" alt="${meal.label}">
                        <div class="meal-name">  ${meal.label.split(' ').length > 1 ? meal.label.split(' ').slice(0, 2).join(' <br> ') : meal.label + '<br><br>'}</div>
                        <div class="meal-name-sub"></div>
                        <div class='meal-info-container'>
                        <div class="meal-info">${calories} kcal<br>${protein} oz</div>
                        <span class="text-end star-margin">
                            <i class="fa fa-star"></i>
                        </span>
                        </div>
                    </div>
                </div>
            `;
            $('#meal-cards').append(mealCard);
        });
    }

    displayMealCardRecipe(PlannerRecipes); 


    // Function Reset button to reset all filter which are selected
    const plannerResetFilterBtn = document.getElementById('plannerResetFilterBtn')
    plannerResetFilterBtn.addEventListener("click", function() {
        $('#meal-cards').empty();
        displayMealCardRecipe(PlannerRecipes); 

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });

        const dropdowns = [
            'my-planner-filter-protein',
            'my-planner-filter-veggie',
            'my-planner-filter-fruit',
        ];
        dropdowns.forEach(dropdownId => {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.selectedIndex = 0;
            }
        });

    });

</script>

<!-- script to sending meal card data to data base on drop of meal -->
<script>
    function PopulateingMealCardDataToDataBase (mealData) { 
        // Send Meal food data to the server
        fetch('../functions/food_history/meal_planner.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(mealData),
            })
            .then(response =>response.json())
            .then(data => {
                if (data.status == "success") {
                    modal.hide();
                    Swal.fire("Success", "Recipe added successfully!", "success")
                        .then(() => location.reload())
                } else {
                    swal("Error", "Failed to add recipe.", "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
        });
    }
</script>

<script>
    $(document).ready(function() {

        // Function to generate days data with formatted date
        function getUrlDate() {
            const urlParams = new URLSearchParams(window.location.search);
            const urlDate = urlParams.get('date'); // Get date from URL
            return urlDate ? new Date(urlDate) : new Date(); // Default to current date if no date is provided
        }

        function generateDaysData() {
            const daysData = [];
            const startDate = getUrlDate();

            for (let i = 0; i < 7; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);

                // Get the abbreviated day name (e.g., "Thu") and formatted date
                const dayAbbreviation = date.toLocaleDateString('en-US', { weekday: 'short' } );
                const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });

                daysData.push({
                    day: i + 1,
                    dayAbbreviation: dayAbbreviation, 
                    date: formattedDate,
                    kcal: '00',
                    oz: '00'
                });
            }
            return daysData;
        }
        
        // Function to create HTML for each day column
        function createDayColumn(dayData, isFirstColumn) {
            const dayId = `day${dayData.day}`;
            const kcal = dayNutritionTotals[dayId]?.kcal || 0;
            const oz = dayNutritionTotals[dayId]?.oz || 0;

            return `
                <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                    <div class="text-center">
                        ${isFirstColumn ? '<div class="nutrition-label">nutrition</div>' : ''}
                        <div class="day-header">day ${dayData.day}</div>
                        <div class="day-Name fs-2" data-day="${dayData.dayAbbreviation}">${dayData.dayAbbreviation}</div>
                        <div class="date-text" data-date="${dayData.date}">${dayData.date}</div>
                        <div class="cal-info">${kcal}kcal<br>${oz} oz</div>
                        <div class="AddToCart"><i class="fa fa-shopping-cart" id="cartIcon"></i></div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-breakfast" data-label="Breakfast">
                        <div class="meal-card">${isFirstColumn ? '<div class="breakfast-label meal-card-title">Breakfast</div>' : ''}
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-lunch" data-label="Lunch">
                        <div class="meal-card">${isFirstColumn ? '<div class="lunch-label meal-card-title">Lunch</div>' : ''}
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-dinner" data-label="Dinner">
                        <div class="meal-card">${isFirstColumn ? '<div class="dinner-label meal-card-title">Dinner</div>' : ''}
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-snack" data-label="Snack">
                        <div class="meal-card">${isFirstColumn ? '<div class="snack-label meal-card-title">Snack</div>' : ''}
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Generate and append the columns with dates
        function displayDates() {
                const daysData = generateDaysData();

                // Clear any existing content
                $('#empty-card-slots').empty();

                function updateLabels() {
                    setTimeout(() => {
                        // Clear all labels first
                        $('.nutrition-label, .breakfast-label, .lunch-label, .dinner-label, .snack-label').remove();

                        // Use a more robust way to detect columns in a row
                        let columnsInRow = []; 

                        $('.day-column').each(function () {
                            const $dayColumn = $(this);
                            const currentRowTop = $dayColumn.offset().top; 
                            
                            // Collect columns in the same row based on their offset.top
                            if (!columnsInRow[currentRowTop]) columnsInRow[currentRowTop] = [];
                            columnsInRow[currentRowTop].push($dayColumn);
                        });

                        // Now process columns in each row and add labels where necessary
                        Object.keys(columnsInRow).forEach((rowTop) => {
                            const rowColumns = columnsInRow[rowTop];

                            const $firstColumn = rowColumns[0]; 
                            addLabels($firstColumn);
                        });
                    }, 200); 
                }

                function addLabels($dayColumn) {
                    const dayNumber = $dayColumn.find('.day-header').text().split(" ")[1];
                    if (!dayNumber) return; 

                    // Add labels to the column
                    $dayColumn.find('.text-center').prepend('<div class="nutrition-label">nutrition</div>');
                    $dayColumn.find(`#day${dayNumber}-breakfast .meal-card`).prepend('<div class="breakfast-label meal-card-title">Breakfast</div>');
                    $dayColumn.find(`#day${dayNumber}-lunch .meal-card`).prepend('<div class="lunch-label meal-card-title">Lunch</div>');
                    $dayColumn.find(`#day${dayNumber}-dinner .meal-card`).prepend('<div class="dinner-label meal-card-title">Dinner</div>');
                    $dayColumn.find(`#day${dayNumber}-snack .meal-card`).prepend('<div class="snack-label meal-card-title">Snack</div>');
                }

                $(document).ready(function () {
                    setTimeout(() => {
                        updateLabels();
                    }, 100); 
                });

                // Trigger updateLabels on window load and resize events
                $(window).on('load resize', function () {
                    setTimeout(() => {
                        updateLabels();
                    }, 100); 
                });
                $('.nav-link').on('shown.bs.tab', function (e) {
                    setTimeout(() => {
                        updateLabels();
                    }, 200); 
                });
                
                // Append the new columns
                daysData.forEach((day, index) => {
                    $('#empty-card-slots').append(createDayColumn(day, index === 0)); 
                });
        }
            // Initial load of the columns
            displayDates();
            // Optional: Refresh the dates daily at midnight
            setInterval(displayDates, 24 * 60 * 60 * 1000); 


            // Initialize Sortable after all elements have been created
            initializeSortable();
    });

    let mealDataArray = [];
    // Function to populate all meat-card data into grocery list
    function populateAllGroceryList(mealDataArray) {
        const groceryListBox = document.querySelector('.grocery-list-box-2');
        groceryListBox.innerHTML = ''; 

        // Check if mealDataArray has data
        if (mealDataArray.length === 0) {
            // Remove event listener if no data is available
            const groceryListBtn = document.querySelector('.grocery-list');
            groceryListBtn.removeEventListener('click', showGroceryPopup2);
            return; // Exit the function if mealDataArray is empty
        }

        const fullDayNames = {
            "Mon": "Monday",
            "Tue": "Tuesday",
            "Wed": "Wednesday",
            "Thu": "Thursday",
            "Fri": "Friday",
            "Sat": "Saturday",
            "Sun": "Sunday"
        };
            
        // Group meals by day
        const groupedMeals = mealDataArray.reduce((acc, meal) => {
            if (!acc[meal.day]) {
                acc[meal.day] = [];
            }
            acc[meal.day].push(meal);
            return acc;
        }, {});

        // Iterate over grouped meals and create the HTML
        for (const [day, meals] of Object.entries(groupedMeals)) {
            const fullDayName = fullDayNames[day] || day;
            // Add the day section header with date
            let daySectionHTML = `
                <div class="day-section">
                    <div class="d-flex justify-content-between day-data-section">
                        <span class="day-box fs-5 fw-bold">${fullDayName}</span>
                        <span class="date-box fs-5 fw-bold">${meals[0].date}</span>
                    </div>
            `;

            // Iterate through meals of the current day and display each meal's data
            meals.forEach(meal => {
                daySectionHTML += `
                    <div class="list-box">
                        <span class="label-name">${meal.label}</span> <!-- Dynamic label -->
                        <div class="recipe-name-date d-flex justify-content-between align-items-center mb-2">
                            <h3 class="fw-bold mb-0">${meal.mealName} ${meal.mealSubName}</h3>
                            <p class="text-muted mb-0"></p>
                        </div>
                        <div class="row">
                            <!-- Left Column with Calories and Total Fat -->
                            <div class="col-md-6 mb-3">
                                <div class="left">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold mb-1">Calories</h5>
                                        <p class="mb-0">${meal.mealInfo.calories || 'N/A'}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold mb-1">Total Fat</h5>
                                        <p class="mb-0">${meal.mealInfo.fats || 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Right Column with Carbohydrates and Protein -->
                            <div class="col-md-6 mb-3">
                                <div class="right">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold mb-1">Carbohydrates</h5>
                                        <p class="mb-0">${meal.mealInfo.carbs || 'N/A'}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold mb-1">Protein</h5>
                                        <p class="mb-0">${meal.mealInfo.size || 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
        });

        // Close the day section div
        daySectionHTML += '</div>';
        
        // Append the complete section to the grocery list box
        groceryListBox.innerHTML += daySectionHTML;
        }

        // Grocery list button event listener
        const groceryListBtn = document.querySelector('.grocery-list');
        groceryListBtn.addEventListener('click', showGroceryPopup2);
    }

    const dayMealData = {
        day1: [],
        day2: [],
        day3: [],
        day4: [],
        day5: [],
        day6: [],
        day7: []
    };
    let selectedId = null;

    const dayNutritionTotals = {};

    // // Function to populate specific meal card data the grocery list
    function populateGroceryList(dayMealData) {
        const groceryListBox = document.querySelector('.grocery-list-box');
        groceryListBox.innerHTML = ''; // Clear previous content

        // Flag to check if day and date have been displayed
        let isDayDateDisplayed = false;

        dayMealData.forEach(meal => {
            const mealHTML = `
                <div class="list-box">
                    ${
                        !isDayDateDisplayed
                        ? `<div class="d-flex justify-content-between day-data-section">
                            <span class="day-box fs-5 fw-bold">${meal.day}</span>
                            <span class="date-box fs-5 fw-bold">${meal.date}</span>
                        </div>`
                        : ''
                    }
                    <span class="label-name">${meal.label}</span>
                    <div class="recipe-name-date d-flex justify-content-between align-items-center mb-2">
                        <h3 class="fw-bold mb-0">${meal.mealName} ${meal.mealSubName}</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="left">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold mb-1">Calories</h5>
                                    <p class="mb-0">${meal.mealInfo.calories || 'N/A'}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold mb-1">Total Fat</h5>
                                    <p class="mb-0">${meal.mealInfo.fats || 'N/A'}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="right">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold mb-1">Carbohydrates</h5>
                                    <p class="mb-0">${meal.mealInfo.carbs || 'N/A'}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold mb-1">Protein</h5>
                                    <p class="mb-0">${meal.mealInfo.size || 'N/A'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            groceryListBox.innerHTML += mealHTML;

            // Set flag to true after displaying day and date once
            isDayDateDisplayed = true;
        });
    }

    function initializeSortable() {
        // Make the meal cards (right side, recipes) draggable
        Sortable.create(document.getElementById('meal-cards'), {
            group: {
                name: 'shared',
                pull: 'clone',
                put: false
            },
            animation: 150,
            sort: false
        });

        // Make each meal section (left side, empty slots) a drop target only
        const mealSections = document.querySelectorAll('.meal-section');
        mealSections.forEach(section => {
            Sortable.create(section, {
                group: {
                    name: 'shared',
                    pull: false,
                    put: true
                },
                animation: 150,
                sort: false,
                onAdd: function(evt) {
                        const targetSection = evt.to;
                        // Check if the section already contains a meal card
                        if (targetSection.querySelector('.meal-card .meal-box')) {
                            const existingMealBox = targetSection.querySelector('.meal-card .meal-box');
                            existingMealBox.style.cursor = 'not-allowed';
                            existingMealBox.style.border = '2px solid red';
                            existingMealBox.classList.add('shake-effect'); 
                            evt.item.remove(); // Remove the dragged item to prevent adding duplicate
                            setTimeout(() => {
                                existingMealBox.style.border = '';
                                existingMealBox.classList.remove('shake-effect');
                                existingMealBox.style.cursor = '';
                            }, 500);

                            return;
                        } else {
                            // Reset cursor and border if the section becomes empty
                            targetSection.style.border = '';
                            targetSection.classList.remove('shake-effect');
                        }
                        // Get the data from the dragged element
                        const draggedItem = evt.item;
                        const imageSrc = draggedItem.querySelector('img').src;
                        const mealName = draggedItem.querySelector('.meal-name').textContent;
                        const mealSubName = draggedItem.querySelector('.meal-name-sub') ? draggedItem.querySelector('.meal-name-sub').textContent : '';
                        const mealCarbs = draggedItem.getAttribute('data-meal-carbs');
                        const mealFats = draggedItem.getAttribute('data-meal-fats');
                        // Extract the nutritional information
                        const mealInfoDiv = draggedItem.querySelector('.meal-info');
                        const mealInfo = extractMealInfo(mealInfoDiv);
                        const kcal = parseFloat(mealInfo.calories) || 0;
                        const oz = parseFloat(mealInfo.size) || 0;
                        // Capture the section label
                        const sectionLabel = evt.to.getAttribute('data-label');
                        // Find the date in the day column
                        const dayColumn = evt.to.closest('.day-column');
                        // Identify the day column where the meal was dropped
                        const dayId = dayColumn.querySelector('.day-header').textContent.toLowerCase().replace(" ", "");
                        const dateTextElement = dayColumn ? dayColumn.querySelector('.date-text') : null;
                        const date = dateTextElement ? dateTextElement.getAttribute('data-date') : '';
                        const dayTextElement = dayColumn ? dayColumn.querySelector('.day-Name') : null;
                        const day = dayTextElement ? dayTextElement.getAttribute('data-day') : '';
                        // meal-box id
                        const mealId = `meal-${new Date().getTime()}`;
                        // Find the existing empty .meal-card in the target section
                        const targetMealCard = evt.to.querySelector('.meal-card');
                        if (targetMealCard) {
                            // Keep the existing label in the meal card
                            const existingLabel = targetMealCard.querySelector('.meal-card-title');
                            
                            // Populate the .meal-card with structured content, retaining the label
                            targetMealCard.innerHTML = `
                                ${existingLabel ? existingLabel.outerHTML : ''} <!-- Keep existing label -->
                                <div class="custom-border rounded meal-box" 
                                    data-meal-name="${mealName}"
                                    data-meal-calories="${mealInfo.calories}" 
                                    data-meal-size="${mealInfo.size}" 
                                    data-meal-carbs="${mealCarbs}" 
                                    data-meal-fats="${mealFats}" 
                                    onclick="showBox(this)" data-id="${mealId}">
                                    <img src="${imageSrc}" alt="${mealName}">
                                    <div class="meal-name">${mealName}</div>
                                    <div class="meal-info">${mealInfo.calories}<br>${mealInfo.size}</div> 
                                    <div class="meal-box-close-btn"><i class="fa fa-times"></i></div>
                                </div>
                            `;

                            // Add event listener for the close button inside the meal-box
                            const closeButton = targetMealCard.querySelector('.meal-box-close-btn');
                            closeButton.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const mealBox = closeButton.closest('.meal-box');
                                if (mealBox) {
                                    // SweetAlert confirmation dialog
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "Do you really want to remove this meal?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, remove it!',
                                        cancelButtonText: 'No, cancel',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                        const mealCard = mealBox.closest('.meal-card');
                                        if (mealCard) {
                                        // Remove the meal-box inside the meal-card
                                        mealBox.remove();
                                        
                                        const mealId = mealBox ? mealBox.getAttribute('data-id') : null;
                                        // Get the day and meal section to properly identify which day and meal type the card belongs to
                                        const dayColumn = mealCard.closest('.day-column');
                                        const mealSection = mealCard.closest('.meal-section');

                                        if (dayColumn && mealSection) {
                                            const dayId = dayColumn.querySelector('.day-header').textContent.trim().toLowerCase().replace(' ', '');
                                            const mealLabel = mealSection.getAttribute('data-label'); // Get the meal label (Breakfast, Lunch, etc.)

                                            // Remove the corresponding meal data from the arrays
                                            const mealName = mealBox.getAttribute('data-meal-name');
                                            
                                            // Remove from mealDataArray
                                            const mealIndex = mealDataArray.findIndex(meal => meal.mealName === mealName);
                                            if (mealIndex !== -1) {
                                                mealDataArray.splice(mealIndex, 1); // Remove from mealDataArray
                                            }

                                            // Update kcal and oz in dayNutritionTotals for the specific dayId
                                            if (mealData && mealData.mealInfo) {
                                                const kcalToRemove = parseFloat(mealData.mealInfo.calories || 0);
                                                const ozToRemove = parseFloat(mealData.mealInfo.size || 0);

                                                if (dayNutritionTotals[dayId]) {
                                                    dayNutritionTotals[dayId].kcal -= kcalToRemove;
                                                    dayNutritionTotals[dayId].oz -= ozToRemove;
                                                }
                                            }

                                            // Update the display of kcal and oz in the day column after meal removal
                                            const calInfoElement = dayColumn.querySelector('.cal-info');
                                            if (calInfoElement) {
                                                calInfoElement.innerHTML = `${dayNutritionTotals[dayId].kcal} kcal<br>${dayNutritionTotals[dayId].oz} oz`;
                                            }

                                            // Remove from dayMealData for the corresponding day and meal section
                                            if (dayMealData[dayId]) {
                                                const mealIndex = dayMealData[dayId].findIndex(meal => meal.mealId === mealId); 

                                                // If the meal is found, remove it
                                                if (mealIndex !== -1) {
                                                    dayMealData[dayId].splice(mealIndex, 1); 
                                                } else {
                                                    console.error(`Meal with ID ${mealId} not found in dayMealData for dayId: ${dayId}`);
                                                }
                                            } 
                                            
                                            const remainingMealCards = mealSection.querySelectorAll('.meal-box');
                                            if (dayMealData[dayId] && dayMealData[dayId].length === 0) {
                                                // Reset the icon's color and remove the event listener
                                                const addToCartIcon = dayColumn.querySelector('.AddToCart');
                                                if (addToCartIcon) {
                                                    const cartIcon = addToCartIcon.querySelector('i');
                                                    if (cartIcon) {
                                                        cartIcon.style.color = '';  // Reset color
                                                        cartIcon.classList.remove('black-icon');  // Remove the black-icon class
                                                        // Remove the click event listener if needed
                                                        cartIcon.addEventListener('click', closeGroceryPopup);
                                                    }
                                                }
                                            }

                                            // Update section (meal-card) if needed
                                            if (mealCard.children.length === 0) {
                                                // If the meal-card is now empty, you may want to add back the empty slot or display a message.
                                                const addMoreDiv = document.createElement('div');
                                                addMoreDiv.classList.add('add-more');
                                                addMoreDiv.innerHTML = '<div class="plus-sign">+</div>';
                                                mealCard.appendChild(addMoreDiv);
                                            }

                                            populateAllGroceryList(mealDataArray);
                                            populateGroceryList(dayMealData[dayId]);
                                        }
                                        }
                                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                                            Swal.fire('Cancelled', 'Your meal data is safe', 'error');
                                        }
                                    });
                                }
                            });
                        }

                        // Remove the dragged item from its original location to keep a single instance
                        draggedItem.remove();

                        // Capture the meal card data and add it to the array
                        const mealData = {
                            foodId: draggedItem.getAttribute('data-food-id'),
                            amount: draggedItem.getAttribute('data-amount'),
                            unit: draggedItem.getAttribute('data-unit'),
                            meal_type_id: draggedItem.getAttribute('data-meal-type-id'),
                            food_group_id: draggedItem.getAttribute('data-food-group-id'),
                            veggie_id: draggedItem.getAttribute('data-veggie-id'),
                            protein_id: draggedItem.getAttribute('data-protein-id'),
                            fruit_id: draggedItem.getAttribute('data-fruit-id'),
                            calories: draggedItem.getAttribute('data-calories'),
                            totalFat: draggedItem.getAttribute('data-total-fat'),
                            satFat: draggedItem.getAttribute('data-meal-fats'),
                            cholesterol: draggedItem.getAttribute('data-cholesterol'),
                            sodium: draggedItem.getAttribute('data-sodium'),
                            carbs: draggedItem.getAttribute('data-meal-carbs'),
                            fiber: draggedItem.getAttribute('data-fiber'),
                            sugars: draggedItem.getAttribute('data-sugars'),
                            protein: draggedItem.getAttribute('data-protein'),
                            user_id: <?php echo $user_id ?>,
                            image: imageSrc,
                            mealName,
                            mealSubName,
                            mealInfo: {
                                calories: mealInfo.calories,
                                size: mealInfo.size,
                                carbs: mealCarbs,
                                fats: draggedItem.getAttribute('data-total-fat'),
                            },
                            label: sectionLabel,
                            date,
                            day
                        };
                        mealDataArray.push(mealData);
                        populateAllGroceryList(mealDataArray);
                        PopulateingMealCardDataToDataBase(mealData)
                        if (dayId) {

                            // Push meal data into the specific day array
                            if (dayMealData[dayId]) {
                                dayMealData[dayId].push({ ...mealData , mealId });
                            } else {
                                console.error(`Invalid dayId: ${dayId}`);
                            }

                            // Ensure `dayNutritionTotals` is initialized for this dayId
                            if (!dayNutritionTotals[dayId]) {
                                dayNutritionTotals[dayId] = { kcal: 0, oz: 0 };
                            }

                            // Add the meal's kcal and oz to the day's totals
                            if (mealData && mealData.mealInfo) {
                                dayNutritionTotals[dayId].kcal += parseFloat(mealData.mealInfo.calories || 0);
                                dayNutritionTotals[dayId].oz += parseFloat(mealData.mealInfo.size || 0);
                            }

                            // Update the display of kcal and oz in the day column
                            const calInfoElement = dayColumn.querySelector('.cal-info');
                            if (calInfoElement) {
                                calInfoElement.innerHTML = `${dayNutritionTotals[dayId].kcal} kcal<br>${dayNutritionTotals[dayId].oz} oz`;
                            }

                            
                        }
                        // Handle the cart icon visibility
                        const addToCartIcon = dayColumn.querySelector('.AddToCart');
                        // Check if there is meal data for this dayId
                        if (dayMealData[dayId] && dayMealData[dayId].length > 0) {
                            // Meal data exists, make sure the cart icon is visible and clickable
                            const cartIcon = addToCartIcon.querySelector('i');
                            if (cartIcon) {
                                cartIcon.style.display = 'block'; // Make sure icon is visible
                                cartIcon.style.color = 'black';  // Set color to black
                                cartIcon.classList.add('black-icon');  // Ensure 'black-icon' class is added
                                cartIcon.removeEventListener('click', closeGroceryPopup); // Remove any previous event listener
                                cartIcon.addEventListener('click', function() {
                                    populateGroceryList(dayMealData[dayId]);
                                    showGroceryPopup();
                                    selectedId = dayId
                                });
                            }
                            } else {
                                // No meal data exists, disable or hide the cart icon
                                const cartIcon = addToCartIcon.querySelector('i');
                                if (cartIcon) {
                                    cartIcon.style.display = 'none';  // Hide the cart icon
                                    cartIcon.style.color = '';        // Remove the color styling
                                    cartIcon.classList.remove('black-icon');  // Remove the black-icon class
                                    cartIcon.removeEventListener('click', function() {
                                        populateGroceryList(dayMealData[dayId]);
                                        showGroceryPopup();
                                    });  // Ensure event listener is removed
                                }
                        }
                }
            });
        });
    }   

    // Function to extract meal info from the HTML
    function extractMealInfo(mealInfoDiv) {

        const infoText = mealInfoDiv.innerText || mealInfoDiv.textContent;
        const infoLines = infoText.split('\n').map(line => line.trim()).filter(line => line.length > 0);

        const mealInfo = {
            calories: infoLines.find(line => line.includes('kcal')) || '',
            size: infoLines.find(line => line.includes('oz')) || '',       
        };

        return mealInfo;
    }

    // function to show the recipe POP-UP
    function showBox(mealElement) {
        const mealName = mealElement.getAttribute('data-meal-name');
        const mealSubName = mealElement.getAttribute('data-meal-subname');
        const calories = mealElement.getAttribute('data-meal-calories');
        const size = mealElement.getAttribute('data-meal-size');
        const carbs = mealElement.getAttribute('data-meal-carbs');
        const fats = mealElement.getAttribute('data-meal-fats');
        
        document.getElementById('popup-overlay').style.display = 'flex';
        const mealDetail = document.querySelector('.meal-detail');
        
        mealDetail.innerHTML = ""; // Clear existing content
        
        mealDetail.innerHTML = `
            <div class="ingredients">
                <h2>${mealName} ${mealSubName}</h2>
                <strong>ingredients</strong>
                <span>egg</span>
                <span>your choice of veg</span>
            </div>
            <div class="details">
                <div><strong>calories</strong> ${calories} </div>
                <div><strong>protein</strong> ${size} </div>
                <div><strong>Fats</strong> ${fats} </div>
                <div><strong>Carbs</strong> ${carbs} </div>
            </div>
        `;
    }


    // Function to close the popup
    function closePopup() {
            document.getElementById('popup-overlay').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const popupOverlay = document.getElementById('popup-overlay');
        if (popupOverlay) {
            popupOverlay.addEventListener('click', function(event) {
                if (event.target.id === 'popup-overlay') {
                    closePopup();
                }
            });
        }
    });



    // Function to show the grocery popup
    function showGroceryPopup() {
        document.getElementById('grocery-popup-overlay').style.display = 'flex';
        }
        // Function to close the grocery popup
        function closeGroceryPopup() {
            document.getElementById('grocery-popup-overlay').style.display = 'none';
        }
        // Close the grocery popup when clicking outside of it
        document.addEventListener('click', function(event) {
            const overlay = document.getElementById('grocery-popup-overlay');
            if (event.target === overlay) {
                closeGroceryPopup();
            }
    });


    // 2nd Function to show the grocery popup
    function showGroceryPopup2() {
         document.getElementById('grocery-popup-overlay-2').style.display = 'flex';
        }

        function closeGroceryPopup2() {
            document.getElementById('grocery-popup-overlay-2').style.display = 'none';
        }

        // Close the 2nd grocery popup when clicking outside of it
        document.addEventListener('click', function(event) {
            const overlay2 = document.getElementById('grocery-popup-overlay-2');
            if (event.target === overlay2) {
                closeGroceryPopup2();
            }
    });

    const mealListPdfBtn = document.getElementById('mealListPdfBtn');
    mealListPdfBtn.addEventListener('click', function() {
        mealListPDF()
    });


    // function to download meal list as a PDF  
    function mealListPDF() {
        const pdfContent = [];
        const meals = dayMealData[selectedId];

        // Check if the selected day has meals
        if (meals.length === 0) {
            console.log(`No meals found for ${dayMealData}`);
            return; // Exit if no meals for the selected day
        }

        const firstMeal = meals[0];
        const fullDayName = firstMeal.day;
        const formattedDate = firstMeal.date;

        // Add table with day name and date
        pdfContent.push({
            table: {
                widths: ['*', 'auto'],
                body: [
                    [
                        { 
                            text: fullDayName, 
                            style: 'dayHeaderText', 
                            margin: [10, 5, 0, 5] 
                        },
                        { 
                            text: formattedDate || '', 
                            style: 'dateStyle', 
                            alignment: 'right', 
                            margin: [0, 5, 10, 5] 
                        }
                    ]
                ]
            },
            layout: {
                hLineWidth: () => 0,
                vLineWidth: () => 0,
                fillColor: (rowIndex) => (rowIndex === 0 ? '#ece5ff' : null)
            },
            margin: [0, 0, 0, 10] // Add bottom margin
        });

        // Add meal cards for the selected day
        meals.forEach(meal => {
            pdfContent.push(
                { text: meal.label, style: 'mealLabel' },
                { text: `${meal.mealName} ${meal.mealSubName}`, style: 'mealTitle' },
                {
                    table: {
                        widths: ['*', 'auto', '*', 'auto'],
                        body: [
                            [
                                { text: 'Calories', style: 'infoLabel' },
                                { text: `${meal.mealInfo.calories || 'N/A'}`, style: 'infoValue' },
                                { text: 'Carbohydrates', style: 'infoLabel' },
                                { text: `${meal.mealInfo.carbs || 'N/A'}`, style: 'infoValue' }
                            ],
                            [
                                { text: 'Total Fat', style: 'infoLabel' },
                                { text: `${meal.mealInfo.fats || 'N/A'}`, style: 'infoValue' },
                                { text: 'Protein', style: 'infoLabel' },
                                { text: `${meal.mealInfo.size || 'N/A'}`, style: 'infoValue' }
                            ]
                        ]
                    },
                    layout: 'noBorders',
                    margin: [0, 5, 0, 15] // Add space between meals
                }
            );
        });

        // Define PDF styles
        const docDefinition = {
            content: pdfContent,
            styles: {
                dayHeaderText: {
                    fontSize: 16,
                    bold: true,
                    color: '#512DA8'
                },
                dateStyle: {
                    fontSize: 12,
                    bold: true,
                    color: '#512DA8'
                },
                mealLabel: {
                    fontSize: 12,
                    color: '#946cfc',
                    bold: true,
                    margin: [0, 10, 0, 5]
                },
                mealTitle: {
                    fontSize: 14,
                    bold: true,
                    margin: [0, 5, 0, 10]
                },
                infoLabel: {
                    fontSize: 12,
                    bold: true
                },
                infoValue: {
                    fontSize: 12
                }
            }
        };

        // Download the PDF with the specified content for the selected day
        pdfMake.createPdf(docDefinition).download(`meal_plan_${selectedId}.pdf`);
    }


    //2nd function to download grocery list as a PDF 
    function GroceryListPdf(mealDataArray) {
            const groupedMeals = mealDataArray.reduce((acc, meal) => {
                if (!acc[meal.day]) {
                    acc[meal.day] = [];
                }
                acc[meal.day].push(meal);
                return acc;
            }, {});

            const pdfContent = [];

            // Add title at the top of the PDF
            pdfContent.push({
                text: 'Grocery List', // Replace with your desired title
                style: 'titleStyle', 
                margin: [0, 0, 0, 20], // Add bottom margin for spacing below the title
                alignment: 'left' // Center align the title
            });

            for (const [day, meals] of Object.entries(groupedMeals)) {
                const firstMeal = meals[0];
                const fullDayName = firstMeal.day;
                const formattedDate = firstMeal.date; 

            pdfContent.push(
                // Full-width background for day and date
                {
                    table: {
                        widths: ['*', 'auto'], // Full-width table with two columns
                        body: [
                            [
                                { 
                                    text: fullDayName, 
                                    style: 'dayHeaderText', 
                                    margin: [10, 5, 0, 5] 
                                },
                                { 
                                    text:formattedDate, 
                                    style: 'dateStyle', 
                                    margin: [0, 5, 10, 5], 
                                    alignment: 'right' 
                                }
                            ]
                        ]
                    },
                    layout: {
                        // Custom layout to add a background and remove borders
                        hLineWidth: () => 0, 
                        vLineWidth: () => 0, 
                        fillColor: (rowIndex, node, columnIndex) => {
                            return rowIndex === 0 ? '#ece5ff' : null;
                        }
                    },
                    margin: [0, 0, 0, 10]
                }

            );

            meals.forEach(meal => {
                pdfContent.push(
                    { text: meal.label, style: 'mealLabel' },
                    { text: `${meal.mealName} ${meal.mealSubName}`, style: 'mealTitle' },
                    {
                        table: {
                            widths: ['30%', '30%', '30%', '30%'],
                            body: [
                                [
                                    { text: 'Calories', style: 'infoLabel' },
                                    { text: `${meal.mealInfo.calories || 'N/A'}`, style: 'infoValue' },
                                    { text: 'Carbohydrates', style: 'infoLabel' },
                                    { text: `${meal.mealInfo.carbs || 'N/A'}`, style: 'infoValue' }
                                ],
                                [
                                    { text: 'Total Fat', style: 'infoLabel' },
                                    { text: `${meal.mealInfo.fats || 'N/A'}`, style: 'infoValue' },
                                    { text: 'Protein', style: 'infoLabel' },
                                    { text: `${meal.mealInfo.size || 'N/A'}`, style: 'infoValue' }
                                ]
                            ]
                        },
                        layout: 'noBorders'
                    },
                    { text: '\n' }
                );
            });

            pdfContent.push({ text: '\n\n' });
        }


        const docDefinition = {
            content: pdfContent,
            styles: {
                titleStyle:{
                    fontSize: 26,
                    bold: true,
                    color:'#946cfc',
                },
                dayHeader: {
                    margin: [0, 0, 0, 10],
                },
                dayHeaderText: {
                    fontSize: 16,
                    bold: true,
                    color: '#512DA8',
                    margin: [0, 0, 10, 0]
                },
                dateStyle: {
                    fontSize: 12,
                    bold: true,
                    color: '#512DA8'
                },
                mealLabel: {
                    fontSize: 12,
                    color: '#946cfc',
                    bold: true,
                    alignment: 'left',
                },
                mealTitle: {
                    fontSize: 14,
                    bold: true,
                    margin: [0, 5, 0, 10]
                },
                infoLabel: {
                    fontSize: 12,
                    bold: true,
                    margin: [0, 2, 0, 2]
                },
                infoValue: {
                    fontSize: 12,
                    margin: [0, 2, 0, 2]
                }
            }
        };

        pdfMake.createPdf(docDefinition).download('grocery_list_full.pdf');
    }


</script>


<!-- JavaScript to Handle Calendar and Date Update -->
<script>
    $(document).ready(function() {
        // Initialize Flatpickr on the hidden input
        var calendar = flatpickr("#datepicker", {
            dateFormat: "Y-m-d",  // Date format
            onChange: function(selectedDates, dateStr, instance) {
                console.log("Date selected: " + dateStr);
                var userId = "<?php echo $_GET['id']; ?>"; 
                // Redirect to the new URL with the selected date
                window.location.href = "?id=" + userId + "&date=" + dateStr;
            },
            closeOnSelect: true 
        });

        // Toggle calendar popup on calendar icon click
        $("#calendar-icon").click(function() {
            // Use flatpickr's toggle method to show/hide the calendar
            if (calendar.isOpen) {
                console.log("Calendar is now hidden.");
                calendar.close();  // Close the calendar
            } else {
                console.log("Calendar is now visible.");
                calendar.open();  // Open the calendar
            }
        });
    });

</script>


<!-- Script to get meal-types filter data -->
<script>

    function handleMyPlannerCheckboxChange(event) {
        const filter_Meal_Type = document.getElementById('filter-meal-type');
        resetAllOtherFilters()
        // Map checkbox IDs to their respective values or actions
        const checkboxMap = {
            breakfastCheckBox: { index: 1, mealType: 'meal-type', id: '2' },
            dessertCheckBox: { index: 2, mealType: 'meal-type', id: '4' },
            lunchCheckBox: { index: 0, mealType: 'meal-type', id: '9' },
            snacksCheckBox: { index: 3, mealType: 'meal-type', id: '22' },
            flavoringsCheckBox: { index: 4, mealType: 'meal-type', id: '30' },
            beveragesCheckBox: { index: 5, mealType: 'meal-type', id: '31' },
        };

        const checkboxId = event.target.id;
        const checkboxData = checkboxMap[checkboxId];

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            if (checkbox.id !== checkboxId) {
                checkbox.checked = false;  
            }
        });

        if (checkboxData) {
            const checkbox = document.getElementById(checkboxId);
            if (checkbox.checked) {
                filter_Meal_Type.selectedIndex = checkboxData.index;
                plannerFilterMealType(checkboxData.mealType, checkboxData.id);
            } else {
                console.log(`${checkboxId} is unchecked.`);
            }
        }
    }


    function plannerFilterMealType(type, id) {
        $.ajax({
            url: '../functions/recipes/filter-recipes.php',
            method: 'POST',
            dataType: 'json',
            data: { category: type, itemId: id },
            success: function (response) {
                $('#meal-cards').empty();
                displayMealCardRecipe(response.data); 
            },
            error: function (xhr, status, error) {
                console.error('Error filtering meal type:', error);
            }
        });
    }

</script>

<!-- Script to get protein filter data -->
<script>

    function resetAllOtherFilters(exceptFilter) {
        const filters = ['my-planner-filter-protein', 'my-planner-filter-veggie', 'my-planner-filter-fruit'];
        filters.forEach(filter => {
            if (filter !== exceptFilter) {
                document.getElementById(filter).selectedIndex = 0;
            }
        });
    }

    function fetchAndPopulatePlannerFilterProtein() {
        const my_planner_filter_protein = document.getElementById('my-planner-filter-protein');

        $.ajax({
            url: '../functions/recipes/protein/fetch-protein.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    my_planner_filter_protein.innerHTML = '<option value="">By Protein</option>';
                    response.forEach(resp => {
                        my_planner_filter_protein.innerHTML += `
                            <option value="${resp.id}">${resp.name}</option>
                        `;
                    });
                } else {
                    console.error('No proteins found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching proteins:', error);
            }
        });
    }

    function handlePlannerProteinChange(event) {
        resetAllOtherFilters('my-planner-filter-protein')
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        const selectedOption = event.target.selectedOptions[0];
        const proteinId = selectedOption.value;

        if (proteinId) {
            plannerFilterProtein('protein', proteinId);
        } else {
            console.log('No valid protein selected.');
        }
    }

    function plannerFilterProtein(type, id) {
        $.ajax({
            url: '../functions/recipes/filter-recipes.php',
            method: 'POST',
            dataType: 'json',
            data: { category: type, itemId: id },
            success: function (response) {
                $('#meal-cards').empty();
                displayMealCardRecipe(response.data); 
            },
            error: function (xhr, status, error) {
                console.error('Error filtering protein:', error);
            }
        });
    }

    document.getElementById('my-planner-filter-protein').addEventListener('change', handlePlannerProteinChange);
    fetchAndPopulatePlannerFilterProtein();
</script>

<!-- Script to get veggies filter data -->
<script>

    function resetAllOtherFilters(exceptFilter) {
        const filters = ['my-planner-filter-protein', 'my-planner-filter-veggie', 'my-planner-filter-fruit'];
        filters.forEach(filter => {
            if (filter !== exceptFilter) {
                document.getElementById(filter).selectedIndex = 0;
            }
        });
    }

    function fetchAndPopulateMyPlannerFilterVeggie() {
        const my_planner_filter_veggie = document.getElementById('my-planner-filter-veggie');

        $.ajax({
            url: '../functions/recipes/veggie/fetch-veggie.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    my_planner_filter_veggie.innerHTML = '<option >By Veggie</option>';
                    response.forEach(resp => {
                        my_planner_filter_veggie.innerHTML += `
                            <option value="${resp.id}">${resp.name}</option>
                        `;
                    });
                } else {
                    console.error('No veggies found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching veggies:', error);
            }
        });
    }

    function handlePlannerVeggieChange(event) {
        resetAllOtherFilters('my-planner-filter-veggie')
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        const selectedOption = event.target.selectedOptions[0];
        const veggieId = selectedOption.value;

        if (veggieId) {
            myplannerFilterVeggie('veggie', veggieId);
        } else {
            console.log('No valid veggie selected.');
        }
    }

    function myplannerFilterVeggie(type, id) {
        $.ajax({
            url: '../functions/recipes/filter-recipes.php',
            method: 'POST',
            dataType: 'json',
            data: { category: type, itemId: id },
            success: function (response) {
                $('#meal-cards').empty();
                displayMealCardRecipe(response.data); 
            },
            error: function (xhr, status, error) {
                console.error('Error filtering veggie:', error);
            }
        });
    }

    document.getElementById('my-planner-filter-veggie').addEventListener('change', handlePlannerVeggieChange);
    fetchAndPopulateMyPlannerFilterVeggie();
</script>

<!-- Script to get fruit filter data-->
<script>

    function resetAllOtherFilters(exceptFilter) {
        const filters = ['my-planner-filter-protein', 'my-planner-filter-veggie', 'my-planner-filter-fruit'];
        filters.forEach(filter => {
            if (filter !== exceptFilter) {
                document.getElementById(filter).selectedIndex = 0;
            }
        });
    }

    function fetchAndPopulatePLannerFilterFruit() {
        const my_planner_filter_fruit = document.getElementById('my-planner-filter-fruit');

        $.ajax({
            url: '../functions/recipes/fruit/fetch-fruit.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    my_planner_filter_fruit.innerHTML = '<option value="">By Fruit</option>';
                    response.forEach(resp => {
                        my_planner_filter_fruit.innerHTML += `
                            <option value="${resp.id}">${resp.name}</option>
                        `;
                    });
                } else {
                    console.error('No fruits found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching fruits:', error);
            }
        });
    }

    function handlePLannerFruitChange(event) {
        resetAllOtherFilters('my-planner-filter-fruit')
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        const selectedOption = event.target.selectedOptions[0];
        const fruitId = selectedOption.value;

        if (fruitId) {
            plannerFilterFruit('fruit', fruitId);
        } else {
            console.log('No valid fruit selected.');
        }
    }

    function plannerFilterFruit(type, id) {
        $.ajax({
            url: '../functions/recipes/filter-recipes.php',
            method: 'POST',
            dataType: 'json',
            data: { category: type, itemId: id },
            success: function (response) {
                $('#meal-cards').empty();
                displayMealCardRecipe(response.data); 
            },
            error: function (xhr, status, error) {
                console.error('Error filtering fruit:', error);
            }
        });
    }

    document.getElementById('my-planner-filter-fruit').addEventListener('change', handlePLannerFruitChange);
    fetchAndPopulatePLannerFilterFruit();
</script>