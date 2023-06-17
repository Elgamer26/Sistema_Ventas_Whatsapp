<?php

//llamos al autoload.php del mpdf
require_once __DIR__ . '/../vendor/autoload.php';
//aqui llamo la nueva conexion
require_once "../../modelo/conect/conect_r.php";

$sql = 'SELECT
        venta_servicio.id_venta_servico,
        cliente.nombres,
        cliente.apellidos,
        cliente.cedula,
        cliente.correo,
        cliente.direcion,
        venta_servicio.numero_compra,
        venta_servicio.tipo_doc,
        venta_servicio.iva,
        venta_servicio.fecha,
        venta_servicio.sub_total,
        venta_servicio.sub_iva,
        venta_servicio.total,
        venta_servicio.cantidad,
        venta_servicio.estado 
        FROM
        venta_servicio
        INNER JOIN cliente ON venta_servicio.id_cliente = cliente.id_cliente 
        WHERE
        venta_servicio.id_venta_servico = "' . $_GET["id"] . '"';

$consulta_empresa = 'SELECT * FROM empresa';
$resulta_empresa = $mysqli->query($consulta_empresa);
$data_empresa = mysqli_fetch_assoc($resulta_empresa);
$fecha = date("d-m-Y");

$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

  if ($row['tipo_doc'] == 'Boleta') {
    $tipo_compro = "Nota de venta";
  } else {
    $tipo_compro = $row['tipo_doc'];
  }

  $html = '<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>Compra reporte</title>
        <link rel="stylesheet" href="../css/style.css" media="all" />
      </head>
      <body>  
        <header class="clearfix">
      <table style="border-collapse;" border="1">
      <thead>
      <tr>
        <th width="20%" style="border-top:0px; border-left:0px; border-bottom:0px; border-right:0px;"><img src="../../' . $data_empresa['foto'] . '" width="99" height="99"></th>
        <th width="50%" style="border-top:0px; border-left:0px; border-bottom:0px; border-right:0px; text-align:left;">
        <b style="color: black;">Datos de le empresa:</b><br>
        <b style="color: black;">Direccion: </b> <span style="color: black;"> ' . $data_empresa['direccion'] . ' </span><br>
        <b style="color: black;">Telefono: </b> <span style="color: black;"> ' . $data_empresa['telefono'] . ' </span><br>
        <b style="color: black;">Correo: </b> <span style="color: black;"> ' . $data_empresa['correo'] . '</span><br>
        </th>


        <th width="30%" style="text-align: center">
        <h3 style="color: black;"> Fecha emisio:  <span style="color: black;"> ' . $fecha . '  </span> </3><br>
        <h1  style="color: black;"> ' . $tipo_compro . '</h1>
        <h3 style="color: black;">N°: <span style="color: black;"></span>' . $row['numero_compra'] . '  </span> 
         </th>
      </tr>
    </thead>
      </table>
          <h1></h1>         
          <div id="project">
            <div><span style="color: black; font-size: 15px"><b> Nombres : </b>  ' . $row['nombres'] . ' ' . $row['apellidos'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Cedula : </b>  ' . $row['cedula'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Correo : </b> ' . $row['correo'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Fecha venta: </b>  ' . $row['fecha'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Cantidad: </b>  ' . $row['cantidad'] . ' </div>
          </div>
        </header>
        <main>
          <table>
            <thead>
              <tr>
                <th style="color: black; " class="service">ITEM</th>
                <th style="color: black; " class="desc">SERVICIO</th>
                <th style="color: black; ">CANTIDAD</th>
                <th style="color: black; ">PRECIO</th>
                <th style="color: black; ">DESCUENTO</th>
                <th style="color: black; ">TOTAL</th>
              </tr>
            </thead>
            <tbody>';

  $sqldetalle = 'SELECT
                detalle_venta_servicio.id_venta_servicio,
                servicio.servicio,
                detalle_venta_servicio.cantidad,
                detalle_venta_servicio.precio,
                detalle_venta_servicio.descuento,
                detalle_venta_servicio.total 
                FROM
                detalle_venta_servicio
                INNER JOIN servicio ON detalle_venta_servicio.id_servicio = servicio.id_servicio 
                WHERE
                detalle_venta_servicio.id_venta_servicio = "' . $_GET["id"] . '"';

  $contador = 0;

  // aqui estoy pidiendo la conexion y la consulta envio
  $resultmedi = $mysqli->query($sqldetalle);

  while ($rowmedi = $resultmedi->fetch_assoc()) {

    $contador++;
    $html .= '<tr>
                <td class="service">' . $contador . '</td>
                <td class="desc"> ' . $rowmedi['servicio'] . '  </td>
                <td class="desc"> ' . $rowmedi['cantidad'] . ' </td>             
                <td class="unit">$ ' . $rowmedi['precio'] . ' </td>
                <td class="qty">$ ' . $rowmedi['descuento'] . ' </td>
                <td class="total">$ ' . $rowmedi['total'] . ' </td>
              </tr>';
  }

  $html .= '<tr>
    <td colspan="2" style="background: #ffffff;"> 
    <b>
  
    </b> 
    </td>
    dff
  </tr>     
    <tr>
    <td style="background: #ffffff;" colspan="5">SUBTOTAL:</td>
    <td style="background: #ffffff;" class="total">$ ' . $row['sub_total'] . '   </td>
  </tr>
  <tr>
    <td style="background: #ffffff;" colspan="5">Iva %  </td>
    <td style="background: #ffffff;" class="total">$ ' . $row['sub_iva'] . ' </td>
  </tr>
  <tr>
    <td style="background: #ffffff;" colspan="5" class="TOTAL">Gran total:</td>
    <td style="background: #ffffff;" class="grand total">$ ' . $row['total'] . ' </td>
  </tr>
  </tbody>';


  $html .= '</tbody>
          </table>';

  if ($row['estado'] == 0) {
    $html .= '<table style="border-collapse;" border="1">
            <thead>
            <tr>
            <th width="20%" style="text-align: center; border-top:0px; border-left:0px; border-bottom:0px; border-right:0px;">
            <img src="../img/anulado.png" width="600" height="100">
            </th>
            </th>
            </tr>
            </thead>
            </table>';
  }
  $html .= '</main>        
      </body>
    </html>';
}

//esto es para cambiar el tamaño de la hoja
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output();
