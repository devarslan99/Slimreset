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
                                <form class="card" method="post">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Create Food Item</h4>
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
                                                        include_once '../database/db_connection.php';
                                                        $query = "SELECT id, name FROM food_categories";
                                                        $result = $mysqli->query($query);

                                                        // Check if any records are found
                                                        if ($result->num_rows > 0) {
                                                            // Loop through the results and create options dynamically
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                            }
                                                        } else {
                                                            echo '<option value="" disabled>No Categories found</option>';
                                                        }

                                                        // Close the database mysqliection
                                                        $mysqli->close();
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Food Item Name</label>
                                                    <input type="text" class="form-control" name="name" required
                                                        placeholder="Food Item Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Create Food Item</button>
                                    </div>
                                </form>
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
                    category_id: $('select[name="category_id"]').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/food_items/store.php',
                    data: formData,
                    success: function (response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Food Item Created",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                form.trigger('reset');
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
                            }).then((result) => {
                                form.trigger('reset');
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