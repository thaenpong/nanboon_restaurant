<?php
include('../fpdf/fpdf.php');
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurantdb";
$port = 3306;
$conn = mysqli_connect($servername, $username, $password, $database, $port);
$conn->set_charset("utf8");

if (isset($_GET["orders"])) {
    $ordersString = $_GET["orders"];
    // Split the orders string into an array
    $ordersArray = explode(",", $ordersString);


    $totalPrice = 0;
    $totalDiscount = 0;
    $menusData = [];
    $table = [];
    $emp = [];
    foreach ($ordersArray as $id) {

        $sql = "SELECT menus.name, 
        SUM(orderitems.quantity) AS sumQuantity,
        SUM(orderitems.discount) AS discount, -- Renamed alias to avoid ambiguity
        SUM(menus.price * orderitems.quantity) AS total_menu_price, -- Added a comma here
        SUM((menus.price * orderitems.quantity) - (orderitems.discount * orderitems.quantity)) AS total -- Used orderitems.discount to remove ambiguity
        FROM orderitems
        INNER JOIN menus ON orderitems.menuId = menus.id
        WHERE orderitems.orderId = $id
        GROUP BY menus.id
        ORDER BY total DESC;";


        $qrOrders = mysqli_query($conn, $sql);

        // Initialize total price and total discount

        while ($row = mysqli_fetch_assoc($qrOrders)) {
            $totalPrice += $row['total_menu_price'];
            $totalDiscount += $row['sumQuantity'] * $row['discount'];
            $menusData[] = $row; // Store row for later use in PDF generation
        }

        $sqlOrder = "SELECT desks.label,
        users.name,
        users.surname
        FROM orders 
        INNER JOIN desks ON desks.id = orders.deskId
        INNER JOIN users ON users.id = orders.userId
        WHERE orders.id = $id";
        $qr = mysqli_query($conn, $sqlOrder);
        while ($rs = mysqli_fetch_assoc($qr)) {
            $emp[] = $rs['name'] . " " . $rs['surname'];
            $table[] = $rs['label'];
        }
    }




    /* 
    $sql = "SELECT menus.name, 
    orderitems.quantity ,
    menus.price * orderitems.quantity as totalPrice,
    orderitems.note
    FROM orderitems 
    INNER JOIN menus ON menus.id = orderitems.menuId
    WHERE orderitems.orderId = $id";
    $result = mysqli_query($conn, $sql);

    $sqlOrder = "SELECT orders.id ,
    desks.label,
    orders.discount,
    users.name,
    users.surname
    FROM orders 
    INNER JOIN desks ON desks.id = orders.deskId
    INNER JOIN users ON users.id = orders.userId
    WHERE orders.id = $id";
    $qr = mysqli_query($conn, $sqlOrder);
    $rs = mysqli_fetch_assoc($qr); */

    $contentHeight = (sizeof($menusData) * 8) + 230; // Assuming 8 is the height of each row

    $pdf = new FPDF('P', 'mm', array(80, $contentHeight));
    $pdf->SetAutoPageBreak(1);
    $pdf->SetLeftMargin(2);


    $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');

    $pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');
    $pdf->AddPage();
    $pdf->SetFont('THSarabunNew', 'B', 22);

    $pdf->Cell(76, 14, iconv('UTF-8', 'cp874', 'ร้านอาหารไก่ย่างหนานบุญ'), 0, 0, 'C');
    $pdf->Ln();


    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(76, 14, iconv('UTF-8', 'cp874', '191 ม.6 ต.เวียงตาล อ.ห้างฉัตร จ.ลำปาง 52190'), 0, 0, 'C');
    $pdf->Ln();


    $pdf->SetFont('THSarabunNew', '', 14);
    $pdf->Cell(76, 4, iconv('UTF-8', 'cp874', 'ใบเสร็จ'), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(76, 10, iconv('UTF-8', 'cp874', '-------------------------------------------------------------'));
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 14);
    $pdf->Cell(46, 8, iconv('UTF-8', 'cp874', 'เลขที่'), 0, 0, 'L');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $ordersString), 0, 0, 'R');
    $pdf->Ln();

    $pdf->Cell(46, 8, iconv('UTF-8', 'cp874', 'ที่นั่ง'), 0, 0, 'L');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', implode(", ", $table)), 0, 0, 'R');
    $pdf->Ln();

    $pdf->Cell(46, 8, iconv('UTF-8', 'cp874', 'พนักงาน'), 0, 0, 'L');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $emp[0]), 0, 0, 'R');
    $pdf->Ln();

    $pdf->Cell(46, 8, iconv('UTF-8', 'cp874', 'วันที่ออกใบเสร็จ'), 0, 0, 'L');
    date_default_timezone_set('Asia/Bangkok');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', date('d/m/Y H:i', time())), 0, 0, 'R');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(76, 10, iconv(
        'UTF-8',
        'cp874',
        '-------------------------------------------------------------'
    ));
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 14);
    $pdf->Cell(36, 8, iconv('UTF-8', 'cp874', 'รายการ'), 0, 0, 'L');
    $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', 'จำนวน'), 0, 0, 'R');
    $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', 'ราคา'), 0, 0, 'R');
    $pdf->Ln();

    $xplus = 75;
    foreach ($menusData as $menu) {
        $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $menu['name']), 0, 0, 'L');
        $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', $menu["sumQuantity"]), 0, 0, 'R');
        $pdf->Cell(25, 8, iconv('UTF-8', 'cp874', number_format($menu['total_menu_price'], 2)), 0, 0, 'R');
        $pdf->Ln();
        $xplus += 8;
    }
    // Close the database connection
    mysqli_close($conn);

    $pdf->Cell(76, 8, iconv('UTF-8', 'cp874', "ทั้งหมด            ฿" . $totalPrice), 0, 0, 'R');
    $pdf->Ln();
    $pdf->Cell(76, 8, iconv('UTF-8', 'cp874', "ส่วนลด            ฿" . $totalDiscount), 0, 0, 'R');
    $pdf->Ln();
    $pdf->Cell(76, 8, iconv('UTF-8', 'cp874', "รวมสุทธิ            ฿" . $totalPrice - $totalDiscount), 0, 0, 'R');


    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Ln();
    $pdf->Cell(76, 10, iconv(
        'UTF-8',
        'cp874',
        '-------------------------------------------------------------'
    ));
    $pdf->Image('../images/qrcode.png', 10, $pdf->GetX() + $xplus, 60); // Adjust the path and dimensions as necessary
    $pdf->Ln();
    $pdf->Cell(76, 8, iconv('UTF-8', 'cp874', '*** QR Code พร้อมเพย์ ***'), 0, 0, 'C');


    $pdf->Output();
}
