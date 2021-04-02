<?php

require_once "../../../com.Mexicash/Base/Conectar.php";
require_once "../../../vendor/autoload.php";

//require_once "bd.php";

$sucursal = '';

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
    ->setCellValue('A1', "Reporte Inventario Auto");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:I1");

// set font style
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

// set cell alignment
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(13);

$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'FECHA')
    ->setCellValue('B2', 'CONTRATO')
    ->setCellValue('C2', 'PRESTAMO')
    ->setCellValue('D2', 'MARCA')
    ->setCellValue('E2', 'MODELO')
    ->setCellValue('F2', 'ANIO')
    ->setCellValue('G2', 'COLOR')
    ->setCellValue('H2', 'PLACAS')
    ->setCellValue('I2', 'OBSERVACIONES');


$spreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($tableHead);

$rptHisto = "SELECT DATE_FORMAT(Aut.fecha_creacion,'%Y-%m-%d') as FECHA, Aut.id_Contrato,
                        total_Prestamo, Aut.marca, Aut.modelo,Aut.anio,Aut.color,
                        Aut.placas, Aut.observaciones
                        FROM auto_tbl AS Aut 
                            LEFT JOIN contratos_tbl AS Con on Aut.id_Contrato = Con.id_Contrato 
                            AND  Aut.sucursal  = Con.sucursal
                            WHERE Con.fisico = 1 AND Aut.id_Estatus != 20 
                            AND  Aut.sucursal = $sucursal AND (Con.id_cat_estatus=1 OR Con.id_cat_estatus=2 ) ";
$query = $db->query($rptHisto);


if ($query->num_rows > 0) {
    $i = 3;
    while ($row = $query->fetch_assoc()) {
        $total_Prestamo = $row["total_Prestamo"];
        //$PRECIOFORM = number_format($precio_venta, 2,'.',',');

        $spreadsheet->getActiveSheet()
            ->setCellValue('A' . $i, $row['FECHA'])
            ->setCellValue('B' . $i, $row['id_Contrato'])
            ->setCellValue('C' . $i, $total_Prestamo)
            ->setCellValue('D' . $i, $row['marca'])
            ->setCellValue('E' . $i, $row['modelo'])
            ->setCellValue('F' . $i, $row['anio'])
            ->setCellValue('G' . $i, $row['color'])
            ->setCellValue('H' . $i, $row["placas"])
            ->setCellValue('I' . $i, $row["observaciones"]);


        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':I' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':I' . $i)->applyFromArray($oddRow);
        }
        $i++;
    }
} else {
    $i = 3;

    $spreadsheet->getActiveSheet()
        ->setCellValue('A' . $i, "")
        ->setCellValue('B' . $i, "")
        ->setCellValue('C' . $i, "")
        ->setCellValue('D' . $i, "")
        ->setCellValue('E' . $i, "")
        ->setCellValue('F' . $i, "")
        ->setCellValue('G' . $i, "")
        ->setCellValue('H' . $i, "")
        ->setCellValue('I' . $i, "");
    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':I' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":F" . $lastRow);


$filename = 'Reporte_Inventario_Auto';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
