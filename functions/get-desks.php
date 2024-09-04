<?php
include "connect.php";

$sql = "SELECT * FROM desks WHERE status <> 2;";
$qr = mysqli_query($conn, $sql);
if ($qr) {
    // Assuming you want to fetch all rows related to the order
    $res = mysqli_fetch_all($qr, MYSQLI_ASSOC);
    ob_clean();
    echo json_encode($res);
}
