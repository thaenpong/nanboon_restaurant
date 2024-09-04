<?php
include("connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = $_POST["name"];
        $detail = $_POST["detail"];
        $price = $_POST["price"];
        $categorieId = $_POST['categorieId'];

        $sql = "INSERT INTO menus (name,price,detail,status,categorieId) VALUE ('$name','$price','$detail','1','$categorieId')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if (!empty($_FILES['image']['name'])) {
                $lastInsertedId = mysqli_insert_id($conn);
                // Handle file upload
                $image_type = $_FILES['image']['type'];
                $image_temp = $_FILES['image']['tmp_name'];

                // Extract the extension from the image type
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                // Construct the image filename
                $image = $lastInsertedId . '.' . $extension;


                move_uploaded_file($image_temp, "../images/" . $image);

                // Update the record with the image information
                $sqlUpdate = "UPDATE menus SET image = '$image' WHERE id = $lastInsertedId";
                $qrUpdate = mysqli_query($conn, $sqlUpdate);

                if ($qrUpdate) {

                    ob_clean();
                    echo json_encode(['message' => "success"]);
                }
            } else {
                ob_clean();
                echo json_encode(['message' => "success"]);
                // You might want to exit or return from the script at this point
            }
        } else {
            ob_clean();
            echo json_encode(['message' => "error"]);
        }
    } catch (Exception $e) {
        ob_clean();
        echo json_encode(['message' => "error" . $e->getMessage()]);
    }
}
