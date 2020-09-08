<?php

require_once "../../../com.Mexicash/Base/Conectar.php";
require_once "../../../vendor/autoload.php";

//require_once "bd.php";
$sucursal='';

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
    ->setCellValue('A1', "Reporte Bazar");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:H1");

// set font style
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

// set cell alignment
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(30);

$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'FECHA BAZAR')
    ->setCellValue('B2', 'CONTRATO')
    ->setCellValue('C2', 'SERIE')
    ->setCellValue('D2', 'MOVIMIENTO')
    ->setCellValue('E2', 'DETALLE')
    ->setCellValue('F2', 'PRECIO VENTA')
    ->setCellValue('G2', 'TIPO ADQUISICIÓN')
    ->setCellValue('H2', 'CONTRATO MIGRACIÓN');

$spreadsheet->getActiveSheet()->getStyle('A2:O2')->applyFromArray($tableHead);

////$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptRef = "SELECT Baz.id_Contrato,id_serie,Mov.descripcion as Movimiento,fecha_Bazar,precio_venta, 
                        ART.detalle as Detalle, CAT.descripcion as CatDesc, ART.id_ContratoMig
                        FROM articulo_bazar_tbl as Baz
                        LEFT JOIN articulo_tbl AS ART on Baz.id_Articulo = ART.id_Articulo 
                        LEFT JOIN cat_adquisicion AS CAT on ART.Adquisiciones_Tipo = CAT.id_Adquisicion
                        LEFT JOIN cat_movimientos AS Mov on Baz.tipo_movimiento = Mov.id_Movimiento
                        WHERE tipo_movimiento!= 6 and Baz.sucursal=$sucursal";
$query = $db->query($rptRef);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {

        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['fecha_Bazar'])
            ->setCellValue('B'.$i , $row['id_Contrato'])
            ->setCellValue('C'.$i , $row['id_serie'])
            ->setCellValue('D'.$i , $row['Movimiento'])
            ->setCellValue('E'.$i , $row['Detalle'])
            ->setCellValue('F'.$i , $row['precio_venta'])
            ->setCellValue('G'.$i , $row['CatDesc'])
            ->setCellValue('H'.$i , $row['id_ContratoMig']);

        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':H' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':H' . $i)->applyFromArray($oddRow);
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
        ->setCellValue('H'.$i , "");
    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':H' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":H" . $lastRow);


$filename = 'Reporte_Bazar';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
