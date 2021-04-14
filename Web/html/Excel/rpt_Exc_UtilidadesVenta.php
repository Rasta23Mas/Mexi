<?php

require_once "../../../com.Mexicash/Base/Conectar.php";
require_once "../../../vendor/autoload.php";

//require_once "bd.php";
$fechaIni='';
$fechaFin='';
$sucursal='';
if (isset($_GET['fechaIni'])) {
    $fechaIni = $_GET['fechaIni'];
}
if (isset($_GET['fechaFin'])) {
    $fechaFin = $_GET['fechaFin'];
}
if (isset($_GET['sucursal'])) {
    $sucursal = $_GET['sucursal'];
}


use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$tableHead = [
    'font' => [
        'color' => [
            'rgb' => 'FFFFFF'
        ],
        'bold' => true,
        'size' => 9
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '4472c4'
        ]
    ],
];
//even row

$evenRow = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'd9e1f2'
        ]
    ]
];
//odd row
$oddRow = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'FFFFFF'
        ]
    ]
];

$spreadsheet = new Spreadsheet();
//$Excel_writer = new Xlsx($spreadsheet);

//$spreadsheet->setActiveSheetIndex(0);
$activeSheet = $spreadsheet->getActiveSheet();
$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Arial')
    ->setSize(7);

//heading
$spreadsheet->getActiveSheet()
    ->setCellValue('A1', "Reporte Utilidades Venta");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:E1");

// set font style
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

// set cell alignment
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);



$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'FECHA')
    ->setCellValue('B2', 'VENTA')
    ->setCellValue('C2', 'PRESTAMO')
    ->setCellValue('D2', 'VENTA')
    ->setCellValue('E2', 'UTILIDAD');


$spreadsheet->getActiveSheet()->getStyle('A2:E2')->applyFromArray($tableHead);

//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptIng = "SELECT  DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')  AS Movimiento,id_Bazar, 
                                    total,totalPrestamo,utilidad FROM contrato_mov_baz_tbl
                                    WHERE sucursal=$sucursal AND tipo_movimiento=6 AND
                                    DATE_FORMAT(fecha_Creacion,'%Y-%m-%d')                                
                                    BETWEEN '$fechaIni' AND '$fechaFin'   ORDER BY id_Bazar  ";

$query = $db->query($rptIng);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $total =   $row['total'];
        $totalPrestamo =  $row['totalPrestamo'];
        $utilidad =   $row['utilidad'];



        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['Movimiento'])
            ->setCellValue('B'.$i , $row['id_Bazar'])
            ->setCellValue('C'.$i ,$totalPrestamo)
            ->setCellValue('D'.$i ,$total)
            ->setCellValue('E'.$i , $utilidad);

        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':E' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':E' . $i)->applyFromArray($oddRow);
        }
        $i++;
    }
}else{
    $i = 3;

    $spreadsheet->getActiveSheet()
        ->setCellValue('A'.$i , "")
        ->setCellValue('B'.$i , "")
        ->setCellValue('C'.$i , "")
        ->setCellValue('D'.$i , "")
        ->setCellValue('E'.$i , "");
    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':E' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":E" . $lastRow);


$filename = 'Utilidad Venta';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
