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
    ->setCellValue('A1', "Reporte Inventario");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:F1");

// set font style
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

// set cell alignment
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);


$spreadsheet->getActiveSheet()
        ->setCellValue('A2', 'FECHA')
        ->setCellValue('B2', 'CONTRATO')
        ->setCellValue('C2', 'SERIE')
        ->setCellValue('D2', 'PRECIO VENTA')
        ->setCellValue('E2', 'DETALLE')
        ->setCellValue('F2', '--');

$spreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($tableHead);

$rptHisto = "SELECT DATE_FORMAT(ART.fecha_creacion,'%Y-%m-%d') as FECHA, ART.id_Contrato,
                        CONCAT (id_SerieSucursal,Adquisiciones_Tipo,id_SerieContrato,id_SerieArticulo) as id_serie,
                        prestamo  AS precio_venta, ART.descripcionCorta AS Detalle
                        FROM articulo_tbl AS ART 
                        LEFT JOIN contratos_tbl AS Con on ART.id_Contrato = Con.id_Contrato AND Con.sucursal = $sucursal
                        WHERE Con.fisico = 1 AND ART.id_Estatus != 20 AND  ART.sucursal = $sucursal
                        AND (Con.id_cat_estatus=1 OR Con.id_cat_estatus=2 )  ";
$query = $db->query($rptHisto);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $precio_venta = $row["precio_venta"];
        //$PRECIOFORM = number_format($precio_venta, 2,'.',',');

        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$i , $row['FECHA'])
                ->setCellValue('B'.$i , $row['id_Contrato'])
                ->setCellValue('C'.$i , $row['id_serie'])
                ->setCellValue('D'.$i , $precio_venta)
                ->setCellValue('E'.$i , $row["Detalle"]);

        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':F' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':F' . $i)->applyFromArray($oddRow);
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
        ->setCellValue('F'.$i , "");
    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':F' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":F" . $lastRow);


$filename = 'Reporte_Inventario';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
