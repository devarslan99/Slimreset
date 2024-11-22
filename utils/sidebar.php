<style>
    .sidebar-entery-btn
    {
        width: 100%;
        padding: 12px 20px;
        text-align: left;
        font-size: 14px;
        background-color: transparent;
        border: none;
        color: #ffff;
        text-transform: capitalize;
    }
    .entery-plus-icon
    {
        font-size:18px;
        margin-right:10px;
    }
    .sidebar-entery-btn:hover {
        background-color: #374462;
    }
    .entery-btn-menu-list {
        height: 0;
        overflow: hidden;
        transition: 0.3s;
    }
    .entery-btn-menu-list.active {
        height: auto;
        transition: 0.3s;
    }

    .entery-btn-menu-list li:hover
    {
        background-color: #374462;
    }

    .txt-li {
        padding:12px 20px;
    }

    .meal-btn i,
    .food-btn {
        vertical-align: middle;
        color: rgba(155, 155, 155, 0.8);
        font-weight: 500;
    }

    .meal-entery-menu-list {
        height: 0;
        transition: 0.3s;
        overflow: hidden;
    }

    .meal-entery-menu-list.active {
        height: auto;
        transition: 0.3s;
        border-bottom: 2px solid #374462;
    }

    .food-entry-menu-list {
        height: 0;
        transition: 0.3s;
        overflow: hidden;
    }

    .food-entry-menu-list.active {
        height: auto;
        transition: 0.3s;
        border-bottom: 2px solid #374462;
    }
</style>
<div class="sidebar-wrapper d-block d-lg-none" data-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="../dashboard/dashboard.php">
                <img class="img-fluid" src="../assets/images/logo/logo.png" alt="" style="width:150px;">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar">
                <svg class="stroke-icon sidebar-toggle status_toggle middle">
                    <use href="../assets/svg/icon-sprite.svg#toggle-icon"></use>
                </svg>
                <svg class="fill-icon sidebar-toggle status_toggle middle">
                    <use href="../assets/svg/icon-sprite.svg#fill-toggle-icon"></use>
                </svg>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="../dashboard/dashboard.php">
                <img class="img-fluid" src="../assets/images/favicon.ico" style="width:20px;" alt="">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="pin-title sidebar-main-title">
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link" href="../dashboard/dashboard.php">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="../assets/svg/icon-sprite.svg#fill-home"></use>
                            </svg>
                            <span class="lan-3">Dashboard </span>
                        </a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-8">Applications</h6>
                        </div>
                    </li>
                    <?php
                    $role = $_SESSION['role'];
                    if ($role == "admin") {
                    ?>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../users/create.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>Add User </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../users/view.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>View Users </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../coach/assign.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>Assign Coach</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../coach/view.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>View Coach</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../food_category/create.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>Add Food Category </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../food_category/view.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>View Food Category </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../food_recommendation/create.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>Add Food Recommendation </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../food_recommendation/view.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>View Food Recommendation </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link" href="../functions/logout.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-layout"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-layout"></use>
                                </svg>
                                <span>Logout </span>
                            </a>
                        </li>
                    <?php
                    } else if ($role == "client") {
                    ?>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../clients/summary.php?id=<?php echo $_SESSION['user_id'] ?>">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>My Profile </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <ul>
                                <li>
                                    <button class="sidebar-entery-btn">
                                        <span class='entery-plus-icon'><i class="fa fa-plus" aria-hidden="true"></i></span> new entry
                                    </button>
                                    <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
                                    <ul class="entery-btn-menu-list">
                                        <li><a class="dropdown-item text-white" href="#" onclick="openWeightModal('weightModal')">Weight</a></li>
                                        <li class="text-white txt-li meal-btn d-flex justify-content-between">
                                            Meal <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </li>
                                        <ul class="meal-entery-menu-list">
                                            <li class="link text-white txt-li food-btn d-flex justify-content-between">Food <i class="fa fa-angle-right" aria-hidden="true"></i>                                            </li>
                                                <ul class="food-entry-menu-list">
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openModal('Breakfast')">Breakfast</a></li>
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openModal('Lunch')">Lunch</a></li>
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openModal('Dinner')">Dinner</a></li>
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openModal('Snacks')">Snacks</a></li>
                                                </ul>
                                            
                                            <li><a class="dropdown-item text-white" href="#" onclick="openWaterModal('waterModal')">Water</a></li>
                                        </ul>
                                        
                                        <li><a class="dropdown-item text-white" href="#" onclick="openBowelMovementsModal('bowelMovementsModal')">Bowel</a></li>
                                        <li class="link text-white txt-li">Activity</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php
                    } else if ($role == "coach") {
                    ?>
                        <li class="sidebar-list">
                            <a class="sidebar-link" href="../clients/invite_clients.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-layout"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-layout"></use>
                                </svg>
                                <span>Invite Clients </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title" href="../clients/view.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-user"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-user"></use>
                                </svg>
                                <span>My Clients </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link" href="../functions/logout.php">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-layout"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="../assets/svg/icon-sprite.svg#fill-layout"></use>
                                </svg>
                                <span>Logout </span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <ul>
                                <li>
                                    <button class="sidebar-entery-btn">
                                        <span class='entery-plus-icon'><i class="fa fa-plus" aria-hidden="true"></i></span> new entry
                                    </button>
                                    <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
                                    <ul class="entery-btn-menu-list">
                                        <li><a class="dropdown-item text-white" href="#" onclick="openWeightModal('weightModal')">Weight</a></li>
                                        <li class="text-white txt-li meal-btn d-flex justify-content-between">
                                            Meal <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </li>
                                        <ul class="meal-entery-menu-list">
                                            <li class="link text-white txt-li food-btn d-flex justify-content-between">Food <i class="fa fa-angle-right" aria-hidden="true"></i>                                            </li>
                                                <ul class="food-entry-menu-list">
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openModal('Breakfast')">Breakfast</a></li>
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openModal('Lunch')">Lunch</a></li>
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openModal('Dinner')">Dinner</a></li>
                                                    <li><a class="dropdown-item text-white" href="#" onclick="openModal('Snacks')">Snacks</a></li>
                                                </ul>
                                            
                                            <li><a class="dropdown-item text-white" href="#" onclick="openWaterModal('waterModal')">Water</a></li>
                                        </ul>
                                        
                                        <li><a class="dropdown-item text-white" href="#" onclick="openBowelMovementsModal('bowelMovementsModal')">Bowel</a></li>
                                        <li class="link text-white txt-li">Activity</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>

<script>

    
    const sidebarEnteryBtn = document.querySelector('.sidebar-entery-btn');
    const enteryBtnMenuList = document.querySelector('.entery-btn-menu-list');
    const MealBtn = document.querySelector('.meal-btn');
    const meal_menu_list = document.querySelector('.meal-entery-menu-list');
    const foodBtn = document.querySelector('.food-btn');
    const food_menu_list = document.querySelector('.food-entry-menu-list');
    const Meal_arrow_icon = document.querySelector('.meal-btn i');
    const Food_arrow_icon = document.querySelector('.food-btn i');

    // entery btn toggle to show entery menu list
    sidebarEnteryBtn.addEventListener('click',(e)=>{
        e.target.style.backgroundColor  = '#374462'
        enteryBtnMenuList.classList.toggle('active')
        meal_menu_list.classList.remove('active')
        food_menu_list.classList.remove('active')
         Meal_arrow_icon.style.transform  = ''
    })

     // Meal toogle to show meal menu list
    MealBtn.addEventListener('click',(e)=>{
        e.target.style.backgroundColor  = '#374462'
        foodBtn.style.backgroundColor  = ''
        Meal_arrow_icon.style.color  = '#fff'
        Meal_arrow_icon.style.transform  = 'rotate(90deg)'
        Food_arrow_icon.style.transform  = ''
        meal_menu_list.classList.toggle('active')
        food_menu_list.classList.remove('active')
    })

    // food toogle to show food menu list
    foodBtn.addEventListener('click',(e)=>{
        e.target.style.backgroundColor  = '#374462'
        MealBtn.style.backgroundColor  = ''
        Food_arrow_icon.style.color  = '#fff'
        Food_arrow_icon.style.transform  = 'rotate(90deg)'
        meal_menu_list.style.border = 'none'
        food_menu_list.classList.toggle('active')
    })


</script>