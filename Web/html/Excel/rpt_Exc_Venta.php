<?php

require_once "../../../com.Mexicash/Base/Conectar.php";
require_once "../../../vendor/autoload.php";

//require_once "bd.php";
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
    ->setCellValue('A1', "Reporte Ventas");
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
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);

$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'VENTA')
    ->setCellValue('B2', 'FECHA')
    ->setCellValue('C2', 'SUBTOTAL')
    ->setCellValue('D2', 'DESCUENTO')
    ->setCellValue('E2', 'TOTAL')
    ->setCellValue('F2', 'PRESTAMO')
    ->setCellValue('G2', 'UTILIDAD')
    ->setCellValue('H2', 'USUARIO');

$spreadsheet->getActiveSheet()->getStyle('A2:H2')->applyFromArray($tableHead);

////$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptRef = "SELECT id_Bazar,DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
Con.subTotal,Con.descuento_Venta,Con.total, Con.totalPrestamo, Con.utilidad, Usu.usuario
                    FROM contrato_mov_baz_tbl AS Con
                    LEFT JOIN bit_cierrecaja AS BitC on Con.id_CierreCaja = BitC.id_CierreCaja 
                    AND BitC.sucursal=$sucursal
                    LEFT JOIN usuarios_tbl AS Usu on BitC.usuario = Usu.id_User
                    WHERE DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d')  >=  '$fechaIni'
                    AND DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d')  <=  '$fechaFin' 
                    AND Con.sucursal=$sucursal ";
$query = $db->query($rptRef);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {

        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['id_Bazar'])
            ->setCellValue('B'.$i , $row['FECHA'])
            ->setCellValue('C'.$i , $row['subTotal'])
            ->setCellValue('D'.$i , $row['descuento_Venta'])
            ->setCellValue('E'.$i , $row['total'])
            ->setCellValue('F'.$i , $row['totalPrestamo'])
            ->setCellValue('G'.$i , $row['utilidad'])
            ->setCellValue('H'.$i , $row['usuario']);

        //set row style
        if ($i % 2 == 0) {
            //even rowh
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


$filename = 'Reporte_Ventas';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
