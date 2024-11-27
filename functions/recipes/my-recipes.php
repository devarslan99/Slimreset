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
            font-weight:600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
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
            border-radius: 50px;
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

        .filter-seclect-input {
            overflow-y: auto;
            max-height: 200px;
        }

        .filter-seclect-input::-webkit-scrollbar {
            width: 8px;
        }

        .filter-seclect-input::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .filter-seclect-input::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .filter-seclect-input::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .filter-seclect-input {
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }
        
        .text-required {
            font-style: italic;
            text-transform: capitalize !important;
        }

        .required-star {
            color:red;
        }

        @media (max-width: 768px) {
            .food-label-name,
            .text-required {
                flex-basis: 100%; /* Make each heading take full width on small screens */
                max-width: 100%;
            }
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
                <select class="form-select" id="filter-meal-type">
                    <option>Select Meal Type</option>
                </select>
            </div>
            <div class="col-md-3 filter-select">
                <label class="form-label">Food Group</label>
                <select class="form-select" id="filter-food-group">
                    <option>Select Food Group</option>
                </select>
            </div>
            <div class="col-md-2 filter-select">
                <label class="form-label">Ingredient</label>
                <select class="form-select" id="filter-protein">
                    <option>By Protein</option>
                </select>
            </div>
            <div class="col-md-2 filter-select">
                <label class="form-label">&nbsp;</label>
                <select class="form-select" id="filter-veggie">
                    <option>By Veggie</option>
                </select>
            </div>
            <div class="col-md-2 filter-select">
                <label class="form-label">&nbsp;</label>
                <select class="form-select" id="filter-fruit">
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

    <!-- Script to get meal-types filter data -->
    <script>
        function fetchAndPopulateFilterMealTypes() {
            const filter_MealType = document.getElementById('filter-meal-type');

            $.ajax({
                url: '../functions/recipes/meal-type/fetch-meal-type.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            filter_MealType.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No meal types found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching meal types:', error);
                }
            });
        }
        fetchAndPopulateFilterMealTypes()
    </script>

    <!-- Script to get food-groups filter data -->
    <script>
       function fetchAndPopulateFilterFoodGroup() {
        const filter_food_group = document.getElementById('filter-food-group');

            $.ajax({
                url: '../functions/recipes/food-group/fetch-food-group.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            filter_food_group.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No food group found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching food groups:', error);
                },

            });
        }
        fetchAndPopulateFilterFoodGroup()
    </script>

    <!-- Script to get veggies filter data -->
    <script>
         function fetchAndPopulateFilterVeggie() {
            const filter_veggie = document.getElementById('filter-veggie');

            $.ajax({
                url: '../functions/recipes/veggie/fetch-veggie.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            filter_veggie.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No veggie found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching veggies:', error);
                },

            });
        }
        fetchAndPopulateFilterVeggie()
    </script>

     <!-- Script to get protein filter data -->
     <script>
         function fetchAndPopulateFilterProtein() {
            const filter_protein = document.getElementById('filter-protein');

            $.ajax({
                url: '../functions/recipes/protein/fetch-protein.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            filter_protein.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No protein found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching proteins:', error);
                },

            })
        }
        fetchAndPopulateFilterProtein() 
    </script>

     <!-- Script to get fruit filter data-->
     <script>
       function fetchAndPopulateFilterFruit() {
        const filter_fruit = document.getElementById('filter-fruit');

            $.ajax({
                url: '../functions/recipes/fruit/fetch-fruit.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            filter_fruit.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No fruit found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching fruits:', error);
                },

            })
        }
        fetchAndPopulateFilterFruit()
    </script>

    <!-- Populating and fetching data for add recipe filters  -->

    <!-- Script to get meal-types -->
    <script>
        function fetchAndPopulateMealTypes() {
            const MealType = document.getElementById('MealType');

            $.ajax({
                url: '../functions/recipes/meal-type/fetch-meal-type.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            MealType.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No meal types found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching meal types:', error);
                }
            });
        }
    </script>

    <!-- Script to get food-groups -->
    <script>
       function fetchAndPopulateFoodGroup() {
        const FoodGroup = document.getElementById('FoodGroup');

            $.ajax({
                url: '../functions/recipes/food-group/fetch-food-group.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            FoodGroup.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No food group found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching food groups:', error);
                },

            });
        }
    </script>

    <!-- Script to get veggies -->
    <script>
         function fetchAndPopulateVeggie() {
            const Veggie = document.getElementById('Veggie');

            $.ajax({
                url: '../functions/recipes/veggie/fetch-veggie.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            Veggie.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No veggie found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching veggies:', error);
                },

            });
        }
    </script>

     <!-- Script to get protein -->
     <script>
         function fetchAndPopulateProtein() {
            const Protein = document.getElementById('Protein');

            $.ajax({
                url: '../functions/recipes/protein/fetch-protein.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            Protein.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No protein found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching proteins:', error);
                },

            })
        }
    </script>

     <!-- Script to get fruit -->
     <script>
       function fetchAndPopulateFruit() {
        const Fruit = document.getElementById('Fruit');

            $.ajax({
                url: '../functions/recipes/fruit/fetch-fruit.php',
                method: 'GET',
                dataType: "json",
                success: function(response) {
                    if (response.length > 0) {
                        response.forEach(resp => {
                            Fruit.innerHTML += `
                                <option value="${resp.id}">${resp.name}</option>
                            `;
                        });
                    } else {
                        console.error('No fruit found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching fruits:', error);
                },

            })
        }
    </script>

    <!-- script for selecting image and removing -->
    <script>         

        let selectedFile = null; 
        let uniqueName = '';

        // preview the uploaded image 
        function chooseFile() {
            let input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/png, image/jpeg, image/jpg, image/webp';

            // Handle file selection and preview
            input.onchange = () => {
                let file = input.files[0];

                if (file) {
                    // Check file size (5MB limit)
                    const maxSize = 5 * 1024 * 1024;

                    if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Size Exceeded',
                            text: 'You can only upload files up to 5MB in size.',
                            footer: 'Allowed file types: PNG, JPG (5MB limit)'
                        });
                        return; 
                    }

                    // Check file type (must be PNG, JPG, or WEBP)
                    if (!['image/png', 'image/jpeg', 'image/jpg', 'image/webp'].includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Type',
                            text: 'You can only upload PNG, JPG, or WEBP files.',
                            footer: 'Allowed file types: PNG, JPG, WEBP (5MB limit)'
                        });
                        return; 
                    }
                    const label = document.getElementById('foodLabel').innerHTML; 
                    let formattedLabel = label.replace(/\s+/g, '-');
                    // Check if the length is more than 15 characters
                    if (formattedLabel.length > 15) {
                        formattedLabel = formattedLabel.substring(0, 15);  // Truncate to 15 characters
                    }

                    const fileExtension = file.name.split('.').pop();
                    uniqueName = `${formattedLabel}-${Date.now()}.${fileExtension}`;

                    // Preview the image after file selection
                    const reader = new FileReader();
                    reader.onload = function() {
                        const foodImage = document.getElementById('foodImage');
                        foodImage.src = reader.result;
                        foodImage.dataset.localFile = 'true';
                        foodImage.style.display = 'block'; 
                        document.getElementById('uploadContainer').innerHTML = `Selected File: <strong>${uniqueName}</strong>`;
                    };
                    reader.readAsDataURL(file);

                    // Store the selected file globally
                    selectedFile = file;
                } else {
                    console.log('No file selected.');
                }
            };

            input.click();  // Trigger file input click
        }

        // sending the uploaded file to the server 
        function submitFile() {
            if (!selectedFile || !uniqueName) {
                Swal.fire({
                    icon: 'error',
                    title: 'No File Selected',
                    text: 'Please choose an image before submitting.'
                });
                return;
            }

            const formData = new FormData();
            formData.append('image', selectedFile);  // Append the selected file
            formData.append('uniqueFileName', uniqueName);  // Append the unique name

            // Use fetch to send the file to the server
            fetch('../functions/recipes/upload-recipe-image.php', {
                method: 'POST',
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    console.log('File uploaded successfully:', data.filePath);
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch((error) => console.error('Error uploading file:', error));
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

                    selectedFile = null;
                    uniqueName = '';

                    console.log("Image removed");
                } else {
                    console.log("Image removal canceled");
                }
            });
        }

    </script>
    
    <!-- script to reset modal fields -->
    <script>
        const recipeModal = document.getElementById('recipeModal');
        recipeModal.addEventListener('hide.bs.modal', function () {
            console.log('Modal is closing');
            resetModalFields();
        });

        function resetModalFields() {
            document.getElementById('recipeSearch').value = ''; 
            document.getElementById('searchResultsForRecipe').innerHTML = '';
            document.getElementById('receipeDetailSection').innerHTML = '';
        }

    </script>

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
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h5 class="food-label-name mb-3 font-weight-bold text-truncate" id="foodLabel">${food.label}</h5>
                            <h6 class="font-weight-bold mb-3 text-required">
                                Fields marked with <span class="required-star">*</span> are required to add a recipe
                            </h6>
                        </div>

                        
                        <!-- Amount and Unit Row -->
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                            <div class="col">
                                <label for="foodAmount" class="font-weight-bold">Amount:</label>
                                <input type="number" id="foodAmount" class="form-control" value="1" placeholder="Enter Amount">
                            </div>
                            <div class="col">
                                <label for="weighingUnit" class="font-weight-bold">Unit:</label>
                                <select id="weighingUnit" class="form-control">
                                </select>
                            </div>
                        </div>

                        <!-- Filters Meal Type and Food Group -->
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                            <div class="col">
                                <label for="MealType" class="font-weight-bold">Meal Type <span class="required-star">*</span></label>
                                <select id="MealType" class="form-control filter-seclect-input" required>
                                    <option selected="selected" disabled >Select Meal Type</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="FoodGroup" class="font-weight-bold">Food Group <span class="required-star">*</span></label>
                                <select id="FoodGroup" class="form-control filter-seclect-input" required>
                                    <option selected="selected" disabled >Select Food Group</option>
                                </select>
                            </div>
                        </div>

                        <!-- Ingredients -->
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                            <div class="flex-fill">
                                <label for="Protein" class="font-weight-bold">Protien <span class="required-star">*</span></label>
                                <select id="Protein" class="form-control filter-seclect-input" required>
                                    <option selected="selected" disabled >By Protein</option>
                                </select>
                            </div>
                            <div class="flex-fill">
                                <label for="Veggie" class="font-weight-bold">Veggie <span class="required-star">*</span></label>
                                <select id="Veggie" class="form-control filter-seclect-input" required>
                                    <option selected="selected" disabled >By Veggie</option>
                                </select>
                            </div>
                            <div class="flex-fill">
                                <label for="Fruit" class="font-weight-bold">Fruit <span class="required-star">*</span></label>
                                <select id="Fruit" class="form-control filter-seclect-input" required>
                                    <option selected="selected" disabled >By Fruit</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nutritional Info -->
                        <div id="nutritionInfo" class="mt-4">
                            <div class="nutrition-grid">
                                <div class="d-flex justify-content-between gap-3 mb-3">
                                    <div class="nutrition-item">
                                        <label>Calories</label>
                                        <input type="text" id="calories" class="form-control" value="${food.nutrients.ENERC_KCAL || '0'}">
                                    </div>
                                    <div class="nutrition-item">
                                        <label>Total Fat</label>
                                        <input type="text" id="fat" class="form-control" value="${food.nutrients.FAT || '0g'}">
                                    </div>
                                    <div class="nutrition-item">
                                        <label>Sat. Fat</label>
                                        <input type="text" id="satFat" class="form-control" value="${food.nutrients.FASAT || '0g'}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-3 mb-3">
                                    <div class="nutrition-item">
                                        <label>Cholest.</label>
                                        <input type="text" id="cholesterol" class="form-control" value="${food.nutrients.CHOLE || '0mg'}">
                                    </div>
                                    <div class="nutrition-item">
                                        <label>Sodium</label>
                                        <input type="text" id="sodium" class="form-control" value="${food.nutrients.NA || '0mg'}">
                                    </div>
                                    <div class="nutrition-item">
                                        <label>Carb.</label>
                                        <input type="text" id="carbs" class="form-control" value="${food.nutrients.CHOCDF || '0g'}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-3 mb-3">
                                    <div class="nutrition-item">
                                        <label>Fiber</label>
                                        <input type="text" id="fiber" class="form-control" value="${food.nutrients.FIBTG || '0g'}">
                                    </div>
                                    <div class="nutrition-item">
                                        <label>Sugars</label>
                                        <input type="text" id="sugars" class="form-control" value="${food.nutrients.SUGAR || '0g'}">
                                    </div>
                                    <div class="nutrition-item">
                                        <label>Protein</label>
                                        <input type="text" id="protein" class="form-control" value="${food.nutrients.PROCNT || '0g'}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="choose-img-section">
                            <div class="upload-container" id="uploadContainer" onclick="chooseFile()">
                                Upload Image
                            </div>
                            <div class="food-img-box position-relative">
                                <img id="foodImage" src="${food.image || 'https://propertywiselaunceston.com.au/wp-content/themes/property-wise/images/no-image@2x.png'}" onerror="this.src='https://propertywiselaunceston.com.au/wp-content/themes/property-wise/images/no-image@2x.png';" />
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

            fetchAndPopulateMealTypes();
            fetchAndPopulateFoodGroup();
            fetchAndPopulateVeggie();
            fetchAndPopulateProtein();
            fetchAndPopulateFruit();
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

        // Add the selected food to the database
        function addRecipeToDatabase(foodId, label, imageUrl) {
            
            if (uniqueName) {
                // If a local file was uploaded, prepare it to send to the backend
                imageData = uniqueName;  
            } else {
                // Use the default image if no file was uploaded
                imageData = imageUrl 
            }

            // Validate dropdown selections
            const requiredDropdowns = [
                { id: 'MealType', name: 'Meal Type', defaultValue: 'Select Meal Type' },
                { id: 'FoodGroup', name: 'Food Group', defaultValue: 'Select Food Group' },
                { id: 'Veggie', name: 'By Veggie', defaultValue: 'By Veggie' },
                { id: 'Protein', name: 'By Protein', defaultValue: 'By Protein' },
                { id: 'Fruit', name: 'By Fruit', defaultValue: 'By Fruit' },
            ];
            for (const dropdown of requiredDropdowns) {
                const element = document.getElementById(dropdown.id);
                if (element && element.value === dropdown.defaultValue) {
                    Swal.fire("Validation Error", `Please select a valid ${dropdown.name}.`, "error");
                    return; // Stop submission if validation fails
                }
            }
            
            submitFile()

            var modal = bootstrap.Modal.getInstance(document.getElementById('recipeModal'));
            const foodData = {
                foodId: foodId,
                label: label,
                image: imageData,
                amount: document.getElementById('foodAmount').value,
                unit: document.getElementById('weighingUnit').value,
                meal_type_id: document.getElementById('MealType').value,
                food_group_id: document.getElementById('FoodGroup').value,
                veggie_id: document.getElementById('Veggie').value,
                protein_id: document.getElementById('Protein').value,
                fruit_id: document.getElementById('Fruit').value,
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

    <!-- Script to display the recipes on the page -->
    <script>
        const recipes = <?php echo $recipes_json; ?>;

        function displayRecipes(recipes) {
            const recipeContainer = document.querySelector(".d-flex.flex-wrap.mt-3.gap-3");
            recipeContainer.innerHTML = "";

            recipes.forEach(recipe => {
                const card = document.createElement("div");
                card.classList.add("meal-card-rec");
                // const recipeImage = recipe.image ? recipe.image : 'https://via.placeholder.com/150'
                const recipeImage = recipe.image && recipe.image.startsWith('https://www.') 
                ? recipe.image 
                : `../assets/images/recipe_images/uploads/${recipe.image}`;

                card.innerHTML = `
                    <div class="custom-border rounded my-recipe-img-card-box">
                        <img class="my-recipe-img-card" src="${recipeImage}"  onerror="this.src='https://propertywiselaunceston.com.au/wp-content/themes/property-wise/images/no-image@2x.png';" alt="${recipe.label}">
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