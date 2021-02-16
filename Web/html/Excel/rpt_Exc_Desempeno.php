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
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(15);


$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'FECHA')
    ->setCellValue('B2', 'MOVIMIENTO')
    ->setCellValue('C2', 'CONTRATO')
    ->setCellValue('D2', 'PRÉSTAMO')
    ->setCellValue('E2', 'INTERÉS')
    ->setCellValue('F2', 'ALMACENAJE')
    ->setCellValue('G2', 'SEGURO')
    ->setCellValue('H2', 'DESCUENTO')
    ->setCellValue('I2', 'COSTO')
    ->setCellValue('J2', 'SUBTOTAL')
    ->setCellValue('K2', 'IVA')
    ->setCellValue('L2', 'TOTAL')
    ->setCellValue('M2', 'UTILIDAD')
    ->setCellValue('N2', 'TIPO');

$spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($tableHead);

//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptRef = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(ConM.fecha_Movimiento,'%Y-%m-%d') AS FECHAMOV,
                        ConM.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO, 
                        ConM.e_interes AS INTERESES,  ConM.e_almacenaje AS ALMACENAJE, 
                        ConM.e_seguro AS SEGURO, ConM.e_pagoDesempeno as DES,ConM.s_descuento_aplicado as DESCU,
                        ConM.e_iva as IVA, ConM.e_costoContrato AS COSTO, Con.id_Formulario as FORMU,
                         ConM.pag_subtotal,  ConM.pag_total,ConM.e_intereses, ConM.e_moratorios,ConM.prestamo_Informativo
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

        $CostoContrato = $row['COSTO'];
        $moratorios = $row['e_moratorios'];
        $e_intereses = $row['e_intereses'];
        $desempeno = $row['DES'];
        $iva = $row['IVA'];
        $prestamo_Informativo = $row['prestamo_Informativo'];
        if($CostoContrato==0){
            $utilidad = $e_intereses - $iva;
            $utilidad  = $utilidad + $moratorios;
        }else{
            $utilidad =  $CostoContrato;
        }

        $tot_des = $desempeno + $utilidad;
        $tot_des = $tot_des - $prestamo_Informativo;

        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['FECHA'])
            ->setCellValue('B'.$i , $row['FECHAMOV'])
            ->setCellValue('C'.$i , $row['CONTRATO'])
            ->setCellValue('D'.$i , $row['PRESTAMO'])
            ->setCellValue('E'.$i , $row['INTERESES'])
            ->setCellValue('F'.$i , $row['ALMACENAJE'])
            ->setCellValue('G'.$i , $row['SEGURO'])
            ->setCellValue('H'.$i , $row['DESCU'])
            ->setCellValue('I'.$i , $CostoContrato)
            ->setCellValue('J'.$i , $row['pag_subtotal'])
            ->setCellValue('K'.$i ,$iva)
            ->setCellValue('L'.$i , $row['pag_total'])
            ->setCellValue('M'.$i , $tot_des)
            ->setCellValue('N'.$i , $tipoArt);

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


$filename = 'Reporte_Desempeno';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
