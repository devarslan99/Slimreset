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
        height: 50px;
        object-fit: cover;
    }

    .meal-name {
        font-weight: bold;
        color: #333;
        margin-top: 5px;
    }

    .meal-name-sub {
        font-weight: bold;
        color: #333;
    }

    .meal-info {
        font-size: 0.85rem;
        color: #666;
        display: inline;
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
        <h1 class="text-center">Recipes</h1>
        <!-- Dropdowns -->
        <div class="my-3">
            <div class="row g-2">
                <div class="col-12 col-sm-6 col-md-4">
                    <select class="custom-select w-100">
                        <option selected>Select by protein</option>
                        <option>Chicken</option>
                        <option>Turkey</option>
                        <option>Eggs</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <select class="custom-select w-100">
                        <option selected>Select by veggie</option>
                        <option>Asparagus</option>
                        <option>Broccoli</option>
                        <option>Carrot</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <select class="custom-select w-100">
                        <option selected>Select by fruit</option>
                        <option>Apples</option>
                        <option>Bananas</option>
                        <option>Grapes</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Category Checkboxes -->
        <div class="d-flex flex-wrap gap-3 recipe-checkboxes">
            <div class="custom-checkbox">
                <input type="checkbox" id="breakfast">
                <label for="breakfast">Breakfast</label>
            </div>
            <div class="custom-checkbox">
                <input type="checkbox" id="lunch">
                <label for="lunch">Lunch/Dinner</label>
            </div>
            <div class="custom-checkbox">
                <input type="checkbox" id="snacks">
                <label for="snacks">Snacks</label>
            </div>
            <div class="custom-checkbox">
                <input type="checkbox" id="beverages">
                <label for="beverages">Beverages</label>
            </div>
            <div class="custom-checkbox">
                <input type="checkbox" id="flavourings">
                <label for="flavourings">Flavorings</label>
            </div>
            <div class="custom-checkbox">
                <input type="checkbox" id="dessert">
                <label for="dessert">Dessert</label>
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

<script>
    $(document).ready(function() {
        // Dummy details of meals for the right side (meal cards)
        const mealData =  [
            {
                image: 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=300&h=200',
                name: 'Veggie',
                subName: 'Omelette',
                mealInfo: {
                    calories: '800 kcal',
                    fats: '8g',
                    carbs: '15g',
                    size: '8 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/248444/pexels-photo-248444.jpeg?auto=compress&cs=tinysrgb&w=300&h=200',
                name: 'Grilled',
                subName: 'Chicken Salad',
                mealInfo: {
                    calories: '600 kcal',
                    fats: '10g',
                    carbs: '12g',
                    size: '10 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/8541404/pexels-photo-8541404.jpeg?auto=compress&cs=tinysrgb&w=600',
                name: 'Berry',
                subName: 'Bowl',
                mealInfo: {
                    calories: '350 kcal',
                    fats: '5g',
                    carbs: '40g',
                    size: '6 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/70497/pexels-photo-70497.jpeg?auto=compress&cs=tinysrgb&w=300&h=200',
                name: 'Avocado',
                subName: 'Toast',
                mealInfo: {
                    calories: '450 kcal',
                    fats: '12g',
                    carbs: '22g',
                    size: '5 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/29389670/pexels-photo-29389670/free-photo-of-fresh-mixed-salad-in-takeaway-container.jpeg?auto=compress&cs=tinysrgb&w=600',
                name: 'Caesar',
                subName: 'Salad',
                mealInfo: {
                    calories: '400 kcal',
                    fats: '12g',
                    carbs: '14g',
                    size: '8 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/376464/pexels-photo-376464.jpeg?auto=compress&cs=tinysrgb&w=300&h=200',
                name: 'Banana',
                subName: 'Pancakes',
                mealInfo: {
                    calories: '450 kcal',
                    fats: '7g',
                    carbs: '50g',
                    size: '6 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/5642831/pexels-photo-5642831.jpeg?auto=compress&cs=tinysrgb&w=300&h=200',
                name: 'Fruit',
                subName: 'Parfait',
                mealInfo: {
                    calories: '350 kcal',
                    fats: '5g',
                    carbs: '45g',
                    size: '5 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                name: 'Pasta',
                subName: 'Primavera',
                mealInfo: {
                    calories: '550 kcal',
                    fats: '10g',
                    carbs: '60g',
                    size: '9 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/8964280/pexels-photo-8964280.jpeg?auto=compress&cs=tinysrgb&w=600',
                name: 'Grilled',
                subName: 'Salmon',
                mealInfo: {
                    calories: '500 kcal',
                    fats: '15g',
                    carbs: '5g',
                    size: '7 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/29345893/pexels-photo-29345893/free-photo-of-freshly-baked-pizza-with-toppings-on-wooden-board.jpeg?auto=compress&cs=tinysrgb&w=600',
                name: 'Margherita',
                subName: 'Pizza',
                mealInfo: {
                    calories: '750 kcal',
                    fats: '18g',
                    carbs: '80g',
                    size: '10 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/27672709/pexels-photo-27672709/free-photo-of-salad-with-shrimps.jpeg?auto=compress&cs=tinysrgb&w=600',
                name: 'Veggie',
                subName: 'Bowl',
                mealInfo: {
                    calories: '300 kcal',
                    fats: '10g',
                    carbs: '35g',
                    size: '6 oz'
                }
            },
            {
                image: 'https://images.pexels.com/photos/27195708/pexels-photo-27195708/free-photo-of-meal-with-vegetables-on-dark-plate.jpeg?auto=compress&cs=tinysrgb&w=600',
                name: 'Quinoa',
                subName: 'Salad',
                mealInfo: {
                    calories: '400 kcal',
                    fats: '9g',
                    carbs: '30g',
                    size: '8 oz'
                }
            }
        ];
    
        // Append meal cards to #meal-cards
        $.each(mealData, function(index, meal) {
            const mealCard = `
                <div class="meal-card-rec" data-meal-fats="${meal.mealInfo.fats}" data-meal-carbs="${meal.mealInfo.carbs}">
                    <div class="custom-border rounded">
                        <img class="recipe-img-card" src="${meal.image}" alt="${meal.name} ${meal.subName}">
                        <div class="meal-name">${meal.name}</div>
                        <div class="meal-name-sub">${meal.subName}</div>
                        <div class="meal-info">${meal.mealInfo.calories}<br>${meal.mealInfo.size}</div>
                        <span class="text-end star-margin">
                            <i class="fa fa-star"></i>
                        </span>
                    </div>
                </div>
            `;
            $('#meal-cards').append(mealCard);
        });

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

                // function updateLabels() {
                //     $('.nutrition-label, .breakfast-label, .lunch-label, .dinner-label, .snack-label').remove();

                //     let group = 0;
                //     let previousOffsetTop = null;

                //     $('.day-column').each(function() {
                //         const currentOffsetTop = $(this).offset().top;
                //         console.log(currentOffsetTop)
                //         if (currentOffsetTop !== previousOffsetTop || currentOffsetTop <= 0) {
                //             addLabels($(this));
                //         }
                //         previousOffsetTop = currentOffsetTop;
                //     });
                // }

                // function addLabels($dayColumn) {
                //     $dayColumn.find('.text-center').prepend('<div class="nutrition-label">nutrition</div>');

                //     $dayColumn.find('#day' + $dayColumn.find('.day-header').text().split(" ")[1] + '-breakfast .meal-card').prepend('<div class="breakfast-label meal-card-title">Breakfast</div>');
                //     $dayColumn.find('#day' + $dayColumn.find('.day-header').text().split(" ")[1] + '-lunch .meal-card').prepend('<div class="lunch-label meal-card-title">Lunch</div>');
                //     $dayColumn.find('#day' + $dayColumn.find('.day-header').text().split(" ")[1] + '-dinner .meal-card').prepend('<div class="dinner-label meal-card-title">Dinner</div>');
                //     $dayColumn.find('#day' + $dayColumn.find('.day-header').text().split(" ")[1] + '-snack .meal-card').prepend('<div class="snack-label meal-card-title">Snack</div>');
                // }

                // // updateLabels();
                // $(window).on('load resize', function () {
                //     setTimeout(() => {
                //         updateLabels(); 
                //     },); 
                // });
                




                // function updateLabels() {
                //     // Clear all labels first
                //     $('.nutrition-label, .breakfast-label, .lunch-label, .dinner-label, .snack-label').remove();

                //     // Use a more robust way to detect columns in a row
                //     let columnsInRow = []; 

                //     $('.day-column').each(function () {
                //         const $dayColumn = $(this);
                        
                //         // Collect columns in the same row
                //         const currentRowTop = $dayColumn.offset().top; 
                //         console.log(currentRowTop)
                //         if (!columnsInRow[currentRowTop]) columnsInRow[currentRowTop] = [];
                //         columnsInRow[currentRowTop].push($dayColumn);
                //     });

                //     // Now add labels to the first column in each row (leftmost column)
                //     Object.keys(columnsInRow).forEach((rowTop) => {
                //         const rowColumns = columnsInRow[rowTop];
                //         const $firstColumn = rowColumns[0]; 

                //         // Call the function to add labels to this first column
                //         addLabels($firstColumn);
                //     });
                // }

                // function addLabels($dayColumn) {
                //     const dayNumber = $dayColumn.find('.day-header').text().split(" ")[1]; // Get the day number
                //     if (!dayNumber) return; // Skip if no valid day number found

                //     // Add labels to the first column in each row
                //     $dayColumn.find('.text-center').prepend('<div class="nutrition-label">nutrition</div>');
                //     $dayColumn.find(`#day${dayNumber}-breakfast .meal-card`).prepend('<div class="breakfast-label meal-card-title">Breakfast</div>');
                //     $dayColumn.find(`#day${dayNumber}-lunch .meal-card`).prepend('<div class="lunch-label meal-card-title">Lunch</div>');
                //     $dayColumn.find(`#day${dayNumber}-dinner .meal-card`).prepend('<div class="dinner-label meal-card-title">Dinner</div>');
                //     $dayColumn.find(`#day${dayNumber}-snack .meal-card`).prepend('<div class="snack-label meal-card-title">Snack</div>');
                // }

                // // Trigger updateLabels on window load and resize events
                // $(window).on('load resize', function () {
                //     setTimeout(() => {
                //         updateLabels();
                //     }, ); 
                // });

                function updateLabels() {
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

        // Detect columns moved down (on small screens), i.e., if offsetTop is the same (or close) and move the labels accordingly
        rowColumns.forEach(($dayColumn) => {
            const currentOffsetTop = $dayColumn.offset().top;
            console.log(currentOffsetTop)
            // Only add labels to columns that are moved down due to smaller screen size
            // Ensure that we're adding labels only if the column is actually at the bottom of the screen
            if (currentOffsetTop === 0) {
                addLabels($dayColumn);  // Add labels to this column if it's down
            }
        });

        // Otherwise, add labels to the first column in each row (leftmost column)
        const $firstColumn = rowColumns[0]; 
        addLabels($firstColumn);
    });
}

function addLabels($dayColumn) {
    const dayNumber = $dayColumn.find('.day-header').text().split(" ")[1]; // Get the day number
    if (!dayNumber) return; // Skip if no valid day number found

    // Add labels to the column
    $dayColumn.find('.text-center').prepend('<div class="nutrition-label">nutrition</div>');
    $dayColumn.find(`#day${dayNumber}-breakfast .meal-card`).prepend('<div class="breakfast-label meal-card-title">Breakfast</div>');
    $dayColumn.find(`#day${dayNumber}-lunch .meal-card`).prepend('<div class="lunch-label meal-card-title">Lunch</div>');
    $dayColumn.find(`#day${dayNumber}-dinner .meal-card`).prepend('<div class="dinner-label meal-card-title">Dinner</div>');
    $dayColumn.find(`#day${dayNumber}-snack .meal-card`).prepend('<div class="snack-label meal-card-title">Snack</div>');
}

// Trigger updateLabels on window load and resize events
$(window).on('load resize', function () {
    setTimeout(() => {
        updateLabels();
    }, 100); // Small delay to allow layout adjustments
});
$('.nav-link').on('shown.bs.tab', function (e) {
    setTimeout(() => {
        updateLabels(); // Update labels when the tab is shown
    }, 200); // Wait a bit to ensure tab content is visible
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
                                data-meal-subname="${mealSubName}" 
                                data-meal-calories="${mealInfo.calories}" 
                                data-meal-size="${mealInfo.size}" 
                                data-meal-carbs="${mealCarbs}" 
                                data-meal-fats="${mealFats}" 
                                onclick="showBox(this)" data-id="${mealId}">
                                <img src="${imageSrc}" alt="${mealName}">
                                <div class="meal-name">${mealName}</div>
                                <div class="meal-name-sub">${mealSubName}</div>
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
                                            const mealIndex = dayMealData[dayId].findIndex(meal => meal.mealId === mealId);  // Use mealId to find the correct meal

                                            // If the meal is found, remove it
                                            if (mealIndex !== -1) {
                                                dayMealData[dayId].splice(mealIndex, 1); // Remove the meal from the array
                                                console.log(`Meal removed: ${mealId} from ${dayId}`);
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
                        imageSrc,
                        mealName,
                        mealSubName,
                        mealInfo: {
                            calories: mealInfo.calories,
                            size: mealInfo.size,
                            carbs: mealCarbs,
                            fats: mealFats
                        },
                        label: sectionLabel,
                        date,
                        day
                    };
                    mealDataArray.push(mealData);
                    populateAllGroceryList(mealDataArray);

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