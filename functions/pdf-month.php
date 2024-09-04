<?php
include('../fpdf/fpdf.php');
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurantdb";
$port = 3306;
$conn = mysqli_connect($servername, $username, $password, $database, $port);
$conn->set_charset("utf8");



if (isset($_GET["month"])) {
    $selectedMonth = $_GET["month"];
    $thai_months = array(
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม'
    );

    // Get the Thai month name
    $thai_month = $thai_months[intval($selectedMonth)];

    $sql = "SELECT orders.*, SUM(menus.price * orderitems.quantity) AS total_menu_price,users.name ,users.surname
            FROM orders
            INNER JOIN orderitems ON orders.id = orderitems.orderId
            INNER JOIN menus ON orderitems.menuId = menus.id
        INNER JOIN users ON orders.userId = users.id
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

    $pdf = new FPDF('P', 'mm', 'A4');

    $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');

    $pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');
    $pdf->AddPage();
    $pdf->SetFont('THSarabunNew', 'B', 24);

    $pdf->Cell(186, 14, iconv('UTF-8', 'cp874', 'ร้านอาหารไก่ย่างหนานบุญ'), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 20);
    $pdf->Cell(186, 14, iconv('UTF-8', 'cp874', '191 ม.6 ต.เวียงตาล อ.ห้างฉัตร จ.ลำปาง 52190'), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 18);
    $pdf->Cell(186, 10, iconv('UTF-8', 'cp874', '----------------------------------------------------------------------------------------------------------------------------'), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', 'B', 20);
    $pdf->Cell(186, 4, iconv('UTF-8', 'cp874', 'รายงานยอดขายรายเดือน'), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(1, 8, iconv('UTF-8', 'cp874', 'เดือนที่ : ' . $thai_month), 0, 0, 'r');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(1, 8, iconv('UTF-8', 'cp874', 'ออเดอร์ : ' . count($ordersData)), 0, 0, 'r');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(1, 8, iconv('UTF-8', 'cp874', 'ยอดขาย : ' . $totalPrice . " บาท"), 0, 0, 'r');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(1, 8, iconv('UTF-8', 'cp874', 'ส่วนลด : ' . $totalDiscount . " บาท"), 0, 0, 'r');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(1, 8, iconv('UTF-8', 'cp874', 'รวมทั้งหมด : ' . $totalPrice - $totalDiscount . " บาท"), 0, 0, 'r');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 18);
    $pdf->SetFont('THSarabunNew', '', 18);
    $pdf->Cell(186, 10, iconv('UTF-8', 'cp874', '----------------------------------------------------------------------------------------------------------------------------'), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', 'B', 16);
    $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', 'ลำดับ'), 0, 0, 'L');
    $pdf->Cell(10, 8, iconv('UTF-8', 'cp874', 'ชื่อ'), 0, 0, 'R');
    $pdf->Cell(40, 8, iconv('UTF-8', 'cp874', 'จำนวน'), 0, 0, 'R');
    $pdf->Cell(40, 8, iconv('UTF-8', 'cp874', 'ราคา'), 0, 0, 'R');
    $pdf->Cell(40, 8, iconv('UTF-8', 'cp874', 'ส่วนลด'), 0, 0, 'R');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', 'ยอดขาย'), 0, 0, 'R');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $i = 0;
    foreach ($menusData as $menu) {
        $i++;
        $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', $i), 0, 0, 'L');
        $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $menu['name']), 0, 0, 'L');
        $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', $menu["sumQuantity"]), 0, 0, 'R');
        $pdf->Cell(40, 8, iconv('UTF-8', 'cp874', number_format($menu['total_menu_price'], 2)), 0, 0, 'R');
        $pdf->Cell(40, 8, iconv('UTF-8', 'cp874', number_format($menu["discount"], 2)), 0, 0, 'R');
        $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', number_format($menu['total_menu_price'] - $menu["discount"], 2)), 0, 0, 'R');
        $pdf->Ln();
    }


    $pdf->Output();
}
