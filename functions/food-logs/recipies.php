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

<h1 class="text-center">Recipes</h1>

<!-- Dropdowns -->
<div class="my-3">
    <div class="row g-2">
        <div class="col-12 col-sm-6 col-md-4">
            <select class="custom-select w-100">
                <option selected>by protein</option>
                <option>Chicken</option>
                <option>Turkey</option>
                <option>Eggs</option>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <select class="custom-select w-100">
                <option selected>by veggie</option>
                <option>Asparagus</option>
                <option>Broccoli</option>
                <option>Carrot</option>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <select class="custom-select w-100">
                <option selected>by fruit</option>
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
<div class="d-flex flex-wrap mt-3 gap-2">
    <!-- Recipe Card Example -->
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.unsplash.com/photo-1525351484163-7529414344d8" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.unsplash.com/photo-1490645935967-10de6ba17061" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.unsplash.com/photo-1495195129352-aeb325a55b65" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.unsplash.com/photo-1543353071-873f17a7a088" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.pexels.com/photos/10261265/pexels-photo-10261265.jpeg" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.pexels.com/photos/3184193/pexels-photo-3184193.jpeg" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="meal-card-rec">
        <div class="custom-border rounded">
            <img class="recipe-img-card" src="https://images.pexels.com/photos/699953/pexels-photo-699953.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Veggie Omelette">
            <div class="meal-name">veggie</div>
            <div class="meal-name-sub">omelette</div>
            <div class="meal-info">800 kcal<br>8 oz</div>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
</div>