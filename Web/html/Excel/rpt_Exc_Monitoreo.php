<?php

require_once "../../../com.Mexicash/Base/Conectar.php";
require_once "../../../vendor/autoload.php";

//require_once "bd.php";
$fechaIni='';
$fechaFin='';
$sucursal='';
$tipo='';
$nombre='';
if (isset($_GET['fechaIni'])) {
    $fechaIni = $_GET['fechaIni'];
}
if (isset($_GET['fechaFin'])) {
    $fechaFin = $_GET['fechaFin'];
}
if (isset($_GET['sucursal'])) {
    $sucursal = $_GET['sucursal'];
}
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
}
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
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
    ->setCellValue('A1', $nombre);
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
    ->setCellValue('B2', 'CONTRATO')
    ->setCellValue('C2', 'TIPO')
    ->setCellValue('D2', 'TOKEN')
    ->setCellValue('E2', 'DESCRIPCIÓN')
    ->setCellValue('F2', 'DESCUENTO')
    ->setCellValue('G2', 'INTERÉS')
    ->setCellValue('H2', 'IMPORTE')
    ->setCellValue('I2', 'FLUJO')
    ->setCellValue('J2', 'TIPO TOKEN')
    ->setCellValue('K2', 'USUARIO')
    ->setCellValue('L2', 'FECHA');

$spreadsheet->getActiveSheet()->getStyle('A2:L2')->applyFromArray($tableHead);

//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptMon = "SELECT BitC.id_BitacoraToken,BitC.id_Contrato,BitC.tipo_formulario as FORMU,BitC.token,BitC.descripcion,
                        BitC.descuento,BitC.interes, Cat.descripcion as Descrip, Usu.usuario,BitC.importe_flujo,
                        BitC.id_flujo,
                        DATE_FORMAT(BitC.fecha_Creacion,'%Y-%m-%d') as Fecha FROM bit_token as BitC
                        INNER JOIN cat_token_movimiento as Cat on BitC.id_tokenMovimiento = Cat.id_tokenMovimiento
                        LEFT JOIN usuarios_tbl as Usu on BitC.usuario = Usu.id_User  ";
if($tipo==0||$tipo=="0"){
    $rptMon .= " WHERE BitC.fecha_Creacion BETWEEN '$fechaIni' 
                            AND '$fechaFin' AND BitC.sucursal = $sucursal  ORDER BY BitC.id_BitacoraToken";
}else{
    $rptMon .= "WHERE BitC.id_tokenMovimiento=$tipo AND  BitC.fecha_Creacion BETWEEN '$fechaIni' 
                            AND '$fechaFin' AND BitC.sucursal = $sucursal  ORDER BY BitC.id_BitacoraToken";
}
$query = $db->query($rptMon);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $Form = $row["FORMU"];

        $tipoArt = "";
        if($Form==1){
            $tipoArt = "METAL";
        }else if($Form==2){
            $tipoArt = "ELECTRÓNICOS";
        }else if($Form ==3){
            $tipoArt = "AUTO";
        }
        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['id_BitacoraToken'])
            ->setCellValue('B'.$i , $row['id_Contrato'])
            ->setCellValue('C'.$i , $tipoArt)
            ->setCellValue('D'.$i , $row['token'])
            ->setCellValue('E'.$i , $row['descripcion'])
            ->setCellValue('F'.$i , $row['descuento'])
            ->setCellValue('G'.$i , $row['interes'])
            ->setCellValue('H'.$i , $row['importe_flujo'])
            ->setCellValue('I'.$i , $row['id_flujo'])
            ->setCellValue('J'.$i , $row['Descrip'])
            ->setCellValue('K'.$i , $row['usuario'])
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


$filename = 'Autorizaciones';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
