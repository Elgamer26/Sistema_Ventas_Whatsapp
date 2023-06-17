<?php

//llamos al autoload.php del mpdf
require_once __DIR__ . '/../vendor/autoload.php';
//aqui llamo la nueva conexion
require_once "../../modelo/conect/conect_r.php";

$sql = 'SELECT
        venta.id_venta,
        CONCAT_WS( " ", cliente.nombres, cliente.apellidos ) AS cliente,
        cliente.cedula,
        cliente.correo,
        cliente.direcion,
        venta.fecha,
        venta.tipo_doc,
        venta.numero_compra,
        venta.iva,
        venta.sub_total,
        venta.sub_iva,
        venta.total,
        venta.cantidad,
        venta.estado 
        FROM
        venta
        INNER JOIN cliente ON venta.id_cliente = cliente.id_cliente 
        WHERE
        venta.id_venta = "' . $_GET["id"] . '"';

$consulta_empresa = 'SELECT * FROM empresa';
$resulta_empresa = $mysqli->query($consulta_empresa);
$data_empresa = mysqli_fetch_assoc($resulta_empresa);
$fecha = date("d-m-Y");
$tipo_compro = "";

$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

  if($row['tipo_doc'] == 'Boleta'){
    $tipo_compro = "Nota de venta";
  }else{
    $tipo_compro = $row['tipo_doc'];
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
        <h1  style="color: black;"> ' . $tipo_compro . '</h1>
        <h3 style="color: black;">N°: <span style="color: black;"></span>' . $row['numero_compra'] . '  </span> 
         </th>
      </tr>
    </thead>
      </table>
          <h1></h1>         
          <div id="project">
            <div><span style="color: black; font-size: 15px"><b> Nombres : </b>  ' . $row['cliente'] . ' </div>
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
                <th style="color: black; " class="desc">PRODUCTO</th>
                <th style="color: black; ">CANTIDAD</th>
                <th style="color: black; ">SALE</th>
                <th style="color: black; ">PRECIO</th>
                <th style="color: black; ">OFERTA</th>
                <th style="color: black; ">DESC. OFERTA</th>
                <th style="color: black; ">DESCUENTO</th>
                <th style="color: black; ">TOTAL</th>
              </tr>
            </thead>
            <tbody>';

    $sqldetalle = 'SELECT
                    detalle_vent_pro.id_venta,
                    producto.nombre_producto,
                    detalle_vent_pro.cantidad,
                    detalle_vent_pro.sale,
                    detalle_vent_pro.precio,
                    detalle_vent_pro.tipo_oferta,
                    detalle_vent_pro.des_pferta,
                    detalle_vent_pro.descuento,
                    detalle_vent_pro.total,
                    detalle_vent_pro.estado 
                FROM
                    detalle_vent_pro
                    INNER JOIN producto ON detalle_vent_pro.id_producto = producto.id_producto 
                WHERE
                    detalle_vent_pro.id_venta = "' . $_GET["id"] . '"';

 

    // aqui estoy pidiendo la conexion y la consulta envio
    $resultmedi = $mysqli->query($sqldetalle);

    while ($rowmedi = $resultmedi->fetch_assoc()) {

  
        $html .= '<tr>
                <td class="desc"> ' . $rowmedi['nombre_producto'] . '  </td>
                <td class="desc"> ' . $rowmedi['cantidad'] . ' </td>             
                <td class="desc"> ' . $rowmedi['sale'] . ' </td>
                <td class="qty">$ ' . $rowmedi['precio'] . ' </td>
                <td class="total"> ' . $rowmedi['tipo_oferta'] . ' </td>
                <td class="unit">$ ' . $rowmedi['des_pferta'] . ' </td>
                <td class="qty">$ ' . $rowmedi['descuento'] . ' </td>
                <td class="unit">$ ' . $rowmedi['total'] . ' </td>
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
    <td style="background: #ffffff;" colspan="7">SUBTOTAL:</td>
    <td style="background: #ffffff;" class="total">$ ' . $row['sub_total'] . '   </td>
  </tr>
  <tr>
    <td style="background: #ffffff;" colspan="7">Iva %  </td>
    <td style="background: #ffffff;" class="total">$ ' . $row['sub_iva'] . ' </td>
  </tr>
  <tr>
    <td style="background: #ffffff;" colspan="7" class="TOTAL">Gran total:</td>
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
