<?php
if (isset($_GET['id'])) {
    $id = $_GET["id"];
    /* $sql = "SELECT menus.name, 
    orderitems.quantity ,
    orderitems.id,
    menus.price,
    menus.price * orderitems.quantity as totalPrice
    FROM orderitems 
    INNER JOIN menus ON menus.id = orderitems.menuId
    WHERE orderitems.orderId = $id";
    $result = mysqli_query($conn, $sql);

    $sqlOrder = "SELECT orders.id ,
    desks.label,
    desks.id as deskId,
    orders.status,
    orders.discount,
    users.name,
    users.surname,
    orders.createdAt
    FROM orders 
    INNER JOIN desks ON desks.id = orders.deskId
    INNER JOIN users ON users.id = orders.userId
    WHERE orders.id = $id";
    $qr = mysqli_query($conn, $sqlOrder);
    $rs = mysqli_fetch_assoc($qr);

    $totalPrice = 0;

    $qrtotal = mysqli_query($conn, $sql);
    while ($rowtotal = mysqli_fetch_assoc($qrtotal)) {
        $totalPrice += $rowtotal['totalPrice'];
    } */
    $totalPrice = 0;
    $totalDiscount = 0;
    $menusData = [];
    $table = [];
    $emp = [];
    $sql = "SELECT menus.name, 
        SUM(orderitems.quantity) AS sumQuantity,
        SUM(orderitems.discount) AS discount, -- Renamed alias to avoid ambiguity
        SUM(menus.price * orderitems.quantity) AS total_menu_price, -- Added a comma here
        SUM((menus.price * orderitems.quantity) - (orderitems.discount * orderitems.quantity)) AS total, -- Used orderitems.discount to remove ambiguity,
        orderitems.id as id
        FROM orderitems
        INNER JOIN menus ON orderitems.menuId = menus.id
        WHERE orderitems.orderId = $id
        GROUP BY menus.id
        ORDER BY total DESC;";


    $qrOrders = mysqli_query($conn, $sql);

    // Initialize total price and total discount

    while ($row = mysqli_fetch_assoc($qrOrders)) {
        $totalPrice += $row['total_menu_price'];
        $totalDiscount += $row['sumQuantity'] * $row['discount'];
        $menusData[] = $row; // Store row for later use in PDF generation
    }

    $sqlOrder = "SELECT desks.id as deskId,desks.label,orders.status,orders.createdAt,
        users.name,
        users.surname
        FROM orders 
        INNER JOIN desks ON desks.id = orders.deskId
        INNER JOIN users ON users.id = orders.userId
        WHERE orders.id = $id";
    $qr = mysqli_query($conn, $sqlOrder);
    $rs = mysqli_fetch_assoc($qr);
}

?>
<html>
<div class="container">
    <div class="d-flex flex-row-reverse my-1">
        <?php if ($rs['status'] == 1) : ?>
            <div class="col-md-2">
                <button class="btn btn-warning" onclick="changeDesk(<?= $id ?>,<?= $rs['deskId'] ?>)">เปลี่ยนโต๊ะ</button>
            </div>
        <?php endif; ?>
        <div class="col-md-2">
            <a href="functions/get-receipt.php?orders=<?= $id ?>" target="_blank" class="btn btn-primary">พิมพ์ใบเสร็จ</a>
        </div>

    </div>
    <div>
        <p>รหัส : <?= $id ?></p>
        <p>โต๊ะ : <?= $rs["label"] ?></p>
        <p>วันที่ : <?= $rs['createdAt'] ?></p>
        <p>ราคา : ฿<?= $totalPrice ?></p>
        <p>ส่วนลด : ฿<?= $totalDiscount ?></p>
        <p>ราคาสุทธิ : ฿<?= $totalPrice - $totalDiscount ?></p>
    </div>

    <div>
        <table class="table mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>
                        ลำดับ
                    </th>
                    <th>
                        ชื่อ
                    </th>
                    <th>
                        จำนวน
                    </th>
                    <th>
                        ราคา
                    </th>
                    <th>
                        ส่วนลด
                    </th>
                    <th>
                        ราคารวม
                    </th>
                    <?php if ($rs['status'] == 1) : ?>
                        <th>
                            แก้ไขจำนวน
                        </th>
                        <th>
                            จัดการ
                        </th>
                    <?php endif; ?>
                </tr>

            </thead>
            <tbody>
                <?php
                $key = 0;
                foreach ($menusData as $row) {
                    $key += 1;
                ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['sumQuantity'] ?></td>
                        <td>฿<?= $row['total_menu_price'] ?></td>
                        <td>฿<?= $row['discount'] ?></td>
                        <td>฿<?= $row['total_menu_price'] - $row['discount'] ?></td>
                        <?php if ($rs['status'] == 1) : ?>
                            <td>
                                <button class="btn btn-info" onclick="quantityChange(<?= $row['sumQuantity'] ?>,<?= $row['id'] ?>)">แก้ไขจำนวน</button>
                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="deleteMenu(<?= $row['id'] ?>)">ลบ</button>
                            </td>
                        <?php endif; ?>

                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function quantityChange(quantity, id) {
        Swal.fire({
            title: "ระบุจำนวน",
            input: "text",
            inputValue: quantity,
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "ตกลง",
            cancelButtonText: "ยกเลิก",
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Get the updated quantity value from the input field
                var updatedQuantity = result.value;

                // Send AJAX request to update the quantity
                $.ajax({
                    type: "POST",
                    url: "functions/patch-orderDetail.php",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    data: {
                        id: id,
                        quantity: updatedQuantity
                    },
                    success: function(response) {
                        // Parse the JSON response
                        var responseData = JSON.parse(response);

                        // Check if the message is equal to "success"
                        if (responseData.message === "success") {
                            // Show SweetAlert for success
                            Swal.fire({
                                title: "สำเร็จ!",
                                text: "บันทึกข้อมูลสำเร็จ",
                                icon: "success",
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            // Show SweetAlert for other cases (error, etc.)
                            Swal.fire({
                                title: "ไม่สำเร็จ!",
                                text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
                                icon: "error",
                            });
                        }
                    },
                    error: function() {
                        // Show SweetAlert if an error occurs during the AJAX request
                        Swal.fire({
                            title: "ไม่สำเร็จ!",
                            text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
                            icon: "error",
                        });
                    },
                });
            }
        });
    }

    function deleteMenu(id) {
        Swal.fire({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณต้องการลบรายการนี้ใช่หรือไม่?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "ใช่",
            cancelButtonText: "ไม่ใช่",
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete the order item
                $.ajax({
                    type: "POST",
                    url: "functions/delete-orderItem.php",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // Parse the JSON response
                        var responseData = JSON.parse(response);

                        // Check if the message is equal to "success"
                        if (responseData.message === "success") {
                            // Show SweetAlert for success
                            Swal.fire({
                                title: "สำเร็จ!",
                                text: "ลบรายการสำเร็จ",
                                icon: "success",
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            // Show SweetAlert for other cases (error, etc.)
                            Swal.fire({
                                title: "ไม่สำเร็จ!",
                                text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
                                icon: "error",
                            });
                        }
                    },
                    error: function() {
                        // Show SweetAlert if an error occurs during the AJAX request
                        Swal.fire({
                            title: "ไม่สำเร็จ!",
                            text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
                            icon: "error",
                        });
                    },
                });
            }
        });
    }

    function changeDesk(id, oldDeskId) {
        (async function() {
            const res = await fetch("functions/get-desks.php");
            const desks = await res.json();

            let deskOptions = {};

            // Loop through the desks array and populate the deskOptions object
            desks.forEach(function(desk) {
                let status = "ว่าง";
                if (desk.status == 1) {
                    deskOptions[desk.id] = desk.label + ` (${status})`;
                }
            });

            Swal.fire({
                title: "เลือกที่นั่ง",
                input: "select",
                inputOptions: deskOptions,
                showCancelButton: true,
                inputValidator: function(value) {
                    return new Promise(function(resolve, reject) {
                        if (value !== "") {
                            resolve();
                        } else {
                            resolve("You need to select a Tier");
                        }
                    });
                }, //result.value,
            }).then(function(result) {
                if (result.isConfirmed) {
                    // Send AJAX request to change the desk
                    $.ajax({
                        type: "POST",
                        url: "functions/patch-activeOrderDesk.php",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        data: {
                            id: id,
                            deskId: result.value,
                            oldDeskId: oldDeskId
                        },
                        success: function(response) {
                            // Parse the JSON response
                            var responseData = JSON.parse(response);

                            // Check if the message is equal to "success"
                            if (responseData.message === "success") {
                                // Show SweetAlert for success
                                Swal.fire({
                                    title: "สำเร็จ!",
                                    text: "เปลี่ยนโต๊ะสำเร็จ",
                                    icon: "success",
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                // Show SweetAlert for other cases (error, etc.)
                                Swal.fire({
                                    title: "ไม่สำเร็จ!",
                                    text: "มีบางอย่างผลิดพลาดกรุณาลองใหม่",
                                    icon: "error",
                                });
                            }
                        },
                    });
                }
            });
        })();
    }
</script>

</html>