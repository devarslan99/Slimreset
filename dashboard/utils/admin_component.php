<?php
// Include your database connection
include_once '../database/db_connection.php';

// Query for the total number of users whose role is not 'admin'
$query_total_users = "SELECT COUNT(*) AS total_users FROM users WHERE role != 'admin'";
$result_total_users = mysqli_query($mysqli, $query_total_users);
$total_users = mysqli_fetch_assoc($result_total_users)['total_users'];

// Query for the total number of users whose role is 'coach'
$query_coach_users = "SELECT COUNT(*) AS coach_users FROM users WHERE role = 'coach'";
$result_coach_users = mysqli_query($mysqli, $query_coach_users);
$coach_users = mysqli_fetch_assoc($result_coach_users)['coach_users'];

// Query for the total number of users whose created_by is not NULL
$query_created_by_not_null = "SELECT COUNT(*) AS created_by_not_null FROM users WHERE created_at IS NOT NULL";
$result_created_by_not_null = mysqli_query($mysqli, $query_created_by_not_null);
$created_by_not_null = mysqli_fetch_assoc($result_created_by_not_null)['created_by_not_null'];

// Query for the total number of users whose created_by is NULL
$query_created_by_null = "SELECT COUNT(*) as total FROM users WHERE id NOT IN (SELECT client_id FROM client_coach_assignments) AND role='client'";
$result_created_by_null = mysqli_query($mysqli, $query_created_by_null);
$created_by_null = mysqli_fetch_assoc($result_created_by_null)['total'];
?>

<div class="row">
    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header card-no-border pb-0">
                    <div class="header-top daily-revenue-card">
                        <h4>Users</h4>
                    </div>
                </div>
                <div class="card-body pb-0 total-sells">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png" alt="icon">
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <h2><?php echo $total_users; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header card-no-border pb-0">
                    <div class="header-top daily-revenue-card">
                        <h4>Coaches</h4>
                    </div>
                </div>
                <div class="card-body pb-0 total-sells">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png" alt="icon">
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <h2><?php echo $coach_users; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header card-no-border pb-0">
                    <div class="header-top daily-revenue-card">
                        <h4>Clients</h4>
                    </div>
                </div>
                <div class="card-body pb-0 total-sells">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png" alt="icon">
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <h2><?php echo $created_by_not_null; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header card-no-border pb-0">
                    <div class="header-top daily-revenue-card">
                        <h4>Un-Assigned Clients</h4>
                    </div>
                </div>
                <div class="card-body pb-0 total-sells">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png" alt="icon">
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2">
                                <h2><?php echo $created_by_null; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Un-Assigned Clients List</h4>
                <span>List of all the clients who do not have a coach assigned to them.</span>
            </div>
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                        <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                            <thead>
                                <tr role="row">
                                    <th>Sr</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Contact Number</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include_once '../database/db_connection.php';
                                $sql = "SELECT users.*
                                FROM users
                                LEFT JOIN client_coach_assignments 
                                    ON users.id = client_coach_assignments.client_id 
                                    OR users.id = client_coach_assignments.coach_id
                                WHERE client_coach_assignments.client_id IS NULL 
                                      AND client_coach_assignments.coach_id IS NULL
                                      AND users.role = 'client'";
                                $result = mysqli_query($mysqli, $sql);
                                $serial_number = 1;
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <tr role="row" class="odd" id="customer_<?php echo $row['id']; ?>">
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
                                            <!-- <td>
                                                <ul class="action">
                                                    <li class='edit'><a href='javascript:void(0);' class='edit-link' data-id='<?php echo $row['id']; ?>'><i class='icon-pencil'></i></a>
                                                    </li>
                                                </ul>
                                            </td> -->
                                        </tr>
                                <?php
                                        $serial_number++;
                                    }
                                }
                                // Free result set
                                mysqli_free_result($result);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TO ASSIGN COACH -->
<!-- Modal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Assign Coach to Client</h5>
            </div>
            <form id="assign_coach_form" class="modal-body">
                <input type="hidden" name="client_id" id="ItemId">
                <div class="form-group">
                    <label>Choose Coach</label>
                    <select class="form-control" name="coach_id">
                        <option value="" selected disabled>Choose Coach</option>
                        <?php
                        include_once '../database/db_connection.php';
                        $sql = "SELECT id, first_name,email FROM users WHERE role = 'coach'";
                        $result = mysqli_query($mysqli, $sql);
                        $serial_number = 1;
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['first_name'] ?> - <?php echo $row['email'] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>