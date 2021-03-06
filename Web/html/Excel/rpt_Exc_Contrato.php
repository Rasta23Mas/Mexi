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
    ->setCellValue('A1', "Reporte Contratos Vencidos");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:J1");

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
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);

$spreadsheet->getActiveSheet()
        ->setCellValue('A2', 'FECHA')
        ->setCellValue('B2', 'VENCIMIENTO')
        ->setCellValue('C2', 'ALMONEDA')
        ->setCellValue('D2', 'CLIENTE')
        ->setCellValue('E2', 'CELULAR')
        ->setCellValue('F2', 'CONTRATO')
        ->setCellValue('G2', 'PRÉSTAMO')
        ->setCellValue('H2', 'DETALLE')
        ->setCellValue('I2', 'OBSERVACIONES')
        ->setCellValue('J2', 'TIPO');

$spreadsheet->getActiveSheet()->getStyle('A2:J2')->applyFromArray($tableHead);

//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptHisto = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM,  
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Cli.celular,
                        Con.id_contrato AS CONTRATO,
                        Con.total_Prestamo AS PRESTAMO,
                        Art.descripcionCorta AS DESCRIPCION,
                        Art.observaciones as ObserArt,
                        Aut.observaciones as ObserAuto,
                        Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
                        AND Art.sucursal=$sucursal
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato
     					AND Aut.sucursal=$sucursal
                        WHERE CURDATE() BETWEEN DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') 
                        AND DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d')
                        AND Con.sucursal = $sucursal AND (id_cat_estatus=1 OR id_cat_estatus=2)
                        ORDER BY Con.id_contrato ";
$query = $db->query($rptHisto);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $descripcionCorta = $row["DESCRIPCION"];


        $Form = $row["Form"];
        $PRESTAMOFORM = $row["PRESTAMO"];

        $Obser = "";
        $DetalleFin = "";
        if($Form==1){
            $Obser =  $row["ObserArt"];
            $DetalleFin = $descripcionCorta;
            $tipoArt = "METAL";
        }else if($Form==2){
            $Obser =  $row["ObserArt"];
            $DetalleFin = $descripcionCorta;
            $tipoArt = "ELECTRÓNICOS";
        }else if($Form ==3){
            $Obser = $row["ObserAuto"];
            $DetalleFin = "";
            $tipoArt = "AUTO";
        }
        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$i , $row['FECHA'])
                ->setCellValue('B'.$i , $row['FECHAVEN'])
                ->setCellValue('C'.$i , $row['FECHAALM'])
                ->setCellValue('D'.$i , $row['NombreCompleto'])
                ->setCellValue('E'.$i , $row['celular'])
                ->setCellValue('F'.$i , $row['CONTRATO'])
                ->setCellValue('G'.$i , $PRESTAMOFORM)
                ->setCellValue('H'.$i , $DetalleFin)
                ->setCellValue('I'.$i , $Obser)
                ->setCellValue('J'.$i , $tipoArt);

        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->applyFromArray($oddRow);
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
        ->setCellValue('J'.$i , "");
    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":J" . $lastRow);


$filename = 'Reporte_Contratos_Vencidos';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
