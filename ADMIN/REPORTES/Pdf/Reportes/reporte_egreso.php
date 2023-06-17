<?php

//llamos al autoload.php del mpdf
require_once __DIR__ . '/../../vendor/autoload.php';
//aqui llamo la nueva conexion
require_once "../../../modelo/conect/conect_r.php";

$f_i = $_GET["f_i"];
$f_f = $_GET["f_f"];

$consulta_empresa = 'SELECT * FROM empresa';
$resulta_empresa = $mysqli->query($consulta_empresa);
$data_empresa = mysqli_fetch_assoc($resulta_empresa);
date_default_timezone_set('America/Guayaquil');
$fecha = date("d-m-Y");
$hora = date("h:i:s a", time());

$html = '<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>Reporte de egresos</title>
        <link rel="stylesheet" href="../../css/style.css" media="all" />
      </head>
      <body>  
        <header class="clearfix">
      <table style="border-collapse;" border="1">
      <thead>
      <tr>
        <th width="20%" style="border-top:0px; border-left:0px; border-bottom:0px; border-right:0px;"><img src="../../../' . $data_empresa['foto'] . '" width="99" height="99"></th>
        <th width="50%" style="border-top:0px; border-left:0px; border-bottom:0px; border-right:0px; text-align:left;">
        <b style="color: black;">Datos de le empresa:</b><br>
        <b style="color: black;">Dirección: </b> <span style="color: black;"> ' . $data_empresa['direccion'] . ' </span><br>
        <b style="color: black;">Telefono: </b> <span style="color: black;"> ' . $data_empresa['telefono'] . ' </span><br>
        <b style="color: black;">Correo: </b> <span style="color: black;"> ' . $data_empresa['correo'] . '</span><br>
        <b style="color: black;">Fecha incio: </b> <span style="color: black;"> ' . $f_i . '</span> -  <b style="color: black;"> Fecha fin: </b> <span style="color: black;"> ' . $f_f . '</span><br>
        </th>


        <th width="30%" style="text-align: center">
        <h3 style="color: black;"> Fecha emisión:  <span style="color: black;"> ' . $fecha . '  </span> </3><br>
        <h1  style="color: black;"> Reporte de egresos</h1>
        <h3 style="color: black;">Hora: <span style="color: black;"></span>' . $hora . '</span> 
         </th>
      </tr>
    </thead>
      </table>    

        </header>
        <main>
          <table>
            <thead>
              <tr>
              <th style="color: black; " class="desc"><b> # </b></th>
              <th style="color: black; " class="desc"><b> Fecha </b></th>
                <th style="color: black; " class="desc"><b> Tipo documento </b></th>             
                <th style="color: black; " class="desc"><b> Iva </b></th>
                <th style="color: black; " class="desc"><b> Subtotal </b></th>
                <th style="color: black; " class="desc"><b> Impuesto </b></th>
                <th style="color: black; " class="desc"><b> Total </b></th>
              </tr>
            </thead>
            <tbody>';

$sqldetalle = 'SELECT
                compra.fecha,
                compra.tipo_doc,
                compra.numero_compra,
                compra.iva,
                compra.cantidad,
                compra.estado,
                compra.sub_total,
                compra.total,
                compra.sub_iva 
                FROM
                compra 
                WHERE
                compra.estado = 1 
                AND DATE(compra.fecha) BETWEEN "' . $f_i . '" AND "' . $f_f . '"';

// aqui estoy pidiendo la conexion y la consulta envio
$resultmedi = $mysqli->query($sqldetalle);
$contadromed = 0;
$tipo = "";
while ($rowmedi = $resultmedi->fetch_assoc()) {

    $sumar += $rowmedi['total'];
    $contadromed++;

    if ($rowmedi['tipo_doc'] == 'Boleta') {
        $tipo = "Nota de compra";
    } else {
        $tipo = $rowmedi['tipo_doc'];
    }

    $html .= '<tr>
                <td class="desc"> ' . $contadromed . '  </td>
                <td class="desc"> ' . $rowmedi['fecha'] . '  </td>
                <td class="desc"> ' . $tipo . ' </td>             
                <td class="desc"> ' . $rowmedi['iva'] . ' %</td>
                <td class="desc"> ' . $rowmedi['sub_total'] . ' </td>
                <td class="desc">$ ' . $rowmedi['sub_iva'] . ' </td>
                <td class="desc">$ ' . $rowmedi['total'] . ' </td>
              </tr>';
}


$html .= '<tr>
<td colspan="6" style="background: #ffffff;"> 
<b>

</b> 
</td>
dff
</tr>     
<tr>
<td style="background: #ffffff;" colspan="6"><b> Total: </b></td>
<td style="background: #ffffff;" class="total">$ ' . number_format($sumar, 2) . '   </td>
</tr>


</tbody>
          </table>
          </main>        
      </body>
    </html>';


//esto es para cambiar el tamaño de la hoja
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output();
