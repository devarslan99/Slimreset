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
            height: 150px;
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center flex-grow-1 mb-0">My Recipes</h2>
            <div class="custom-checkbox-my-recipes d-flex align-items-center">
                <input type="checkbox" id="lunch">
                <label for="lunch" class="mb-0">Lunch/Dinner</label>
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

        <div class="row">
            <!-- Recipe Card -->
            <div class="d-flex flex-wrap mt-3 gap-3">
                <!-- Recipe Card Example -->
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.unsplash.com/photo-1525351484163-7529414344d8" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.unsplash.com/photo-1490645935967-10de6ba17061" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.unsplash.com/photo-1495195129352-aeb325a55b65" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.unsplash.com/photo-1543353071-873f17a7a088" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.pexels.com/photos/10261265/pexels-photo-10261265.jpeg" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.pexels.com/photos/3184193/pexels-photo-3184193.jpeg" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <div class="meal-card-rec">
                    <div class="custom-border rounded">
                        <img class="my-recipe-img-card" src="https://images.pexels.com/photos/699953/pexels-photo-699953.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Veggie Omelette">
                        <div class="meal-name">veggie</div>
                        <div class="meal-name-sub">omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>