<style>
    /* Container for the switch */
.toggle-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin: 20px;
}

/* Label Styling */
.switch-label {
    font-size: 16px;
    font-weight: bold;
    color: #555;
}

/* Switch Styling */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 30px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #4caf50;
}

input:checked + .slider:before {
    transform: translateX(30px);
}

</style>
<?php
include_once '../database/db_connection.php';
$new_count = 0;
$stalling_count = 0;
$losing_count = 0;

$coach_id = $_SESSION['user_id'];
$sql = "SELECT id, first_name, last_name, profile_image,created_at FROM users WHERE role = 'client'";
$result = mysqli_query($mysqli, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['id'];
        $weight_sql = "SELECT weight, created_at FROM weight_records WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 2";
        $weight_result = mysqli_query($mysqli, $weight_sql);
        $weights = mysqli_fetch_all($weight_result, MYSQLI_ASSOC);

        $latest_weight = $weights[0]['weight'] ?? null;
        $previous_weight = $weights[1]['weight'] ?? null;
        $lbs_day = ($latest_weight && $previous_weight) ? round($latest_weight - $previous_weight, 2) : 0;

        // Fetch goal weight
        $goal_sql = "SELECT goal_weight FROM medical_intake WHERE user_id = $user_id";
        $goal_result = mysqli_query($mysqli, $goal_sql);
        $goal_weight = mysqli_fetch_assoc($goal_result)['goal_weight'] ?? null;

        // Calculate lbs to goal
        $lbs_to_goal = ($latest_weight && $goal_weight) ? round($latest_weight - $goal_weight, 2) : null;

        // Determine Progress and increment counts
        if ($lbs_day < 0.5 && $row['created_at'] && strtotime($row['created_at']) >= strtotime('+2 days')) {
            $stalling_count++;
        } elseif ($lbs_day > 0.5) {
            $losing_count++;
        } elseif ($lbs_day < 0.5 && $row['created_at'] && strtotime($row['created_at']) >= strtotime('-2 days')) {
            $new_count++;
        } else {
            $progress = "<h3 style='color:grey;'>No Progress</h3>";
        }
    }
}
?>


<style>
        /* Header Counters */
        .header-stats {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin: 20px 0;
            gap: 15px;
        }

        .stat-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            width: 200px;
            text-align: center;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px;
            min-width: 120px;
            color: #fff
        }

        .stat-box h2 {
            margin: 0;
            font-size: 26px;
            color: #fff;
            font-weight: bold;
        }

        .stat-box span {
            font-size: 16px;
            font-weight: 700;
        }

        .purple { background-color: #a36cf9; }
        .green { background-color: #2ecc71; }
        .red { background-color: #e74c3c; }
        .orange { background-color: #f39c12; }

        /* Filters */
        .filter-section {
            text-align: center;
            margin: 20px;
        }

        .filterTxt {
            font-size: 14px;
            font-weight: 700;
        }

        .filter-btn, .coach-filter-btn {
            background: none;
            border: none;
            color: #999;
            font-weight: bold;
            margin: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .purple-btn { color: #a36cf9; font-size: 18px; }
        .green-btn{ color: #2ecc71;  font-size: 18px;}
        .red-btn { color: #e74c3c; font-size: 18px; }
        .orange-btn { color: #f39c12; font-size: 18px; }

        /* Table */
        .client-table {
            width: 90%;
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

        .status {
            font-weight: bold;
        }

        .status.losing { color: #2ecc71; }
        .status.stall { color: #e74c3c; }

        /* Insights Icons */
        .insights {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            gap: 8px;
            margin: 0;
        }

        .insights span{
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            background: #2ecc71;
            margin-bottom: 5px;
        }

        .action-icons {
            font-size: 22px;
            color: #a36cf9;
        }

        .action-icons i {
            cursor: pointer;
        }

        .action-icons .fa-search {
            transform: rotate(90deg);
        }

        .clientName:hover    {
            color: #a36cf9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-stats {
                flex-wrap: wrap;
            }

            .stat-box {
                width: 45%;
                margin-bottom: 10px;
            }

            .client-table {
                width: 100%;
            }
        }

        .coach-filter-btn.active {
            border-bottom: 2px solid currentColor;
            font-weight: bold;
        }

        .coach-filter-btn {
            border-bottom: none;
        }
        
</style>

    <!-- Header Stats for Coaching -->
    <div id="coachingHeaderComponent" style="display:none;">
        <div class="header-stats">
            <div class="stat-box purple">
                <span>not started</span>
                <h2><?php echo $new_count; ?></h2>
            </div>
            <div class="stat-box green">
                <span>losing</span>
                <h2><?php echo $losing_count; ?></h2>
            </div>
            <div class="stat-box red">
                <span>stalls</span>
                <h2><?php echo $stalling_count; ?></h2>
            </div>
            <div class="stat-box orange">
                <span>paused</span>
                <h2>23</h2>
            </div>
        </div>
    </div>

        <!-- Header Stats for OnBoarding -->
    <div id="onBoardingHeaderComponent">
        <div class="header-stats">
            <div class="stat-box purple">
                <span>intakes</span>
                <h2>23</h2>
            </div>
            <div class="stat-box green">
                <span>pharmacy</span>
                <h2>23</h2>
            </div>
            <div class="stat-box red">
                <span>in delivery</span>
                <h2>23</h2>
            </div>
            <div class="stat-box orange">
                <span>paused</span>
                <h2>23</h2>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-center">
        <h2 style="margin-top: 40px;">
            client dashboard
        </h2>
    </div>

    <div class="d-flex justify-content-center align-items-center my-4">
        <label class="form-label me-2 fs-6 responsive-font" id="onboardingLabel">onboarding</label>
        <div class="form-check form-switch">
            <input class="form-check-input custom-switch" type="checkbox" id="coachingTab" role="switch">
            <label class="form-label ms-2 fs-6 responsive-font" id="coachingLabel">coaching</label>
        </div>
    </div>

       

    <!-- Coaching Section -->
    <div id="coachingTabComponent" style="display:none;">

            <!-- Filters -->
        <div class="filter-section">
            <span class="filterTxt">filter</span>
            <button class="coach-filter-btn purple-btn active">not started</button>
            <button class="coach-filter-btn green-btn">losing</button>
            <button class="coach-filter-btn red-btn">stalls</button>
            <button class="coach-filter-btn orange-btn">paused</button>
        </div>

        <table class="client-table clientTabeFilterData">
            <thead>
                <tr>
                    <th>name</th>
                    <th>status</th>
                    <th>lost today</th>
                    <th>weight</th>
                    <th>goal</th>
                    <th>days left</th>
                    <th>3 day insights</th>
                </tr>
            </thead>
            <tbody>
                        <?php
                        include_once '../database/db_connection.php';

                        // Fetch clients
                        $coach_id = $_SESSION['user_id'];
                        $client_ids = [];

                        // Step 1: Get all client IDs for the given coach
                        $query = "SELECT client_id FROM client_coach_assignments WHERE coach_id = ?";
                        $stmt = $mysqli->prepare($query);
                        $stmt->bind_param("i", $coach_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            $client_ids[] = $row['client_id'];
                        }
                        if (!empty($client_ids)) {
                            $client_ids_str = implode(",", $client_ids);
                            $sql = "SELECT id, first_name, last_name, profile_image, created_at FROM users WHERE id IN ($client_ids_str)";
                            $result = mysqli_query($mysqli, $sql);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $user_id = $row['id'];
                                    // Fetch latest weight and goal weight
                                    $weight_sql = "SELECT weight, created_at FROM weight_records WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 2";
                                    $weight_result = mysqli_query($mysqli, $weight_sql);
                                    $weights = mysqli_fetch_all($weight_result, MYSQLI_ASSOC);

                                    $latest_weight = $weights[0]['weight'] ?? null;
                                    $previous_weight = $weights[1]['weight'] ?? null;
                                    $lbs_day = ($latest_weight && $previous_weight) ? round($latest_weight - $previous_weight, 2) : 0;

                                    // Fetch goal weight
                                    $goal_sql = "SELECT goal_weight FROM medical_intake WHERE user_id = $user_id";
                                    $goal_result = mysqli_query($mysqli, $goal_sql);
                                    $goal_weight = mysqli_fetch_assoc($goal_result)['goal_weight'] ?? null;

                                    // Calculate lbs to goal
                                    $lbs_to_goal = ($latest_weight && $goal_weight) ? round($latest_weight - $goal_weight, 2) : null;

                                    // Determine Progress and increment counts
                                    if ($lbs_day < 0.5 && $row['created_at'] && strtotime($row['created_at']) >= strtotime('+2 days')) {
                                        $progress = "<h3 style='color:red;'>Stalling</h3>";
                                        $stalling_count++;
                                    } elseif ($lbs_day > 0.5) {
                                        $progress = "<h3 style='color:green;'>Losing</h3>";
                                        $losing_count++;
                                    } elseif ($lbs_day < 0.5 && $row['created_at'] && strtotime($row['created_at']) >= strtotime('-2 days')) {
                                        $progress = "<h3 style='color:purple;'>New</h3>";
                                        $new_count++;
                                    } else {
                                        $progress = "<h3 style='color:grey;'>No Progress</h3>";
                                    }


                                    $bm_sql = "SELECT AVG(bowel_movement) as avg_bm FROM bowel_movements WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 4 DAY";
                                    $bm_result = mysqli_query($mysqli, $bm_sql);
                                    $avg_bm = mysqli_fetch_assoc($bm_result)['avg_bm'] ?? 0;


                                    $p_sql = "SELECT protein FROM food_items WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 4 DAY";
                                    $p_result = mysqli_query($mysqli, $p_sql);

                                    // Initialize total protein in ounces and count of entries
                                    $total_protein_oz = 0;
                                    $entry_count = 0;

                                    // Updating icons or text color as a indicator   
                                    $c_sql = "SELECT AVG(calories) as avg_calories FROM food_items WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 3 DAY";
                                        $c_result = mysqli_query($mysqli, $c_sql);
                                        $avg_calories = mysqli_fetch_assoc($c_result)['avg_calories'] ?? null;

                                        if ($avg_calories === null) {
                                            $c_status = "<span style='background-color:gray;'>c</span>"; 
                                        } elseif ($avg_calories >= 500 && $avg_calories <= 700) {
                                            $c_status = "<span style='background-color:green;'>c</span>"; 
                                        } else {
                                            $c_status = "<span style='background-color:red;'>c</span>"; 
                                        }

                                        // Protein (p)
                                        $p_sql = "SELECT protein FROM food_items WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 3 DAY";
                                        $p_result = mysqli_query($mysqli, $p_sql);
                                        $total_protein_oz = 0;
                                        $p_entry_count = 0;

                                        // Convert protein to ounces and calculate average
                                        while ($row_protein = mysqli_fetch_assoc($p_result)) {
                                            preg_match('/(\d+)(g|oz)/i', $row_protein['protein'], $matches);
                                            if (count($matches) === 3) {
                                                $amount = (float)$matches[1];
                                                $unit = strtolower($matches[2]);
                                                $total_protein_oz += ($unit === 'g') ? $amount * 0.0353 : $amount;
                                                $p_entry_count++;
                                            }
                                        }
                                        $avg_protein_oz = ($p_entry_count > 0) ? $total_protein_oz / $p_entry_count : 0;

                                        if ($avg_protein_oz === 0) {
                                            $p_status = "<span style='background-color:gray;'>p</span>"; 
                                        } elseif ($avg_protein_oz >= 9) {
                                            $p_status = "<span style='background-color:green;'>p</span>"; 
                                        } elseif ($avg_protein_oz >= 7) {
                                            $p_status = "<span style='background-color:orange;'>p</span>"; 
                                        } else {
                                            $p_status = "<span style='background-color:red;'>p</span>"; 
                                        }

                                        // Water (w)
                                        $w_sql = "SELECT AVG(water) as avg_water FROM water_records WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 3 DAY";
                                        $w_result = mysqli_query($mysqli, $w_sql);
                                        $avg_water = mysqli_fetch_assoc($w_result)['avg_water'] ?? null;

                                        if ($avg_water === null) {
                                            $w_status = "<span style='background-color:gray;'>w</span>";
                                        } elseif ($avg_water >= 9) {
                                            $w_status = "<span style='background-color:green;'>w</span>"; 
                                        } elseif ($avg_water >= 5) {
                                            $w_status = "<span style='background-color:orange;'>w</span>"; 
                                        } else {
                                            $w_status = "<span style='background-color:red;'>w</span>"; 
                                        }

                                        // Bowel Movements (b)
                                        $bm_sql = "SELECT AVG(bowel_movement) as avg_bm FROM bowel_movements WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 3 DAY";
                                        $bm_result = mysqli_query($mysqli, $bm_sql);
                                        $avg_bm = mysqli_fetch_assoc($bm_result)['avg_bm'] ?? 0;

                                        if ($avg_bm === null) {
                                            $b_status = "<span style='background-color:gray;'>b</span>";
                                        } elseif ($avg_bm > 1) {
                                            $b_status = "<span style='background-color:green;'>b</span>";
                                        } else {
                                            $b_status = "<span style='background-color:red;'>b</span>";
                                        }

                                        // Food Logs (k)
                                        $fl_sql = "SELECT COUNT(*) as food_entries FROM food_items WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 3 DAY";
                                        $fl_result = mysqli_query($mysqli, $fl_sql);
                                        $food_entries = mysqli_fetch_assoc($fl_result)['food_entries'] ?? 0;

                                        if ($food_entries === 0) {
                                            $k_status = "<span style='background-color:gray;'>k</span>";
                                        } elseif ($food_entries >= 4) {
                                            $k_status = "<span style='background-color:green;'>k</span>"; 
                                        } elseif ($food_entries >= 2) {
                                            $k_status = "<span style='background-color:orange;'>k</span>"; 
                                        } else {
                                            $k_status = "<span style='background-color:red;'>k</span>";
                                        }

                        ?>
                                    <tr>
                                        <td  role="row" class="odd cursor-pointer clientName" id="customer_<?php echo $user_id; ?>" onclick="window.location.href='../clients/summary.php?id=<?php echo $row['id'] ?>'">
                                            <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                        </td>
                                        <td><?php echo $progress; ?></td>
                                        <td><?php echo $lbs_day; ?> Lbs</td>
                                        <td><?php echo $latest_weight; ?> Lbs</td>
                                        <td><?php echo $goal_weight; ?> Lbs</td>
                                        <td><?php echo $lbs_to_goal; ?> Lbs</td>
                                        <td >
                                            <div class="insights">
                                                <div>
                                                    <?php echo $c_status; ?>
                                                    <?php echo $k_status; ?>
                                                    <?php echo $p_status; ?>
                                                    <?php echo $w_status; ?>
                                                    <?php echo $b_status; ?>
                                                </div>
                                                <div class="d-flex gap-4 action-icons">
                                                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                                    <i class="fa fa-search"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        }
                        // Free result set
                        mysqli_free_result($result);
                        // Close connection
                        mysqli_close($mysqli);
                        ?>
            </tbody>
        </table>
    </div>
    
    <!-- OnBoarding Section -->
    <div id="onBoardingTabComponent">
        
        <!-- Filters -->
        <div class="filter-section">
            <span class="filterTxt">filter</span>
            <button class="filter-btn purple-btn active">intakes</button>
            <button class="filter-btn green-btn">pharmacy</button>
            <button class="filter-btn red-btn">in delivery</button>
            <button class="filter-btn orange-btn">paused</button>
        </div>

        <table class="client-table">
            <thead>
                <tr>
                    <th>name</th>
                    <th>journey</th>
                    <th>order date</th>
                    <th>product</th>
                    <th>gut analysis</th>
                    <th>status</th>
                    <th>days left</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>tim lee</td>
                    <td>30 day</td>
                    <td>jan 1 2025</td>
                    <td>pharmacy</td>
                    <td>in transit</td>
                    <td>losing</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-evenly gap-3">
                            <div>
                                <span>23 days</span>
                            </div>
                            <div class="d-flex gap-4 action-icons">
                                <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>tim lee</td>
                    <td>30 day</td>
                    <td>jan 1 2025</td>
                    <td>pharmacy</td>
                    <td>in transit</td>
                    <td>losing</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-evenly gap-3">
                            <div>
                                <span>23 days</span>
                            </div>
                            <div class="d-flex gap-4 action-icons">
                                <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>tim lee</td>
                    <td>30 day</td>
                    <td>jan 1 2025</td>
                    <td>pharmacy</td>
                    <td>in transit</td>
                    <td>losing</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-evenly gap-3">
                            <div>
                                <span>23 days</span>
                            </div>
                            <div class="d-flex gap-4 action-icons">
                                <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>tim lee</td>
                    <td>30 day</td>
                    <td>jan 1 2025</td>
                    <td>pharmacy</td>
                    <td>in transit</td>
                    <td>losing</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-evenly gap-3">
                            <div>
                                <span>23 days</span>
                            </div>
                            <div class="d-flex gap-4 action-icons">
                                <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
                
        </table>
    </div>


    <!-- Script to switch onboaring to Coaching -->
    <script>
        const coachingTab = document.getElementById('coachingTab');

        const onboardingSection = document.getElementById('onBoardingTabComponent');
        const coachingSection = document.getElementById('coachingTabComponent');

        const onBoardingHeaderComponent = document.getElementById('onBoardingHeaderComponent');
        const coachingHeaderComponent = document.getElementById('coachingHeaderComponent');

        const coachingLabel = document.getElementById('coachingLabel');
        const onboardingLabel = document.getElementById('onboardingLabel');

        // Function to update sections based on toggle state
        function updateSections() {
            if (coachingTab.checked) {
                coachingLabel.style.fontWeight = 800;
                onboardingLabel.style.fontWeight = 'normal'; 
                coachingSection.style.display = 'block'; 
                onboardingSection.style.display = 'none';
                coachingHeaderComponent.style.display = 'block'; 
                onBoardingHeaderComponent.style.display = 'none';
            } else {
                onboardingLabel.style.fontWeight = 'bold';
                coachingLabel.style.fontWeight = 'normal';
                onboardingSection.style.display = 'block';
                coachingSection.style.display = 'none'; 
                onBoardingHeaderComponent.style.display = 'block';
                coachingHeaderComponent.style.display = 'none'; 
            }
        }

        // Save toggle state to localStorage
        coachingTab.addEventListener('change', function () {
            localStorage.setItem('coachingTabChecked', coachingTab.checked);
            updateSections(); 
        });

        // Initialize toggle state from localStorage on page load
        document.addEventListener('DOMContentLoaded', function () {
            const savedState = localStorage.getItem('coachingTabChecked');
            coachingTab.checked = savedState === 'true'; 
            updateSections();
        });
    </script>

    <!-- Script for filter coaching Table Data -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Filter buttons
            const filterButtons = document.querySelectorAll('.coach-filter-btn');
            const tableRows = document.querySelectorAll('.clientTabeFilterData tbody tr');

            // Function to filter rows
            function filterTable(status) {
                tableRows.forEach(row => {
                    const statusCell = row.querySelector('td:nth-child(2)');
                    if (status === 'all' || (statusCell && statusCell.innerText.toLowerCase().includes(status))) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Add event listeners to buttons
            filterButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to the clicked button
                    event.target.classList.add('active');

                    // Get the filter type from button's class
                    if (button.classList.contains('purple-btn')) {
                        filterTable('not started');
                    } else if (button.classList.contains('green-btn')) {
                        filterTable('losing');
                    } else if (button.classList.contains('red-btn')) {
                        filterTable('stall');
                    } else if (button.classList.contains('orange-btn')) {
                        filterTable('paused');
                    }
                });
            });

            // Default behavior: show all rows and no active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            filterTable('all');

            const resetBtn = document.querySelector('.filterTxt')
            resetBtn.addEventListener('click',()=>{
                filterButtons.forEach(btn => btn.classList.remove('active'));
                filterTable('all');
                resetBtn.style.cursor = 'pointer'
            })
        });
    </script>
