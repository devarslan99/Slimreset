<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php" ?>
<style>
    .expanded-row {
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        margin-top: 5px;
    }
</style>

<body>
    <?php include_once "../utils/loader.php" ?>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include_once "../utils/navbar.php" ?>
        <div class="page-body-wrapper">
            <?php include_once "../utils/sidebar.php" ?>
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid default-dashboard">
                    <div class="row widget-grid">
                        <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                            <?php
                            $role = $_SESSION['role'];
                            if ($role == "admin") {
                                include_once "../dashboard/utils/admin_component.php";
                            } else if ($role == "coach") {
                                include_once "../dashboard/utils/coach_component.php";
                            } else if ($role == "client") {
                                include_once "../dashboard/utils/client_component.php";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <?php include_once "../utils/footer.php" ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Food</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="food_type">
                    <input type="text" id="foodSearch" class="form-control" placeholder="Search for food..."
                        oninput="fetchFoodData()">
                    <!-- Display search results -->
                    <ul class="list-group mt-3" id="searchResults"></ul>
                </div>
            </div>
        </div>
    </div>

    <?php include_once "../utils/scripts.php" ?>
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
                label: label,   // Include label
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
    <!-- SCRIPT TO DELETE FOOD ITEM -->
    <script>
        $(document).ready(function () {
            $('.delete a').click(function (e) {
                e.preventDefault();
                var deleteId = $(this).data('food-id');
                var table_name = 'food_items';
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '../functions/global_delete.php',
                            data: {
                                id: deleteId,
                                table_name: table_name
                            },
                            success: function (response) {
                                if (response === 'Success') {
                                    Swal.fire({
                                        title: 'Success',
                                        text: "Food Item Deleted Successfully",
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
                                        text: "Failed to Delete Food Item",
                                        icon: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
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
                    }
                });
            });
        });
    </script>
    <!-- SCRIPT TO RECORD WEIGHT -->
    <script>
        $(document).ready(function () {
            $('#weight-form').on('submit', function (e) {
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
                    success: function (response) {
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
                    error: function (xhr, status, error) {
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
    <!-- SCRIPT TO RECORD BOWEL MOVEMENT -->
    <script>
        $(document).ready(function () {
            $('#bowel-form').on('submit', function (e) {
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
                    success: function (response) {
                        if (response === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Bowel Movement Recorded",
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
                                text: "Failed to Record Bowel Movement",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
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
    <!-- SCRIPT TO RECORD WATER CONSUMPTION -->
    <script>
        $(document).ready(function () {
            $('#water-form').on('submit', function (e) {
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
                    success: function (response) {
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
                    error: function (xhr, status, error) {
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
    <!-- SCRIPT FOR LAYOUT -->
    <script>
        function updateWrapperClass() {
            const pageWrapper = document.getElementById('pageWrapper');

            if (window.innerWidth <= 768) { // Assuming mobile screen width is 768px or less
                pageWrapper.classList.remove('horizontal-wrapper');
                pageWrapper.classList.add('compact-wrapper');
            } else {
                pageWrapper.classList.remove('compact-wrapper');
                pageWrapper.classList.add('horizontal-wrapper');
            }
        }

        // Run on page load
        updateWrapperClass();

        // Run on window resize
        window.addEventListener('resize', updateWrapperClass);

    </script>
    <!-- SCRIPT FOR MODAL -->
    <script>
        $(document).ready(function () {
            $('.edit-link').on('click', function () {
                // Get the ID from data attribute
                var id = $(this).data('id');

                // Set the ID in the modal (optional)
                $('#ItemId').val(id);

                // Show the modal
                $('#editModal').modal('show');
            });

            $('#saveChanges').on('click', function () {
                var formData = $('#assign_coach_form').serialize();

                // AJAX request to submit the form
                $.ajax({
                    type: 'POST',
                    url: '../functions/clients/assign_coach.php', // URL of the server-side script to process the form
                    data: formData,
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script>
</body>

</html>