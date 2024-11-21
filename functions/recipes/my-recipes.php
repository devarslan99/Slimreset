<?php
include_once "../database/db_connection.php";

$user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

$recipes = [];
if ($user_id) {
    $stmt = mysqli_prepare($mysqli, "SELECT * FROM recipe_items WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $recipes = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    mysqli_stmt_close($stmt);
}
$recipes_json = json_encode($recipes);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Recipes</title>
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

        .custom-checkbox-my-recipes {
            position: relative;
            display: flex;
        }

        .custom-checkbox-my-recipes input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border: 2px solid #946CFC;
            border-radius: 4px;
            appearance: none;
            cursor: pointer;
            position: relative;
            margin-right: 8px;
        }

        .custom-checkbox-my-recipes input[type="checkbox"]:checked::before {
            content: '✓';
            position: absolute;
            top: 56%;
            left: 45%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 16px;
            font-weight: bold;
        }

        .custom-checkbox-my-recipes input[type="checkbox"]:checked {
            background-color: transparent;
        }

        .custom-checkbox-my-recipes label {
            cursor: pointer;
            color: #333;
        }

        .my-recipe-img-card {
            width: 200px;
            height: 180px;
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <div class="">
            <h2 class="text-center flex-grow-1 mb-0">My Recipes</h2>
            <div class="d-flex justify-content-between align-items-center my-4">
                <div class="custom-checkbox-my-recipes d-flex align-items-center">
                    <input type="checkbox" id="lunch">
                    <label for="lunch" class="mb-0">Lunch/Dinner</label>
                </div>
                <button class="btn btn-primary rounded-pill py-2" onclick="openRecipeModal('recipeModal')" style="background-color: #946CFC; border: none;">
                    Add Recipe
                </button>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-3 filter-select">
                <label class="form-label">Meal Type</label>
                <select class="form-select">
                    <option>Select Meal Type</option>
                </select>
            </div>
            <div class="col-md-3 filter-select">
                <label class="form-label">Food Group</label>
                <select class="form-select">
                    <option>Select Food Group</option>
                </select>
            </div>
            <div class="col-md-2 filter-select">
                <label class="form-label">Ingredient</label>
                <select class="form-select">
                    <option>By Protein</option>
                </select>
            </div>
            <div class="col-md-2 filter-select">
                <label class="form-label">&nbsp;</label>
                <select class="form-select">
                    <option>By Veggie</option>
                </select>
            </div>
            <div class="col-md-2 filter-select">
                <label class="form-label">&nbsp;</label>
                <select class="form-select">
                    <option>By Fruit</option>
                </select>
            </div>
        </div>

        <!-- Recipe Card -->
        <div class="row">
            <div class="d-flex flex-wrap mt-3 gap-3">
                <!-- Recipes will be dynamically injected here -->
            </div>
        </div>
    </div>

    <!--Recipe Modal -->
    <div class="modal fade" id="recipeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Recipe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="recipeSearch" class="form-control" placeholder="Search for recipes..." oninput="fetchRecipeData()">
                    <!-- Display search results -->
                    <ul class="list-group mt-3" id="searchResultsForRecipe"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT TO SEARCH AND ADD RECIPE -->
    <script>
        // Open modal with selected food type
        function openRecipeModal(foodOption) {
            document.getElementById('recipeSearch').value = '';
            document.getElementById('searchResultsForRecipe').innerHTML = '';
            var modal = new bootstrap.Modal(document.getElementById('recipeModal'));
            modal.show();
        }

        // Fetch food data from Edamam API
        function fetchRecipeData() {
            const query = document.getElementById('recipeSearch').value;
            console.log("Recipe function called!")
            if (query.length < 3) return; // Avoid too many requests for short queries

            fetch(`https://api.edamam.com/api/food-database/v2/parser?app_id=f73b06f6&app_key=562df73d9c2324199c25a9b8088540ba&ingr=${query}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const searchResultsForRecipe = document.getElementById('searchResultsForRecipe');
                    searchResultsForRecipe.innerHTML = ''; // Clear previous results

                    // Edamam stores food items in the 'parsed' and 'hints' arrays
                    const foodItems = [...data.parsed, ...data.hints.map(hint => hint.food)];
                    const validFoodItems = foodItems.filter(item => item.nutrients && Object.keys(item.nutrients).length > 0);
                    validFoodItems.forEach(item => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item');
                        li.innerHTML = item.label || `${item.food.label}`;
                        li.onclick = () => selectRecipeItem(item, li); // Pass the selected item and the li element
                        searchResultsForRecipe.appendChild(li);
                    });
                })
                .catch(error => console.error('Error fetching food data:', error));
        }

        // Select food item and display its details directly beneath the clicked item
        function selectRecipeItem(food, listItem) {
            // Remove any existing expanded sections
            const existingExpandedRow = document.querySelector('.expanded-row');
            if (existingExpandedRow) existingExpandedRow.remove();

            // Create the expanded row to show details
            const expandedRow = document.createElement('div');
            expandedRow.classList.add('expanded-row');

            // Add content to expanded row
            expandedRow.innerHTML = `
                    <h6 class="mt-3">${food.label}</h6>
                    <p class="mt-2">Enter amount:</p>
                    <input type="number" id="foodAmount" class="form-control mb-2" value="1" placeholder="Amount" onchange="updateNutritionValuesForRecipe()">

                    <!-- Dropdown for weighing unit -->
                    <select id="weighingUnit" class="form-control mb-2" onchange="updateNutritionValuesForRecipe()">
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

                    <!-- Button to add recipe to the database -->
                    <button type="button" class="btn btn-success my-3" onclick="addRecipeToDatabase('${food.foodId}', '${food.label}', '${food.image || ''}')">Add Recipe</button>
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
            populateWeighingUnitsForRecipe(food);
        }

        // Populate weighing units dynamically
        function populateWeighingUnitsForRecipe(food) {
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
        function updateNutritionValuesForRecipe() {
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
        function addRecipeToDatabase(foodId, label, imageUrl) {
            var modal = bootstrap.Modal.getInstance(document.getElementById('recipeModal'));
            const foodData = {
                foodId: foodId,
                label: label,
                image: imageUrl,
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
                user_id: <?php echo $user_id ?>
            };

            // Send food data to the server (you'll need to define the actual endpoint)
            fetch('../functions/food_history/recipe-store.php', {
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

    <!-- Script to display the recipes on the page -->
    <script>
        const recipes = <?php echo $recipes_json; ?>;

        function displayRecipes(recipes) {
            const recipeContainer = document.querySelector(".d-flex.flex-wrap.mt-3.gap-3");
            recipeContainer.innerHTML = "";

            recipes.forEach(recipe => {
                const card = document.createElement("div");
                card.classList.add("meal-card-rec");
                const recipeImage = recipe.image ? recipe.image : 'https://via.placeholder.com/150'

                card.innerHTML = `
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="${recipeImage}" alt="${recipe.label}">
                        <div class="meal-name">${recipe.label}</div>
                        <div class="meal-info">
                            ${recipe.calories} kcal<br>
                            ${recipe.amount} ${recipe.unit}
                        </div>
                    </div>
                    `;
                recipeContainer.appendChild(card);
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            displayRecipes(recipes);
        });
    </script>

</body>

</html>