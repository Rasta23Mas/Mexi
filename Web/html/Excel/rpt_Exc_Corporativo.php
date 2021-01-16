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
    ->setCellValue('A1', "Reporte Corporativo");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:L1");

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



$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'ID')
    ->setCellValue('B2', 'DESEMPEÑO')
    ->setCellValue('C2', 'COSTO CONTRATO')
    ->setCellValue('D2', 'ABONO')
    ->setCellValue('E2', 'INTERÉS')
    ->setCellValue('F2', 'IVA')
    ->setCellValue('G2', 'VENTAS')
    ->setCellValue('H2', 'IVA VENTAS<')
    ->setCellValue('I2', 'APARTADOS')
    ->setCellValue('J2', 'ABONO VENTA')
    ->setCellValue('K2', 'UTILIDAD')
    ->setCellValue('L2', 'FECHA');

$spreadsheet->getActiveSheet()->getStyle('A2:L2')->applyFromArray($tableHead);

//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptIng = "SELECT id_CierreSucursal,capitalRecuperado as Desem,abonoCapital as AbonoRef,intereses as Inte,
                       costoContrato as costoContrato,iva as Iva,mostrador as Ventas,iva_venta as IvaVenta,
                       utilidadVenta as Utilidad, apartados as Apartados,abonoVentas as AbonoVen, 
                       DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') as Fecha, MONTH(fecha_Creacion) as Mes
                       FROM bit_cierresucursal
                       WHERE DATE_FORMAT(fecha_Creacion,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin' 
                       AND sucursal = $sucursal  ORDER BY id_CierreSucursal  ";

$query = $db->query($rptIng);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['id_CierreSucursal'])
            ->setCellValue('B'.$i , $row['Desem'])
            ->setCellValue('C'.$i , $row['AbonoRef'])
            ->setCellValue('D'.$i , $row['Inte'])
            ->setCellValue('E'.$i , $row['costoContrato'])
            ->setCellValue('F'.$i , $row['Iva'])
            ->setCellValue('G'.$i , $row['Ventas'])
            ->setCellValue('H'.$i , $row['IvaVenta'])
            ->setCellValue('I'.$i , $row['Utilidad'])
            ->setCellValue('J'.$i , $row['Apartados'])
            ->setCellValue('K'.$i , $row['AbonoVen'])
            ->setCellValue('L'.$i , $row['Fecha']);

        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':L' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':L' . $i)->applyFromArray($oddRow);
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
        ->setCellValue('L'.$i , "");
    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':L' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":L" . $lastRow);


$filename = 'Corporativo';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
