<?php
$sqlGet = mysqli_query($conn, "SELECT * FROM level ORDER BY id DESC");
$result = mysqli_fetch_all($sqlGet, MYSQLI_ASSOC);

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];

    $sqlInsert = mysqli_query($conn, "INSERT INTO level (level_name) VALUES ('$nama')");

    if ($sqlInsert) {
        echo "<script>window.location.href='?page=level&add=success';</script>";
    } else {
        echo "<script>window.location.href='?page=level&add=failed';</script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sqlGet = mysqli_query($conn, "SELECT * FROM level WHERE id = '$id'");
    $result = mysqli_fetch_assoc($sqlGet);
    // print_r($result);
    // die;

    if (!$result) {
        die("Data tidak ditemukan!");
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];

    $sqlUpdate = mysqli_query($conn, "UPDATE level SET level_name = '$nama' WHERE id = '$id'");

    if ($sqlUpdate) {
        echo "<script>window.location.href='?page=level&update=success';</script>";
    } else {
        echo "<script>window.location.href='?page=level&update=failed';</script>";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sqlDelete = mysqli_query($conn, "DELETE FROM level WHERE id = '$id'");

    if ($sqlDelete) {
        echo "<script>window.location.href='?page=level&notif=success');</script>";
    }
}

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-header">
                            <h5 class="card-title text-primary">Level Data</h5>

                            <!-- ALERT ERROR -->
                            <?php if (isset($_GET['add'])) : ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="bx bx-bell me-2"></i>
                                    <strong>Level Has Added!</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif ?>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                                    New Levels
                                </button>
                            </div>

                            <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                        <!-- FORM ADD CUSTOMER -->
                                        <form action="" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Level Add</h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="nameWithTitle" class="form-label">Level Name</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Enter Name of Services" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="simpan" class="btn btn-dark">SAVE</button>
                                                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                                                    CLOSE
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <caption class="ms-4">
                                            List of Levels
                                        </caption>
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Level Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $no = 1;
                                        foreach ($result as $row) :
                                        ?>
                                            <tbody>
                                                <td><?php echo $no++ . '.' ?></td>
                                                <td><?= $row['level_name'] ?></td>
                                                <td>
                                                    <a href="?page=level&id<?= $row['id'] ?>" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">EDIT</a>

                                                    <a href="?page=level&delete=<?php echo $row['id'] ?>" class="btn btn-light" onclick="return confirm('Are you sure you want to delete this customer?')">DELETE</a>
                                                </td>
                                            </tbody>

                                            <div class="modal fade" id="modalEdit<?php echo $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">

                                                        <!-- FORM EDIT CUSTOMER -->
                                                        <form action="" method="post">
                                                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">Level Edit</h5>
                                                                <button
                                                                    type="button"
                                                                    class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <label for="nameWithTitle" class="form-label">Level Name</label>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $row['level_name'] ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="edit" class="btn btn-dark">EDIT</button>
                                                                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                                                                    CLOSE
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>