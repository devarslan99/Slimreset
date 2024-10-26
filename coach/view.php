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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Coach Assignments</h4>
                                        <span>List of all the coaches assigned to clients.</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="assignment-wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="assignment-table" role="grid" aria-describedby="assignment_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>Sr</th>
                                                            <th>Coach Name</th>
                                                            <th>Client Name</th>
                                                            <th>Assigned Date</th>
                                                            <th>Actions</th> <!-- New column for actions -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="assignment-list">
                                                        <!-- AJAX will populate this section -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

            function fetchAssignments() {
                $.ajax({
                    type: 'GET',
                    url: '../functions/coach/get_assignments.php',
                    success: function(response) {
                        let data = JSON.parse(response);
                        let assignmentList = $('#assignment-list');
                        assignmentList.empty();

                        if (data.length > 0) {
                            let serialNumber = 1;
                            data.forEach(function(assignment) {
                                assignmentList.append(`
                                    <tr role="row" id="assignment_${assignment.id}">
                                        <td>${serialNumber++}</td>
                                        <td>${assignment.coach_name}</td>
                                        <td>${assignment.client_name}</td>
                                        <td>${assignment.assigned_at}</td>
                                        <td>
                                            <ul class="action">
                                                <!-- Edit icon -->
                                                <li class='edit'><a href='../coach/edit.php?id=${assignment.id}'><i class='icon-pencil-alt'></i></a></li>
                                                
                                                <!-- Delete icon -->
                                                <li class='delete'><a href="#" data-assignment-id="${assignment.id}"><i class='icon-trash'></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            assignmentList.append(`
                                <tr>
                                    <td colspan="5" class="text-center">No assignments found</td>
                                </tr>
                            `);
                        }

                        setupDeleteHandlers();
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to fetch assignments',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            }

            function setupDeleteHandlers() {
                $('.delete a').click(function(e) {
                    e.preventDefault();
                    var deleteId = $(this).data('assignment-id');
                    var table_name = 'client_coach_assignments';
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
                                url: '../functions/coach/delete_assignment.php',
                                data: {
                                    id: deleteId,
                                    table_name: table_name
                                },
                                success: function(response) {
                                    if (response === 'Success') {
                                        Swal.fire({
                                            title: 'Success',
                                            text: "Assignment Deleted Successfully",
                                            icon: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Ok'
                                        });
                                        $('#assignment_' + deleteId).remove();
                                    } else {
                                        Swal.fire({
                                            title: 'Error',
                                            text: "Failed to Delete Assignment",
                                            icon: 'error',
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
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            });
                        }
                    });
                });
            }

            // Call fetch function on page load
            fetchAssignments();
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