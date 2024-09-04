<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    try {
        // Update orders
        $sql = "DELETE FROM orderitems WHERE `orderitems`.`id` = $id";
        $qr = mysqli_query($conn, $sql);
        if ($qr) {
            ob_clean();
            echo json_encode(['message' => "success"]);
        } else {
            ob_clean();
            echo json_encode(['message' => "error"]);
        }
    } catch (Exception $e) {
        ob_clean();
        echo json_encode(['message' => "error" . $e->getMessage()]);
    }
}
