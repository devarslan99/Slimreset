<style>
    .view-all-checkboxes input[type="checkbox"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 15px;
        height: 15px;
        border: 2px solid #000;
        border-radius: 3px;
        outline: none;
        cursor: pointer;
        position: relative;
        background-color: transparent;
    }

    .view-all-checkboxes input[type="checkbox"]:checked {
        background-color: transparent;
        border-color: #000;
    }

    .view-all-checkboxes input[type="checkbox"]:checked::after {
        content: '✔';
        font-size: 12px;
        position: absolute;
        top: -3px;
        left: 0px;
        color: black;
    }

    .fa-star {
        color: black;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .fa-star.active {
        color: yellow;
    }
</style>

<h1 class="text-center">Recipes</h1>

<!-- Dropdowns -->
<div class="my-3">
    <div class="row g-2">
        <div class="col-12 col-sm-6 col-md-4">
            <select class="form-select w-100">
                <option selected>Select by protein</option>
                <option>Chicken</option>
                <option>Turkey</option>
                <option>Eggs</option>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <select class="form-select w-100">
                <option selected>Select by veggie</option>
                <option>Asparagus</option>
                <option>Broccoli</option>
                <option>Carrot</option>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <select class="form-select w-100">
                <option selected>Select by fruit</option>
                <option>Apples</option>
                <option>Bananas</option>
                <option>Grapes</option>
            </select>
        </div>
    </div>


</div>

<!-- Category Checkboxes -->
<div class="d-flex flex-wrap gap-3 view-all-checkboxes">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="breakfast">
        <label class="form-check-label" for="breakfast">Breakfast</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="lunch">
        <label class="form-check-label" for="lunch">Lunch/Dinner</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="snacks">
        <label class="form-check-label" for="snacks">Snacks</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="beverages">
        <label class="form-check-label" for="beverages">Beverages</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="flavourings">
        <label class="form-check-label" for="flavourings">Flavorings</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="dessert">
        <label class="form-check-label" for="dessert">Dessert</label>
    </div>
</div>

<!-- Recipe Cards -->
<div class="d-flex flex-wrap mt-3">
    <!-- Recipe Card Example -->
    <div class="card m-2" style="width: 8rem;">
        <img src="https://via.placeholder.com/100" class="card-img-top" alt="Recipe Image">
        <div class="card-body">
            <p class="card-text">Veggie Omelette</p>
            <small>800 kcal, 10g protein</small>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="card m-2" style="width: 8rem;">
        <img src="https://via.placeholder.com/100" class="card-img-top" alt="Recipe Image">
        <div class="card-body">
            <p class="card-text">Veggie Omelette</p>
            <small>800 kcal, 10g protein</small>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="card m-2" style="width: 8rem;">
        <img src="https://via.placeholder.com/100" class="card-img-top" alt="Recipe Image">
        <div class="card-body">
            <p class="card-text">Veggie Omelette</p>
            <small>800 kcal, 10g protein</small>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="card m-2" style="width: 8rem;">
        <img src="https://via.placeholder.com/100" class="card-img-top" alt="Recipe Image">
        <div class="card-body">
            <p class="card-text">Veggie Omelette</p>
            <small>800 kcal, 10g protein</small>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="card m-2" style="width: 8rem;">
        <img src="https://via.placeholder.com/100" class="card-img-top" alt="Recipe Image">
        <div class="card-body">
            <p class="card-text">Veggie Omelette</p>
            <small>800 kcal, 10g protein</small>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <div class="card m-2" style="width: 8rem;">
        <img src="https://via.placeholder.com/100" class="card-img-top" alt="Recipe Image">
        <div class="card-body">
            <p class="card-text">Veggie Omelette</p>
            <small>800 kcal, 10g protein</small>
            <span class="text-end star-margin">
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
</div>

<script>
    // JavaScript to toggle the star color on click
    document.querySelectorAll('.fa-star').forEach(star => {
        star.addEventListener('click', () => {
            star.classList.toggle('active'); // Toggle yellow color
        });
    });
</script>