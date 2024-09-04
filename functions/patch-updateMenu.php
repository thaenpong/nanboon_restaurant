<?php
include("connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $detail = $_POST["detail"];
        $price = $_POST["price"];
        $categorieId = $_POST['categorieId'];
        $discount = $_POST['discount'];

        // Check if a new image is uploaded
        if (!empty($_FILES['image']['name'])) {
            // Get the old image filename
            $sqlOldImage = "SELECT image FROM menus WHERE id = '$id'";
            $resultOldImage = mysqli_query($conn, $sqlOldImage);
            $oldImage = mysqli_fetch_assoc($resultOldImage)['image'];

            // Remove the old image file
            if (!empty($oldImage) && file_exists("../images/" . $oldImage)) {
                unlink("../images/" . $oldImage);
            }

            // Handle file upload for the new image
            $image_type = $_FILES['image']['type'];
            $image_temp = $_FILES['image']['tmp_name'];
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image = $id . '.' . $extension;
            move_uploaded_file($image_temp, "../images/" . $image);

            // Update the record with the new image information
            $sqlUpdateImage = "UPDATE menus SET image = '$image' WHERE id = $id";
            $qrUpdateImage = mysqli_query($conn, $sqlUpdateImage);

            if (!$qrUpdateImage) {
                ob_clean();
                echo json_encode(['message' => "error updating image"]);
                exit;
            }
        }

        // Update the rest of the record
        $sqlUpdate = "UPDATE menus SET name = '$name', price = '$price', detail = '$detail', categorieId = '$categorieId', discount = '$discount' WHERE id = '$id'";
        $result = mysqli_query($conn, $sqlUpdate);

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
