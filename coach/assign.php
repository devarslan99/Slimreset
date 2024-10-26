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
                                <form class="card" id="assign-coach-form" method="post">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Assign Coach to Client</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Select Coach</label>
                                                    <select class="form-control" name="coach_id" id="coach-dropdown" required>
                                                        <option value="" selected disabled>Select Coach</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Select Client</label>
                                                    <select class="form-control" name="client_id" id="client-dropdown" required>
                                                        <option value="" selected disabled>Select Client</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Assign</button>
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
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: '../functions/coach/get_clients_coaches.php',
                success: function(response) {
                    let data = JSON.parse(response);

                    let clientDropdown = $('#client-dropdown');
                    data.clients.forEach(function(client) {
                        clientDropdown.append(`<option value="${client.id}">${client.first_name} ${client.last_name}</option>`);
                    });

                    let coachDropdown = $('#coach-dropdown');
                    data.coaches.forEach(function(coach) {
                        coachDropdown.append(`<option value="${coach.id}">${coach.first_name} ${coach.last_name}</option>`);
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to fetch clients and coaches',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });

            $('#assign-coach-form').submit(function(e) {
                e.preventDefault();
                var formData = {
                    client_id: $('#client-dropdown').val(),
                    coach_id: $('#coach-dropdown').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/coach/store.php',
                    data: formData,
                    success: function(response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Coach assigned to client successfully",
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                $('#assign-coach-form').trigger('reset');
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred while processing your request. Please try again.',
                            icon: 'error',
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