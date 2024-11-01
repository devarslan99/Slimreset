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
</style>

<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between">
        <!-- Protein Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Protein</h3>
            <div class="form-check">
                <label class="d-block text-secondary select-margin">Select</label>
                <div class="d-relative">
                    <input class="form-check-input" type="checkbox" id="protein1">
                    <label class="form-check-label" for="protein1">Chicken</label>
                    <span class="d-absolute"></span>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="protein2">
                <label class="form-check-label" for="protein2">Turkey</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="protein3">
                <label class="form-check-label" for="protein3">Eggs</label>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="protein1">
                    <label class="form-check-label" for="protein1">Chicken</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="protein2">
                    <label class="form-check-label" for="protein2">Turkey</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="protein3">
                    <label class="form-check-label" for="protein3">Eggs</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="protein1">
                    <label class="form-check-label" for="protein1">Chicken</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="protein2">
                    <label class="form-check-label" for="protein2">Turkey</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="protein3">
                    <label class="form-check-label" for="protein3">Eggs</label>
                </div>
            </div>
        </div>

        <!-- Veggies Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Veggies</h3>
            <div class="form-check">
                <label class="d-block text-secondary select-margin">Select</label>
                <input class="form-check-input" type="checkbox" id="veggie1">
                <label class="form-check-label" for="veggie1">Asparagus</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="veggie2">
                <label class="form-check-label" for="veggie2">Broccoli</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="veggie3">
                <label class="form-check-label" for="veggie3">Carrot</label>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="veggie1">
                    <label class="form-check-label" for="veggie1">Asparagus</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="veggie2">
                    <label class="form-check-label" for="veggie2">Broccoli</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="veggie3">
                    <label class="form-check-label" for="veggie3">Carrot</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="veggie1">
                    <label class="form-check-label" for="veggie1">Asparagus</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="veggie2">
                    <label class="form-check-label" for="veggie2">Broccoli</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="veggie3">
                    <label class="form-check-label" for="veggie3">Carrot</label>
                </div>
            </div>
        </div>

        <!-- Fruit Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Fruit</h3>
            <div class="form-check">
                <label class="d-block text-secondary select-margin">Select</label>
                <input class="form-check-input" type="checkbox" id="fruit1">
                <label class="form-check-label" for="fruit1">Apples</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="fruit2">
                <label class="form-check-label" for="fruit2">Bananas</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="fruit3">
                <label class="form-check-label" for="fruit3">Grapes</label>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="fruit1">
                    <label class="form-check-label" for="fruit1">Apples</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="fruit2">
                    <label class="form-check-label" for="fruit2">Bananas</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="fruit3">
                    <label class="form-check-label" for="fruit3">Grapes</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="fruit1">
                    <label class="form-check-label" for="fruit1">Apples</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="fruit2">
                    <label class="form-check-label" for="fruit2">Bananas</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="fruit3">
                    <label class="form-check-label" for="fruit3">Grapes</label>
                </div>
            </div>
        </div>

        <!-- Beverages Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Beverages</h3>
            <div class="form-check">
                <label class="d-block text-secondary select-margin">Select</label>
                <input class="form-check-input" type="checkbox" id="beverage1">
                <label class="form-check-label" for="beverage1">Water</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="beverage2">
                <label class="form-check-label" for="beverage2">Juice</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="beverage3">
                <label class="form-check-label" for="beverage3">Milk</label>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="beverage1">
                    <label class="form-check-label" for="beverage1">Water</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="beverage2">
                    <label class="form-check-label" for="beverage2">Juice</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="beverage3">
                    <label class="form-check-label" for="beverage3">Milk</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="beverage1">
                    <label class="form-check-label" for="beverage1">Water</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="beverage2">
                    <label class="form-check-label" for="beverage2">Juice</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="beverage3">
                    <label class="form-check-label" for="beverage3">Milk</label>
                </div>
            </div>
        </div>

        <!-- Flavorings Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Flavorings</h3>
            <div class="form-check">
                <label class="d-block text-secondary select-margin">Select</label>
                <input class="form-check-input" type="checkbox" id="flavor1">
                <label class="form-check-label" for="flavor1">Salt</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="flavor2">
                <label class="form-check-label" for="flavor2">Pepper</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="flavor3">
                <label class="form-check-label" for="flavor3">Herbs</label>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="flavor1">
                    <label class="form-check-label" for="flavor1">Salt</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="flavor2">
                    <label class="form-check-label" for="flavor2">Pepper</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="flavor3">
                    <label class="form-check-label" for="flavor3">Herbs</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="flavor1">
                    <label class="form-check-label" for="flavor1">Salt</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="flavor2">
                    <label class="form-check-label" for="flavor2">Pepper</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="flavor3">
                    <label class="form-check-label" for="flavor3">Herbs</label>
                </div>
            </div>
        </div>
    </div>
</div>