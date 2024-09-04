<?php
include("connect.php");

$sql = "SELECT * FROM `categories`";
$foodcategory = mysqli_query($conn, $sql);
