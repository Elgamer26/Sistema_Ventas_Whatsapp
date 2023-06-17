<?php
require 'envio_correo.php';
$ME_CO = new envio_correo();

///////////////////
$correo = "";
$id = $_POST["id"];
$tipo_compro = "";
//aqui llamo la nueva conexion
require_once "../conect/conect_r.php";

$consulta = 'SELECT
venta_servicio.id_venta_servico,
CONCAT_WS(" ", cliente.nombres, cliente.apellidos) AS cliente,
cliente.cedula,
cliente.correo,
venta_servicio.numero_compra,
venta_servicio.tipo_doc,
venta_servicio.iva,
venta_servicio.fecha,
venta_servicio.sub_total,
venta_servicio.sub_iva,
venta_servicio.total,
venta_servicio.cantidad 
FROM
venta_servicio
INNER JOIN cliente ON venta_servicio.id_cliente = cliente.id_cliente 
WHERE
venta_servicio.id_venta_servico = "' . $id . '" ';

$result = $mysqli->query($consulta);
$fecha = date("Y-m-d");
while ($row = $result->fetch_assoc()) {

  $correo = $row['correo'];

  if($row['tipo_doc'] == 'Boleta'){
    $tipo_compro = "Nota de venta";
  }else{
    $tipo_compro = $row['tipo_doc'];
  }

  $html = '
    <div style="text-align:center;"><h1><u>' . $tipo_compro . ' de servicio</u></h1></div><br>
    <div style="float:left; width:auto;">
    <span><b>Fecha:</b>  ' . $fecha . '   </span>
    </div>   
    <br> 
    <div style="float:left; width:auto;">
    <span><b>Nombre y apellidos:</b>  ' . $row['cliente'] . ' </span>
    </div>
    <br>
    <div style="float:left; width:auto">
    <span><b>Cedula:</b> ' . $row['cedula'] . '  </span>
    </div>
    <br>
    <div style="float:left; width:auto">
    <span><b>Correo:</b> ' . $row['correo'] . '  </span>
    </div>
    <br>
    <div style="float:left; width:auto">
    <span><b>Numero venta:</b> ' . $row['numero_compra'] . '  </span>
    </div>
    <br> 
    <div style="float:left; width:auto">
    <span><b>Tipo documento:</b> ' . $tipo_compro . '  </span>
    </div>
    <br>';

  $html .= '<div style="width:700px; text-align:center;">
                    <h2><u>Detalle de servicio</u></h2>
            </div>

        <table style="width:100%; border-collapse:collapse;" border="1">
            <thead>
                <tr bgcolor="orange">
                    <th>#</th>
                    <th>Servicio</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Total</th>
                </tr>
            </thead>';

  $consult_ingreso = 'SELECT
            detalle_venta_servicio.id_venta_servicio, 
            servicio.servicio, 
            detalle_venta_servicio.cantidad, 
            detalle_venta_servicio.precio, 
            detalle_venta_servicio.descuento, 
            detalle_venta_servicio.total
            FROM
            detalle_venta_servicio
            INNER JOIN
            servicio
            ON 
            detalle_venta_servicio.id_servicio = servicio.id_servicio 
            WHERE
            detalle_venta_servicio.id_venta_servicio = "' . $id . '" ';

  $cont_ingreso = 0;

  //aqui estoy pidiendo la conexion y la consulta envio
  $resul_ingreso = $mysqli->query($consult_ingreso);
  while ($row_i = $resul_ingreso->fetch_assoc()) {

    $cont_ingreso++;
    $html .= ' <tr>
               <td style="text-align:center;">' . $cont_ingreso . '</td>
               <td style="text-align:center;">' . $row_i['servicio'] . '</td>
               <td style="text-align:center;">' . $row_i['precio'] . '</td>
               <td style="text-align:center;">' . $row_i['cantidad'] . '</td>
               <td style="text-align:center;">' . $row_i['descuento'] . '</td>
               <td style="text-align:center;">' . $row_i['total'] . '</td> ';
  }

  $html .= '</tr>
    <tbody>
    </tbody>
    </table><br>
    <br>
    <div style="float:left; width:auto;">
    <span><b>Subtotal:</b>$. ' .  $row['sub_total'] . ' </span>
    </div>
    <br>
    <div style="float:left; width:auto;">
    <span><b>Impuesto:</b>$. ' .  $row['sub_iva'] . ' </span>
    </div>
    <br>
    <div style="float:left; width:auto;">
    <span><b>Total:</b>$. ' .  $row['total'] . ' </span>
    </div>';

}

$sms = "$tipo_compro de servicio";

$resultado = $ME_CO->enviar_correo($correo, $html, $sms);
echo $resultado;

exit();