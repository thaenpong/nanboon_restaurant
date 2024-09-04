<?php
include "connect.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT menus.name as name,
    orderitems.quantity as quantity,
    orders.deskId as deskId, menus.price as price,
    orderitems.note as note,
    orders.printed as printed,
    menus.discount as discount
    FROM orderitems 
    LEFT JOIN menus ON menus.id = orderitems.menuId 
    LEFT JOIN orders ON orders.id = orderitems.orderId 
    WHERE orderitems.orderId = '$id';";
    $qr = mysqli_query($conn, $sql);

    if ($qr) {
        // Assuming you want to fetch all rows related to the order
        $res = mysqli_fetch_all($qr, MYSQLI_ASSOC);
        ob_clean();
        echo json_encode($res);
    }
}
