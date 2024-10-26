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
                                        <h4>Edit Food Category</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        include_once '../database/db_connection.php';
                                        $id = $_GET['id'];
                                        $sql = "SELECT * FROM food_category WHERE id = ?";
                                        $stmt = $mysqli->prepare($sql);
                                        $stmt->bind_param("i", $id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $category = $result->fetch_assoc();
                                        ?>
                                        <form id="editCategoryForm">
                                            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label" for="name">Category Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name'], ENT_QUOTES); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($category['description'], ENT_QUOTES); ?></textarea>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Update Category</button>
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
            $('#editCategoryForm').submit(function(e) {
                e.preventDefault();
                var formData = {
                    id: $('input[name="id"]').val(),
                    name: $('#name').val(),
                    description: $('#description').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/food_category/update.php',
                    data: formData,
                    success: function(response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Category updated successfully.",
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