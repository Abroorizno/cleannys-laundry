<?php
// $sqlGet = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
// $result = mysqli_fetch_all($sqlGet, MYSQLI_ASSOC);

$sqlReq = mysqli_query($conn, "SELECT users. * , level.level_name FROM users LEFT JOIN level ON users.id_level = level.id");
$result = mysqli_fetch_all($sqlReq, MYSQLI_ASSOC);

if (isset($_POST['simpan'])) {
    $level = $_POST['level'];
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $sqlInsert = mysqli_query($conn, "INSERT INTO users (id_level, name, email, password) VALUES ('$level', '$name', '$email', '$password')");

    if ($sqlInsert) {
        echo "<script>window.location.href='?page=user&add=success';</script>";
    } else {
        echo "<script>window.location.href='?page=user&add=failed';</script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sqlGet = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
    $result = mysqli_fetch_assoc($sqlGet);
    print_r($result);
    die;

    if (!$result) {
        die("Data tidak ditemukan!");
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $level = $_POST['level'];
    $name = $_POST['nama'];
    $email = $_POST['email'];

    if ($_POST['password']) {
        $password = sha1($_POST['password']);
    } else {
        $password = $result['password'];
    }

    $sqlUpdate = mysqli_query($conn, "UPDATE users SET id_level = '$level', name = '$name', email = '$email', password = '$password' WHERE id = '$id'");

    if ($sqlUpdate) {
        echo "<script>window.location.href='?page=user&update=success';</script>";
    } else {
        echo "<script>window.location.href='?page=user&update=failed';</script>";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sqlDelete = mysqli_query($conn, "DELETE FROM users WHERE id = '$id'");

    if ($sqlDelete) {
        echo "<script>window.location.href='?page=user&notif=success');</script>";
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
                            <h5 class="card-title text-primary">Users Data</h5>
                            <!-- ALERT ERROR -->
                            <?php if (isset($_GET['add'])) : ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <i class="bx bx-bell me-2"></i>
                                    <strong>Users Has Added!</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif ?>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                                    New Users
                                </button>
                            </div>

                            <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                        <!-- FORM ADD CUSTOMER -->
                                        <form action="" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Users Add</h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="nameWithTitle" class="form-label">Level</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <select name="level" id="level" class="form-select">
                                                            <option value="" selected disabled>SELECT</option>
                                                            <?php
                                                            $sql = mysqli_query($conn, "SELECT * FROM level ORDER BY id");
                                                            $resultSel = mysqli_fetch_all($sql, MYSQLI_ASSOC);
                                                            foreach ($resultSel as $row) : ?>
                                                                <option value=<?php echo $row['id'] ?>><?php echo $row['level_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="nameWithTitle" class="form-label">Name</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Enter Your Name" />
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3">
                                                        <label for="nameWithTitle" class="form-label">Email</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email" />
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="nameWithTitle" class="form-label">Passwords</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="password" name="password" id="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
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
                                            List of Customers
                                        </caption>
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Level</th>
                                                <th>Name</th>
                                                <th>Email</th>
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
                                                <td><?= $row['name'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <td>
                                                    <!-- <button type="button" class="btn btn-dark" data-id="?page=customer&id<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalEdit"> EDIT </button> -->

                                                    <a href="?page=user&id<?= $row['id'] ?>" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">EDIT</a>

                                                    <a href="?page=user&delete=<?php echo $row['id'] ?>" class="btn btn-light" onclick="return confirm('Are you sure you want to delete this customer?')">DELETE</a>
                                                </td>
                                            </tbody>

                                            <div class="modal fade" id="modalEdit<?php echo $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">

                                                        <!-- FORM EDIT CUSTOMER -->
                                                        <form action="" method="post">
                                                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">User Edit</h5>
                                                                <button
                                                                    type="button"
                                                                    class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <label for="nameWithTitle" class="form-label">Level</label>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <select name="level" id="level" class="form-select">
                                                                            <?php
                                                                            $sql = mysqli_query($conn, "SELECT * FROM level ORDER BY id");
                                                                            $resultSel = mysqli_fetch_all($sql, MYSQLI_ASSOC);
                                                                            foreach ($resultSel as $rows) : ?>
                                                                                <option <?php echo ($row['id_level'] == $rows['id']) ? 'selected' : '' ?> value="<?php echo $rows['id'] ?>"><?php echo $rows['level_name'] ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <label for="nameWithTitle" class="form-label">Name</label>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $row['name'] ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-3">
                                                                        <label for="nameWithTitle" class="form-label">Email</label>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="email" id="email" class="form-control" value="<?php echo $row['email'] ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <label for="nameWithTitle" class="form-label">Passwords</label>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input type="password" name="password" id="password" class="form-control" value="<?php echo $row['password'] ?>" aria-describedby="password" />
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