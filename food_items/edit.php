<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php" ?>

<body>
    <?php include_once "../utils/loader.php" ?>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include_once "../utils/navbar.php" ?>
        <div class="page-body-wrapper">
            <?php include_once "../utils/sidebar.php" ?>
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="edit-profile">
                        <div class="row">
                            <div class="col-xl-12">
                                <?php
                                include_once '../database/db_connection.php';
                                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                                    $user_id = $_GET['id'];
                                    $sql = "SELECT * FROM food_items WHERE id = $user_id";
                                    $result = mysqli_query($mysqli, $sql);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        ?>
                                        <form class="card" method="POST" action="update_food_item.php">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0">Edit Food Item</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Category Name</label>
                                                            <select class="form-control" name="category_id" required>
                                                                <option value="" selected disabled>-- Please Choose Food
                                                                    Category --</option>
                                                                <?php
                                                                // Query to fetch all categories
                                                                $query_options = "SELECT id, name FROM food_categories";
                                                                $result_options = $mysqli->query($query_options);

                                                                // Check if any records are found
                                                                if ($result_options->num_rows > 0) {
                                                                    // Loop through categories and create <option> elements
                                                                    while ($category = $result_options->fetch_assoc()) {
                                                                        // Check if the category_id matches the current food item category_id
                                                                        $selected = ($category['id'] == $row['category_id']) ? 'selected' : '';
                                                                        echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                                                                    }
                                                                } else {
                                                                    echo '<option value="" disabled>No Categories found</option>';
                                                                }

                                                                // Close the database connection
                                                                $mysqli->close();
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Food Item Name</label>
                                                            <input class="form-control" type="text" placeholder="Food Item Name"
                                                                name="name" value="<?php echo $row['name']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="food_item_id" value="<?php echo $_GET['id']; ?>">
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <button class="btn btn-primary" type="submit">Update Food Item</button>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <?php include_once "../utils/footer.php" ?>
        </div>
    </div>
    <?php include_once "../utils/scripts.php" ?>
    <script>
        $(document).ready(function () {
            $('form').submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = {
                    name: $('input[name="name"]').val(),
                    food_item_id: $('input[name="food_item_id"]').val(),
                    category_id:$('select[name="category_id"]').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/food_items/update.php',
                    data: formData,
                    success: function (response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Food Item Updated",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response,
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: "An error occurred while processing your request. Please try again.",
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>