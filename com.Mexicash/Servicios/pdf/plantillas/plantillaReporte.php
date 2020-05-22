<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dirs.php');
include_once (SQL_PATH."sqlReporteDAO.php");

function getInventarioFisicoExcel($empe, $desempe, $refrendo, $almoneda, $auto, $fechaInicial, $fechaFinal){
header("Pragma: public");
header("Expires: 0");
$filename = "inventarioFisico.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    $sql = new sqlReporteDAO();
    $datos = array();

    $datos = $sql ->traeInventario($empe, $desempe, $refrendo, $almoneda, $auto, $fechaInicial, $fechaFinal);

    $plantilla2 = '';

    for($i =0; $i < count($datos); $i++){
        $plantilla2 .= '<tr>
              <td>'. $datos[$i]["id_Articulo"] .'</td>
              <td>'. $datos[$i]["detalle"] .'</td>
              <td>'. $datos[$i]["kilataje"] .'</td>
              <td>'. $datos[$i]["peso"] .'</td>
              <td>'. $datos[$i]["cantidad"] .'</td>
              <td>'. $datos[$i]["fecha_creacion"] .'</td>
              <td>'. $datos[$i]["fecha_modificacion"] .'</td>
              <td>'. $datos[$i]["estatus"] .'</td>
              </tr>';
    };

echo '
    <h2>Inventario Fisico</h2>
    <h5>Fecha inicio: '. $fechaInicial .' </h5>
    <h5>Fecha final: '. $fechaFinal .' </h5>
    <table>
        <thead>
          <tr>
            <th class="service">C&Oacute;DIGO</th>
            <th class="desc">DESCRIPCI&Oacute;N</th>
            <th>Kilataje</th>
            <th>Peso</th>
            <th>Cantidad</th>
            <th>Creacion</th>
            <th>Modificacion</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody> '
        . $plantilla2 . '

        </tbody>
    </table>';

}

function getInventarioFisicoPDF($empe, $desempe, $refrendo, $almoneda, $auto, $fechaInicial, $fechaFinal){

    $sql = new sqlReporteDAO();
    $datos = array();

    $datos = $sql ->traeInventario($empe, $desempe, $refrendo, $almoneda, $auto, $fechaInicial, $fechaFinal);

    $plantilla2 = '';

    for($i =0; $i < count($datos); $i++){
        $plantilla2 .= '<tr>
              <td>'. $datos[$i]["id_Articulo"] .'</td>
              <td>'. $datos[$i]["detalle"] .'</td>
              <td>'. $datos[$i]["kilataje"] .'</td>
              <td>'. $datos[$i]["peso"] .'</td>
              <td>'. $datos[$i]["cantidad"] .'</td>
              <td>'. $datos[$i]["fecha_creacion"] .'</td>
              <td>'. $datos[$i]["fecha_modificacion"] .'</td>
              <td>'. $datos[$i]["estatus"] .'</td>
              </tr>';
    };


    $plantilla = '<body>
    <header class="clearfix">
      <div id="logo">
        <img src="../../style/Img/LogoCH.jpeg">
      </div>
      <h1>Inventario Fisico</h1>
    </header>
    <main>
    <h5>Fecha inicio: '. $fechaInicial .' </h5>
    <h5>Fecha final: '. $fechaFinal .' </h5>
      <table>
        <thead>
          <tr>
            <th class="service">C&Oacute;DIGO</th>
            <th class="desc">DESCRIPCI&Oacute;N</th>
            <th>Kilataje</th>
            <th>Peso</th>
            <th>Cantidad</th>
            <th>Creacion</th>
            <th>Modificacion</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody> '
        . $plantilla2 . '
          
        </tbody>
      </table>
    </main>
    <footer>
      Mexicash, una franquicia 100% Mexicana.
    </footer>
  </body>';

    return $plantilla;
}

function getPlantilla($empe, $desempe, $refrendo, $almoneda){
    $sql = new sqlReporteDAO();
    $datos = array();

    $datos = $sql ->traeInventario($empe, $desempe, $refrendo, $almoneda);

    $plantilla2 = '';

    for($i =0; $i < count($datos); $i++){
        $plantilla2 = $plantilla2 . '<tr>
              <td>'. $datos[$i]["id_Articulo"] .'</td>
              <td>'. $datos[$i]["detalle"] .'</td>
              <td>'. $datos[$i]["kilataje"] .'</td>
              <td>'. $datos[$i]["peso"] .'</td>
              <td>'. $datos[$i]["total_Prestamo"] .'</td>
              <td>'. $datos[$i]["cantidad"] .'</td>
              <td>'. $datos[$i]["fecha_Vencimiento"] .'</td>
              <td>'. $datos[$i]["estatus"] .'</td>
              </tr>';
    };


    $plantilla = '<body>
    <header class="clearfix">
      <div id="logo">
        <img src="../../style/Img/LogoCH.jpeg">
      </div>
      <h1>Inventario Fisico</h1>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">C&Oacute;DIGO</th>
            <th class="desc">DESCRIPCI&Oacute;N</th>
            <th>Kilataje</th>
            <th>Peso</th>
            <th>PR&Eacute;STAMO</th>
            <th>Cantidad</th>
            <th>Vencimiento</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody> '
        . $plantilla2 . '
          
        </tbody>
      </table>
    </main>
    <footer>
      Mexicash, una franquicia 100% Mexicana.
    </footer>
  </body>';

    return $plantilla;

}

function getReporteCliente($nombre, $curp){

    $plantilla = '<body>
<header class="clearfix">
  <div id="logo">
    <img src="../../style/Img/LogoCH.jpeg">
  </div>
  <h1>Contrato de Empeño</h1>
  <div id="company" class="clearfix">
    <div>Mexicash</div>
    <div>725 Jamaica,<br /> GAM 07300, MX</div>
    <div>(+52) 7282-0450</div>
    <div><a href="contacto@mexicash.com">contacto@mexicash.com</a></div>
  </div>
  <div id="project">
    <div><span>PROGRAMA</span> Empeño</div>
    <div><span>CLIENTE</span> Alejandro Jair Ramos Peña</div>
    <div><span>DIRECCION</span> Jacarandas 32 col Centro del Cuauht&eacute;moc 04300 CDMX</div>
    <div><span>EMAIL</span> <a href="yayis-bros@hotmail.com">yayis-bros@hotmail.com</a></div>
    <div><span>FECHA MOVIMIENTO</span> Enero 09, 2020</div>
    <div><span>VENCIMIENTO</span> Marzo 31, 2020</div>
  </div>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th class="service">C&Oacute;DIGO</th>
        <th class="desc">DESCRIPCI&Oacute;N</th>
        <th>CANTIDAD</th>
        <th>AVALUO</th>
        <th>PR&Eacute;STAMO</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="service">030224</td>
        <td class="desc">C&aacute;mara digital CASIO</td>
        <td class="unit">1</td>
        <td class="qty">$10000</td>
        <td class="total">$6500.00</td>
      </tr>
      <tr>
        <td class="service">132423</td>
        <td class="desc">Guitarra Fender Squire</td>
        <td class="unit">2</td>
        <td class="qty">$21000</td>
        <td class="total">$10000.00</td>
      </tr>
      <tr>
        <td class="service">732543</td>
        <td class="desc">Teclado rgb inal&aacute;mbrico</td>
        <td class="unit">1</td>
        <td class="qty">$700</td>
        <td class="total">$300.00</td>
      </tr>
      <tr>
        <td class="service">102190</td>
        <td class="desc">Tenis Jordan nuevos</td>
        <td class="unit">1</td>
        <td class="qty">$1300</td>
        <td class="total">$600.00</td>
      </tr>
      <tr>
        <td colspan="4">SUBTOTAL</td>
        <td class="total">$17400.00</td>
      </tr>
      <tr>
        <td colspan="4">IVA 16%</td>
        <td class="total">$2784.00</td>
      </tr>
      <tr>
        <td colspan="4" class="grand total">TOTAL</td>
        <td class="grand total">$14616.00</td>
      </tr>
    </tbody>
  </table>
  <div id="notices">
    <div>NOTA:</div>
    <div class="notice">Recuerda desempeñar tus artículos antes de la fecha de vencimiento, ya que de lo contrario pasarán a ser propiedad de Mexicash.</div>
  </div>
</main>
<footer>
  Gracias por su preferencia y esperamos su recomendaci&oacute;n.
</footer>
</body>';

    return $plantilla;

}

function getReportes($opc){

    }

