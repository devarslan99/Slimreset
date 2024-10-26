<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php"; ?>

<body>
    <?php include_once "../utils/loader.php"; ?>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include_once "../utils/navbar.php"; ?>
        <div class="page-body-wrapper">
            <?php include_once "../utils/sidebar.php"; ?>
            <div class="page-body">
                <div class="container-fluid">
                    <div class="edit-profile">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="createFoodRecommendationForm" class="card" method="POST">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Create Food Recommendation</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="food_item_name">Food Item Name</label>
                                            <input type="text" class="form-control" id="food_item_name" name="food_item_name" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="food_category_id">Food Category</label>
                                            <select class="form-control" id="food_category_id" name="food_category_id" required>
                                                <option value="" disabled selected>--Select a Category--</option>
                                                <?php
                                                include_once '../database/db_connection.php';
                                                $sql = "SELECT * FROM food_category";
                                                $result = mysqli_query($mysqli, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="food_intolerance">Food Intolerance</label>
                                            <select class="form-control" id="food_intolerance" name="food_intolerance" required>
                                                <option value="" disabled selected>--Select Intolerance Level--</option>
                                                <option value="Recommended">Recommended</option>
                                                <option value="Not Recommended">Not Recommended</option>
                                                <option value="Mild Recommended">Mild Recommended</option>
                                            </select>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="protein_level">Protein Level</label>
                                            <select class="form-control" id="protein_level" name="protein_level" required>
                                                <option value="" disabled selected>Select Protein Level</option>
                                                <option value="High">High Protein</option>
                                                <option value="Low">Low Protein</option>
                                                <option value="Mild">Mild Protein</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Create Recommendation</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once "../utils/footer.php"; ?>
        </div>
    </div>
    <?php include_once "../utils/scripts.php"; ?>

    <script>
        $(document).ready(function() {
            $('#createFoodRecommendationForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = {
                    food_category_id: $('#food_category_id').val(),
                    food_intolerance: $('#food_intolerance').val(),
                    food_item_name: $('#food_item_name').val(),
                    protein_level: $('#protein_level').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/food_recommendation/store.php',
                    data: formData,
                    success: function(response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Food Recommendation Created",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
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
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: "An error occurred while processing your request. Please try again.",
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function updateWrapperClass() {
            const pageWrapper = document.getElementById('pageWrapper');

            if (window.innerWidth <= 768) { // Assuming mobile screen width is 768px or less
                pageWrapper.classList.remove('horizontal-wrapper');
                pageWrapper.classList.add('compact-wrapper');
            } else {
                pageWrapper.classList.remove('compact-wrapper');
                pageWrapper.classList.add('horizontal-wrapper');
            }
        }

        // Run on page load
        updateWrapperClass();

        // Run on window resize
        window.addEventListener('resize', updateWrapperClass);
    </script>
</body>

</html>