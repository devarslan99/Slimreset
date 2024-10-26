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
                                        <h4>Food Items List</h4>
                                        <span>List of all the created Food Items.</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                    aria-describedby="basic-1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>Sr</th>
                                                            <th>Category Name</th>
                                                            <th>Food Item Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        include_once '../database/db_connection.php';
                                                        $sql = "SELECT food_items.id, food_items.name AS food_item_name, food_categories.name AS category_name 
                                                        FROM food_items 
                                                        JOIN food_categories ON food_items.category_id = food_categories.id";
                                                        $result = mysqli_query($mysqli, $sql);
                                                        $serial_number = 1;
                                                        if ($result && mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>
                                                                <tr role="row" class="odd"
                                                                    id="customer_<?php echo $row['id']; ?>">
                                                                    <td>
                                                                        <?php echo $serial_number; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['category_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['food_item_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <ul class="action">
                                                                            <li class='edit'><a
                                                                                    href='../food_items/edit.php?id=<?php echo $row['id']; ?>'><i
                                                                                        class='icon-pencil-alt'></i></a></li>
                                                                            <li class='delete'><a href="#"
                                                                                    data-customer-id="<?php echo $row['id']; ?>"><i
                                                                                        class='icon-trash'></i></a></li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $serial_number++;
                                                            }
                                                        }
                                                        // Free result set
                                                        mysqli_free_result($result);
                                                        // Close connection
                                                        mysqli_close($mysqli);
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
        $(document).ready(function () {
            $('.delete a').click(function (e) {
                e.preventDefault();
                var deleteId = $(this).data('customer-id');
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
                            success: function (response) {
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
                                    $('#customer_' + deleteId).remove();
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
                    }
                });
            });
        });
    </script>
</body>

</html>