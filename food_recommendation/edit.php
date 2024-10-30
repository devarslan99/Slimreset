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
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit Food Recommendation</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        include_once '../database/db_connection.php';
                                        $id = $_GET['id'];
                                        $sql = "SELECT * FROM food_recommendation WHERE id = ?";
                                        $stmt = $mysqli->prepare($sql);
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $foodRecommendation = $result->fetch_assoc();
                                        ?>
                                        <form id="editRecommendationForm">
                                            <input type="hidden" name="id" value="<?php echo $foodRecommendation['id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label" for="food_category_id">Food Category</label>
                                                <select class="form-control" id="food_category_id" name="food_category_id" required>
                                                    <?php
                                                    // Fetching food categories for dropdown
                                                    $categoryQuery = "SELECT * FROM food_category";
                                                    $categories = mysqli_query($mysqli, $categoryQuery);
                                                    while ($category = mysqli_fetch_assoc($categories)) {
                                                        $selected = ($category['id'] == $foodRecommendation['food_category_id']) ? 'selected' : '';
                                                        echo "<option value='{$category['id']}' $selected>" . htmlspecialchars($category['name'], ENT_QUOTES) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="food_intolerance">Food Intolerance</label>
                                                <select class="form-control" id="food_intolerance" name="food_intolerance" required>
                                                    <option value="Recommended" <?php echo ($foodRecommendation['food_intolerance'] == 'Recommended') ? 'selected' : ''; ?>>Recommended</option>
                                                    <option value="Not Recommended" <?php echo ($foodRecommendation['food_intolerance'] == 'Not Recommended') ? 'selected' : ''; ?>>Not Recommended</option>
                                                    <option value="Mild Recommended" <?php echo ($foodRecommendation['food_intolerance'] == 'Mild Recommended') ? 'selected' : ''; ?>>Mild Recommended</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="food_item_name">Food Item Name</label>
                                                <input type="text" class="form-control" id="food_item_name" name="food_item_name" value="<?php echo htmlspecialchars($foodRecommendation['food_item_name'], ENT_QUOTES); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="protein_level">Protein Level</label>
                                                <select class="form-control" id="protein_level" name="protein_level" required>
                                                    <option value="High Protein" <?php echo ($foodRecommendation['protein_level'] == 'High Protein') ? 'selected' : ''; ?>>High Protein</option>
                                                    <option value="Low" <?php echo ($foodRecommendation['protein_level'] == 'Low') ? 'selected' : ''; ?>>Low</option>
                                                    <option value="Mild" <?php echo ($foodRecommendation['protein_level'] == 'Mild') ? 'selected' : ''; ?>>Mild</option>
                                                </select>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Update Recommendation</button>
                                                <a href="view.php" class="btn btn-secondary">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
            $('#editRecommendationForm').submit(function(e) {
                e.preventDefault();
                var formData = {
                    id: $('input[name="id"]').val(),
                    food_category_id: $('#food_category_id').val(),
                    food_intolerance: $('#food_intolerance').val(),
                    food_item_name: $('#food_item_name').val(),
                    protein_level: $('#protein_level').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/food_recommendation/update.php',
                    data: formData,
                    success: function(response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Recommendation updated successfully.",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "view.php";
                                }
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
                    error: function() {
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
