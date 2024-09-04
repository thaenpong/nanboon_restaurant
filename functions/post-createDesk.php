<?php
include("connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $label = $_POST["label"];
        $sheets = $_POST["sheets"];
        $takeAwayString = $_POST["takeAway"];
        if ($takeAwayString == "on") {
            $takeAway = 1;
        } else {
            $takeAway = 0;
        }
        // Update users
        $sqlUser = "INSERT INTO desks (label,sheets,status,takeAway) VALUE ('$label','$sheets','1','$takeAway')";
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
