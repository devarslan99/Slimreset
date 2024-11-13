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
        height: 250px;
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
        width: 700px;
        max-width: 90%;
        display: flex;
        flex-direction: column;
        gap: 15px;
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

    /* Grocery List Styles */
    .grocery-list-title {
        font-size: 1.8em;
        font-weight: bold;
        color: #946cfc;
        margin-bottom: 20px;
    }

    /* Two-column Layout */
    .grocery-columns {
        display: flex;
        gap: 20px;
    }

    /* Aisle Section in Each Column */
    .grocery-column {
        flex: 1;
    }

    .grocery-aisle h3 {
        font-weight: bold;
        font-style: italic;
        color: #333;
        margin-bottom: 10px;
    }

    .grocery-aisle ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .grocery-aisle li {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1em;
    }

    .grocery-aisle li span strong {
        font-weight: bold;
    }

    /* PDF Icon */
    .grocery-pdf-icon {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
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

    .date-text {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
    }

    .cal-info {
        color: #000;
        font-size: 0.9rem;
    }

    .col-lg-9 {
        padding-right: 0px;
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
        left: -66px;
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
        left: -55px;
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
        left: -57px;
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
        left: -55px;
        top: 70px;
        transform: rotate(-90deg);
    }

    .custom-border {
        border: 1px solid #946CFC;
    }


    .AddToCart i {
        font-size: 18px;
        cursor: pointer;
    }

    .AddToCart i:hover {
        color: #00BF63;
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
                    <span class="grocery-list rounded-2 d-inline-flex align-items-center fs-6 fw-bold">
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
                <div class="main-color text-center my-3">
                    <i class="fa fa-calendar me-2 fw-bold fs-4" id="calendar-icon" style="cursor: pointer;"></i>
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

                    <!-- Grocery List Content -->
                    <div class="grocery-list-box">
                        <h2 class="grocery-list-title">grocery list</h2>

                        <!-- Columns for Aisles -->
                        <div class="grocery-columns">
                            <!-- Left Column -->
                            <div class="grocery-column">
                                <div class="grocery-aisle">
                                    <h3>vegetable aisle</h3>
                                    <ul>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>eggs, <strong>3</strong></span>
                                        </li>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>chicken breast, <strong>3</strong></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="grocery-aisle">
                                    <h3>vegetable aisle</h3>
                                    <ul>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>eggs, <strong>3</strong></span>
                                        </li>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>chicken breast, <strong>3</strong></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="grocery-column">
                                <div class="grocery-aisle">
                                    <h3>vegetable aisle</h3>
                                    <ul>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>eggs, <strong>3</strong></span>
                                        </li>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>chicken breast, <strong>3</strong></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- PDF Icon -->
                        <div class="grocery-pdf-icon">
                            <i class="fa fa-file-pdf-o" onclick="downloadPDF()"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grocery List Popup Overlay -->
            <div class="grocery-popup-overlay" id="grocery-popup-overlay">
                <div class="grocery-popup-content">
                    <div class="grocery-close-popup" onclick="closeGroceryPopup()">X</div>

                    <!-- Grocery List Content -->
                    <div class="grocery-list-box">
                        <h2 class="grocery-list-title">grocery list</h2>

                        <!-- Columns for Aisles -->
                        <div class="grocery-columns">
                            <!-- Left Column -->
                            <div class="grocery-column">
                                <div class="grocery-aisle">
                                    <h3>vegetable aisle</h3>
                                    <ul>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>eggs, <strong>3</strong></span>
                                        </li>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>chicken breast, <strong>3</strong></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="grocery-aisle">
                                    <h3>vegetable aisle</h3>
                                    <ul>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>eggs, <strong>3</strong></span>
                                        </li>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>chicken breast, <strong>3</strong></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="grocery-column">
                                <div class="grocery-aisle">
                                    <h3>vegetable aisle</h3>
                                    <ul>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>eggs, <strong>3</strong></span>
                                        </li>
                                        <li>
                                            <input type="checkbox" checked>
                                            <span>chicken breast, <strong>3</strong></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- PDF Icon -->
                        <div class="grocery-pdf-icon">
                            <i class="fa fa-file-pdf-o" onclick="downloadPDF()"></i>
                        </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.2/html2pdf.bundle.min.js" integrity="sha512-MpDFIChbcXl2QgipQrt1VcPHMldRILetapBl5MPCA9Y8r7qvlwx1/Mc9hNTzY+kS5kX6PdoDq41ws1HiVNLdZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {
        const mealData = [{
                image: 'https://images.pexels.com/photos/699953/pexels-photo-699953.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                name: 'Veggie',
                subName: 'Omelette',
                calories: '800 kcal',
                size: '8 oz'
            },
            {
                image: 'https://images.pexels.com/photos/10261265/pexels-photo-10261265.jpeg',
                name: 'Chicken',
                subName: 'Salad',
                calories: '650 kcal',
                size: '7 oz'
            },
            {
                image: 'https://images.unsplash.com/photo-1543353071-873f17a7a088',
                name: 'Beef',
                subName: 'Burger',
                calories: '900 kcal',
                size: '9 oz'
            },
            {
                image: 'https://images.unsplash.com/photo-1495195129352-aeb325a55b65',
                name: 'Fruit',
                subName: 'Smoothie',
                calories: '250 kcal',
                size: '12 oz'
            },
            {
                image: 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd',
                name: 'Pasta',
                subName: 'Primavera',
                calories: '700 kcal',
                size: '10 oz'
            },
            {
                image: 'https://images.unsplash.com/photo-1490645935967-10de6ba17061',
                name: 'Greek',
                subName: 'Yogurt',
                calories: '200 kcal',
                size: '5 oz'
            },
            {
                image: 'https://images.unsplash.com/photo-1525351484163-7529414344d8',
                name: 'Steak',
                subName: 'Frites',
                calories: '1200 kcal',
                size: '14 oz'
            },
            {
                image: 'https://images.pexels.com/photos/4050291/pexels-photo-4050291.jpeg',
                name: 'Avocado',
                subName: 'Toast',
                calories: '300 kcal',
                size: '6 oz'
            },
            {
                image: 'https://images.pexels.com/photos/4413724/pexels-photo-4413724.jpeg',
                name: 'Tomato',
                subName: 'Soup',
                calories: '150 kcal',
                size: '8 oz'
            }
        ];
        
        $.each(mealData, function(index, meal) {
            const mealCard = `
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="recipe-img-card" src="${meal.image}" alt="${meal.name} ${meal.subName}">
                        <div class="meal-name">${meal.name}</div>
                        <div class="meal-name-sub">${meal.subName}</div>
                        <div class="meal-info">${meal.calories}<br>${meal.size}</div>
                        <span class="text-end star-margin">
                            <i class="fa fa-star"></i>
                        </span>
                    </div>
                </div>`;
            $('#meal-cards').append(mealCard);
        });
        
        const daysData = [{
                day: 1,
                date: "Oct 5",
                kcal: 800,
                oz: "10.5 oz"
            },
            {
                day: 2,
                date: "Oct 6",
                kcal: 850,
                oz: "11 oz"
            },
            {
                day: 3,
                date: "Oct 7",
                kcal: 780,
                oz: "9 oz"
            },
            {
                day: 4,
                date: "Oct 8",
                kcal: 790,
                oz: "10 oz"
            },
            {
                day: 5,
                date: "Oct 9",
                kcal: 820,
                oz: "10.8 oz"
            },
            {
                day: 6,
                date: "Oct 10",
                kcal: 750,
                oz: "9.5 oz"
            },
            {
                day: 7,
                date: "Oct 11",
                kcal: 830,
                oz: "11 oz"
            }
        ];

        function createDayColumn(dayData) {
            return `
                <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                    <div class="text-center">
                        <div class="day-header">day ${dayData.day}</div>
                        <div class="date-text">${dayData.date}</div>
                        <div class="cal-info">${dayData.kcal} kcal<br>${dayData.oz}</div>
                        <div class="AddToCart" onclick="showGroceryPopup()"><i class="fa fa-shopping-cart"></i></div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-breakfast">
                        <div class="meal-card">
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-lunch">
                        <div class="meal-card">
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-dinner">
                        <div class="meal-card">
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-snack">
                        <div class="meal-card">
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function updateLabels() {
            $('.nutrition-label, .breakfast-label, .lunch-label, .dinner-label, .snack-label').remove();

            let previousOffsetTop = null;

            $('.day-column').each(function() {
                const currentOffsetTop = $(this).offset().top;
                if (currentOffsetTop !== previousOffsetTop) {
                    addLabels($(this));
                }
                previousOffsetTop = currentOffsetTop;
            });
        }

        function addLabels($dayColumn) {
            $dayColumn.find('.text-center').prepend('<div class="nutrition-label">nutrition</div>');

            $dayColumn.find('#day' + $dayColumn.find('.day-header').text().split(" ")[1] + '-breakfast .meal-card').prepend('<div class="breakfast-label meal-card-title">Breakfast</div>');
            $dayColumn.find('#day' + $dayColumn.find('.day-header').text().split(" ")[1] + '-lunch .meal-card').prepend('<div class="lunch-label meal-card-title">Lunch</div>');
            $dayColumn.find('#day' + $dayColumn.find('.day-header').text().split(" ")[1] + '-dinner .meal-card').prepend('<div class="dinner-label meal-card-title">Dinner</div>');
            $dayColumn.find('#day' + $dayColumn.find('.day-header').text().split(" ")[1] + '-snack .meal-card').prepend('<div class="snack-label meal-card-title">Snack</div>');
        }

        daysData.forEach((day) => {
            $('#empty-card-slots').append(createDayColumn(day));
        });

        updateLabels();

        $(window).on('resize', function() {
            updateLabels();
        });
        
        initializeSortable();
    });

    function initializeSortable() {
        // Make the meal cards (right side, recipes) draggable
        Sortable.create(document.getElementById('meal-cards'), {
            group: {
                name: 'shared',
                pull: 'clone', // Allows items to be dragged out of this list
                put: false // Prevents items from being dropped back here
            },
            animation: 150,
            sort: false // Prevent sorting within the right side container
        });

        // Make each meal section (left side, empty slots) a drop target only
        const mealSections = document.querySelectorAll('.meal-section');
        mealSections.forEach(section => {
            Sortable.create(section, {
                group: {
                    name: 'shared',
                    pull: false, // Prevents these items from being dragged out
                    put: true // Allows items to be dropped in
                },
                animation: 150,
                sort: false, // Prevent sorting within the meal sections
                onAdd: function(evt) {
                    // Get the data from the dragged element
                    const draggedItem = evt.item;
                    const imageSrc = draggedItem.querySelector('img').src;
                    const mealName = draggedItem.querySelector('.meal-name').textContent;
                    const mealSubName = draggedItem.querySelector('.meal-name-sub') ? draggedItem.querySelector('.meal-name-sub').textContent : '';
                    const mealInfo = draggedItem.querySelector('.meal-info').innerHTML;

                    // Find the existing empty .meal-card in the target section
                    const targetMealCard = evt.to.querySelector('.meal-card');

                    if (targetMealCard) {
                        // Keep the existing label in the meal card
                        const existingLabel = targetMealCard.querySelector('.meal-card-title');

                        // Populate the .meal-card with structured content, retaining the label
                        targetMealCard.innerHTML = `
                            ${existingLabel ? existingLabel.outerHTML : ''} <!-- Keep existing label -->
                            <div class="custom-border rounded meal-box">
                                <img src="${imageSrc}" alt="${mealName}">
                                <div class="meal-name">${mealName}</div>
                                <div class="meal-name-sub">${mealSubName}</div>
                                <div class="meal-info">${mealInfo}</div>
                            </div>
                        `;
                    }

                    // Remove the dragged item from its original location to keep single instance
                    draggedItem.remove();
                }
            });
        });
    }

    // function to show the recipe POP-UP
    function showPopup() {
        document.getElementById('popup-overlay').style.display = 'flex';
    }

    // Function to close the popup
    function closePopup() {
        document.getElementById('popup-overlay').style.display = 'none';
    }

    // Event listener for meal-box click
    $(document).on('click', '.meal-box', function(event) {
        showPopup();
        event.stopPropagation(); // Prevents triggering from any other part
    });

    // Close the popup when clicking outside of it
    $(document).on('click', '#popup-overlay', function(event) {
        if (event.target.id === 'popup-overlay') {
            closePopup();
        }
    });


    // Function to show the grocery popup
    function showGroceryPopup(e) {
        document.getElementById('grocery-popup-overlay').style.display = 'flex';
        console.log(e)
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


    // function to download grocery list as a PDF 
    function downloadPDF() {
        // Select the HTML element to be converted to PDF
        const element = document.querySelector('.grocery-list-box');

        // Set up options for html2pdf
        const options = {
            margin: 1,
            filename: 'grocery_list.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        // Convert to PDF
        html2pdf().set(options).from(element).save();
    }


    // calender date picker
    $(document).ready(function() {
        // Initialize Flatpickr
        flatpickr("#datepicker", {
            dateFormat: "Y-m-d", // Set the date format to YYYY-MM-DD
            onChange: function(selectedDates, dateStr, instance) {
                // When a date is selected, update the URL with the selected date
                var userId = "<?php echo $_GET['id']; ?>"; // Get the user ID from the URL
                window.location.href = "?id=" + userId + "&date=" + dateStr; // Redirect to the new URL with the selected date
            }
        });

        // Event listener for meal-box click
        $(document).on('click', '.meal-box', function(event) {
            showPopup();
            event.stopPropagation(); // Prevents triggering from any other part
        });

        // Close the popup when clicking outside of it
        $(document).on('click', '#popup-overlay', function(event) {
            if (event.target.id === 'popup-overlay') {
                closePopup();
            }
        });


        // Function to show the grocery popup
        function showGroceryPopup(e) {
            document.getElementById('grocery-popup-overlay').style.display = 'flex';
            console.log(e)
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


        // function to download grocery list as a PDF 
        function downloadPDF() {
            // Select the HTML element to be converted to PDF
            const element = document.querySelector('.grocery-list-box');

            // Set up options for html2pdf
            const options = {
                margin: 1,
                filename: 'grocery_list.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            // Convert to PDF
            html2pdf().set(options).from(element).save();
        }


        // calender date picker
        $(document).ready(function() {
            // Initialize Flatpickr
            flatpickr("#datepicker", {
                dateFormat: "Y-m-d", // Set the date format to YYYY-MM-DD
                onChange: function(selectedDates, dateStr, instance) {
                    // When a date is selected, update the URL with the selected date
                    var userId = "<?php echo $_GET['id']; ?>"; // Get the user ID from the URL
                    window.location.href = "?id=" + userId + "&date=" + dateStr; // Redirect to the new URL with the selected date
                }
            });

            // Toggle calendar popup on calendar icon click
            $("#calendar-icon").click(function() {
                $("#datepicker").toggle(); // Show the hidden datepicker input
                // Open the calendar automatically when the user clicks on the calendar icon
                $("#datepicker").focus(); // Focus to trigger the Flatpickr calendar
            });
        });

        // Toggle calendar popup on calendar icon click
        $("#calendar-icon").click(function() {
            $("#datepicker").toggle(); // Show the hidden datepicker input
            // Open the calendar automatically when the user clicks on the calendar icon
            $("#datepicker").focus(); // Focus to trigger the Flatpickr calendar
        });
    });
</script>