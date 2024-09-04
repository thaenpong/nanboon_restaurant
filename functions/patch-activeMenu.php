<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    parse_str(file_get_contents("php://input"), $_PATCH); // Parse the raw data as PATCH parameters
    $id = $_PATCH["id"];

    try {
        // Update orders
        $sql = "UPDATE menus SET status = '1' WHERE id = $id";
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
