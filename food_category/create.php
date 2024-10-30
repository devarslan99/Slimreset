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
                                <form id="createCategoryForm" class="card" method="POST">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Create Food Category</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="description">Description (Optional)</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Create Category</button>
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
        $(document).ready(function () {
            $('#createCategoryForm').submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = {
                    name: $('#name').val(),
                    description: $('#description').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/food_category/store.php',
                    data: formData,
                    success: function (response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Food Category Created",
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
                    error: function (xhr, status, error) {
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
