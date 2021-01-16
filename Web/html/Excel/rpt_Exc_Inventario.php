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
$spreadsheet->getActiveSheet()->mergeCells("A1:L1");

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
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(10);


$spreadsheet->getActiveSheet()
        ->setCellValue('A2', 'FECHA')
        ->setCellValue('B2', 'VENCIMIENTO')
        ->setCellValue('C2', 'ALMONEDA')
        ->setCellValue('D2', 'CONTRATO')
        ->setCellValue('E2', 'CLIENTE')
        ->setCellValue('F2', 'PRÉSTAMO')
        ->setCellValue('G2', 'PLAZO')
        ->setCellValue('H2', 'PERIODO')
        ->setCellValue('I2', 'TIPO INTERÉS')
        ->setCellValue('J2', 'DETALLE')
        ->setCellValue('K2', 'OBSERVACIONES')
        ->setCellValue('L2', 'TIPO');

$spreadsheet->getActiveSheet()->getStyle('A2:L2')->applyFromArray($tableHead);

//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptHisto = "SELECT DATE_FORMAT(ART.fecha_creacion,'%Y-%m-%d') as FECHA, ART.id_Contrato,
                        CONCAT (id_SerieSucursal,Adquisiciones_Tipo,id_SerieContrato,id_SerieArticulo) as id_serie,
                        vitrina AS precio_venta, 
                        descripcionCorta as Detalle,CAT.descripcion as CatDesc
                        FROM articulo_tbl AS ART 
                        LEFT JOIN contratos_tbl AS Con on ART.id_Contrato = Con.id_Contrato AND Con.sucursal = $sucursal
                        LEFT JOIN cat_adquisicion AS CAT on tipoArticulo = CAT.id_Adquisicion
                        WHERE Con.fisico = 1 AND  ART.sucursal = $sucursal  ";
$query = $db->query($rptHisto);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $DescripcionCorta = $row["DescripcionCorta"];
        $Obs = $row["Obs"];
        $ObserAuto = $row["ObserAuto"];
        $DetalleAuto = $row["DetalleAuto"];
        $Form = $row["Form"];
        $PRESTAMO = $row["PRESTAMO"];
        $PRESTAMOFORM = number_format($PRESTAMO, 2,'.',',');
        //$PRESTAMOFORM = "$100,000.00";

        $Obser = "";
        $DetalleFin = "";
        if($Form==1){
            $Obser = $DescripcionCorta;
            $DetalleFin = $Obs;
            $tipoArt = "METAL";
        }else if($Form==2){
            $Obser = $DescripcionCorta;
            $DetalleFin = $Obs;
            $tipoArt = "ELECTRÓNICOS";
        }else if($Form ==3){
            $Obser = $ObserAuto;
            $DetalleFin = $DetalleAuto;
            $tipoArt = "AUTO";
        }
        $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$i , $row['FECHA'])
                ->setCellValue('B'.$i , $row['FECHAVEN'])
                ->setCellValue('C'.$i , $row['FECHAALM'])
                ->setCellValue('D'.$i , $row['CONTRATO'])
                ->setCellValue('E'.$i , $row['NombreCompleto'])
                ->setCellValue('F'.$i , $PRESTAMOFORM)
                ->setCellValue('G'.$i , $row['Plazo'])
                ->setCellValue('H'.$i , $row['Periodo'])
                ->setCellValue('I'.$i , $row['TipoInteres'])
                ->setCellValue('J'.$i , $Obser)
                ->setCellValue('K'.$i , $DetalleFin)
                ->setCellValue('L'.$i , $tipoArt);

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


$filename = 'Reporte_Inventario';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
