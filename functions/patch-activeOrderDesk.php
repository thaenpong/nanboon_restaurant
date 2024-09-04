<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $deskId = $_POST["deskId"];
    $oldDeskId = $_POST["oldDeskId"];

    try {
        // Update orders
        $sql = "UPDATE orders SET deskId = $deskId WHERE id = $id";
        $qr = mysqli_query($conn, $sql);

        if ($qr) {
            try {
                // Update orderitems
                $sql1 = "UPDATE desks SET status = '1' WHERE id = $oldDeskId";
                $qr1 = mysqli_query($conn, $sql1);

                $sql2 = "UPDATE desks SET status = '0' WHERE id = $deskId";
                $qr2 = mysqli_query($conn, $sql2);

                if ($qr1 && $qr2) {
                    ob_clean();
                    echo json_encode(['message' => "success"]);
                } else {
                    throw new Exception("Failed to update desks");
                }
            } catch (Exception $e) {
                ob_clean();
                http_response_code(400);
                echo json_encode(['message' => "error : " . $e->getMessage()]);
            }
        } else {
            ob_clean();
            echo json_encode(['message' => "error"]);
        }
    } catch (Exception $e) {
        ob_clean();
        http_response_code(400);
        echo json_encode(['message' => "error : $e"]);
    }
}
