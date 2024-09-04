<?php
$sql = "SELECT orders.id as id,orders.day_queue, desks.id as deskId, desks.label as label FROM orders INNER JOIN desks ON desks.id = orders.deskId WHERE orders.status = 1 ORDER BY day_queue;";
$qr = mysqli_query($conn, $sql);


function getTotal($id)
{
    include "./functions/connect.php";
    $price = 0;
    $sqlPrice = "SELECT menus.price , orderItems.quantity FROM orderItems
    INNER JOIN menus ON menus.id = orderItems.menuId
     WHERE orderId = $id";
    $qrSPrice = mysqli_query($conn, $sqlPrice);

    // Check if the query executed successfully
    if ($qrSPrice) {
        // Fetch each row and accumulate the price
        while ($rs = mysqli_fetch_assoc($qrSPrice)) {
            $price += $rs['price'] * $rs['quantity'];
        }

        // Close the result set
        mysqli_free_result($qrSPrice);
    } else {
        // Handle query error if needed
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);

    echo $price;
}

?>
<html>

<head>

</head>
<div class="container mt-5">
    <div>
        <center class="mb-5">
            <h2>รายการออเดอร์</h2>
        </center>
    </div>
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">คิว</th>
                    <th scope="col">โต๊ะ</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">รายละเอียด</th>
                    <th scope="col">ยกเลิก</th>
                    <th scope="col">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $key = 0;
                foreach ($qr as $row) {
                    $key++;
                ?>
                    <tr>
                        <th scope=" row"><?= $key ?></th>
                        <th scope="row"><?= $row['day_queue'] ?></th>
                        <td><?= $row['label'] ?></td>
                        <td>฿<?= getTotal($row['id']) ?></td>
                        <td class="col-md-2">
                            <a href="/nb_res/home.php?page=manage-orderDetail&id=<?= $row['id'] ?>" class="btn btn-info">รายละเอียด</a>
                        </td>
                        <td class="col-md-1">
                            <button class="btn btn-danger" onclick="cancleOrder(<?= $row['id'] ?>,<?= $row['deskId'] ?>)">ยกเลิก</button>
                        </td>
                        <td class="col-md-3">
                            <button class="btn btn-primary" onclick="getTable(<?= $row['id'] ?>)">เลือก</button> | <button class="btn btn-primary sumTable" id="sum<?= $row['id'] ?>" hidden onclick="sumTable(<?= $row['id'] ?>)">รวม</button>
                        </td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
<script src="./js/billList.js"></script>

</html>