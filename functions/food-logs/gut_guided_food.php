<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Categories</title>
    <style>
        .category-section{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .checkboxes input[type="checkbox"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 15px;
            height: 15px;
            border: 2px solid transparent;
            border-radius: 3px;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        .red-checkbox {
            box-shadow: 0 0 0 2px red;
        }

        .green-checkbox {
            box-shadow: 0 0 0 2px green;
        }

        .orange-checkbox {
            box-shadow: 0 0 0 2px orange;
        }

        .checkboxes input[type="checkbox"]:checked::after {
            content: '✔';
            font-size: 16px;
            position: absolute;
            top: -6px;
            left: -1px;
        }

        .red-checkbox:checked::after {
            color: red;
        }

        .green-checkbox:checked::after {
            color: green;
        }

        .orange-checkbox:checked::after {
            color: orange;
        }

        .border-bottom-row-gut-guided {
            border-bottom: 2px solid #B9BDC6;
        } 
    </style>

</head>

<body>

    <div class="container-fluid">
        <div class="d-flex flex-wrap justify-content-between">
            <!-- Protein Category -->
            <div class="category-section flex-fill mb-4">
                <h3 class="">Protein</h3>
                <h3 class="my-3 main-color">rich protein</h3>
                <div class="checkbox-group">
                    <div class="label-select mb-2">select</div>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        chicken
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        chicken
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        chicken
                    </label>
                </div>
                <h3 class="my-3 main-color">light protein</h3>
                <div class="checkbox-group">
                    <div class="label-select mb-2">select</div>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        chicken
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        chicken
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        chicken
                    </label>
                </div>
            </div>

            <!-- Veggies Category -->
            <div class="category-section flex-fill mb-4">
                <h3 class="">veggies</h3>
                <h3 class="my-3 main-color">rich protein</h3>
                <div class="checkbox-group">
                    <div class="label-select mb-2">select</div>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        asparagus
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        broccoli
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        carrot
                    </label>
                </div>
                <h3 class="my-3 main-color">light protein</h3>
                <div class="checkbox-group">
                    <div class="label-select mb-2">select</div>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        asparagus
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        broccoli
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        carrot
                    </label>
                </div>
            </div>

            <!-- Fruits Category -->
            <div class="category-section flex-fill mb-4">
                <h3 class="">veggies</h3>
                <h3 class="my-3 main-color">rich protein</h3>
                <div class="checkbox-group">
                    <div class="label-select mb-2">select</div>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        asparagus
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        broccoli
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        carrot
                    </label>
                </div>
                <h3 class="my-3 main-color">light protein</h3>
                <div class="checkbox-group">
                    <div class="label-select mb-2">select</div>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        asparagus
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        broccoli
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        carrot
                    </label>
                </div>
            </div>

            <!-- Beverages Category -->
            <div class="category-section flex-fill mb-4">
                <h3 class="">veggies</h3>
                <h3 class="my-3 main-color">rich protein</h3>
                <div class="checkbox-group">
                    <div class="label-select mb-2">select</div>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        asparagus
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        broccoli
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        carrot
                    </label>
                </div>
                <h3 class="my-3 main-color">light protein</h3>
                <div class="checkbox-group">
                    <div class="label-select mb-2">select</div>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        asparagus
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        broccoli
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        carrot
                    </label>
                </div>
            </div>

            <!-- Repeat for Fruit, Beverages, etc. as needed -->
        </div>
    </div>
</body>

</html>