<style>
    .recipe-checkboxes input[type="checkbox"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 15px;
        height: 15px;
        border: 2px solid #946CFC;
        border-radius: 3px;
        outline: none;
        cursor: pointer;
        position: relative;
        background-color: transparent;
    }

    .recipe-checkboxes input[type="checkbox"]:checked {
        background-color: transparent;
        border-color: #946CFC;
    }

    .fa-star {
        color: black;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .fa-star.active {
        color: yellow;
    }

    .custom-select {
        border: 1px solid #946CFC;
        border-radius: 4px;
        padding: 8px;
        color: #333;
    }

    .custom-select:focus {
        border-color: #946CFC;
        outline: none;
        box-shadow: none;
    }

    .custom-checkbox {
        position: relative;
        display: flex;
        min-width: 120px;
    }

    .custom-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        border: 2px solid #946CFC;
        border-radius: 4px;
        appearance: none;
        cursor: pointer;
        position: relative;
        margin-right: 8px;
    }

    .custom-checkbox input[type="checkbox"]:checked::before {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: black;
        font-size: 14px;
        font-weight: bold;
    }

    .custom-checkbox input[type="checkbox"]:checked {
        background-color: transparent;
    }

    .custom-checkbox label {
        cursor: pointer;
        color: #333;
    }

    .recipe-img-card {
        width: 100px;
        height: 60px;
    }
</style>

<div class="d-flex justify-content-between align-items-center gap-2">
    <h1 class="text-center">Recipes</h1>
    <button id="resetRecipesFilter" class="btn btn-primary rounded-pill py-2">
        View all
    </button>
</div>

<!-- Dropdowns -->
<div class="my-3">
    <div class="row g-2">
        <div class="col-12 col-sm-6 col-md-4">
            <select id="food-filter-protein" class="custom-select w-100">

            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <select id="food-filter-veggie" class="custom-select w-100">
              
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <select id="food-filter-fruit" class="custom-select w-100">
               
            </select>
        </div>
    </div>
</div>


<!-- Category Checkboxes -->
<div class="d-flex justify-content-between flex-wrap gap-3 recipe-checkboxes">
    <div class="custom-checkbox">
        <input type="checkbox" id="recipeBreakfastCheckBox" onchange="updateMealTypeFilterCheckbox(event)">
        <label for="recipeBreakfastCheckBox">Breakfast</label>
    </div>
    <div class="custom-checkbox">
        <input type="checkbox" id="recipeLunchCheckBox" onchange="updateMealTypeFilterCheckbox(event)">
        <label for="recipeLunchCheckBox">Lunch/Dinner</label>
    </div>
    <div class="custom-checkbox">
        <input type="checkbox" id="recipeSnacksCheckBox" onchange="updateMealTypeFilterCheckbox(event)">
        <label for="recipeSnacksCheckBox">Snacks</label>
    </div>
    <div class="custom-checkbox">
        <input type="checkbox" id="RecipeBeveragesCheckBox" onchange="updateMealTypeFilterCheckbox(event)">
        <label for="RecipeBeveragesCheckBox">Beverages</label>
    </div>
    <div class="custom-checkbox">
        <input type="checkbox" id="recipeFlavoringsCheckBox" onchange="updateMealTypeFilterCheckbox(event)">
        <label for="recipeFlavoringsCheckBox">Flavorings</label>
    </div>
    <div class="custom-checkbox">
        <input type="checkbox" id="recipeDessertCheckBox" onchange="updateMealTypeFilterCheckbox(event)">
        <label for="recipeDessertCheckBox">Dessert</label>
    </div>
</div>



<!-- Recipe Cards -->
<div class="d-flex flex-wrap mt-3 gap-2" id="recipe-card-container">
   <!-- Dynamically Recipe will be populate Here -->
    
</div>



<?php
    include_once "../database/db_connection.php";

    // Get user ID from the query parameter if it exists and is valid
    $currentUserId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

    $recipeItems = []; // Array to store recipe items
    if ($currentUserId) {
        // Prepare the SQL query to fetch all recipe items
        $query = "SELECT * FROM recipe_items ORDER BY id DESC";
        $statement = mysqli_prepare($mysqli, $query);

        if ($statement) {
            // Execute the prepared statement
            mysqli_stmt_execute($statement);

            // Fetch the results
            $queryResult = mysqli_stmt_get_result($statement);
            $recipeItems = $queryResult ? mysqli_fetch_all($queryResult, MYSQLI_ASSOC) : [];

            // Close the statement
            mysqli_stmt_close($statement);
        }
    }

    // Encode the recipe items array to JSON
    $recipeItemsJson = json_encode($recipeItems);
?>


<script>

    let recipesItems = <?php echo $recipeItemsJson; ?>;
    function renderFilteredMealCards (recipesItems) {

        let recipe_card_container = document.getElementById('recipe-card-container')

        recipesItems.forEach(recipe => {

            const recipe_Image = recipe.image && recipe.image.startsWith('https://www.') 
            ? recipe.image 
            : `../assets/images/recipe_images/uploads/${recipe.image}`;

            const calories = recipe.calories ? Math.round(recipe.calories) : 0;
            const protein = recipe.protein ? Math.round(recipe.protein) : 0;
            const carbs = recipe.carbs ? Math.round(recipe.carbs) : 0;


            const recipe_card = `
            <div class="meal-card-rec">
                <div class="custom-border rounded meal-card-container">
                        <img class="recipe-img-card" src="${recipe_Image}" onerror="this.src='https://propertywiselaunceston.com.au/wp-content/themes/property-wise/images/no-image@2x.png';" alt="${recipe.label}">
                        <div class="meal-name">  ${recipe.label.split(' ').length > 1 ? recipe.label.split(' ').slice(0, 2).join(' <br> ') : recipe.label + '<br><br>'}</div>
                        <div class="meal-name-sub"></div>
                        <div class='meal-info-container'>
                        <div class="meal-info">${calories} kcal<br>${protein} oz</div>
                        <span class="text-end star-margin">
                            <i class="fa fa-star"></i>
                        </span>
                        </div>
                    </div>
            </div>
            `
            recipe_card_container.innerHTML += recipe_card;
        });

    }
    document.addEventListener("DOMContentLoaded", function() {
        renderFilteredMealCards(recipesItems)
    });

    document.getElementById('resetRecipesFilter').addEventListener('click',()=>{
        clearMealCards()
        renderFilteredMealCards(recipesItems)

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });

        const dropdowns = [
            'food-filter-protein',
            'food-filter-veggie',
            'food-filter-fruit',
        ];
        dropdowns.forEach(dropdownId => {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.selectedIndex = 0;
            }
        });

    })
</script>


<!-- Script to handle meal type filters -->
<script>
    function updateMealTypeFilterCheckbox(event) {
        const mealTypeDropdown = document.getElementById('filter-meal-type');
        clearAllOtherFilters();
        const mealTypeCheckboxMap = {
            recipeBreakfastCheckBox: { index: 1, type: 'meal-type', id: '2' },
            recipeDessertCheckBox: { index: 2, type: 'meal-type', id: '4' },
            recipeLunchCheckBox: { index: 0, type: 'meal-type', id: '9' },
            recipeSnacksCheckBox: { index: 3, type: 'meal-type', id: '22' },
            recipeFlavoringsCheckBox: { index: 4, type: 'meal-type', id: '30' },
            RecipeBeveragesCheckBox: { index: 5, type: 'meal-type', id: '31' },
        };

        const currentCheckboxId = event.target.id;
        const selectedMealType = mealTypeCheckboxMap[currentCheckboxId];

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            if (checkbox.id !== currentCheckboxId) {
                checkbox.checked = false;
            }
        });

        if (selectedMealType) {
            const currentCheckbox = document.getElementById(currentCheckboxId);
            if (currentCheckbox.checked) {
                mealTypeDropdown.selectedIndex = selectedMealType.index;
                applyMealTypeFilter(selectedMealType.type, selectedMealType.id);
            } else {
                console.log(`${currentCheckboxId} is unchecked.`);
            }
        }
    }

    function clearMealCards() {
        const recipe_card_container = document.getElementById('recipe-card-container');
        recipe_card_container.innerHTML = '';
    }

    function applyMealTypeFilter(type, id) {
        $.ajax({
            url: '../functions/recipes/filter-recipes.php',
            method: 'POST',
            dataType: 'json',
            data: { category: type, itemId: id },
            success: function (response) {
                clearMealCards()
                renderFilteredMealCards(response.data);
            },
            error: function (xhr, status, error) {
                console.error('Error applying meal type filter:', error);
            }
        });
    }
</script>

<!-- Script to handle protein filter -->
<script>
    function clearAllOtherFilters(excludeFilter) {
        const availableFilters = ['food-filter-protein', 'food-filter-veggie', 'food-filter-fruit'];
        availableFilters.forEach(filter => {
            if (filter !== excludeFilter) {
                document.getElementById(filter).selectedIndex = 0;
            }
        });
    }

    function clearMealCards() {
        const recipe_card_container = document.getElementById('recipe-card-container');
        recipe_card_container.innerHTML = ''; 
    }

    function fetchProteinFilterOptions() {
        const proteinDropdown = document.getElementById('food-filter-protein');

        $.ajax({
            url: '../functions/recipes/protein/fetch-protein.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    proteinDropdown.innerHTML = '<option value="">By Protein</option>';
                    response.forEach(item => {
                        proteinDropdown.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                } else {
                    console.error('No protein options found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching protein options:', error);
            }
        });
    }

    function handleProteinDropdownChange(event) {
        clearAllOtherFilters('food-filter-protein');
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        const selectedOption = event.target.selectedOptions[0];
        const proteinId = selectedOption.value;

        if (proteinId) {
            filterRecipesByProtein('protein', proteinId);
        } else {
            console.log('No valid protein selected.');
        }
    }

    function filterRecipesByProtein(type, id) {
        $.ajax({
            url: '../functions/recipes/filter-recipes.php',
            method: 'POST',
            dataType: 'json',
            data: { category: type, itemId: id },
            success: function (response) {
                clearMealCards()
                renderFilteredMealCards(response.data);
            },
            error: function (xhr, status, error) {
                console.error('Error filtering by protein:', error);
            }
        });
    }

    document.getElementById('food-filter-protein').addEventListener('change', handleProteinDropdownChange);
    fetchProteinFilterOptions();
</script>

<!-- Script to handle veggie filter -->
<script>
    function fetchVeggieFilterOptions() {
        const veggieDropdown = document.getElementById('food-filter-veggie');

        $.ajax({
            url: '../functions/recipes/veggie/fetch-veggie.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    veggieDropdown.innerHTML = '<option value="">By Veggie</option>';
                    response.forEach(item => {
                        veggieDropdown.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                } else {
                    console.error('No veggie options found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching veggie options:', error);
            }
        });
    }

    function clearMealCards() {
        const recipe_card_container = document.getElementById('recipe-card-container');
        recipe_card_container.innerHTML = ''; 
    }

    function handleVeggieDropdownChange(event) {
        clearAllOtherFilters('food-filter-veggie');
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        const selectedOption = event.target.selectedOptions[0];
        const veggieId = selectedOption.value;

        if (veggieId) {
            filterRecipesByVeggie('veggie', veggieId);
        } else {
            console.log('No valid veggie selected.');
        }
    }

    function filterRecipesByVeggie(type, id) {
        $.ajax({
            url: '../functions/recipes/filter-recipes.php',
            method: 'POST',
            dataType: 'json',
            data: { category: type, itemId: id },
            success: function (response) {
                clearMealCards()
                renderFilteredMealCards(response.data);
            },
            error: function (xhr, status, error) {
                console.error('Error filtering by veggie:', error);
            }
        });
    }

    document.getElementById('food-filter-veggie').addEventListener('change', handleVeggieDropdownChange);
    fetchVeggieFilterOptions();
</script>

<!-- Script to handle fruit filter -->
<script>
    function fetchFruitFilterOptions() {
        const fruitDropdown = document.getElementById('food-filter-fruit');

        $.ajax({
            url: '../functions/recipes/fruit/fetch-fruit.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    fruitDropdown.innerHTML = '<option value="">By Fruit</option>';
                    response.forEach(item => {
                        fruitDropdown.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                } else {
                    console.error('No fruit options found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching fruit options:', error);
            }
        });
    }

    function handleFruitDropdownChange(event) {
        clearAllOtherFilters('food-filter-fruit');
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        const selectedOption = event.target.selectedOptions[0];
        const fruitId = selectedOption.value;

        if (fruitId) {
            filterRecipesByFruit('fruit', fruitId);
        } else {
            console.log('No valid fruit selected.');
        }
    }

    function clearMealCards() {
        const recipe_card_container = document.getElementById('recipe-card-container');
        recipe_card_container.innerHTML = ''; 
    }

    function filterRecipesByFruit(type, id) {
        $.ajax({
            url: '../functions/recipes/filter-recipes.php',
            method: 'POST',
            dataType: 'json',
            data: { category: type, itemId: id },
            success: function (response) {
                clearMealCards()
                renderFilteredMealCards(response.data);
            },
            error: function (xhr, status, error) {
                console.error('Error filtering by fruit:', error);
            }
        });
    }

    document.getElementById('food-filter-fruit').addEventListener('change', handleFruitDropdownChange);
    fetchFruitFilterOptions();
</script>
