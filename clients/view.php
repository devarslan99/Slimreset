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
                                        <h4>Clients List</h4>
                                        <span>List of all the clients.</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                    aria-describedby="basic-1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>Sr</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Email</th>
                                                            <th>Address</th>
                                                            <th>Contact Number</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        include_once '../database/db_connection.php';
                                                        $sql = "SELECT id, first_name,last_name, email, address, contact_no FROM users WHERE role = 'client'";
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
                                                                        <?php echo $row['first_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['last_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['email']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['address']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['contact_no']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <ul class="action">
                                                                            <li class='edit'><a
                                                                                    href='../clients/summary.php?id=<?php echo $row['id']; ?>'><i
                                                                                        class='icon-eye'></i></a></li>
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