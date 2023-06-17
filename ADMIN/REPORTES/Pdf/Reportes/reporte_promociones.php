<?php

//llamos al autoload.php del mpdf
require_once __DIR__ . '/../../vendor/autoload.php';
//aqui llamo la nueva conexion
require_once "../../../modelo/conect/conect_r.php";


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
        <title>Reporte promociones</title>
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
        </th>


        <th width="30%" style="text-align: center">
        <h3 style="color: black;"> Fecha emisión:  <span style="color: black;"> ' . $fecha . '  </span> </3><br>
        <h1  style="color: black;"> Reporte promociones </h1>
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
                <th style="color: black; " class="desc"><b> Código </b></th>
                <th style="color: black; " class="desc"><b> Producto </b></th>
                <th style="color: black; " class="desc"><b> Fecha inicio </b></th>
                <th style="color: black; " class="desc"><b> Fecha fin </b></th>
                <th style="color: black; " class="desc"><b> Tipo oferta </b></th>
                <th style="color: black; " class="desc"><b> Descuento</b></th>
              </tr>
            </thead>
            <tbody>';

$sqldetalle = 'SELECT
                producto.codigo,
                producto.nombre_producto,
                ofertas.fecha_inicio,
                ofertas.fecha_fin,
                ofertas.tipo_oferta,
                ofertas.descuento,
                producto.eliminado 
                FROM
                ofertas
                INNER JOIN producto ON ofertas.id_producto = producto.id_producto 
                WHERE
                producto.eliminado = 1';

// aqui estoy pidiendo la conexion y la consulta envio
$resultmedi = $mysqli->query($sqldetalle);
$contador = 0;
while ($rowmedi = $resultmedi->fetch_assoc()) {
    $contador++;
    $html .= '<tr>
                <td class="desc"> ' . $contador . '  </td>
                <td class="desc"> ' . $rowmedi['codigo'] . ' </td>             
                <td class="desc"> ' . $rowmedi['nombre_producto'] . ' </td>
                <td class="desc"> ' . $rowmedi['fecha_inicio'] . ' </td>
                <td class="desc">' . $rowmedi['fecha_fin'] . ' </td>
                <td class="desc"> ' . $rowmedi['tipo_oferta'] . ' </td>
                <td class="desc">' . $rowmedi['descuento'] . ' %</td>
              </tr>';
}

$html .= '</tbody>
          </table>
          </main>        
      </body>
    </html>';


//esto es para cambiar el tamaño de la hoja
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output();