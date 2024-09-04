<?php
session_start();
include("./functions/connect.php");

if (!isset($_SESSION['user'])) {
    header("[Location]: /nb_res/home.php");
}

$adminPage = ['admin-users', 'admin-userAdd', 'admin-userEdit'];
/* $employeePage = ['admin-menus', 'admin-menuAdd', 'admin-menuEdit', 'admin-desks', 'admin-deskEdit', 'admin-deskAdd', 'billList']; */

if ($_SESSION['user']['role'] == 'admin') {
    if (isset($_GET["page"]) && in_array($_GET["page"], $adminPage)) {
        $page = $_GET["page"];
    } else {
        $page = "admin-users"; // Set a default page for admins
    }
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = "menuList"; // Set a default page for admins
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ร้านไก่ย่างหนานบุญ</title>
    <link rel="stylesheet" href="css/gobalstyle.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
    a {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Inherit color */
    }
</style>

<body>
    <div class="CContainer">
        <div class="Cnavbar">
            <div>
                <h2 class="welcomeUser"><a href="/nb_res/home.php">ร้านไก่ย่างหนานบุญ</a></h2>
            </div>
            <div>
                <h4 class="welcomeUser">สวัสดี <?= $_SESSION['user']['name'] . " " . $_SESSION['user']['surname'] ?> <a href="functions/logout.php" class="btn btn-danger">ออกจากระบบ</a></h4>
            </div>
        </div>
        <div class="Csidebar"><?php include("components/sidebar.php") ?></div>
        <div class="Cmain"><?php include("pages/" . $page . ".php"); ?></div>
        <div class="Cbilling"><?php if ($page == "billList") {
                                    include("components/BillItems.php");
                                } elseif ($page == "menuList") {
                                    include("components/MenuItems.php");
                                } else {
                                    ""; // Adjust the default component accordingly
                                } ?></div>
</body>

</html>