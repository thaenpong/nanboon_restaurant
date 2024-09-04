<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = $_POST["quantity"];
    $id = $_POST["id"];
    try {
        // Update orders
        $sql = "UPDATE orderitems SET quantity = $quantity WHERE id = $id";
        $qr = mysqli_query($conn, $sql);
        if ($qr) {
            ob_clean();
            echo json_encode(['message' => "success", 'id' => $id, 'quantity' => $quantity]);
        } else {
            ob_clean();
            echo json_encode(['message' => "error"]);
        }
    } catch (Exception $e) {
        ob_clean();
        echo json_encode(['message' => "error" . $e->getMessage()]);
    }
}
