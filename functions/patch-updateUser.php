<?php
include("connect.php");
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    try {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $role = $_POST["role"];
        // Update users
        $sqlUser = "UPDATE users SET name = '$name', surname = '$surname', username = '$username', password = '$password',role = '$role' WHERE id = $id";
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
