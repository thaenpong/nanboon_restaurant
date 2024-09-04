<?php
include("connect.php");
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id = $_POST["id"];
        $label = $_POST["label"];
        $sheets = $_POST["sheets"];
        $takeAwayString = $_POST["takeAway"];
        if ($takeAwayString == "on") {
            $takeAway = 1;
        } else {
            $takeAway = 0;
        }
        // Update users
        $sqlUser = "UPDATE desks SET label = '$label', sheets = '$sheets',takeAway = '$takeAway' WHERE id = $id";
        $result = mysqli_query($conn, $sqlUser);

        if ($result) {
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
