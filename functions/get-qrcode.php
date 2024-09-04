<?php
include('../fpdf/fpdf.php');
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurantdb";
$port = 3306;
$conn = mysqli_connect($servername, $username, $password, $database, $port);
$conn->set_charset("utf8");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT menus.name, 
    orderitems.quantity ,
    menus.price * orderitems.quantity as totalPrice
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
    $rs = mysqli_fetch_assoc($qr);

    $contentHeight = (mysqli_num_rows($result) * 8) + 210; // Assuming 8 is the height of each row

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
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $rs['id']), 0, 0, 'R');
    $pdf->Ln();

    $pdf->Cell(46, 8, iconv('UTF-8', 'cp874', 'ที่นั่ง'), 0, 0, 'L');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $rs['label']), 0, 0, 'R');
    $pdf->Ln();

    $pdf->Cell(46, 8, iconv('UTF-8', 'cp874', 'พนักงาน'), 0, 0, 'L');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $rs['name'] . " " . $rs['surname']), 0, 0, 'R');
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

    $totalPrice = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(36, 8, iconv('UTF-8', 'cp874', $row['name']), 0, 0, 'L');
        $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', $row['quantity']), 0, 0, 'R');
        $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', '฿' . $row['totalPrice']), 0, 0, 'R');
        $pdf->Ln();
        $totalPrice += $row['totalPrice'];
    }
    // Close the database connection
    mysqli_close($conn);

    $pdf->Cell(76, 8, iconv('UTF-8', 'cp874', "ทั้งหมด            ฿" . $totalPrice), 0, 0, 'R');
    $pdf->Ln();
    $pdf->Cell(76, 8, iconv('UTF-8', 'cp874', "ส่วนลด            ฿" . $rs['discount']), 0, 0, 'R');
    $pdf->Ln();
    $pdf->Cell(76, 8, iconv('UTF-8', 'cp874', "รวมสุทธิ            ฿" . $totalPrice - $rs['discount']), 0, 0, 'R');
    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Ln();
    $pdf->Cell(76, 10, iconv(
        'UTF-8',
        'cp874',
        '-------------------------------------------------------------'
    ));
    $pdf->Image('../images/qrcode.png', 10, 176, 60); // Adjust the path and dimensions as necessary
    $pdf->Ln();
    $pdf->Cell(76, 8, iconv('UTF-8', 'cp874', '*** โอนผ่าน Promptpay ***'), 0, 0, 'C');

    $pdf->Output();
}
