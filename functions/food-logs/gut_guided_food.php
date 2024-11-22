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
                <div class="label-select mb-2">select</div>
                <div class="checkbox-group">
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
                <div class="label-select mb-2">select</div>
                <div class="checkbox-group">
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
                <h3 class="">Veggies</h3>
                <h3 class="my-3 main-color">Rich Protein</h3>
                <div class="label-select mb-2">Select</div>
                <div class="checkbox-group">
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Spinach
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Kale
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Brussels Sprouts
                    </label>
                </div>
                <h3 class="my-3 main-color">Light Protein</h3>
                <div class="label-select mb-2">Select</div>
                <div class="checkbox-group">
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Lettuce
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Cabbage
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Cauliflower
                    </label>
                </div>
            </div>

            <!-- Fruits Category -->
            <div class="category-section flex-fill mb-4">
                <h3 class="">Fruits</h3>
                <h3 class="my-3 main-color">Rich Protein</h3>
                <div class="label-select mb-2">Select</div>
                <div class="checkbox-group">
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Avocado
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Guava
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Mulberries
                    </label>
                </div>
                <h3 class="my-3 main-color">Light Protein</h3>
                <div class="label-select mb-2">Select</div>
                <div class="checkbox-group">
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Apples
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Banana
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Berries
                    </label>
                </div>
            </div>

            <!-- Beverages Category -->
            <div class="category-section flex-fill mb-4">
                <h3 class="">Beverages</h3>
                <h3 class="my-3 main-color">Rich Protein</h3>
                <div class="label-select mb-2">Select</div>
                <div class="checkbox-group">
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Soy Milk
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Almond Milk
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Oat Milk
                    </label>
                </div>
                <h3 class="my-3 main-color">Light Protein</h3>
                <div class="label-select mb-2">Select</div>
                <div class="checkbox-group">
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Coconut Water
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Green Tea
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Herbal Tea
                    </label>
                </div>
            </div>

            <!-- Flavorings Category -->
            <div class="category-section flex-fill mb-4">
                <h3 class="">Flavorings</h3>
                <h3 class="my-3 main-color">Rich Protein</h3>
                <div class="label-select mb-2">Select</div>
                <div class="checkbox-group">
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Tofu
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Tempeh
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Edamame
                    </label>
                </div>
                <h3 class="my-3 main-color">Light Protein</h3>
                <div class="label-select mb-2">Select</div>
                <div class="checkbox-group">
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Low-fat Yogurt
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Cottage Cheese
                    </label>
                    <label class="d-flex align-items-center gap-2 border-bottom-row-gut-guided py-2">
                        <div class="checkboxes">
                            <input type="checkbox" class="red-checkbox">
                            <input type="checkbox" class="green-checkbox mx-2">
                            <input type="checkbox" class="orange-checkbox">
                        </div>
                        Almond Butter
                    </label>
                </div>
            </div>
            
        </div>
    </div>
</body>

</html>