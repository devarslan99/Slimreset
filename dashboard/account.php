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
                                if (isset($_SESSION['user_id'])) {
                                    $user_id = $_SESSION['user_id'];
                                    $sql = "SELECT * FROM users WHERE id = $user_id";
                                    $result = mysqli_query($mysqli, $sql);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        ?>
                                        <form class="card" id="edit-profile">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0">Edit Profile</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">First Name</label>
                                                            <input class="form-control" type="text" placeholder="First Name"
                                                                name="first_name" value="<?php echo $row['first_name'] ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Email address</label>
                                                            <input class="form-control" type="email" placeholder="Email"
                                                                name="email_address" value="<?php echo $row['email'] ?>"
                                                                required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Address</label>
                                                            <input class="form-control" type="text" placeholder="Address"
                                                                name="address" value="<?php echo $row['address'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">City</label>
                                                            <input class="form-control" type="text" placeholder="City"
                                                                name="city" value="<?php echo $row['city'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Postal Code</label>
                                                            <input class="form-control" type="number" placeholder="ZIP Code"
                                                                name="postal_code" value="<?php echo $row['postal_code'] ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Contact Number</label>
                                                            <input class="form-control" type="text" placeholder="Contact Number"
                                                                name="contact_number" value="<?php echo $row['contact_no'] ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="user_id"
                                                        value="<?php echo $_SESSION['user_id'] ?>">
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <button class="btn btn-primary" type="submit">Edit Profile</button>
                                            </div>
                                        </form>
                                        <form class="card" id="edit-image" enctype="multipart/form-data">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0">Update Profile Image</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Choose Image</label>
                                                            <input class="form-control" type="file"
                                                                accept="image/jpeg, image/png" name="profile_image" required>
                                                        </div>
                                                        <input type="hidden" name="user_id"
                                                            value="<?php echo $_SESSION['user_id'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <button class="btn btn-primary" type="submit">Update Profile Image</button>
                                            </div>
                                        </form>
                                        <form class="card" id="edit-password">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0">Update Password</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Enter New Password</label>
                                                            <input class="form-control" type="password" name="password"
                                                                required>
                                                        </div>
                                                        <input type="hidden" name="user_id"
                                                            value="<?php echo $_SESSION['user_id'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end">
                                                <button class="btn btn-primary" type="submit">Update Password</button>
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
            var form = document.getElementById('edit-profile');
            $(form).submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = {
                    company_name: $('input[name="first_name"]').val(),
                    email_address: $('input[name="email_address"]').val(),
                    address: $('input[name="address"]').val(),
                    city: $('input[name="city"]').val(),
                    postal_code: $('input[name="postal_code"]').val(),
                    contact_number: $('input[name="contact_number"]').val(),
                    user_id: $('input[name="user_id"]').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/users/update_profile.php',
                    data: formData,
                    success: function (response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Profile Updated",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                location.reload();
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
    <!-- EDIT PROFILE IMAGE -->
    <script>
        $(document).ready(function () {
            var form_image = document.getElementById('edit-image');
            $(form_image).submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);

                $.ajax({
                    type: 'POST',
                    url: '../functions/users/update_image.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Image Updated",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                location.reload();
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
                                location.reload();
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
                        }).then((result) => {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>

    <!-- EDIT PROFILE Password -->
    <script>
        $(document).ready(function () {
            var form_image = document.getElementById('edit-password');
            $(form_image).submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);

                $.ajax({
                    type: 'POST',
                    url: '../functions/users/update_password.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Password Updated",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                location.reload();
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
                            })
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
                        }).then((result) => {
                            location.reload();
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