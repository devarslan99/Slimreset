<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php" ?>
<style>
    .expanded-row {
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        margin-top: 5px;
    }
</style>

<body>
    <?php include_once "../utils/loader.php" ?>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include_once "../utils/navbar.php" ?>
        <div class="page-body-wrapper">
            <?php include_once "../utils/sidebar.php" ?>
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid default-dashboard">
                    <div class="row widget-grid">
                        <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                            <?php
                            $role = $_SESSION['role'];
                            if ($role == "admin") {
                                include_once "../dashboard/utils/admin_component.php";
                            } else if ($role == "coach") {
                                include_once "../dashboard/utils/coach_component.php";
                            } else if ($role == "client") {
                                include_once "../dashboard/utils/client_component.php";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <?php include_once "../utils/footer.php" ?>
        </div>
    </div>

    <?php include_once "../utils/scripts.php" ?>
    
    <!-- SCRIPT TO DELETE FOOD ITEM -->
    <script>
        $(document).ready(function() {
            $('.delete a').click(function(e) {
                e.preventDefault();
                var deleteId = $(this).data('food-id');
                var table_name = 'food_items';
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '../functions/global_delete.php',
                            data: {
                                id: deleteId,
                                table_name: table_name
                            },
                            success: function(response) {
                                if (response === 'Success') {
                                    Swal.fire({
                                        title: 'Success',
                                        text: "Food Item Deleted Successfully",
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ok'
                                    });
                                    location.reload();
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: "Failed to Delete Food Item",
                                        icon: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
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
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    <!-- SCRIPT TO RECORD WEIGHT -->
    <script>
        $(document).ready(function() {
            $('#weight-form-dashboard').on('submit', function(e) {
                e.preventDefault();
                var weight = $('input[name="weight-dashboard"]').val();
                var selected_date = document.getElementById('selected_date').value;
                if (!weight) {
                    $('#weight-error').text("Weight cannot be empty").show();
                    setTimeout(function() {
                        $('#weight-error').fadeOut();
                    }, 5000);

                    return;
                }
                $.ajax({
                    url: '../functions/weight/store.php',
                    type: 'POST',
                    data: {
                        weight: weight,
                        selected_date: selected_date
                    },
                    success: function(response) {
                        if (response === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Weight Recorded",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: "Failed to Record Weight",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
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
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });
    </script>
    <!-- SCRIPT TO RECORD BOWEL MOVEMENT -->
    <script>
        $(document).ready(function() {
            $('#bowel-form-dashboard').on('submit', function(e) {
                e.preventDefault();
                var bowel = $('input[name="bowel-dashboard"]').val();
                var selected_date = document.getElementById('selected_date').value;
                if (!bowel) {
                    $('#bowel-error').text("Bowel Movements cannot be empty").show();
                    setTimeout(function() {
                        $('#bowel-error').fadeOut();
                    }, 5000);

                    return;
                }
                $.ajax({
                    url: '../functions/bowel/store.php',
                    type: 'POST',
                    data: {
                        bowel: bowel,
                        selected_date: selected_date
                    },
                    success: function(response) {
                        if (response === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Bowel Movement Recorded",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: "Failed to Record Bowel Movement",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
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
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });
    </script>
    <!-- SCRIPT TO RECORD WATER CONSUMPTION -->
    <script>
        $(document).ready(function() {
            $('#water-form-dashboard').on('submit', function(e) {
                e.preventDefault();
                var water = $('input[name="water-dashboard"]').val();
                var selected_date = document.getElementById('selected_date').value;
                if (!water) {
                    $('#water-error').text("Water cannot be empty").show();
                    setTimeout(function() {
                        $('#water-error').fadeOut();
                    }, 5000);

                    return;
                }
                $.ajax({
                    url: '../functions/water/store.php',
                    type: 'POST',
                    data: {
                        water: water,
                        selected_date: selected_date
                    },
                    success: function(response) {
                        if (response === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Water Consumption Recorded",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: "Failed to Record Water Consumption",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
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
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });
    </script>
    <!-- SCRIPT FOR LAYOUT -->
    <script>
        function updateWrapperClass() {
            const pageWrapper = document.getElementById('pageWrapper');

            if (window.innerWidth <= 991) { // Assuming mobile screen width is 768px or less
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
    <!-- SCRIPT FOR MODAL -->
    <script>
        $(document).ready(function() {
            $('.edit-link').on('click', function() {
                var id = $(this).data('id');
                $('#ItemId').val(id);
                $('#editModal').modal('show');
            });

            $('#saveChanges').on('click', function() {
                var formData = $('#assign_coach_form').serialize();
                $.ajax({
                    type: 'POST',
                    url: '../functions/clients/assign_coach.php',
                    data: formData,
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script>
</body>

</html>