<style>
    .recipe_wrapper {
        width: 100%;
        min-height: 100vh;
        padding: 20px 40px;
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
        display: flex;
        gap: 20px;
    }

    .recipe_title {
        font-size: 24px;
        font-weight: bold;
        text-transform: lowercase;
        width: 120px;
    }

    .recipe_links {
        list-style-type: none;
        margin-top: 10px;
        font-size: 14px;
        color: #999;
        padding-left: 0;
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
        color: #946cfc;
        font-weight: bold;
    }

    .highlight_p {
        color: #946cfc;
        font-weight: bold;
    }

    /* Tabs */

    .recipe-tabs-navigation{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        gap: 20px;
    }

    .recipe-tab-item {
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        text-transform: lowercase;
        margin-bottom: 10px;
    }

    .recipe-tab-item.recipe-tab-selected {
        color: #946cfc;
    }

    /* Tab Content */
    .recipe-tab-content-section {
        display: none;
    }

    .recipe-tab-content-section.recipe-tab-content-visible {
        display: block;
    }

    /* ----------->>> */

    /* Table */
    #recipe-tab-ingredients { 
        overflow-x: auto;
    }
    .ingredientsTable {
        width: 100%;
        margin: auto;
        border-collapse: collapse;
        background-color: #fff;
        border-radius: 8px;
    }

    .ingredientsTable thead {
        background-color: #fff;
    }

    .ingredientsTable th, 
    .ingredientsTable td {
        padding: 16px;
        text-align: center;
        border-bottom: 2px solid #946cfc;
    }

    th {
        text-transform: lowercase;
        font-weight: bold;
    }

    .ingredientsTable tr:hover {
        background-color: #f9f9f9;
    }

    /* Responsive Design */
    @media (max-width: 450px) {
        .recipe_header {
            flex-direction: column;
            align-items: center;
        }

        .recipe_nutrition {
            text-align: center;
        }

        .recipe-tabs-navigation {
            flex-direction: column;
            align-items: center;
        }

        .ingredientsTable th, 
        .ingredientsTable td {
            font-size: 12px;
            padding: 8px;
        }
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
        color: #946cfc;
    }

    /* Phase Popup */
    .action-popup {
        position: absolute;
        right: 25px;
        background: linear-gradient(135deg, #9a50ff, #6f30ff);
        border-radius: 10px;
        padding: 15px;
        width: 100px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        z-index: 999;
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
        color: #946cfc;
        border-radius: 5px;
    }

    </style>
</head>
<body>
    <div class="recipe_wrapper">
        <!-- Header Section -->
        <div class="recipe_header">
            <div class="recipe_details">
                <img src="https://images.pexels.com/photos/257816/pexels-photo-257816.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Southwest Shrimp Salad" class="recipe_image">
                <div>
                    <h1 class="recipe_title">southwest shrimp salad</h1>
                    <ul class="recipe_links">
                        <li>+ recipe book</li>
                        <li>+ modify + save</li>
                        <li>+ grocery list</li>
                    </ul>
                </div>
            </div>
            <div class="recipe_nutrition">
                <p class="nutrition_info">per <b>1 serving</b><br>/ 3.5 oz of protein</p>
                <p><span class="highlight_c">c</span> ~142 kal</p>
                <p><span class="highlight_p">p</span> ~22 g</p>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="recipe-tabs-navigation">
            <span class="recipe-tab-item recipe-tab-selected" data-target="recipe-tab-ingredients">Ingredients</span>
            <span class="recipe-tab-item" data-target="recipe-tab-steps">Step by Step</span>
            <span class="recipe-tab-item" data-target="recipe-tab-nutrition">Nutrition Profile</span>
        </div>

        <!-- Ingredients Tab Content Sections -->
        <div  id="recipe-tab-ingredients" class="recipe-tab-content-section recipe-tab-content-visible">
            <table class="ingredientsTable">
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
                            <div style="display:flex;gap:10px;justify-content:space-between;align-items:center;">
                                <span>0g</span>
                                    <div class="three-dots-wrapper">
                                        <i class="fa fa-ellipsis-h action-three-dots-icon" onclick="actionToggleDropdown()"></i>
                                        <div class="action-popup" id="actionPopUp">
                                            <button class="action-btn" id="editBtn">edit</button>
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

        <!-- Step By step Tab Content Section -->
        <div id="recipe-tab-steps" class="recipe-tab-content-section">
            <p>1. Heat a pan and cook shrimp for 3-5 minutes.<br>
            2. Add mixed greens, tomatoes, and cooked shrimp to a bowl.<br>
            3. Toss with your favorite dressing.<br>
            4. Serve and enjoy!</p>
        </div>

        <!-- Nutrition Profile Tab Content Section -->
        <div id="recipe-tab-nutrition" class="recipe-tab-content-section">
           <?php include 'nutrition_component.php' ?>
        </div>
    </div>

    <!-- scripit for tabs and Sections  -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll('.recipe-tab-item');
            const tabContents = document.querySelectorAll('.recipe-tab-content-section');

            // Check localStorage for the saved tab or default to the first tab
            const savedTab = localStorage.getItem('selectedRecipeTab') || 'recipe-tab-ingredients';

            // Initialize tabs based on saved state or default
            tabs.forEach(tab => {
                const target = tab.getAttribute('data-target');
                if (target === savedTab) {
                    tab.classList.add('recipe-tab-selected');
                    document.getElementById(target).classList.add('recipe-tab-content-visible');
                } else {
                    tab.classList.remove('recipe-tab-selected');
                    document.getElementById(target).classList.remove('recipe-tab-content-visible');
                }
            });

            // Tab click event listener
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');

                    // Reset all tabs and contents
                    tabs.forEach(t => t.classList.remove('recipe-tab-selected'));
                    tabContents.forEach(content => content.classList.remove('recipe-tab-content-visible'));

                    // Activate clicked tab and corresponding content
                    this.classList.add('recipe-tab-selected');
                    document.getElementById(target).classList.add('recipe-tab-content-visible');

                    // Save the selected tab to localStorage
                    localStorage.setItem('selectedRecipeTab', target);
                });
            });
        });
    </script>
</body>
</html>


    <!-- script for toggle action button -->
    <script>
        function actionToggleDropdown() {
            const actionPopUp = document.getElementById('actionPopUp');
            actionPopUp.style.display = actionPopUp.style.display === 'flex' ? 'none' : 'flex';
        }

        // Close the actionPopUp if the user clicks outside
        window.addEventListener('click', function (event) {
            const actionPopUp = document.getElementById('actionPopUp');
            const icon = document.querySelector('.action-three-dots-icon');

            if (
                actionPopUp.style.display === 'flex' && 
                !actionPopUp.contains(event.target) && 
                !icon.contains(event.target)
            ) {
                actionPopUp.style.display = 'none';
            }
        });

        // Close the popup when an action is clicked
        document.querySelectorAll('.action-btn').forEach(button => {
            button.addEventListener('click', function () {
                const actionPopUp = document.getElementById('actionPopUp');
                actionPopUp.style.display = 'none';
            });
        });
    </script>