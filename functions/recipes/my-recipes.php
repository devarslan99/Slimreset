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
        .modal-dialog {
            max-width:700px !important;
        }
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

        .my-recipe-img-card-box {
            width: 200px;
        }

        .my-recipe-img-card {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .food-label-name {
            color:rgb(148 108 252) !important;
        }

        .nutrition-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .nutrition-item {
            flex: 1;
            text-align: left;
            width: 100%;
        }

        .nutrition-item label {
            margin-bottom: 0.25rem;
            display: block;
        }

        .nutrition-item input {
            text-align: right;
            width:100%;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .nutrition-grid .d-flex {
                flex-direction: column;
            }

            .nutrition-item {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }

        .choose-img-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .upload-container {
            width: 100%;
            max-width: 300px;
            height: 160px;
            border: 2px dashed #ccc;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: #fafafa;
            transition: background-color 0.2s, border-color 0.2s;
            cursor: pointer;
        }

        .file-name {
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }

        .hidden-input {
            display: none;
        }

        .food-img-box {
            width: 100%;
            height:160px;
            text-align: right;
            border: 2px dashed #ccc;
            border-radius: 15px;
            overflow: hidden;
        }

        .food-img-box img {
            width: 100%;
            height: 100%;
            object-fit:cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 600px) {
            .choose-img-section {
                flex-direction: row;
            }

            .upload-container,
            .food-img-box {
                flex: 1;
            }
        }
        .btn-danger {
            border-radius:50px;
        }

        .remove-imf-btn {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            text-align: center;
            line-height: 25px;
            background: #ed4141;
            color: #fff;
            font-weight: 800;
            border: 2px solid #fff;
        }

        .meal-name {
            white-space: nowrap;          
            overflow: hidden;            
            text-overflow: ellipsis;  
            width: 100%;
            max-width: 300px;  
            padding:0 10px
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
                    <ul class="list-group mt-3 bg-red" id="searchResultsForRecipe"></ul>

                    <div class="recipe-detail-section" id="receipeDetailSection">
                       <!-- dynamically data of selected resipe or food will be display here  -->
                    </div>
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
                    const searchInput = document.getElementById('recipeSearch');
                    const receipeDetailSection = document.getElementById('receipeDetailSection').innerHTML = "";

                    // Edamam stores food items in the 'parsed' and 'hints' arrays
                    const foodItems = [...data.parsed, ...data.hints.map(hint => hint.food)];
                    const validFoodItems = foodItems.filter(item => item.nutrients && Object.keys(item.nutrients).length > 0);
                    validFoodItems.forEach(item => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item');
                        li.innerHTML = item.label || `${item.food.label}`;
                        li.onclick = () =>{
                            selectRecipeItem(item, li)
                            searchResultsForRecipe.innerHTML = '';
                        }; // Pass the selected item and the li element
                        searchResultsForRecipe.appendChild(li);
                    });
                })
                .catch(error => console.error('Error fetching food data:', error));
        }

        
        // Select food item and display its details directly beneath the clicked item
        function selectRecipeItem(food, listItem) {
            const receipeDetailSection = document.getElementById('receipeDetailSection');

            receipeDetailSection.innerHTML = `
                    <div class="food-card p-4 mb-4 border rounded">
                            <!-- Food Label -->
                            <h5 class="food-label-name mb-3 font-weight-bold">${food.label}</h5>
                            
                            <!-- Amount and Unit Row -->
                            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                <div class="col">
                                    <label for="foodAmount" class="font-weight-bold">Amount:</label>
                                    <input type="number" id="foodAmount" class="form-control" value="1" placeholder="Enter Amount" onchange="updateNutritionValuesForRecipe()">
                                </div>
                                <div class="col">
                                    <label for="weighingUnit" class="font-weight-bold">Unit:</label>
                                    <select id="weighingUnit" class="form-control" onchange="updateNutritionValuesForRecipe()">
                                    </select>
                                </div>
                            </div>

                            <!-- Filters Meal Type and Food Group -->
                            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                <div class="col">
                                    <label for="MealType" class="font-weight-bold">Meal Type</label>
                                    <select id="MealType" class="form-control" onchange="updateNutritionValuesForRecipe()">
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="FoodGroup" class="font-weight-bold">Food Group</label>
                                    <select id="FoodGroup" class="form-control" onchange="updateNutritionValuesForRecipe()">
                                    </select>
                                </div>
                            </div>

                            <!-- Ingredients -->
                            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                <div class="flex-fill">
                                    <label for="Protein" class="font-weight-bold">Protien</label>
                                    <select id="Protein" class="form-control" onchange="updateNutritionValuesForRecipe()">
                                    </select>
                                </div>
                                <div class="flex-fill">
                                    <label for="Veggie" class="font-weight-bold">Veggie</label>
                                    <select id="Veggie" class="form-control" onchange="updateNutritionValuesForRecipe()">
                                    </select>
                                </div>
                                <div class="flex-fill">
                                    <label for="Fruit" class="font-weight-bold">Fruit</label>
                                    <select id="Fruit" class="form-control" onchange="updateNutritionValuesForRecipe()">
                                    </select>
                                </div>
                            </div>

                            <!-- Nutritional Info -->
                            <div id="nutritionInfo" class="mt-4">
                                <div class="nutrition-grid">
                                    <div class="d-flex justify-content-between gap-3 mb-3">
                                        <div class="nutrition-item">
                                            <label>Calories</label>
                                            <input type="text" id="calories" class="form-control" value="${food.nutrients.ENERC_KCAL || '0'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                        <div class="nutrition-item">
                                            <label>Total Fat</label>
                                            <input type="text" id="fat" class="form-control" value="${food.nutrients.FAT || '0g'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                        <div class="nutrition-item">
                                            <label>Sat. Fat</label>
                                            <input type="text" id="satFat" class="form-control" value="${food.nutrients.FASAT || '0g'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between gap-3 mb-3">
                                        <div class="nutrition-item">
                                            <label>Cholest.</label>
                                            <input type="text" id="cholesterol" class="form-control" value="${food.nutrients.CHOLE || '0mg'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                        <div class="nutrition-item">
                                            <label>Sodium</label>
                                            <input type="text" id="sodium" class="form-control" value="${food.nutrients.NA || '0mg'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                        <div class="nutrition-item">
                                            <label>Carb.</label>
                                            <input type="text" id="carbs" class="form-control" value="${food.nutrients.CHOCDF || '0g'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between gap-3 mb-3">
                                        <div class="nutrition-item">
                                            <label>Fiber</label>
                                            <input type="text" id="fiber" class="form-control" value="${food.nutrients.FIBTG || '0g'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                        <div class="nutrition-item">
                                            <label>Sugars</label>
                                            <input type="text" id="sugars" class="form-control" value="${food.nutrients.SUGAR || '0g'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                        <div class="nutrition-item">
                                            <label>Protein</label>
                                            <input type="text" id="protein" class="form-control" value="${food.nutrients.PROCNT || '0g'}" onchange="updateNutritionValuesForRecipe()">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="choose-img-section">
                                <div class="upload-container" id="uploadContainer" onclick="chooseFile()">
                                   Upload Image
                                </div>
                                <div class="food-img-box position-relative">
                                    <img id="foodImage" src="${food.image || 'https://propertywiselaunceston.com.au/wp-content/themes/property-wise/images/no-image@2x.png'}" />
                                    <button id="removeImageBtn" class="remove-imf-btn position-absolute" style="top: 5px; right: 5px; display: ${food.image ? 'block' : 'none'};" onclick="removeImage()">X</button> 
                                </div>
                            </div>

                            <!-- Add Recipe Button -->
                            <div class='d-flex justify-content-end'>
                                <button type="button" style="width: 160px;height: 40px;" class="btn btn-success btn-block mt-4" onclick="addRecipeToDatabase('${food.foodId}', '${food.label}', '${food.image || ''}')">Add Recipe</button>
                            </div>
                        </div>
                `;

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
        // function updateNutritionValuesForRecipe() {
        //     const amount = document.getElementById('foodAmount').value || 1;
        //     const unit = document.getElementById('weighingUnit').value;
        //     // const expandedRow = document.querySelector('.expanded-row');

        //     if (!expandedRow) return;

        //     const caloriesPerServing = expandedRow.dataset.caloriesPerServing;
        //     const defaultServingSize = expandedRow.dataset.defaultServingSize;
        //     const defaultWeightGrams = expandedRow.dataset.defaultWeightGrams;

        //     // Conversion factors for other units
        //     const unitToGrams = {
        //         g: 1,
        //         oz: 28.35,
        //         lb: 453.59
        //     };

        //     // Calculate the factor to adjust based on the selected unit and amount
        //     const weightInGrams = unitToGrams[unit] * amount;

        //     // Scaling factor for nutritional values
        //     const scalingFactor = weightInGrams / defaultWeightGrams;

        //     // Dynamically update all nutritional values
        //     document.getElementById('calories').innerText = (caloriesPerServing * scalingFactor).toFixed(2);
        //     document.getElementById('fat').innerText = (expandedRow.dataset.fat * scalingFactor).toFixed(2) + 'g';
        //     document.getElementById('satFat').innerText = (expandedRow.dataset.saturatedFat * scalingFactor).toFixed(2) + 'g';
        //     document.getElementById('cholesterol').innerText = (expandedRow.dataset.cholesterol * scalingFactor).toFixed(2) + 'mg';
        //     document.getElementById('sodium').innerText = (expandedRow.dataset.sodium * scalingFactor).toFixed(2) + 'mg';
        //     document.getElementById('carbs').innerText = (expandedRow.dataset.carbs * scalingFactor).toFixed(2) + 'g';
        //     document.getElementById('fiber').innerText = (expandedRow.dataset.fiber * scalingFactor).toFixed(2) + 'g';
        //     document.getElementById('sugars').innerText = (expandedRow.dataset.sugars * scalingFactor).toFixed(2) + 'g';
        //     document.getElementById('protein').innerText = (expandedRow.dataset.protein * scalingFactor).toFixed(2) + 'g';
        // }

        // Add the selected food to the database
        function addRecipeToDatabase(foodId, label, imageUrl) {
            const foodImage = document.getElementById('foodImage');
            let imageData;

            if (foodImage.dataset.localFile) {
                // If a local file was uploaded, use the base64 data
                imageData = foodImage.src;
            } else {
                // Use the default image (passed from the `food` object)
                imageData = imageUrl || foodImage.src;
            }

            var modal = bootstrap.Modal.getInstance(document.getElementById('recipeModal'));
            const foodData = {
                foodId: foodId,
                label: label,
                image: imageData,
                amount: document.getElementById('foodAmount').value,
                unit: document.getElementById('weighingUnit').value,
                calories: document.getElementById('calories').value,
                totalFat: document.getElementById('fat').value,
                satFat: document.getElementById('satFat').value,
                cholesterol: document.getElementById('cholesterol').value,
                sodium: document.getElementById('sodium').value,
                carbs: document.getElementById('carbs').value,
                fiber: document.getElementById('fiber').value,
                sugars: document.getElementById('sugars').value,
                protein: document.getElementById('protein').value,
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
                    <div class="custom-border rounded my-recipe-img-card-box">
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

        <!-- script for selecting image and removing -->
    <script>         
        function chooseFile() {
            let uploadContainer = document.getElementById('uploadContainer');
            let input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/png, image/jpeg'; // Allow only PNG and JPG files

            input.onchange = () => {
                let file = input.files[0];
                console.log("Selected file:", file); // Debugging line

                if (file) {
                    // Check file size (1MB limit)
                    const maxSize = 1 * 1024 * 1024; // 1MB in bytes
                    console.log("File size:", file.size); // Debugging line
                    
                    // If the file is larger than 1MB, show an error
                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Size Exceeded',
                            text: 'You can only upload files up to 1MB in size.',
                            footer: 'Allowed file types: PNG, JPG (1MB limit)'
                        });
                        return; // Stop further processing if the file is too large
                    }

                    // Check file type (must be PNG or JPG)
                    console.log("File type:", file.type); // Debugging line
                    if (file.type !== 'image/png' && file.type !== 'image/jpeg') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Type',
                            text: 'You can only upload PNG or JPG files.',
                            footer: 'Allowed file types: PNG, JPG (1MB limit)'
                        });
                        return; // Stop further processing if the file type is invalid
                    }

                    // Proceed if the file is valid
                    const reader = new FileReader();

                    // Preview the selected image
                    reader.onload = () => {
                        const imgElement = document.getElementById('foodImage');
                        imgElement.src = reader.result;
                        imgElement.dataset.localFile = 'true'; // Mark the image as locally selected
                        document.getElementById('removeImageBtn').style.display = 'block';
                        uploadContainer.innerHTML = `Selected File <br/> <strong>${file.name}</strong>`;
                    };

                    reader.readAsDataURL(file);
                }
            };

            input.click();
        }


        // Remove the uploaded image and reset the preview
        function removeImage() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to remove this image?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove the uploaded image and reset the preview
                    const foodImage = document.getElementById('foodImage');
                    foodImage.src = 'https://propertywiselaunceston.com.au/wp-content/themes/property-wise/images/no-image@2x.png'; 
                    foodImage.removeAttribute('data-local-file'); 
                    document.getElementById('removeImageBtn').style.display = 'none';
                    uploadContainer.innerHTML = 'No File Selected'

                    // Optional: You can reset the file input or do any other action after removal
                    console.log("Image removed");
                } else {
                    console.log("Image removal canceled");
                }
            });
        }

    </script>

</body>

</html>