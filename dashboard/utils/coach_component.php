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
            $progress = "<h3 style='color:grey;'>No Progress</h3>"; // Optional: Handle cases with no progress
        }
    }
}
?>

<div class="row">
    <div class="col-md-4">
        <div class="card p-5">
            <h4 class="text-center">Stalling: <?php echo $stalling_count; ?></h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-5">
            <h4 class="text-center">Losing: <?php echo $losing_count; ?></h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-5">
            <h4 class="text-center">New: <?php echo $new_count; ?></h4>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Clients List</h4>
            <span>List of all the Clients.</span>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                        <thead style="background-color:#FFF">
                            <tr role="row">
                                <th>Client</th>
                                <th>Progress</th>
                                <th>lbs/day</th>
                                <th>Weight</th>
                                <th>Goal</th>
                                <th>Lbs to goal</th>
                                <th>Days Left</th>
                                <th class="text-center" style="color:red;" data-bs-toggle="tooltip" data-bs-placement="top" title="Intolerances">i</th>
                                <th class="text-center" style="color:red;" data-bs-toggle="tooltip" data-bs-placement="top" title="Food Logs">fl</th>
                                <th class="text-center" style="color:purple;" data-bs-toggle="tooltip" data-bs-placement="top" title="Protein">p</th>
                                <th class="text-center" style="color:yellow;" data-bs-toggle="tooltip" data-bs-placement="top" title="Carbs">c</th>
                                <th class="text-center" style="color:blue;" data-bs-toggle="tooltip" data-bs-placement="top" title="Water">w</th>
                                <th class="text-center" style="color:purple;" data-bs-toggle="tooltip" data-bs-placement="top" title="Bowel Movements">b</th>
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
                                            $progress = "<h3 style='color:grey;'>No Progress</h3>"; // Optional: Handle cases with no progress
                                        }


                                        $bm_sql = "SELECT AVG(bowel_movement) as avg_bm FROM bowel_movements WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 4 DAY";
                                        $bm_result = mysqli_query($mysqli, $bm_sql);
                                        $avg_bm = mysqli_fetch_assoc($bm_result)['avg_bm'] ?? 0;

                                        if ($avg_bm > 1) {
                                            $bm_icon = '../assets/images/check.png';
                                        } else {
                                            $bm_icon = '../assets/images/warning_red.png';
                                        }

                                        $w_sql = "SELECT AVG(water) as avg_w FROM water_records WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 4 DAY";
                                        $w_result = mysqli_query($mysqli, $w_sql);
                                        $avg_w = mysqli_fetch_assoc($w_result)['avg_w'] ?? 0;

                                        if ($avg_w >= 9) {
                                            $w_icon = '../assets/images/check.png';
                                        } elseif ($avg_w >= 5 && $avg_w <= 8) {
                                            $w_icon = '../assets/images/warning_yellow.png';
                                        } else {
                                            $w_icon = '../assets/images/warning_red.png';
                                        }

                                        $c_sql = "SELECT AVG(calories) as avg_c FROM food_items WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 4 DAY";
                                        $c_result = mysqli_query($mysqli, $c_sql);
                                        $avg_c = mysqli_fetch_assoc($c_result)['avg_c'] ?? 0;

                                        if ($avg_c >= 700) {
                                            $c_icon = '../assets/images/check.png';
                                        } elseif ($avg_c >= 500 && $avg_c < 700) {
                                            $c_icon = '../assets/images/warning_yellow.png';
                                        } else {
                                            $c_icon = '../assets/images/warning_red.png';
                                        }


                                        $t_sql = "SELECT course_time,created_at FROM medical_intake WHERE user_id = '$user_id'";
                                        $t_result = mysqli_query($mysqli, $t_sql);
                                        if ($t_result && mysqli_num_rows($t_result) > 0) {
                                            $row_time = mysqli_fetch_assoc($t_result);
                                            $course_time = $row_time['course_time']; // This will be either 30 or 60
                                            $created_at = $row_time['created_at']; // This should be a timestamp in 'Y-m-d H:i:s' format

                                            // Convert created_at to a DateTime object
                                            $created_at_date = new DateTime($created_at);

                                            // Add the course time to the created date
                                            $expiration_date = $created_at_date->modify("+$course_time days");

                                            // Get the current date
                                            $current_date = new DateTime();

                                            // Calculate the difference between the current date and the expiration date
                                            $remaining_time = $current_date->diff($expiration_date);

                                            // Determine the remaining days
                                            if ($remaining_time->invert == 1) {
                                                $finalized_date = "Course Expired" . $remaining_time->days . " days ago.";
                                            } else {
                                                $finalized_date = $remaining_time->days . " Days Left.";
                                            }
                                        } else {
                                            echo "No records found.";
                                        }



                                        $fl_sql = "SELECT COUNT(*) as total_entries FROM food_items WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 4 DAY";
                                        $fl_result = mysqli_query($mysqli, $fl_sql);
                                        $avg_fl = mysqli_fetch_assoc($fl_result)['total_entries'] ?? 0;

                                        if ($avg_fl >= 4) {
                                            $fl_icon = '../assets/images/check.png';
                                        } elseif ($avg_fl < 4 && $avg_fl > 2) {
                                            $fl_icon = '../assets/images/warning_yellow.png';
                                        } else {
                                            $fl_icon = '../assets/images/warning_red.png';
                                        }

                                        $p_sql = "SELECT protein FROM food_items WHERE user_id = $user_id AND created_at >= NOW() - INTERVAL 4 DAY";
                                        $p_result = mysqli_query($mysqli, $p_sql);

                                        // Initialize total protein in ounces and count of entries
                                        $total_protein_oz = 0;
                                        $entry_count = 0;

                                        // Process each row to convert protein values to ounces
                                        while ($row_protein = mysqli_fetch_assoc($p_result)) {
                                            $protein_value = $row_protein['protein'];

                                            // Extract the numeric value and the unit (g or oz)
                                            preg_match('/(\d+)(g|oz)/i', $protein_value, $matches);
                                            if (count($matches) === 3) {
                                                $amount = (float) $matches[1]; // The numeric part
                                                $unit = strtolower($matches[2]); // The unit (g or oz)

                                                // Convert grams to ounces if necessary
                                                if ($unit === 'g') {
                                                    $amount_in_oz = $amount * 0.0353; // 1g = 0.0353oz
                                                } else {
                                                    $amount_in_oz = $amount; // Already in oz
                                                }

                                                // Add the converted amount to the total
                                                $total_protein_oz += $amount_in_oz;
                                                $entry_count++;
                                            }
                                        }

                                        // Calculate the average protein in ounces
                                        $avg_p = ($entry_count > 0) ? $total_protein_oz / $entry_count : 0;
                                        if ($avg_p >= 9) {
                                            $p_icon = '../assets/images/check.png';
                                        } elseif ($avg_p >= 7 && $avg_p < 9) {
                                            $p_icon = '../assets/images/warning_yellow.png';
                                        } else {
                                            $p_icon = '../assets/images/warning_red.png';
                                        }

                            ?>
                                        <tr role="row" class="odd cursor-pointer" id="customer_<?php echo $user_id; ?>" onclick="window.location.href='../clients/summary.php?id=<?php echo $row['id'] ?>'">
                                            <td>
                                                <?php
                                                if (empty($row['profile_image'])) {
                                                    echo '<img src="data:image/png;base64,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"
                                                            alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%;" />';
                                                } else {
                                                    echo '<img src="../uploads/' . $row['profile_image'] . '" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%;" />';
                                                }
                                                ?>
                                                <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                            </td>
                                            <td><?php echo $progress; ?></td>
                                            <td><?php echo $lbs_day; ?> Lbs</td>
                                            <td><?php echo $latest_weight; ?> Lbs</td>
                                            <td><?php echo $goal_weight; ?> Lbs</td>
                                            <td><?php echo $lbs_to_goal; ?> Lbs</td>
                                            <td><?php echo $finalized_date ?></td>
                                            <td><img src="<?php echo $fl_icon; ?>"></td>
                                            <td><img src="<?php echo $fl_icon; ?>"></td>
                                            <td><img src="<?php echo $p_icon; ?>"></td>
                                            <td><img src="<?php echo $c_icon; ?>"></td>
                                            <td><img src="<?php echo $w_icon; ?>"></td>
                                            <td><img src="<?php echo $bm_icon; ?>"></td>
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
            </div>
        </div>
    </div>
</div>