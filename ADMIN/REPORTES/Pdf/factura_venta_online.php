<?php

//llamos al autoload.php del mpdf
require_once __DIR__ . '/../vendor/autoload.php';
//aqui llamo la nueva conexion
require_once "../../modelo/conect/conect_r.php";

$sql = 'SELECT
        venta_online.id_venta_online_trans, 
        cliente.nombres, 
        cliente.apellidos, 
        cliente.cedula, 
        venta_online.tipo_pago, 
        venta_online.numero_compra, 
        venta_online.fecha, 
        venta_online.cantidad, 
        venta_online.subtotal, 
        venta_online.impuesto, 
        venta_online.total, 
        venta_online.direccion, 
        venta_online.referencia, 
        venta_online.estado, 
        venta_online.pago
        FROM
        venta_online
        INNER JOIN
        cliente
        ON 
            venta_online.cliente_id = cliente.id_cliente 
            WHERE venta_online.id_venta_online_trans ="' . $_GET["id"] . '"';

$consulta_empresa = 'SELECT * FROM empresa';
$resulta_empresa = $mysqli->query($consulta_empresa);
$data_empresa = mysqli_fetch_assoc($resulta_empresa);
$fecha = date("d-m-Y");

$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

    $pago = "";

    if ($row['pago'] == 0) {
        $pago = "En espera";
    } else if ($row['pago'] == 1) {
        $pago = "Pago enviado";
    } else {
        $pago = "Pagado";
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
        <b style="color: black;">Dirección: </b> <span style="color: black;"> ' . $data_empresa['direccion'] . ' </span><br>
        <b style="color: black;">Telefono: </b> <span style="color: black;"> ' . $data_empresa['telefono'] . ' </span><br>
        <b style="color: black;">Correo: </b> <span style="color: black;"> ' . $data_empresa['correo'] . '</span><br>
        </th>


        <th width="30%" style="text-align: center">
        <h3 style="color: black;"> Fecha emisión:  <span style="color: black;"> ' . $fecha . '  </span> </3><br>
        <h1  style="color: black;"> ' . $pago . '</h1>
        <h3 style="color: black;">N°: <span style="color: black;"></span>' . $row['numero_compra'] . '  </span> 
         </th>
      </tr>
    </thead>
      </table>
          <h1></h1>         
          <div id="project">
            <div><span style="color: black; font-size: 15px"><b> Nombres: </b>  ' . $row['nombres'] . ' ' . $row['apellidos'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Cedula: </b>  ' . $row['cedula'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Dirección envio: </b>  ' . $row['direccion'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Referencia envio: </b> ' . $row['referencia'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Tipo pago: </b>  ' . $row['tipo_pago'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Fecha venta: </b>  ' . $row['fecha'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Cantidad: </b>  ' . $row['cantidad'] . ' </div>
          </div>
        </header>
        <main>
          <table>
            <thead>
              <tr>
                <th style="color: black; " class="desc">PRODUCTO</th>
                <th style="color: black; ">CANTIDAD</th>
                <th style="color: black; ">PRECIO</th>
                <th style="color: black; ">DESC. OFERTA</th>
                <th style="color: black; ">OFERTA</th>
                <th style="color: black; ">TOTAL</th>
              </tr>
            </thead>
            <tbody>';

    $sqldetalle = 'SELECT
                    detalle_venta_online_transferencia.id_venta_online,
                    producto.nombre_producto,
                    detalle_venta_online_transferencia.cantidad,
                    detalle_venta_online_transferencia.precio,
                    detalle_venta_online_transferencia.descuento_oferta,
                    detalle_venta_online_transferencia.tipo_oferta,
                    detalle_venta_online_transferencia.subtotal,
                    detalle_venta_online_transferencia.estado 
                FROM
                    detalle_venta_online_transferencia
                    INNER JOIN producto ON detalle_venta_online_transferencia.producto_id = producto.id_producto
                    INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto 
                WHERE
                    detalle_venta_online_transferencia.id_venta_online = "' . $_GET["id"] . '"';

    // aqui estoy pidiendo la conexion y la consulta envio
    $resultmedi = $mysqli->query($sqldetalle);

    while ($rowmedi = $resultmedi->fetch_assoc()) {


        $html .= '<tr>
                <td class="desc"> ' . $rowmedi['nombre_producto'] . '  </td>
                <td class="desc"> ' . $rowmedi['cantidad'] . ' </td>             
                <td class="qty">$ ' . $rowmedi['precio'] . ' </td>
                <td class="total"> ' . $rowmedi['descuento_oferta'] . ' </td>
                <td class="unit">' . $rowmedi['tipo_oferta'] . ' </td>
                <td class="qty">$ ' . $rowmedi['subtotal'] . ' </td>
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
    <td style="background: #ffffff;" colspan="5">SUBTOTAL:</td>
    <td style="background: #ffffff;" class="total">$ ' . $row['subtotal'] . '   </td>
  </tr>
  <tr>
    <td style="background: #ffffff;" colspan="5">Iva %  </td>
    <td style="background: #ffffff;" class="total">$ ' . $row['impuesto'] . ' </td>
  </tr>
  <tr>
    <td style="background: #ffffff;" colspan="5" class="TOTAL">Total:</td>
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
