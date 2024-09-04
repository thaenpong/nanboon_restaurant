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
        $sqlUser = "INSERT INTO users (name, surname, username, password, role,isActive) VALUES ('$name', '$surname', '$username', '$password', '$role','1')";
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
