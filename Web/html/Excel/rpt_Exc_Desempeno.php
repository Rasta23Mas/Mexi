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
    ->setCellValue('A1', "Reporte Histórico");
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
        ->setCellValue('J2', 'OBSERVACIONES')
        ->setCellValue('K2', 'DETALLE')
        ->setCellValue('L2', 'TIPO');

$spreadsheet->getActiveSheet()->getStyle('A2:L2')->applyFromArray($tableHead);


//$query = $db->query("SELECT * FROM products ORDER BY id DESC");
$rptHisto = "SELECT DATE_FORMAT(Con.fecha_Creacion,'%Y-%m-%d') as FECHA,
                        DATE_FORMAT(Con.fecha_vencimiento,'%Y-%m-%d') AS FECHAVEN, 
                        DATE_FORMAT(Con.fecha_almoneda,'%Y-%m-%d') AS FECHAALM, 
                        Con.id_contrato AS CONTRATO,
                        CONCAT (Cli.apellido_Pat , ' ',Cli.apellido_Mat,' ', Cli.nombre) as NombreCompleto,
                        Con.total_Prestamo AS PRESTAMO,
                        Con.plazo AS Plazo, Con.periodo as Periodo, Con.tipoInteres as TipoInteres,
                        CONCAT(EM.descripcion,' ', ET.descripcion, ' ',EMOD.descripcion) as ObserElec, 
                        CONCAT(Tipo.descripcion, ' ',Kil.descripcion,' ', Cal.descripcion) as ObserMetal,
                        Aut.observaciones as ObserAuto,
                        CONCAT(Aut.marca, ' ', Aut.modelo) as DetalleAuto, 
                        CONCAT(Art.detalle) as Detalle,
                        Art.tipoArticulo, Con.id_Formulario as Form
                        FROM contratos_tbl AS Con 
                        INNER JOIN cliente_tbl as Cli on Con.id_Cliente = Cli.id_Cliente
                        LEFT JOIN bit_cierrecaja as Bit on Con.id_cierreCaja = Bit.id_CierreCaja
                        LEFT JOIN articulo_tbl as Art on Con.id_Contrato = Art.id_Contrato 
     					LEFT JOIN auto_tbl as Aut on Con.id_Contrato = Aut.id_Contrato 
                        LEFT JOIN cat_electronico_marca as EM on Art.marca = EM.id_marca
                        LEFT JOIN cat_electronico_modelo as EMOD on Art.modelo = EMOD.id_modelo
                        LEFT JOIN cat_electronico_tipo as ET on Art.tipo = ET.id_tipo
                        LEFT JOIN cat_kilataje as Kil on Art.kilataje = Kil.id_Kilataje
                        LEFT JOIN cat_tipoarticulo as Tipo on Art.tipo = Tipo.id_tipo
                        LEFT JOIN cat_calidad as Cal on Art.calidad = Cal.id_calidad
                        WHERE '$fechaIni' >= Con.fecha_fisico_ini
                        AND '$fechaFin'  <= Con.fecha_fisico_fin
                        AND Bit.sucursal = $sucursal 
                        ORDER BY Form";
$query = $db->query($rptHisto);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {
        $ObserElec = $row["ObserElec"];
        $ObserMetal = $row["ObserMetal"];
        $ObserAuto = $row["ObserAuto"];
        $DetalleAuto = $row["DetalleAuto"];
        $Detalle = $row["Detalle"];
        $Form = $row["Form"];
        $PRESTAMO = $row["PRESTAMO"];
        $PRESTAMOFORM = number_format($PRESTAMO, 2,'.',',');
        //$PRESTAMOFORM = "$100,000.00";

        $Obser = "";
        $DetalleFin = "";
        if($Form==1){
            $Obser = $ObserMetal;
            $DetalleFin = $Detalle;
            $tipoArt = "METAL";
        }else if($Form==2){
            $Obser = $ObserElec;
            $DetalleFin = $Detalle;
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
}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":L" . $lastRow);


$filename = 'Reporte_Historicos';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
