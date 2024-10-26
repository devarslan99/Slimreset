<!DOCTYPE html>
<html lang="en">

<?php include_once "../utils/header.php"; ?>
<?php include_once "../database/db_connection.php"; ?>

<body>
    <?php include_once "../utils/loader.php"; ?>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include_once "../utils/navbar.php"; ?>
        <div class="page-body-wrapper">
            <?php include_once "../utils/sidebar.php"; ?>
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="edit-profile">
                        <div class="row">
                            <div class="col-xl-12">
                                <form class="card" id="assign-coach-form" method="post">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Edit Coach Assignment</h4>
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
                                        <button class="btn btn-primary" type="submit">Update Assignment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <?php include_once "../utils/footer.php"; ?>
        </div>
    </div>
    <?php include_once "../utils/scripts.php"; ?>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const assignmentId = urlParams.get('id');

            $.ajax({
                type: 'GET',
                url: '../functions/coach/get_assignment_id.php?id=' + assignmentId,
                success: function(response) {
                    let currentAssignment = JSON.parse(response);

                    $('#client-dropdown').val(currentAssignment.client_id);
                    $('#coach-dropdown').val(currentAssignment.coach_id);

                    populateDropdowns(currentAssignment.client_id, currentAssignment.coach_id);
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to fetch current assignment details',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            });

            // Function to populate dropdowns with clients and coaches
            function populateDropdowns(selectedClientId, selectedCoachId) {
                $.ajax({
                    type: 'GET',
                    url: '../functions/coach/get_clients_coaches.php',
                    success: function(response) {
                        let data = JSON.parse(response);

                        // Populate clients dropdown
                        let clientDropdown = $('#client-dropdown');
                        data.clients.forEach(function(client) {
                            clientDropdown.append(`<option value="${client.id}" ${client.id == selectedClientId ? 'selected' : ''}>${client.first_name} ${client.last_name}</option>`);
                        });

                        let coachDropdown = $('#coach-dropdown');
                        data.coaches.forEach(function(coach) {
                            coachDropdown.append(`<option value="${coach.id}" ${coach.id == selectedCoachId ? 'selected' : ''}>${coach.first_name} ${coach.last_name}</option>`);
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
            }

            // Handle form submission to update assignment
            $('#assign-coach-form').submit(function(e) {
                e.preventDefault();
                var formData = {
                    id: assignmentId,
                    client_id: $('#client-dropdown').val(),
                    coach_id: $('#coach-dropdown').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../functions/coach/update_assignment.php',
                    data: formData,
                    success: function(response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Assignment updated successfully",
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(() => {
                                window.location.href = '../coach/view.php';
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