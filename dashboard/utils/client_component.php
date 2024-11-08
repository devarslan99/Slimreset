<div class="row">
    <div class="col-md-8">
        <div class="row" style="margin-top:20px;">
            <?php
            $user_id = $_SESSION['user_id'];
            include_once '../database/db_connection.php';
            $total_calories = 0;
            function formatValue($value)
            {
                if (is_numeric($value)) {
                    if (floor($value) == $value) {
                        return number_format($value, 0);
                    } else {
                        return number_format($value, 2);
                    }
                }
                return $value;
            }
            $selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
            function displayFoodItems($mealType, $selected_date)
            {
                global $mysqli, $user_id, $total_calories;
                $sql = "SELECT * FROM food_items WHERE user_id = '$user_id' AND type = '$mealType' AND created_at = '$selected_date'";
                $result = mysqli_query($mysqli, $sql);
                $serial_number = 1;

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $total_calories += floatval($row['calories']);
            ?>
                        <tr role="row" class="odd" id="customer_<?php echo $row['id']; ?>">
                            <td><?php echo $serial_number; ?></td>
                            <td><?php echo $row['label']; ?></td>
                            <td><?php echo formatValue($row['amount']) . ' ' . $row['unit']; ?></td>
                            <td><?php echo formatValue($row['calories']) . ' Kal'; ?></td>
                            <td><?php echo formatValue($row['protein']); ?></td>
                            <td><?php echo formatValue($row['totalFat']); ?></td>
                            <td><?php echo formatValue($row['carbs']); ?></td>
                            <td><?php echo formatValue($row['sugars']); ?></td>
                            <td>
                                <ul class="action">
                                    <li class='delete'><a href="#" data-food-id="<?php echo $row['id']; ?>"><i class='icon-trash'></i></a></li>
                                </ul>
                            </td>
                        </tr>
            <?php
                        $serial_number++;
                    }
                }
                mysqli_free_result($result);
            }
            $prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
            $next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));
            ?>

            <!-- Display Breakfast -->
            <div class="col-md-12">
                <h2>Breakfast</h2>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive theme-scrollbar">
                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                <table class="display dataTable no-footer" id="basic-1" role="grid">
                                    <thead>
                                        <th>#</th>
                                        <th>Food Name</th>
                                        <th>Food Quantity</th>
                                        <th>Calories</th>
                                        <th>Protein</th>
                                        <th>Fat</th>
                                        <th>Carbs</th>
                                        <th>Sugar</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php displayFoodItems('breakfast', $selected_date); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display Lunch -->
            <div class="col-md-12">
                <h2>Lunch</h2>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive theme-scrollbar">
                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                <table class="display dataTable no-footer" id="basic-1" role="grid">
                                    <thead>
                                        <th>#</th>
                                        <th>Food Name</th>
                                        <th>Food Quantity</th>
                                        <th>Calories</th>
                                        <th>Protein</th>
                                        <th>Fat</th>
                                        <th>Carbs</th>
                                        <th>Sugar</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php displayFoodItems('lunch', $selected_date); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display Dinner -->
            <div class="col-md-12">
                <h2>Dinner</h2>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive theme-scrollbar">
                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                <table class="display dataTable no-footer" id="basic-1" role="grid">
                                    <thead>
                                        <th>#</th>
                                        <th>Food Name</th>
                                        <th>Food Quantity</th>
                                        <th>Calories</th>
                                        <th>Protien</th>
                                        <th>Fat</th>
                                        <th>Carbs</th>
                                        <th>Sugar</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php displayFoodItems('dinner', $selected_date); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display Snacks -->
            <div class="col-md-12">
                <h2>Snacks</h2>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive theme-scrollbar">
                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                <table class="display dataTable no-footer" id="basic-1" role="grid">
                                    <thead>
                                        <th>#</th>
                                        <th>Food Name</th>
                                        <th>Food Quantity</th>
                                        <th>Calories</th>
                                        <th>Protein</th>
                                        <th>Fat</th>
                                        <th>Carbs</th>
                                        <th>Sugar</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php displayFoodItems('snacks', $selected_date); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="main-color text-center my-3">
                <i class="fa fa-calendar me-2 fw-bold fs-4"></i>
                <a href="?date=<?php echo $prev_date; ?>">
                    <i class="fa fa-angle-left fw-bold fs-4"></i>
                </a>
                <h3 class="text-center mx-2 d-inline main-color">
                    <?php echo date('M d, Y', strtotime($selected_date)); ?>
                </h3>
                <input type="hidden" value="<?php echo $selected_date; ?>" id="selected_date">
                <a href="?date=<?php echo $next_date; ?>">
                    <i class="fa fa-angle-right fw-bold fs-4"></i>
                </a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Total Calories Consumed:
                        <?php echo $total_calories; ?> Kal
                    </h4>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];

                        // Fetch the weight from the weight_records table for the specified date and user
                        $fetch_query = "SELECT weight FROM weight_records WHERE user_id = '$user_id' AND DATE(created_at) = '$selected_date' LIMIT 1";
                        $result = mysqli_query($mysqli, $fetch_query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $record = mysqli_fetch_assoc($result);
                            $weight = $record['weight']; // Get the weight from the record
                            echo "<h4 class='text-center'>Weight Recorded: {$weight} Lbs</h4>";
                        } else {
                            echo "<h4 class='text-center'>No weight recorded for the selected date.</h4>";
                        }
                    } else {
                        echo "<h4 class='text-center'>User not logged in.</h4>";
                    }
                    ?>

                    <form class="mb-2 mt-2" id="weight-form-dashboard">
                        <label>Record Weight (Lbs)</label>
                        <input type="number" class="form-control" placeholder="Enter Your Weight For The Mentioned Date" name="weight-dashboard">
                        <div id="weight-error" style="color: red; font-size: 0.9rem; display: none;padding-top:5px">Weight cannot be empty</div>
                        <button type="submit" class="btn btn-primary mt-2">Record
                            Weight</button>
                    </form>

                    <form class="mb-2 mt-2" id="bowel-form-dashboard">
                        <label>Record Bowel Movements</label>
                        <input type="number" class="form-control" placeholder="Enter Number of Bowel Movements For The Mentioned Date" name="bowel-dashboard">
                        <div id="bowel-error" style="color: red; font-size: 0.9rem; display: none;padding-top:5px">Bowel Movements cannot be empty</div>
                        <button type="submit" class="btn btn-primary mt-2">Record
                            Bowel Movement</button>
                    </form>

                    <form class="mb-2 mt-2" id="water-form-dashboard">
                        <label>Record Water Consumed</label>
                        <input type="number" class="form-control" placeholder="Enter Oz of Water Consumed For The Mentioned Date" name="water-dashboard">
                        <div id="water-error" style="color: red; font-size: 0.9rem; display: none;padding-top:5px">Water cannot be empty</div>
                        <button type="submit" class="btn btn-primary mt-2">Record
                            Water Consumption</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>