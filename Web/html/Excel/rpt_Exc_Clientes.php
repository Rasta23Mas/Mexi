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
    ->setCellValue('A1', "Reporte Clientes");
//->setCellValue('A1', "Reporte Histórico del ". $fechaIni ." al ". $fechaFin);

//merge heading
$spreadsheet->getActiveSheet()->mergeCells("A1:G1");

// set font style
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

// set cell alignment
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);

$spreadsheet->getActiveSheet()
    ->setCellValue('A2', 'ID')
    ->setCellValue('B2', 'NOMBRE')
    ->setCellValue('C2', 'FECHA NACIMIENTO')
    ->setCellValue('D2', 'SEXO')
    ->setCellValue('E2', 'DIRECCIÓN')
    ->setCellValue('F2', 'MENSAJE')
    ->setCellValue('G2', 'COMO SE ENTERO');


$spreadsheet->getActiveSheet()->getStyle('A2:G2')->applyFromArray($tableHead);


$rptCliente = "SELECT id_Cliente,fecha_Nacimiento,
                        CONCAT(apellido_Pat,'/',  apellido_Mat, '/', nombre) AS NombreCompleto, 
                        CONCAT(calle, ', ',num_interior,', ', num_exterior, ', ',localidad, ', ', municipio, 
                        ', ', cat_estado.descripcion ) AS direccionCompleta,  Sex.descripcion as Sexo,
                        PROM.descripcion as Promo, mensaje
                        FROM cliente_tbl
                        INNER JOIN cat_estado ON cliente_tbl.estado = cat_estado.id_Estado
                        LEFT JOIN cat_cliente AS SEX ON cliente_tbl.sexo = Sex.id_Cat_Cliente
                        LEFT JOIN cat_cliente AS PROM ON cliente_tbl.promocion = PROM.id_Cat_Cliente
                        WHERE sucursal =$sucursal";
$query = $db->query($rptCliente);


if($query->num_rows > 0) {
    $i = 3;
    while($row = $query->fetch_assoc()) {

        $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i , $row['id_Cliente'])
            ->setCellValue('B'.$i , $row['NombreCompleto'])
            ->setCellValue('C'.$i , $row['fecha_Nacimiento'])
            ->setCellValue('D'.$i , $row['Sexo'])
            ->setCellValue('E'.$i , $row['direccionCompleta'])
            ->setCellValue('F'.$i , $row['Promo'])
            ->setCellValue('G'.$i , $row['mensaje']);

        //set row style
        if ($i % 2 == 0) {
            //even row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':G' . $i)->applyFromArray($evenRow);
        } else {
            //odd row
            $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':G' . $i)->applyFromArray($oddRow);
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
        ->setCellValue('G'.$i , "");

    $spreadsheet->getActiveSheet()->getStyle('A' . $i . ':G' . $i)->applyFromArray($evenRow);

}

$firstRow = 2;
$lastRow = $i - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ":G" . $lastRow);


$filename = 'Reporte_Clientes';

//header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='. $filename. '.xlsx');
header('Cache-Control: max-age=0');

//create IOFactory object
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//save into php output
$writer->save('php://output');
