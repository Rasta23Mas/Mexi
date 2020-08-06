<?php
require_once "../../../vendor/autoload.php";

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(BASE_PATH . "Conectar.php");
//require_once "bd.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$Excel_writer = new Xlsx($spreadsheet);

$spreadsheet->setActiveSheetIndex(0);
$activeSheet = $spreadsheet->getActiveSheet();

$activeSheet->setCellValue('A1', 'Product Name');
$activeSheet->setCellValue('B1', 'Product SKU');
$activeSheet->setCellValue('C1', 'Product Price');
/*$newCon = new Conexion();
$db = $newCon->connectDB();*/


$query = $db->query("SELECT * FROM products ORDER BY id DESC");

if($query->num_rows > 0) {
    $i = 2;
    while($row = $query->fetch_assoc()) {
        $activeSheet->setCellValue('A'.$i , $row['product_name']);
        $activeSheet->setCellValue('B'.$i , $row['product_sku']);
        $activeSheet->setCellValue('C'.$i , $row['product_price']);
        $i++;
    }
}

$filename = 'products';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');
$Excel_writer->save('php://output');