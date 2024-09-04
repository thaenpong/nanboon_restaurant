<?php
include("connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    parse_str(file_get_contents("php://input"), $_PATCH); // Parse the raw data as PATCH parameters

    $id = $_PATCH["id"];
    $deskId = $_PATCH["deskId"];

    try {
        // Update orders
        $sqlOrder = "UPDATE orders SET status = 2 WHERE id = $id";
        $qrOrder = mysqli_query($conn, $sqlOrder);

        // Update tables
        $sqlTable = "UPDATE desks SET status = 1 WHERE id = $deskId";
        $qrTable = mysqli_query($conn, $sqlTable);

        if ($qrOrder && $qrTable) {
            ob_clean();
            echo json_encode(['message' => "success"]);
        } else {
            ob_clean();
            http_response_code(400);
            echo json_encode(['message' => "error"]);
        }
    } catch (Exception $e) {
        ob_clean();
        http_response_code(400);
        echo json_encode(['message' => "error"]);
    }
}
