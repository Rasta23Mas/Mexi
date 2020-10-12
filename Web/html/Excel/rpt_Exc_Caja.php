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
    ->setCellValue('A1', "Reporte Caja");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:N1");

// set font style
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

// set cell alignment
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);



$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'ID')
    ->setCellValue('B2', 'ID SUCURSAL')
    ->setCellValue('C2', 'DOTACIONES')
    ->setCellValue('D2', 'CAPITAL')
    ->setCellValue('E2', 'ABONO')
    ->setCellValue('F2', 'INTERESES')
    ->setCellValue('G2', 'IVA')
    ->setCellValue('H2', 'MOSTRADOR')
    ->setCellValue('I2', 'IVA')
    ->setCellValue('J2', 'APARTADOS')
    ->setCellValue('K2', 'ABONO')
    ->setCellValue('L2', 'RETIROS')
    ->setCellValue('M2', 'PRESTAMOS')
    ->setCellValue('N2', 'COSTO CONT.');

$spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($tableHead);

//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptIng = "SELECT id_CierreCaja,id_CierreSucursal,dotacionesA_Caja,capitalRecuperado,abonoCapital,intereses,
                        iva,mostrador,iva_venta,apartadosVentas,abonoVentas,retirosCaja,prestamosNuevos,costoContrato
                       FROM bit_cierrecaja
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreCaja ";

$query = $db->query($rptIng);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['id_CierreCaja'])
            ->setCellValue('B'.$i , $row['id_CierreSucursal'])
            ->setCellValue('C'.$i , $row['dotacionesA_Caja'])
            ->setCellValue('D'.$i , $row['capitalRecuperado'])
            ->setCellValue('E'.$i , $row['abonoCapital'])
            ->setCellValue('F'.$i , $row['intereses'])
            ->setCellValue('G'.$i , $row['iva'])
            ->setCellValue('H'.$i , $row['mostrador'])
            ->setCellValue('I'.$i , $row['iva_venta'])
            ->setCellValue('J'.$i , $row['apartadosVentas'])
            ->setCellValue('K'.$i , $row['abonoVentas'])
            ->setCellValue('L'.$i , $row['retirosCaja'])
            ->setCellValue('M'.$i , $row['prestamosNuevos'])
            ->setCellValue('N'.$i , $row['costoContrato']);

        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':N' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':N' . $i)->applyFromArray($oddRow);
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
        ->setCellValue('E'.$i , "")
        ->setCellValue('F'.$i , "")
        ->setCellValue('G'.$i , "")
        ->setCellValue('H'.$i , "")
        ->setCellValue('I'.$i , "")
        ->setCellValue('J'.$i , "")
        ->setCellValue('K'.$i , "")
        ->setCellValue('L'.$i , "")
        ->setCellValue('M'.$i , "")
    ->setCellValue('N'.$i , "");
    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':N' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":N" . $lastRow);


$filename = 'Caja';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
