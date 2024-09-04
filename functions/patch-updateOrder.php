<?php
include("connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    parse_str(file_get_contents("php://input"), $_PATCH); // Parse the raw data as PATCH parameters

    $ordersString = $_PATCH["orders"];
    $orders = explode(",", $ordersString);
    $paytype = $_PATCH["paytype"];



    try {
        foreach ($orders as $id) {
            // Update orders
            $sqlOrder = "UPDATE orders SET status = 0, paytype = $paytype, doneAt = NOW() WHERE id = $id";
            $qrOrder = mysqli_query($conn, $sqlOrder);


            $sql = "SELECT desks.id FROM orders LEFT JOIN desks ON orders.deskId = desks.id WHERE orders.id = $id";
            $qr = mysqli_query($conn, $sql);
            $rs = mysqli_fetch_assoc($qr);
            $deskId = $rs['id'];

            // Update tables
            $sqlTable = "UPDATE desks SET status = 1 WHERE id = $deskId";
            $qrTable = mysqli_query($conn, $sqlTable);
        }
        ob_clean();
        echo json_encode(['message' => "success"]);
    } catch (Exception $e) {
        ob_clean();
        http_response_code(400);
        echo json_encode(['message' => "error" . $e->getMessage()]);
    }
}
