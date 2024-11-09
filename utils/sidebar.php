<div class="sidebar-wrapper d-block d-md-none" data-layout="stroke-svg">
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
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>