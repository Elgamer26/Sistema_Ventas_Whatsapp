<?php

//llamos al autoload.php del mpdf
require_once __DIR__ . '/../vendor/autoload.php';
//aqui llamo la nueva conexion
require_once "../../modelo/conect/conect_r.php";

$sql = 'SELECT
        compra.id_compra,
        proveedor.razon_social,
        compra.fecha,
        compra.tipo_doc,
        compra.numero_compra,
        compra.iva,
        compra.cantidad,
        compra.estado,
        compra.sub_total,
        compra.total,
        compra.sub_iva,
        proveedor.ruc,
        proveedor.telefono,
        proveedor.encargado,
        proveedor.correo,
        proveedor.direccion 
        FROM
        compra
        INNER JOIN proveedor ON compra.id_proveedor = proveedor.id_proveedor
        WHERE compra.id_compra = "' . $_GET["id"] . '"';

$consulta_empresa = 'SELECT * FROM empresa';
$resulta_empresa = $mysqli->query($consulta_empresa);
$data_empresa = mysqli_fetch_assoc($resulta_empresa);
$fecha = date("d-m-Y");

$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

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
        <h1  style="color: black;"> ' . $row['tipo_doc'] . '</h1>
        <h3 style="color: black;">N°: <span style="color: black;"></span>' . $row['numero_compra'] . '  </span> 
         </th>
      </tr>
    </thead>
      </table>
          <h1></h1>         
          <div id="project">
            <div><span style="color: black; font-size: 15px"><b> Proveedor : </b>  ' . $row['razon_social'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Numero contacto : </b>  ' . $row['telefono'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Ruc : </b> ' . $row['ruc'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Fecha compra: </b>  ' . $row['fecha'] . ' </div>
            <div><span style="color: black; font-size: 15px"><b> Cantidad: </b>  ' . $row['cantidad'] . ' </div>
          </div>
        </header>
        <main>
          <table>
            <thead>
              <tr>
                <th style="color: black; " class="service">ITEM</th>
                <th style="color: black; " class="desc">PRODUCTO</th>
                <th style="color: black; ">CANTIDAD</th>
                <th style="color: black; ">PRECIO</th>
                <th style="color: black; ">DESCUENTO</th>
                <th style="color: black; ">TOTAL</th>
              </tr>
            </thead>
            <tbody>';

  $sqldetalle = 'SELECT
                  detalle_compra.id_compra,
                  producto.nombre_producto,
                  tipo_producto.tipo_producto,
                  detalle_compra.cantidad,
                  detalle_compra.precio,
                  detalle_compra.descuento,
                  detalle_compra.total 
                  FROM
                      detalle_compra
                      INNER JOIN producto ON detalle_compra.id_producto = producto.id_producto
                      INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto 
                  WHERE
                  detalle_compra.id_compra = "' . $_GET["id"] . '"';

  $contador = 0;

  // aqui estoy pidiendo la conexion y la consulta envio
  $resultmedi = $mysqli->query($sqldetalle);

  while ($rowmedi = $resultmedi->fetch_assoc()) {

    $contador++;
    $html .= '<tr>
                <td class="service">' . $contador . '</td>
                <td class="desc"> ' . $rowmedi['nombre_producto'] . ' - ' . $rowmedi['tipo_producto'] . ' </td>
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
