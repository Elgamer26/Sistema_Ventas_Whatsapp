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
        <title>Reporte facturación servicios</title>
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
        <h1  style="color: black;"> Facturación servicios</h1>
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
                <th style="color: black; " class="desc"><b> Cliente </b></th>             
                <th style="color: black; " class="desc"><b> N° servicio </b></th>
                <th style="color: black; " class="desc"><b> Cantidad </b></th>
                <th style="color: black; " class="desc"><b> Total </b></th>
              </tr>
            </thead>
            <tbody>';

$sqldetalle = 'SELECT
                venta_servicio.fecha,
                CONCAT_WS( " ", cliente.nombres, cliente.apellidos ) AS cliente,
                venta_servicio.numero_compra,
                venta_servicio.tipo_doc,
                venta_servicio.iva,
                venta_servicio.sub_total,
                venta_servicio.sub_iva,
                venta_servicio.total,
                venta_servicio.cantidad,
                venta_servicio.estado 
                FROM
                venta_servicio
                INNER JOIN cliente ON venta_servicio.id_cliente = cliente.id_cliente 
                WHERE
                venta_servicio.estado = 1 AND DATE(venta_servicio.fecha) BETWEEN "' . $f_i . '" AND "' . $f_f . '"';

// aqui estoy pidiendo la conexion y la consulta envio
$resultmedi = $mysqli->query($sqldetalle);
$contadromed = 0;
while ($rowmedi = $resultmedi->fetch_assoc()) {

    $sumar += $rowmedi['total'];
    $contadromed++;

    $html .= '<tr>
                <td class="desc"> ' . $contadromed . '  </td>
                <td class="desc"> ' . $rowmedi['fecha'] . '  </td>
                <td class="desc"> ' . $rowmedi['cliente'] . ' </td>             
                <td class="desc"> ' . $rowmedi['numero_compra'] . ' </td>
                <td class="desc"> ' . $rowmedi['cantidad'] . ' </td>
                <td class="desc">$ ' . $rowmedi['total'] . ' </td>
              </tr>';
}


$html .= '<tr>
<td colspan="4" style="background: #ffffff;"> 
<b>

</b> 
</td>
dff
</tr>     
<tr>
<td style="background: #ffffff;" colspan="5"><b> Total: </b></td>
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
