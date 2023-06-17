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
        <title>Reporte usuario</title>
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
        <h1  style="color: black;"> Reporte usuario </h1>
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
                <th style="color: black; " class="desc"><b> Nombres </b></th>
                <th style="color: black; " class="desc"><b> Apellidos </b></th>
                <th style="color: black; " class="desc"><b> Cedula </b></th>
                <th style="color: black; " class="desc"><b> Tipo de usuario </b></th>
                <th style="color: black; " class="desc"><b> Usuario </b></th> 
              </tr>
            </thead>
            <tbody>';

$sqldetalle = 'SELECT
                usuario.nombres,
                usuario.apellidos,
                usuario.documento,
                tipo_usuario.tipo_usuario,
                usuario.estado,
                usuario.usuario,
                usuario.foto 
                FROM
                usuario
                INNER JOIN tipo_usuario ON usuario.id_tipo_usuario = tipo_usuario.id_tipo_usuario 
                WHERE
                usuario.estado = 1';

// aqui estoy pidiendo la conexion y la consulta envio
$resultmedi = $mysqli->query($sqldetalle);
$contador = 0;
while ($rowmedi = $resultmedi->fetch_assoc()) {

    $contador++;
    $html .= '<tr>
                <td class="desc"> ' . $contador . '  </td>
                <td class="desc"> ' . $rowmedi['nombres'] . '  </td>
                <td class="desc"> ' . $rowmedi['apellidos'] . '  </td>
                <td class="desc"> ' . $rowmedi['documento'] . ' </td>             
                <td class="desc"> ' . $rowmedi['tipo_usuario'] . ' </td>
                <td class="desc"> ' . $rowmedi['usuario'] . ' </td> 
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
