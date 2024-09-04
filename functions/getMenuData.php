<?php
include("connect.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM `menus` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $res = mysqli_fetch_assoc($result);
        // Clear any previous output
        ob_clean();
        // Convert the array to a JSON string and echo it
        echo json_encode($res);
    } else {
        // Handle the case where the query fails
        ob_clean();
        echo json_encode(["error" => "Query failed"]);
    }
} else {
    // Handle the case where $_GET["id"] is not set
    ob_clean();
    echo json_encode(["error" => "ID not set"]);
}
