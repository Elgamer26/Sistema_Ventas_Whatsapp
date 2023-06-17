<?php

//llamos al autoload.php del mpdf
require_once __DIR__ . '/../vendor/autoload.php';
//aqui llamo la nueva conexion
require_once "../../modelo/conect/conect_r.php";

$sql = 'SELECT
        envios.envio_id,
        CONCAT_WS(" ", repartidor.nombres, repartidor.apellidos ) AS repartidor,
        CONCAT_WS(" ", vehiculo.tipo, "/", vehiculo.marca, "/", vehiculo.matricula ) AS vehiculos,
        envios.num_envio,
        envios.fecha_envio,
        envios.total,
        envios.countt,
        envios.estado 
        FROM
        envios
        INNER JOIN repartidor ON envios.repartidor_id = repartidor.repartidor_id
        INNER JOIN vehiculo ON envios.`vehículo_id` = vehiculo.id_vehiculo
        WHERE
        envios.envio_id = "' . $_GET["id"] . '"';

$consulta_empresa = 'SELECT * FROM empresa';
$resulta_empresa = $mysqli->query($consulta_empresa);
$data_empresa = mysqli_fetch_assoc($resulta_empresa);
$fecha = date("d-m-Y");
$estado = "";

$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

    if ($row['estado'] == 1) {
        $estado = "ENVIADO";
    } else {
        $estado = "ENTREGADO";
    }

    $html = '<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>Venta reporte</title>
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
        <h1  style="color: black;"> ' . $estado . '</h1>
        <h3 style="color: black;">N°: <span style="color: black;"></span>' . $row['num_envio'] . '  </span> 
         </th>
      </tr>
    </thead>
      </table>
          <h1></h1>         
          <div id="project">
            <div><span style="color: black; font-size: 15px"><b> Nombres : </b>  ' . $row['repartidor'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Vehiculo : </b>  ' . $row['vehiculos'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Fecha envio : </b> ' . $row['fecha_envio'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Cantidad envios: </b>  ' . $row['countt'] . ' </div>
          </div>
        </header>
        <main>
          <table>
            <thead>
              <tr>
                <th style="color: black; ">Cliente</th>
                <th style="color: black; ">Tipo transf.</th>
                <th style="color: black; ">N. venta</th>
                <th style="color: black; ">Dirección</th>
                <th style="color: black; ">Referencia</th>
                <th style="color: black; ">Telefono</th>
                <th style="color: black; ">Cant. producto</th>
                <th style="color: black; ">Valor envio</th>
              </tr>
            </thead>
            <tbody>';

    $sqldetalle = 'SELECT
    detalle_envios.envio_id, 
    CONCAT_WS(" ", cliente.nombres, cliente.apellidos ) AS cliente, 
    cliente.telefono,
    detalle_envios.direccion, 
    detalle_envios.refrencia, 
    detalle_envios.num_venta, 
    detalle_envios.cantidad, 
    detalle_envios.valor, 
    venta_online.tipo_pago
    FROM
    detalle_envios
    INNER JOIN
    venta_online
    ON 
        detalle_envios.venta_online_id = venta_online.id_venta_online_trans
    INNER JOIN
    cliente
    ON 
        venta_online.cliente_id = cliente.id_cliente
    WHERE
    detalle_envios.envio_id =  "' . $_GET["id"] . '"';

    // aqui estoy pidiendo la conexion y la consulta envio
    $resultmedi = $mysqli->query($sqldetalle);
    while ($rowmedi = $resultmedi->fetch_assoc()) {
        $html .= '<tr>
                <td class="desc"> ' . $rowmedi['cliente'] . ' </td>             
                <td class="desc"> ' . $rowmedi['tipo_pago'] . ' </td>
                <td class="desc"> ' . $rowmedi['num_venta'] . ' </td>
                <td class="desc"> ' . $rowmedi['direccion'] . ' </td>
                <td class="desc"> ' . $rowmedi['refrencia'] . ' </td>
                <td class="desc"> ' . $rowmedi['telefono'] . ' </td>
                <td class="desc"> ' . $rowmedi['cantidad'] . ' </td>
                <td class="desc">$ ' . $rowmedi['valor'] . ' </td>
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
    <td style="background: #ffffff;" colspan="7">TOTAL:</td>
    <td style="background: #ffffff;" class="total">$ ' . $row['total'] . '   </td>
  </tr>

  </tbody>';

    $html .= '</tbody>
          </table>';

    $html .= '</main>        
      </body>
    </html>';
}

//esto es para cambiar el tamaño de la hoja
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output();
