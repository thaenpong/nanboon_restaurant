<?php
include('../fpdf/fpdf.php');
$servername = "localhost";
$username = "root";
$password = "";
$database = "restaurantdb";
$port = 3306;
$conn = mysqli_connect($servername, $username, $password, $database, $port);
$conn->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $menuItems = json_decode($_GET['menuItems'], true);
    $tableId = $_GET['selectedValue'];
    $id = $_GET['id'];

    $sql = "SELECT label FROM `desks` WHERE `id` = '$tableId'";
    $result = mysqli_query($conn, $sql);
    $tableLabel = mysqli_fetch_assoc($result)['label'];

    $sql2 = "SELECT day_queue FROM `orders` WHERE `id` = '$id'";
    $result2 = mysqli_query($conn, $sql2);
    $queue = mysqli_fetch_assoc($result2)['day_queue'];

    $menuItemsCount = count($menuItems);

    $contentHeight = ($menuItemsCount * 8) + 100; // Assuming 8 is the height of each row

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
    $pdf->Cell(76, 4, iconv('UTF-8', 'cp874', 'รายการอาหาร'), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', 'B', 24);
    $pdf->Cell(76, 10, iconv('UTF-8', 'cp874', 'ลำดับ ' . $queue), 0, 0, 'C');
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(76, 10, iconv(
        'UTF-8',
        'cp874',
        '-------------------------------------------------------------'
    ));
    $pdf->Ln();

    $pdf->SetFont('THSarabunNew', '', 14);
    $pdf->Cell(46, 8, iconv('UTF-8', 'cp874', 'ที่นั่ง'), 0, 0, 'L');
    $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $tableLabel), 0, 0, 'R');
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
    $pdf->Cell(12, 8, iconv('UTF-8', 'cp874', 'จำนวน'), 0, 0, 'R');
    $pdf->Cell(23, 8, iconv('UTF-8', 'cp874', 'รายระเอียด'), 0, 0, 'R');
    $pdf->Ln();


    $xplus = 75;
    foreach ($menuItems as $menuItem) {
        $id = $menuItem['itemId'];
        $sql = "SELECT name FROM menus WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $name = mysqli_fetch_assoc($result)['name'];

        $xplus += 8;
        $pdf->Cell(36, 8, iconv('UTF-8', 'cp874', $name), 0, 0, 'L');
        $pdf->Cell(12, 8, iconv('UTF-8', 'cp874', $menuItem['quantity']), 0, 0, 'R');
        $pdf->Cell(23, 8, iconv('UTF-8', 'cp874', $menuItem['note']), 0, 0, 'R');
        $pdf->Ln();
    }

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell($xplus + 8, 10, iconv(
        'UTF-8',
        'cp874',
        '-------------------------------------------------------------'
    ));
    $pdf->Ln();
    $pdf->Output();
}
