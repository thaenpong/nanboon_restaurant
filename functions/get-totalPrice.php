<?php
include "connect.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    //$sql = "SELECT SUM(orderitems.quantity * menus.price) AS totalPrice FROM orders JOIN orderitems ON orders.id = orderitems.id JOIN menus ON orderitems.menuId = menus.id WHERE orders.id = $id";
    $sql = "SELECT SUM(menus.price * orderitems.quantity) AS total FROM orderitems
        INNER JOIN orders ON orders.id = orderitems.orderId
        INNER JOIN menus ON menus.id = orderitems.menuId
        WHERE orderitems.orderId = $id";

    $qr = mysqli_query($conn, $sql);

    if ($qr) {
        // Assuming you want to fetch all rows related to the order
        $res = mysqli_fetch_assoc($qr);
        ob_clean();
        echo json_encode($res);
    }
}
