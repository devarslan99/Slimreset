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

    .border-bottom-row {
        border-bottom: 2px solid #B9BDC6;
        width: 10em;
    }

    .like-icon
    {
        position: relative;
        top: -10px; 
        width: 20px;
        height: 20px;
        background: #2ed52e;
        text-align: center;
        line-height: 20px;
        border-radius: 50%;
        color: #fff;
        font-size: 12px;
        display:none;
    } 
    #like-label:hover
    {
        color:#2ed52e;
    }
    #like-label:hover + .like-icon
    {
        display:inline-block;
    }
    .dis-like-icon
    {
        position: relative;
        top: -10px; 
        width: 20px;
        height: 20px;
        background: red;
        text-align: center;
        line-height: 20px;
        border-radius: 50%;
        color: #fff;
        display:none;
    }
    .dis-like-icon i
    {
        font-size: 12px;
    }
    #dislike-label:hover
    {
        color:red;
    }
    #dislike-label:hover + .dis-like-icon
    {
        display:inline-block;
    }
    .excla-icon
    {
        position: relative;
        top: -10px; 
        width: 20px;
        height: 20px;
        background: orange;
        text-align: center;
        line-height: 20px;
        border-radius: 50%;
        color: #fff;
        display:none;
    }
    .excla-icon i
    {
        font-size: 12px;
    }
    #excla-label:hover
    {
        color:orange;
    }
    #excla-label:hover + .excla-icon
    {
        display:inline-block;
    }

</style>

<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between gap-2">
        <!-- Protein Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Protein</h3>
            <div class="form-check border-bottom-row my-2">
                <label class="d-block text-secondary select-margin">Select</label>
                <div class="d-relative">
                    <input class="form-check-input" type="checkbox" id="protein1">
                    <label class="form-check-label" id="excla-label" for="protein1">Chicken</label>
                    <span class="excla-icon"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
                    <span class="d-absolute"></span>
                </div>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="protein2">
                <label class="form-check-label" id="like-label" for="protein2">Turkey</label>
                <span class="like-icon"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="protein3">
                <label class="form-check-label" id="dislike-label" for="protein3">Eggs</label>
                <span class="dis-like-icon"><i class="fa fa-times" aria-hidden="true"></i></span>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="protein1">
                    <label class="form-check-label" for="protein1">Chicken</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="protein2">
                    <label class="form-check-label" for="protein2">Turkey</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="protein3">
                    <label class="form-check-label" for="protein3">Eggs</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="protein1">
                    <label class="form-check-label" for="protein1">Chicken</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="protein2">
                    <label class="form-check-label" for="protein2">Turkey</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="protein3">
                    <label class="form-check-label" for="protein3">Eggs</label>
                </div>
            </div>
        </div>

        <!-- Veggies Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Veggies</h3>
            <div class="form-check border-bottom-row my-2">
                <label class="d-block text-secondary select-margin">Select</label>
                <input class="form-check-input" type="checkbox" id="veggie1">
                <label class="form-check-label" for="veggie1">Asparagus</label>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="veggie2">
                <label class="form-check-label" for="veggie2">Broccoli</label>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="veggie3">
                <label class="form-check-label" for="veggie3">Carrot</label>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="veggie1">
                    <label class="form-check-label" for="veggie1">Asparagus</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="veggie2">
                    <label class="form-check-label" for="veggie2">Broccoli</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="veggie3">
                    <label class="form-check-label" for="veggie3">Carrot</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="veggie1">
                    <label class="form-check-label" for="veggie1">Asparagus</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="veggie2">
                    <label class="form-check-label" for="veggie2">Broccoli</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="veggie3">
                    <label class="form-check-label" for="veggie3">Carrot</label>
                </div>
            </div>
        </div>

        <!-- Fruit Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Fruit</h3>
            <div class="form-check border-bottom-row my-2">
                <label class="d-block text-secondary select-margin">Select</label>
                <input class="form-check-input" type="checkbox" id="fruit1">
                <label class="form-check-label" for="fruit1">Apples</label>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="fruit2">
                <label class="form-check-label" for="fruit2">Bananas</label>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="fruit3">
                <label class="form-check-label" for="fruit3">Grapes</label>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="fruit1">
                    <label class="form-check-label" for="fruit1">Apples</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="fruit2">
                    <label class="form-check-label" for="fruit2">Bananas</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="fruit3">
                    <label class="form-check-label" for="fruit3">Grapes</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="fruit1">
                    <label class="form-check-label" for="fruit1">Apples</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="fruit2">
                    <label class="form-check-label" for="fruit2">Bananas</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="fruit3">
                    <label class="form-check-label" for="fruit3">Grapes</label>
                </div>
            </div>
        </div>

        <!-- Beverages Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Beverages</h3>
            <div class="form-check border-bottom-row my-2">
                <label class="d-block text-secondary select-margin">Select</label>
                <input class="form-check-input" type="checkbox" id="beverage1">
                <label class="form-check-label" for="beverage1">Water</label>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="beverage2">
                <label class="form-check-label" for="beverage2">Juice</label>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="beverage3">
                <label class="form-check-label" for="beverage3">Milk</label>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="beverage1">
                    <label class="form-check-label" for="beverage1">Water</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="beverage2">
                    <label class="form-check-label" for="beverage2">Juice</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="beverage3">
                    <label class="form-check-label" for="beverage3">Milk</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="beverage1">
                    <label class="form-check-label" for="beverage1">Water</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="beverage2">
                    <label class="form-check-label" for="beverage2">Juice</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="beverage3">
                    <label class="form-check-label" for="beverage3">Milk</label>
                </div>
            </div>
        </div>

        <!-- Flavorings Category -->
        <div class="category-section flex-fill mb-4 view-all-checkboxes">
            <h3 class="mb-3">Flavorings</h3>
            <div class="form-check border-bottom-row my-2">
                <label class="d-block text-secondary select-margin">Select</label>
                <input class="form-check-input" type="checkbox" id="flavor1">
                <label class="form-check-label" for="flavor1">Salt</label>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="flavor2">
                <label class="form-check-label" for="flavor2">Pepper</label>
            </div>
            <div class="form-check border-bottom-row my-2">
                <input class="form-check-input" type="checkbox" id="flavor3">
                <label class="form-check-label" for="flavor3">Herbs</label>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="flavor1">
                    <label class="form-check-label" for="flavor1">Salt</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="flavor2">
                    <label class="form-check-label" for="flavor2">Pepper</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="flavor3">
                    <label class="form-check-label" for="flavor3">Herbs</label>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-check border-bottom-row my-2">
                    <label class="d-block text-secondary select-margin">Select</label>
                    <input class="form-check-input" type="checkbox" id="flavor1">
                    <label class="form-check-label" for="flavor1">Salt</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="flavor2">
                    <label class="form-check-label" for="flavor2">Pepper</label>
                </div>
                <div class="form-check border-bottom-row my-2">
                    <input class="form-check-input" type="checkbox" id="flavor3">
                    <label class="form-check-label" for="flavor3">Herbs</label>
                </div>
            </div>
        </div>
    </div>
</div>