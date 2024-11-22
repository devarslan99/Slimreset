<!DOCTYPE html>
<html lang="en">
<?php include_once "../utils/header.php";

include_once "../database/db_connection.php";

$proteinId = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$proteinId) {
    header("Location: view-protein.php");
    exit();
}

$query = "SELECT * FROM `protein` WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $proteinId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $proteinItem = $result->fetch_assoc();
} else {
    header("Location: view-protein.php");
    exit();
}

$stmt->close();
?>

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
                                <form class="card" method="post">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Edit Protein</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-10 mb-1">
                                                <label class="form-label" for="protein">Protein</label>
                                                <input id="protein" class="form-control" type="text" placeholder="Enter Protein" name="protein" value="<?php echo htmlspecialchars($proteinItem['name']); ?>" required>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-end align-items-end mb-1">
                                                <button class="btn btn-primary w-100 p-2" type="submit" style="white-space: nowrap;">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
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
            $('form').submit(function(e) {
                e.preventDefault();
                var formData = {
                    id: <?php echo $proteinId; ?>,
                    protein: $('input[name="protein"]').val()
                };
                $.ajax({
                    type: 'POST',
                    url: '../functions/recipes/protein/edit.php',
                    data: formData,
                    success: function(response) {
                        if (response.trim() === 'Success') {
                            Swal.fire({
                                title: 'Success',
                                text: "Protein updated successfully!",
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(() => {
                                window.location.href = 'view-protein.php';
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