<?php
include("connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menuItems = json_decode($_POST['menuItems'], true);
    $tableId = $_POST['selectedValue'];
    $tableStatus = checkTableStatus($tableId);
    $orderId = null;

    if ($tableStatus == 1) {
        // Create new order if the table is empty
        $orderId = createNewOrder($tableId);
    } else {
        // Get the existing order ID for the specified desk
        $orderId = getExistingOrderId($tableId);
        updateQueue($orderId);
        if (!$orderId) {
            ob_clean();
            http_response_code(400);
            echo json_encode(["message" => "No order found for the specified desk"]);
            exit();
        }
    }

    // Insert menu items into orderitems table
    insertMenuItems($orderId, $menuItems);

    ob_clean();
    echo json_encode(["message" => "success", "id" => $orderId]);
}

function checkTableStatus($id)
{
    include("connect.php");
    $sql = "SELECT status,takeAway FROM `desks` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($result);
    if ($result) {
        if ($result['takeAway'] == 1) {
            return 1;
        }
        return $result['status'];
    } else {
        return 0;
    }
}

function createNewOrder($tableId)
{
    include("connect.php");
    $queue = lastGetQueue();
    $createOrder = "INSERT INTO `orders` (userId, deskId, status, createdAt, day_queue) VALUES ('{$_SESSION['user']['id']}', '{$tableId}', '1', NOW(),'$queue')";
    $qr = mysqli_query($conn, $createOrder);

    if ($qr) {
        $orderId = mysqli_insert_id($conn);
        updateTableStatus($tableId, 0);
        return $orderId;
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Query failed"]);
        exit();
    }
}

function getExistingOrderId($tableId)
{
    include("connect.php");
    $selectOrderId = "SELECT `id` FROM orders WHERE `deskId` = '{$tableId}' AND `status` = 1 ORDER BY id DESC LIMIT 1";
    $qrOrderId = mysqli_query($conn, $selectOrderId);

    return $qrOrderId ? mysqli_fetch_assoc($qrOrderId)['id'] : null;
}

function insertMenuItems($orderId, $menuItems)
{
    include("connect.php");
    foreach ($menuItems as $menuItem) {
        $itemId = $menuItem['itemId'];
        $quantity = $menuItem['quantity'];
        $note = $menuItem['note'];

        // Check if the item already exists in the order
        $existingOrderItem = getExistingOrderItem($orderId, $itemId, $note);

        if ($existingOrderItem) {
            // Item already exists, update quantity
            $newQuantity = $existingOrderItem['quantity'] + $quantity;

            $updateSql = "UPDATE orderitems SET quantity = $newQuantity WHERE id = {$existingOrderItem['id']}";
            $updateResult = mysqli_query($conn, $updateSql);

            if (!$updateResult) {
                http_response_code(400);
                echo json_encode(["message" => "Error updating existing order item"]);
                exit();
            }
        } else {
            $dis = getDiscount($itemId, $quantity);
            // Item does not exist, insert a new record
            $insertSql = "INSERT INTO orderitems (orderId, menuId, quantity,note,discount) VALUES ('$orderId','$itemId', '$quantity','$note','$dis')";
            $insertResult = mysqli_query($conn, $insertSql);

            if (!$insertResult) {
                http_response_code(400);
                echo json_encode(["message" => "Error inserting new order item"]);
                exit();
            }
        }
    }
}

function updateTableStatus($id, $status)
{
    include 'connect.php';
    $sql = "UPDATE desks SET status = $status WHERE id = $id";
    $qr = mysqli_query($conn, $sql);

    if (!$qr) {
        http_response_code(400);
        echo json_encode(["message" => "Error updating table status"]);
        exit();
    }
}

function getExistingOrderItem($orderId, $itemId, $note)
{
    include 'connect.php';
    $sql = "SELECT id, quantity FROM orderitems WHERE orderId = $orderId AND menuId = '$itemId' AND note = '$note'";
    $qr = mysqli_query($conn, $sql);

    return $qr ? mysqli_fetch_assoc($qr) : null;
}

function lastGetQueue()
{
    include 'connect.php';

    // Get the last day_queue from orders table
    $sql = "SELECT day_queue, DATE_FORMAT(createdAt, '%Y-%m-%d') AS order_date 
        FROM orders 
        WHERE DATE(createdAt) = CURDATE() AND status != 2 
        ORDER BY day_queue DESC LIMIT 1";

    $qr = mysqli_query($conn, $sql);

    if ($qr && mysqli_num_rows($qr) > 0) {
        $row = mysqli_fetch_assoc($qr);
        $last_day_queue = $row['day_queue'];
        $order_date = $row['order_date'];

        // Get today's date
        $current_date = date('Y-m-d');

        // If the last order was placed on the same day
        if ($order_date == $current_date) {
            // Increment the last day_queue by 1
            $new_queue = $last_day_queue + 1;
        } else {
            // If it's a new day, reset the queue to 2
            $new_queue = 1;
        }
    } else {
        // If there are no orders yet, set the queue to 1
        $new_queue = 1;
    }

    return $new_queue;
}

function updateQueue($id)
{
    include 'connect.php';
    $queue = lastGetQueue();
    $sql = "UPDATE orders SET day_queue = $queue WHERE id = $id";
    $qr = mysqli_query($conn, $sql);

    if (!$qr) {
        http_response_code(400);
        echo json_encode(["message" => "Error updating table status"]);
        exit();
    }
}

function getDiscount($id, $quantity)
{
    include 'connect.php';
    $sql = "SELECT price, discount FROM menus WHERE id = $id";
    $qr = mysqli_query($conn, $sql);
    if ($qr) {
        $res = mysqli_fetch_assoc($qr);
        if ($res['discount']) {
            $discount = $res['price'] * $quantity * ($res['discount'] / 100);
            return $discount;
        } else {
            return 0;
        }
    } else {
        // Handle query error if needed
        return 0;
    }
}
