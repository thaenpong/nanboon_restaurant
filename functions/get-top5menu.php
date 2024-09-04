<?php
include('connect.php');
$rs = "SELECT menus.*, SUM(orderitems.quantity) AS total_quantity
FROM menus
LEFT JOIN orderitems ON menus.id = orderitems.menuId
WHERE DATE(orderitems.createAt) >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01')
AND DATE(orderitems.createAt) < DATE_FORMAT(CURDATE(), '%Y-%m-01')
GROUP BY menus.id
ORDER BY total_quantity DESC
LIMIT 5;
";


$qr = mysqli_query($conn, $rs);
$topmenu = array();
while ($row = mysqli_fetch_assoc($qr)) {
    $topmenu[] = $row;
}
ob_clean();
header('Content-Type: application/json');
echo json_encode($topmenu);
