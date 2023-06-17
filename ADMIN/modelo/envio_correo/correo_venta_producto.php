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
            venta.id_venta,
            CONCAT_WS(" ", cliente.nombres, cliente.apellidos ) AS cliente,
            cliente.cedula,
            cliente.correo,
            venta.fecha,
            venta.tipo_doc,
            venta.numero_compra,
            venta.iva,
            venta.sub_total,
            venta.sub_iva,
            venta.total,
            venta.cantidad 
            FROM
            venta
            INNER JOIN cliente ON venta.id_cliente = cliente.id_cliente 
            WHERE
            venta.id_venta = "' . $id . '" ';

$result = $mysqli->query($consulta);
$fecha = date("Y-m-d");
while ($row = $result->fetch_assoc()) {

    $correo = $row['correo'];

    if ($row['tipo_doc'] == 'Boleta') {
        $tipo_compro = "Nota de venta";
    } else {
        $tipo_compro = $row['tipo_doc'];
    }

    $html = '
    <div style="text-align:center;"><h1><u>' . $tipo_compro . ' de producto</u></h1></div><br>
    <div style="float:left; width:auto;">
    <span><b>Fecha envio:</b>  ' . $fecha . '   </span>
    </div>  
    <br> 
    <div style="float:left; width:auto;">
    <span><b>Fecha venta:</b>  ' . $row['fecha'] . ' </span>
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
                    <h2><u>Detalle de producto</u></h2>
            </div>

        <table style="width:100%; border-collapse:collapse;" border="1">
            <thead>
                <tr bgcolor="orange">
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Sale</th>
                    <th>Precio</th>
                    <th>Oferta</th>
                    <th>Desc. oferta</th>
                    <th>Desc. moneda</th>
                    <th>Subtotal</th>
                </tr>
            </thead>';

    $consult_ingreso = 'SELECT
                        detalle_vent_pro.id_detalle_venta_pro,
                        detalle_vent_pro.id_venta,
                        producto.nombre_producto,
                        detalle_vent_pro.cantidad,
                        detalle_vent_pro.sale,
                        detalle_vent_pro.precio,
                        detalle_vent_pro.tipo_oferta,
                        detalle_vent_pro.des_pferta,
                        detalle_vent_pro.descuento,
                        detalle_vent_pro.total 
                        FROM
                            detalle_vent_pro
                            INNER JOIN producto ON detalle_vent_pro.id_producto = producto.id_producto 
                        WHERE
                        detalle_vent_pro.id_venta = "' . $id . '" ';

    $cont_ingreso = 0;

    //aqui estoy pidiendo la conexion y la consulta envio
    $resul_ingreso = $mysqli->query($consult_ingreso);
    while ($row_i = $resul_ingreso->fetch_assoc()) {

        $cont_ingreso++;
        $html .= ' <tr>
               <td style="text-align:center;">' . $cont_ingreso . '</td>
               <td style="text-align:center;">' . $row_i['nombre_producto'] . '</td>
               <td style="text-align:center;">' . $row_i['cantidad'] . '</td>
               <td style="text-align:center;">' . $row_i['sale'] . '</td>
               <td style="text-align:center;">' . $row_i['precio'] . '</td>
               <td style="text-align:center;">' . $row_i['tipo_oferta'] . '</td>
               <td style="text-align:center;">' . $row_i['des_pferta'] . '</td>
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

$sms = "$tipo_compro de producto";

$resultado = $ME_CO->enviar_correo($correo, $html, $sms);
echo $resultado;

exit();
