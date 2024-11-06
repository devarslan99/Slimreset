<?php
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));
?>

<style>
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

    .day-column {
        position: relative;
        border-left: 4px solid #ddd;
        padding-left: 20px;
        margin-right: -2px;
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

    .meal-card,
    .empty-card {
        border: none;
        border-top: 4px solid #ddd;
        padding: 10px;
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
        width: 94px;
        height: 145px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .meal-card img {
        width: 100%;
        border-radius: 5px;
        height: 50px;
        object-fit:cover;
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
                    <i class="fa fa-calendar me-2 fw-bold fs-4"></i>
                    <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $prev_date; ?>">
                        <i class="fa fa-angle-left fw-bold fs-4"></i>
                    </a>
                    <h3 class="text-center mx-2 d-inline main-color">
                        <?php echo date('M d, Y', strtotime($selected_date)); ?>
                    </h3>
                    <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
                    <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $next_date; ?>">
                        <i class="fa fa-angle-right fw-bold fs-4"></i>
                    </a>
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

<script>
    $(document).ready(function() {
        // Dummy details of meals for the right side (meal cards)
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

        // Append meal cards to #meal-cards
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
                </div>
            `;
            $('#meal-cards').append(mealCard);
        });

        // Sample data for the left side (days and empty cards)
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

        // Function to create HTML for each day column
        function createDayColumn(dayData, isFirstColumn) {
            return `
                <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                    <div class="text-center">
                        ${isFirstColumn ? '<div class="nutrition-label">nutrition</div>' : ''}
                        <div class="day-header">day ${dayData.day}</div>
                        <div class="date-text">${dayData.date}</div>
                        <div class="cal-info">${dayData.kcal} kcal<br>${dayData.oz}</div>
                        <div><i class="fa fa-shopping-cart text-muted"></i></div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-breakfast">
                        <div class="meal-card">${isFirstColumn ? '<div class="breakfast-label meal-card-title">Breakfast</div>' : ''}
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-lunch">
                        <div class="meal-card">${isFirstColumn ? '<div class="lunch-label meal-card-title">Lunch</div>' : ''}
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-dinner">
                        <div class="meal-card">${isFirstColumn ? '<div class="dinner-label meal-card-title">Dinner</div>' : ''}
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                    <div class="meal-section" id="day${dayData.day}-snack">
                        <div class="meal-card">${isFirstColumn ? '<div class="snack-label meal-card-title">Snack</div>' : ''}
                            <div class="add-more">
                                <div class="plus-sign">+</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Append all day columns to the main container
        daysData.forEach((day, index) => {
            $('#empty-card-slots').append(createDayColumn(day, index === 0));
        });

        // Initialize Sortable after all elements have been created
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
                            <div class="custom-border rounded">
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
</script>