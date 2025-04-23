<?php
if (isset($_GET['idPay'])) {
    $id = $_GET['idPay'];
    $query = mysqli_query($conn, "SELECT trans_order.*, trans_order.id as tId, customers.*, customers.id as cId FROM trans_order LEFT JOIN customers on trans_order.id_customer = customers.id WHERE trans_order.id = '$id'");
    $data = mysqli_fetch_array($query);
}

if (isset($_POST['pay'])) {
    $id = $_GET['idPay'];
    $amount = $_POST['amount'];
    $change = $_POST['change'];
    $order_status = $_POST['order_status'];

    $query = mysqli_query($conn, "UPDATE trans_order SET order_status = '$order_status', order_pay = '$amount', change_pay = '$change' WHERE id = $id"); // update order status

    if ($query) {
        echo "<script>window.location.href='?page=transaction&payment=success';</script>";
    } else {
        echo "<script>alert('Payment Failed!')</script>";
        echo "<script>window.location.href='?page=transaction&payment=failed';</script>";
    }
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="card-title text-primary">Transactions</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="order_status" value="0">
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="">Customer Name</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control" name="customer_name" id="customer_name" value="<?= $data['customer_name'] ?>" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="">Transaction Total</label>
                            </div>
                            <div class="col-10">
                                <div class="input-group">
                                    <span class="input-group-text">Rp. </span>
                                    <input type="text" class="form-control" name="total_transaksi" id="total_transaksi" value="<?= $data['total'] ?>" readonly />
                                </div>
                            </div>
                        </div>
                        <!-- <div class=" row mb-3">
                            <div class="col-2">
                                <label for="">Order Status</label>
                            </div>
                            <div class="col-10">
                                <span style="margin-right: 10px;"></span>
                                <input type="radio" name="order_status" id="order_status" value="1" <?= isset($data['order_status']) && $data['order_status'] == 1 ? 'checked' : '' ?> /> Has Pickup
                            </div>
                        </div> -->
                        <hr>
                        <div class="card-title mb-4">
                            <h5 class="text-primary">Payments</h5>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="">Amount</label>
                            </div>
                            <div class="col-10">
                                <input type="number" class="form-control" name="amount" id="amount" oninput="payment()" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label for="">Change Amount</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control" name="change" id="change" />
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-10"></div> -->
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" name="pay">PAY!</button>
                                <?php if ($data['order_pay'] != 0) { ?>
                                    <a href="#" class="btn btn-light">PRINT</a>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>