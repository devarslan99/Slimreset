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
                                        <h4>Meal Type List</h4>
                                        <span>List of all meal types.</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>Sr</th>
                                                            <th>Name</th>
                                                            <th>Created At</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        include_once '../database/db_connection.php';

                                                        $query = "SELECT * FROM `meal-type`";
                                                        $stmt = $mysqli->prepare($query);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        $serial_number = 1;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $statusText = $row['status'] == 1 ? 'Active' : 'Inactive';
                                                            $statusClass = $row['status'] == 1 ? 'active' : 'inactive';
                                                        ?>
                                                            <tr role="row" class="odd" id="meal_type_<?php echo $row['id']; ?>">
                                                                <td>
                                                                    <?php echo $serial_number; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['name']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo date('Y-m-d H:i:s', strtotime($row['created_at'])); ?>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="status-link <?php echo $statusClass; ?>" data-id="<?php echo $row['id']; ?>" title="<?php echo $statusText; ?>">
                                                                        <?php echo $statusText; ?>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <ul class="action" style="list-style-type: none; padding: 0; margin: 0; display: flex; gap: 10px;">
                                                                        <li class="edit">
                                                                            <a href="edit-meal-type.php?id=<?php echo $row['id']; ?>" title="Edit">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li class="delete">
                                                                            <a href="javascript:void(0);" data-id="<?php echo $row['id']; ?>" title="Delete" class="delete-record">
                                                                                <i class="fa fa-trash"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $serial_number++;
                                                        }
                                                        $result->free();
                                                        $mysqli->close();
                                                        ?>
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
            $('.status-link').on('click', function(e) {
                e.preventDefault();

                var mealTypeId = $(this).data('id');
                var currentStatus = $(this).text().trim();
                var newStatus = (currentStatus === 'Active') ? 'Inactive' : 'Active';

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to change the status to " + newStatus + ". Do you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '../functions/recipes/meal-type/status.php',
                            data: {
                                id: mealTypeId,
                                status: (newStatus === 'Active') ? 1 : 0
                            },
                            success: function(response) {
                                if (response.trim() === 'Success') {
                                    $('a[data-id="' + mealTypeId + '"]').text(newStatus).toggleClass('active inactive');
                                    Swal.fire({
                                        title: 'Success',
                                        text: "Status updated successfully!",
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    }).then(() => {
                                        location.reload();
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
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-record').on('click', function(e) {
                e.preventDefault();
                const recordId = $(this).data('id');

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
                            url: '../functions/recipes/meal-type/delete.php',
                            type: 'POST',
                            data: {
                                id: recordId
                            },
                            success: function(response) {
                                if (response.trim() === 'Success') {
                                    Swal.fire(
                                        'Deleted!',
                                        'The meal type has been deleted.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the record. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function updateWrapperClass() {
            const pageWrapper = document.getElementById('pageWrapper');

            if (window.innerWidth <= 991) {
                pageWrapper.classList.remove('horizontal-wrapper');
                pageWrapper.classList.add('compact-wrapper');
            } else {
                pageWrapper.classList.remove('compact-wrapper');
                pageWrapper.classList.add('horizontal-wrapper');
            }
        }

        updateWrapperClass();

        window.addEventListener('resize', updateWrapperClass);
    </script>
</body>

</html>