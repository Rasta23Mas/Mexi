<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once(SQL_PATH . "sqlReportesDAO.php");


$tipoReporte = $_POST['tipoReporte'];
$auto = $_POST['auto'];

$sqlReportesDAO= new sqlReportesDAO();
if($tipoReporte==1){
    if($auto==0){
        $sqlReportesDAO->reporteRefrendo();
    }else if ($auto==1){
        $sqlReportesDAO->reporteRefrendoAuto();
    }
}

?>