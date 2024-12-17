<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Southwest Shrimp Salad</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #333;
        }

        /* Main Wrapper */
        .recipe_wrapper {
            width: 90%;
            margin: 20px auto;
            max-width: 1200px;
        }

        /* Header Section */
        .recipe_header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            flex-wrap: wrap;
        }

        .recipe_image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .recipe_details {
            flex: 1;
            min-width: 200px;
        }

        .recipe_title {
            font-size: 24px;
            font-weight: bold;
            text-transform: lowercase;
        }

        .recipe_links {
            list-style-type: none;
            margin-top: 10px;
            font-size: 14px;
            color: #999;
        }

        .recipe_links li {
            margin-bottom: 5px;
        }

        /* Nutrition Info */
        .recipe_nutrition {
            text-align: right;
        }

        .nutrition_info {
            font-size: 14px;
        }

        .highlight_c {
            color: #a055ff;
            font-weight: bold;
        }

        .highlight_p {
            color: #8888ff;
            font-weight: bold;
        }

        /* Tabs */
        .recipe_nav {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            padding-bottom: 10px;
        }

        .recipe_tab {
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-transform: lowercase;
        }

        .recipe_tab.active {
            color: #a055ff;
            border-bottom: 2px solid #a055ff;
        }

        /* Content Sections */
        .tab_content {
            display: none;
        }

        .tab_content.active {
            display: block;
        }

        /* Table */
        table {
            width: 100%;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #fff;
        }

        th, td {
            padding: 16px;
            text-align: center;
            border-bottom: 2px solid #a36cf9;
        }

        th {
            text-transform: lowercase;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .recipe_header {
                flex-direction: column;
                text-align: center;
            }

            .recipe_nutrition {
                text-align: center;
            }

            .recipe_nav {
                flex-direction: column;
                align-items: center;
            }

            table th, table td {
                font-size: 12px;
                padding: 8px;
            }
        }

    .client-plan-wrapper {
        position: relative;
        padding: 10px;
        margin: 10px 0;
    }

    .client-plan-title {
        font-size: 1.2rem;
        color: #000;
    }

    /* Three Dots Icon */
    .action-three-dots-icon {
        position: relative;
        font-size: 18px;
        cursor: pointer;
        color: #000;
        transition: color 0.3s ease;
        border: 2px solid;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-three-dots-icon:hover {
        color: #936CFB;
    }

    /* Phase Popup */
    .action-popup {
        position: absolute;
        top: 35px;
        right: 0;
        background: linear-gradient(135deg, #9a50ff, #6f30ff);
        border-radius: 10px;
        padding: 15px;
        width: 140px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        z-index: 1000;
    }

    .action-btn {
        background: transparent;
        border: none;
        color: #fff;
        padding: 8px;
        font-size: 1rem;
        cursor: pointer;
        text-align: center;
        font-weight: bold;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .action-btn:hover {
        background: #fff;
        color: #6f30ff;
        border-radius: 5px;
    }

    </style>
</head>
<body>
    <div class="recipe_wrapper">
        <!-- Header Section -->
        <div class="recipe_header">
            <img src="assets/img/salad.jpg" alt="Southwest Shrimp Salad" class="recipe_image">
            <div class="recipe_details">
                <h1 class="recipe_title">southwest shrimp salad</h1>
                <ul class="recipe_links">
                    <li>+ recipe book</li>
                    <li>+ modify + save</li>
                    <li>+ grocery list</li>
                </ul>
            </div>
            <div class="recipe_nutrition">
                <p class="nutrition_info">per <b>1 serving</b><br>/ 3.5 oz of protein</p>
                <p><span class="highlight_c">c</span> ~142 kal</p>
                <p><span class="highlight_p">p</span> ~22 g</p>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="recipe_nav">
            <span class="recipe_tab active" data-target="ingredients">ingredients</span>
            <span class="recipe_tab" data-target="steps">step by step</span>
            <span class="recipe_tab" data-target="nutrition">nutrient profile</span>
        </div>

        <!-- Tab Content Sections -->
        <div id="ingredients" class="tab_content active">
            <table>
                <thead>
                    <tr>
                        <th>ingredients</th>
                        <th>calories</th>
                        <th>protein</th>
                        <th>fat</th>
                        <th>net carbs</th>
                        <th style="text-align:left;">sugar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>7 oz shrimp</td>
                        <td>210 kal</td>
                        <td>21g</td>
                        <td>3.43g</td>
                        <td>1.6g</td>
                        <td>
                            <div style="display:flex;justify-content:space-between;">
                                <span>0g</span>
                                    <div class="three-dots-wrapper">
                                        <i class="fa fa-ellipsis-h action-three-dots-icon" onclick="actionToggleDropdown()"></i>
                                        <div class="action-popup" id="actionPopUp">
                                            <button class="action-btn">edit</button>
                                            <button class="action-btn">swap</button>
                                            <button class="action-btn">delete</button>
                                        </div>
                                    </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="steps" class="tab_content">
            <p>1. Heat a pan and cook shrimp for 3-5 minutes.<br>
            2. Add mixed greens, tomatoes, and cooked shrimp to a bowl.<br>
            3. Toss with your favorite dressing.<br>
            4. Serve and enjoy!</p>
        </div>

        <div id="nutrition" class="tab_content">
            <p>Calories: 142 kcal<br>
            Protein: 22g<br>
            Fat: 3.43g<br>
            Carbs: 1.6g<br>
            Sugar: 0g</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll('.recipe_tab');
            const tabContents = document.querySelectorAll('.tab_content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');

                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    this.classList.add('active');
                    document.getElementById(target).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>


<script>
    function actionToggleDropdown() {
            const actionPopUp = document.getElementById('actionPopUp');
            actionPopUp.style.display = actionPopUp.style.display === 'flex' ? 'none' : 'flex';
        }

        // Close the actionPopUp if the user clicks outside
        window.addEventListener('click', function(event) {
            const actionPopUp = document.getElementById('actionPopUp');
            const icon = document.querySelector('.three-dots-icon');

            // Check if the click is outside the actionPopUp and the three-dot icon
            if (actionPopUp.style.display === 'flex' && !actionPopUp.contains(event.target) && !icon.contains(event.target)) {
                actionPopUp.style.display = 'none';
            }
        });
</script>