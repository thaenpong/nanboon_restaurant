<?php

include('connect.php');

if (isset($_GET["month"])) {
    $selectedMonth = $_GET["month"];

    $sql = "SELECT orders.*, SUM(menus.price * orderitems.quantity) AS total_menu_price
            FROM orders
            INNER JOIN orderitems ON orders.id = orderitems.orderId
            INNER JOIN menus ON orderitems.menuId = menus.id
            WHERE MONTH(orders.createdAt) = $selectedMonth
            AND orders.status <> 2
            GROUP BY orders.id";

    $qrOrders = mysqli_query($conn, $sql);

    // Initialize total price and total discount
    $totalPrice = 0;
    $totalDiscount = 0;

    $ordersData = array();
    while ($row = mysqli_fetch_assoc($qrOrders)) {
        // Accumulate the total price by adding the price of each order
        $totalPrice += $row['total_menu_price'];

        // Accumulate the total discount by adding the discount of each order
        $totalDiscount += $row['discount'];

        // Append the order data to the array
        $ordersData[] = $row;
    }

    // Use an associative array to store the results
    $result = array(
        'orders' => $ordersData, // Include the array of orders
        'totalPrice' => $totalPrice,
        'totalDiscount' => $totalDiscount
    );

    // Send the response as JSON
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($result);
}

if (isset($_GET["year"])) {
    $selectedYear = $_GET["year"];



    $sql = "SELECT menus.name, 
       SUM(orderitems.quantity) AS sumQuantity,
       SUM(orderitems.discount) AS discount, -- Renamed alias to avoid ambiguity
       SUM(menus.price * orderitems.quantity) AS total_menu_price, -- Added a comma here
       SUM((menus.price * orderitems.quantity) - (orderitems.discount * orderitems.quantity)) AS total -- Used orderitems.discount to remove ambiguity
       FROM orderitems
       INNER JOIN menus ON orderitems.menuId = menus.id
       WHERE YEAR(orderitems.createAt) = '$selectedYear'
       GROUP BY menus.id
       ORDER BY sumQuantity DESC;";


    $qrOrders = mysqli_query($conn, $sql);

    // Initialize total price and total discount
    $totalPrice = 0;
    $totalDiscount = 0;

    $ordersData = array();
    while ($row = mysqli_fetch_assoc($qrOrders)) {
        // Accumulate the total price by adding the price of each order
        $totalPrice += $row['total_menu_price'];

        // Accumulate the total discount by adding the discount of each order
        $totalDiscount += $row['discount'];

        // Append the order data to the array
        $ordersData[] = $row;
    }

    // Use an associative array to store the results
    $result = array(
        'orders' => $ordersData, // Include the array of orders
        'totalPrice' => $totalPrice,
        'totalDiscount' => $totalDiscount
    );

    // Send the response as JSON
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($result);
}

if (isset($_GET["date"])) {
    $selecteddate = $_GET["date"];

    $sql = "SELECT menus.name, 
       SUM(orderitems.quantity) AS sumQuantity,
       SUM(orderitems.discount) AS discount, -- Renamed alias to avoid ambiguity
       SUM(menus.price * orderitems.quantity) AS total_menu_price, -- Added a comma here
       SUM((menus.price * orderitems.quantity) - (orderitems.discount * orderitems.quantity)) AS total -- Used orderitems.discount to remove ambiguity
       FROM orderitems
       INNER JOIN menus ON orderitems.menuId = menus.id
       WHERE DATE(orderitems.createAt) = '$selecteddate'
       GROUP BY menus.id
       ORDER BY sumQuantity DESC;";



    $qrOrders = mysqli_query($conn, $sql);

    // Initialize total price and total discount
    $totalPrice = 0;
    $totalDiscount = 0;

    $ordersData = array();
    while ($row = mysqli_fetch_assoc($qrOrders)) {
        // Accumulate the total price by adding the price of each order
        $totalPrice += $row['total_menu_price'];

        // Accumulate the total discount by adding the discount of each order
        $totalDiscount += $row['discount'];

        // Append the order data to the array
        $ordersData[] = $row;
    }

    // Use an associative array to store the results
    $result = array(
        'orders' => $ordersData, // Include the array of orders
        'totalPrice' => $totalPrice,
        'totalDiscount' => $totalDiscount
    );

    // Send the response as JSON
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($result);
}

if (isset($_GET["fromDate"]) && isset($_GET["toDate"])) {
    $fromDate = $_GET["fromDate"];
    $toDate = $_GET["toDate"];

    /*  $sql = "SELECT menus.name,
            SUM(orderitems.quantity) as quantity,
            SUM(quantity * menus.price) as price
            FROM orders 
            INNER JOIN orderitems ON orderitems.orderId = orders.id
            INNER JOIN menus ON menus.id = orderitems.menuId
            WHERE DATE(orders.createdAt) BETWEEN '$fromDate' AND '$toDate' 
            AND orders.status <> 2
            GROUP BY menus.id
            ORDER BY quantity DESC";
             */
    $sql = "SELECT menus.name, 
       SUM(orderitems.quantity) AS sumQuantity,
       SUM(orderitems.discount) AS discount, -- Renamed alias to avoid ambiguity
       SUM(menus.price * orderitems.quantity) AS total_menu_price, -- Added a comma here
       SUM((menus.price * orderitems.quantity) - (orderitems.discount * orderitems.quantity)) AS total -- Used orderitems.discount to remove ambiguity
       FROM orderitems
       INNER JOIN menus ON orderitems.menuId = menus.id
       WHERE DATE(orderitems.createAt) BETWEEN '$fromDate' AND '$toDate' 
       GROUP BY menus.id
       ORDER BY sumQuantity DESC;";

    /*  $qrTotal = mysqli_query($conn, $sql);

    $totalPrice = 0;
    while ($total = mysqli_fetch_assoc($qrTotal)) {
        $totalPrice += $total['price'];
    }

    $totalDiscount = 0;
    $sqlDiscount = "SELECT discount FROM orders WHERE DATE(orders.createdAt) BETWEEN '$fromDate' AND '$toDate'";
    $qrDiscount = mysqli_query($conn, $sqlDiscount);

    while ($discount = mysqli_fetch_assoc($qrDiscount)) {
        $totalDiscount += $discount['discount'];
    }

    $qrMenus = mysqli_query($conn, $sql);
    $rsMenu = mysqli_fetch_all($qrMenus, MYSQLI_ASSOC);

    // Use an associative array to store the results
    $result = array(
        'menus' => $rsMenu,
        'totalPrice' => $totalPrice,
        'totalDiscount' => $totalDiscount
    );

    // Send the response as JSON
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($result); */
    $qrOrders = mysqli_query($conn, $sql);

    // Initialize total price and total discount
    $totalPrice = 0;
    $totalDiscount = 0;

    $ordersData = array();
    while ($row = mysqli_fetch_assoc($qrOrders)) {
        // Accumulate the total price by adding the price of each order
        $totalPrice += $row['total_menu_price'];

        // Accumulate the total discount by adding the discount of each order
        $totalDiscount += $row['discount'];

        // Append the order data to the array
        $ordersData[] = $row;
    }

    // Use an associative array to store the results
    $result = array(
        'orders' => $ordersData, // Include the array of orders
        'totalPrice' => $totalPrice,
        'totalDiscount' => $totalDiscount
    );

    // Send the response as JSON
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($result);
}
