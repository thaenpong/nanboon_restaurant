<?php
include("connect.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    try {
        // Update orders
        $sql = "UPDATE orders SET printed = 1 WHERE id = $id";
        $qr = mysqli_query($conn, $sql);
        if ($qr) {
            ob_clean();
            echo json_encode(['message' => "success"]);
        } else {
            ob_clean();
            //http_response_code(400);
            echo json_encode(['message' => "error"]);
        }
    } catch (Exception $e) {
        ob_clean();
        http_response_code(400);
        echo json_encode(['message' => "error : $sql"]);
    }
}
