<?php
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));
?>

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col text-center mb-3 mb-sm-0">
            <h1 class="mb-0 fs-2 fs-md-1">Let's plan your meals</h1>
        </div>

        <div class="col-auto d-none d-sm-inline-flex">
            <span class="grocery-list rounded-2 d-inline-flex align-items-center fs-6 fw-bold">
                <i class="fa fa-shopping-cart me-2 fs-5 fw-bold"></i>
                Grocery List
            </span>
        </div>

        <div class="col-12 text-center d-sm-none">
            <span class="grocery-list rounded-2 d-inline-flex align-items-center fs-6 fw-bold">
                <i class="fa fa-shopping-cart me-2 fs-5 fw-bold"></i>
                Grocery List
            </span>
        </div>
        <div class="main-color text-center my-3">
            <i class="fa fa-calendar me-2 fw-bold fs-4"></i>
            <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $prev_date; ?>">
                <i class="fa fa-angle-left fw-bold fs-4"></i>
            </a>
            <h3 class="text-center mx-2 d-inline main-color">
                <?php echo date('M d, Y', strtotime($selected_date)); ?>
            </h3>
            <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
            <a href="?id=<?php echo $_GET['id'] ?>&date=<?php echo $next_date; ?>">
                <i class="fa fa-angle-right fw-bold fs-4"></i>
            </a>
        </div>
    </div>

    <style>
        .day-header {
            font-weight: bold;
            color: #6b4ce6;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .date-text {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }

        .cal-info {
            color: #000;
            font-size: 0.9rem;
        }

        .day-column {
            position: relative;
            border-left: 4px solid #ddd;
            padding-left: 20px;
            margin-right: -2px;
        }

        .day-column::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 4px;
            background-color: #ddd;
        }

        .meal-card,
        .empty-card {
            border: none;
            border-top: 4px solid #ddd;
            padding: 10px;
            text-align: center;
            min-height: 120px;
            position: relative;
        }

        .meal-card-rec {
            padding: 10px;
            text-align: center;
            min-height: 120px;
            position: relative;
        }

        .empty-card {
            border-top: 4px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .add-more {
            border: 1px dashed #ddd;
            border-radius: 0.375rem;
            width: 94px;
            height: 145px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .meal-card img {
            max-width: 100%;
            border-radius: 5px;
        }

        .meal-name {
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }

        .meal-name-sub {
            font-weight: bold;
            color: #333;
        }

        .meal-info {
            font-size: 0.85rem;
            color: #666;
            display: inline;
        }

        .plus-sign {
            font-size: 2rem;
            color: #ccc;
        }

        .nutrition-label {
            background-color: #E9F8E3;
            color: #00BF63;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 2px;
            position: absolute;
            left: -45px;
            top: 45px;
            transform: rotate(-90deg);
        }

        .breakfast-label {
            background-color: blue;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 2px;
            position: absolute;
            left: -69px;
            top: 70px;
            transform: rotate(-90deg);
        }

        .lunch-label {
            background-color: blue;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 2px;
            position: absolute;
            left: -56px;
            top: 70px;
            transform: rotate(-90deg);
        }

        .dinner-label {
            background-color: blue;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 2px;
            position: absolute;
            left: -58px;
            top: 70px;
            transform: rotate(-90deg);
        }

        .snack-label {
            background-color: blue;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 2px;
            position: absolute;
            left: -56px;
            top: 70px;
            transform: rotate(-90deg);
        }

        .custom-border {
            border: 1px solid #946CFC;
        }
    </style>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                <!-- Day 1 -->
                <div class="text-center">
                    <div class="nutrition-label">nutrition</div>
                    <div class="day-header">day 1</div>
                    <div class="date-text">oct 5</div>
                    <div class="cal-info">800 kcal<br>10.5 oz</div>
                    <div><i class="fa fa-shopping-cart text-muted"></i></div>
                </div>
                <div class="meal-card breakfast">
                    <div class="custom-border rounded">
                        <div class="breakfast-label">breakfast</div>
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- lunch Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <div class="lunch-label">lunch</div>
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- dinner Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <div class="dinner-label">dinner</div>
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- snack Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <div class="snack-label">snack</div>
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>
                <!-- Empty Add Card -->
                <div class="empty-card">
                    <div class="add-more">
                        <div class="plus-sign">+</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                <!-- Day 1 -->
                <div class="text-center">
                    <div class="day-header">day 1</div>
                    <div class="date-text">oct 5</div>
                    <div class="cal-info">800 kcal<br>10.5 oz</div>
                    <div><i class="fa fa-shopping-cart text-muted"></i></div>
                </div>

                <!-- Breakfast Card -->
                <div class="meal-card breakfast">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- lunch Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- dinner Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- snack Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- Empty Add Card -->
                <div class="empty-card">
                    <div class="add-more">
                        <div class="plus-sign">+</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                <!-- Day 1 -->
                <div class="text-center">
                    <div class="day-header">day 1</div>
                    <div class="date-text">oct 5</div>
                    <div class="cal-info">800 kcal<br>10.5 oz</div>
                    <div><i class="fa fa-shopping-cart text-muted"></i></div>
                </div>

                <!-- Breakfast Card -->
                <div class="meal-card breakfast">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- lunch Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- dinner Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- snack Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- Empty Add Card -->
                <div class="empty-card">
                    <div class="add-more">
                        <div class="plus-sign">+</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                <!-- Day 1 -->
                <div class="text-center">
                    <div class="day-header">day 1</div>
                    <div class="date-text">oct 5</div>
                    <div class="cal-info">800 kcal<br>10.5 oz</div>
                    <div><i class="fa fa-shopping-cart text-muted"></i></div>
                </div>

                <!-- Breakfast Card -->
                <div class="meal-card breakfast">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- lunch Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- dinner Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- snack Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- Empty Add Card -->
                <div class="empty-card">
                    <div class="add-more">
                        <div class="plus-sign">+</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                <!-- Day 1 -->
                <div class="text-center">
                    <div class="day-header">day 1</div>
                    <div class="date-text">oct 5</div>
                    <div class="cal-info">800 kcal<br>10.5 oz</div>
                    <div><i class="fa fa-shopping-cart text-muted"></i></div>
                </div>

                <!-- Breakfast Card -->
                <div class="meal-card breakfast">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- lunch Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- dinner Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- snack Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- Empty Add Card -->
                <div class="empty-card">
                    <div class="add-more">
                        <div class="plus-sign">+</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                <!-- Day 1 -->
                <div class="text-center">
                    <div class="day-header">day 1</div>
                    <div class="date-text">oct 5</div>
                    <div class="cal-info">800 kcal<br>10.5 oz</div>
                    <div><i class="fa fa-shopping-cart text-muted"></i></div>
                </div>

                <!-- Breakfast Card -->
                <div class="meal-card breakfast">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- lunch Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- dinner Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- snack Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- Empty Add Card -->
                <div class="empty-card">
                    <div class="add-more">
                        <div class="plus-sign">+</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 day-column" style="max-width: 150px;">
                <!-- Day 1 -->
                <div class="text-center">
                    <div class="day-header">day 1</div>
                    <div class="date-text">oct 5</div>
                    <div class="cal-info">800 kcal<br>10.5 oz</div>
                    <div><i class="fa fa-shopping-cart text-muted"></i></div>
                </div>

                <!-- Breakfast Card -->
                <div class="meal-card breakfast">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>

                </div>

                <!-- lunch Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- dinner Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- snack Card -->
                <div class="meal-card">
                    <div class="custom-border rounded">
                        <img src="https://placehold.co/100x60" alt="Veggie Omelette">
                        <div class="meal-name">veggie omelette</div>
                        <div class="meal-info">800 kcal<br>8 oz</div>
                    </div>
                </div>

                <!-- Empty Add Card -->
                <div class="empty-card">
                    <div class="add-more">
                        <div class="plus-sign">+</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>