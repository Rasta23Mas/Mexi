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
    ->setCellValue('A1', "Reporte Desempeño");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:O1");

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
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(15);


$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'FECHA')
    ->setCellValue('B2', 'MOVIMIENTO')
    ->setCellValue('C2', 'VENCIMIENTO')
    ->setCellValue('D2', 'CONTRATO')
    ->setCellValue('E2', 'PRÉSTAMO')
    ->setCellValue('F2', 'INTERÉS')
    ->setCellValue('G2', 'ALMACENAJE')
    ->setCellValue('H2', 'SEGURO')
    ->setCellValue('I2', 'ABONO')
    ->setCellValue('J2', 'DESCUENTO')
    ->setCellValue('K2', 'COSTO')
    ->setCellValue('L2', 'SUBTOTAL')
    ->setCellValue('M2', 'IVA')
    ->setCellValue('N2', 'TOTAL')
    ->setCellValue('O2', 'TIPO');

$spreadsheet->getActiveSheet()->getStyle('A2:O2')->applyFromArray($tableHead);

//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptRef = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        DATE_FORMAT(ConM.fechaVencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO,  ConM.e_abono as ABONO,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU,
                         ConM.pag_subtotal,  ConM.pag_total
                        FROM contrato_mov_tbl AS ConM
                        INNER JOIN contratos_tbl AS Con ON ConM.id_contrato = Con.id_Contrato AND Con.sucursal=$sucursal
                        WHERE DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') BETWEEN '$fechaIni' AND '$fechaFin'
                        AND ConM.sucursal = $sucursal AND ( ConM.tipo_movimiento = 5 OR ConM.tipo_movimiento = 9 )  
                        ORDER BY ConM.id_contrato ";
$query = $db->query($rptRef);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $Form = $row["FORMU"];

        //$PRESTAMOFORM = "$100,000.00";

        $tipoArt = "";
        if($Form==1){
            $tipoArt = "METAL";
        }else if($Form==2){
            $tipoArt = "ELECTRÓNICOS";
        }else if($Form ==3){
            $tipoArt = "AUTO";
        }

        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['FECHA'])
            ->setCellValue('B'.$i , $row['FECHAMOV'])
            ->setCellValue('C'.$i , $row['FECHAVEN'])
            ->setCellValue('D'.$i , $row['CONTRATO'])
            ->setCellValue('E'.$i , $row['PRESTAMO'])
            ->setCellValue('F'.$i , $row['INTERESES'])
            ->setCellValue('G'.$i , $row['ALMACENAJE'])
            ->setCellValue('H'.$i , $row['SEGURO'])
            ->setCellValue('I'.$i , $row['ABONO'])
            ->setCellValue('J'.$i , $row['DESCU'])
            ->setCellValue('K'.$i , $row['COSTO'])
            ->setCellValue('L'.$i , $row['SUBTOTAL'])
            ->setCellValue('M'.$i , $row['IVA'])
            ->setCellValue('N'.$i , $row['TOTAL'])
            ->setCellValue('O'.$i , $tipoArt);

        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':O' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':O' . $i)->applyFromArray($oddRow);
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
        ->setCellValue('N'.$i , "")
        ->setCellValue('O'.$i , "");
    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':O' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":O" . $lastRow);


$filename = 'Reporte_Desempeno';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
