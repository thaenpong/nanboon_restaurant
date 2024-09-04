<?php
include("connect.php");
session_start();

if (isset($_SESSION['id'])) {
    header("Location: /nb_res/home.php");
}

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        echo "<script>window.location.href = '/nb_res?error=notfound';</script>";
    } else {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['user']["id"] = $data['id'];
        $_SESSION['user']['username'] = $data['username'];
        $_SESSION['user']['name'] = $data['name'];
        $_SESSION['user']['surname'] = $data['surname'];
        $_SESSION['user']['role'] = $data['role'];
        if ($data['role'] == "admin") {

            echo "<script>window.location.href = '/nb_res/home.php?page=admin-menus';</script>";
        } else {
            echo "<script>window.location.href = '/nb_res/home.php';</script>";
        }
    }
}
