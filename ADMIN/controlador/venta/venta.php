<?php
require '../../modelo/modelo_venta.php';
$MV = new modelo_venta();

//////////////  
if ($_POST["funcion"] === "listar_cliente_combo") {
    $data = $MV->listar_cliente_combo();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

//////////////  
if ($_POST["funcion"] === "listar_servicio_combo") {
    $data = $MV->listar_servicio_combo();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

//////////////  
if ($_POST["funcion"] === "traer_precio_servicio") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $data = $MV->traer_precio_servicio($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registrar_servicio_venta") {

    $cliente = htmlspecialchars($_POST["cliente"], ENT_QUOTES, 'UTF-8');
    $numero_compra = htmlspecialchars($_POST["numero_compra"], ENT_QUOTES, 'UTF-8');
    $comprobante_tipo = htmlspecialchars($_POST["comprobante_tipo"], ENT_QUOTES, 'UTF-8');
    $impuesto = htmlspecialchars($_POST["impuesto"], ENT_QUOTES, 'UTF-8');
    $fecha_compra = htmlspecialchars($_POST["fecha_compra"], ENT_QUOTES, 'UTF-8');
    $txt_totalneto = htmlspecialchars($_POST["txt_totalneto"], ENT_QUOTES, 'UTF-8');
    $txt_impuesto = htmlspecialchars($_POST["txt_impuesto"], ENT_QUOTES, 'UTF-8');
    $txt_a_pagar = htmlspecialchars($_POST["txt_a_pagar"], ENT_QUOTES, 'UTF-8');
    $count = htmlspecialchars($_POST["count"], ENT_QUOTES, 'UTF-8');

    $consulta = $MV->registrar_servicio_venta($cliente, $numero_compra, $comprobante_tipo, $impuesto, $fecha_compra, $txt_totalneto, $txt_impuesto, $txt_a_pagar, $count);
    echo $consulta;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "registrar_detalle_venta_servicio") {

    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $idpm = htmlspecialchars($_POST['idpm'], ENT_QUOTES, 'UTF-8');
    $cantidad = htmlspecialchars($_POST['cantidad'], ENT_QUOTES, 'UTF-8');
    $precio = htmlspecialchars($_POST['precio'], ENT_QUOTES, 'UTF-8');
    $des = htmlspecialchars($_POST['des'], ENT_QUOTES, 'UTF-8');
    $sutotal = htmlspecialchars($_POST['sutotal'], ENT_QUOTES, 'UTF-8');

    $arraglo_idpm = explode(",", $idpm); //aqui separo los datos
    $arraglo_cantidad = explode(",", $cantidad); //aqui separo los datos
    $arraglo_precio = explode(",", $precio); //aqui separo los datos
    $arraglo_des  = explode(",", $des); //aqui separo los datos
    $arraglo_sutotal = explode(",", $sutotal); //aqui separo los datos  

    //bucle para contar la cantidad de datos
    for ($i = 0; $i < count($arraglo_idpm); $i++) {
        $consulta = $MV->registrar_detalle_venta_servicio(
            $id,
            $arraglo_idpm[$i],
            $arraglo_cantidad[$i],
            $arraglo_precio[$i],
            $arraglo_des[$i],
            $arraglo_sutotal[$i]
        );
    }
    echo $consulta;

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_venta_servicios") {
    $data = $MV->listar_venta_servicios();
    if ($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
    }

    exit();
}

/////////////////////////
if ($_POST["funcion"] === "anular_venta_servicio") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MV->anular_venta_servicio($id);
    echo $consulta;
    exit();
}

/////////////////////////
if ($_POST["funcion"] === "cargar_detalle_venta_servicios") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MV->cargar_detalle_venta_servicios($id);
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_producto_selecionar") {
    $data = $MV->listar_producto_selecionar();
    if ($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_producto_oferta_selecionar") {
    $data = $MV->listar_producto_oferta_selecionar();
    if ($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registrar_producto_venta") {

    $cliente = htmlspecialchars($_POST["cliente"], ENT_QUOTES, 'UTF-8');
    $numero_compra = htmlspecialchars($_POST["numero_compra"], ENT_QUOTES, 'UTF-8');
    $comprobante_tipo = htmlspecialchars($_POST["comprobante_tipo"], ENT_QUOTES, 'UTF-8');
    $impuesto = htmlspecialchars($_POST["impuesto"], ENT_QUOTES, 'UTF-8');
    $fecha_compra = htmlspecialchars($_POST["fecha_compra"], ENT_QUOTES, 'UTF-8');
    $txt_totalneto = htmlspecialchars($_POST["txt_totalneto"], ENT_QUOTES, 'UTF-8');
    $txt_impuesto = htmlspecialchars($_POST["txt_impuesto"], ENT_QUOTES, 'UTF-8');
    $txt_a_pagar = htmlspecialchars($_POST["txt_a_pagar"], ENT_QUOTES, 'UTF-8');
    $count = htmlspecialchars($_POST["count"], ENT_QUOTES, 'UTF-8');

    $consulta = $MV->registrar_producto_venta($cliente, $numero_compra, $comprobante_tipo, $impuesto, $fecha_compra, $txt_totalneto, $txt_impuesto, $txt_a_pagar, $count);
    echo $consulta;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "registrar_detalle_venta_producto_a") {

    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $idpm = htmlspecialchars($_POST['idpm'], ENT_QUOTES, 'UTF-8');
    $cantidad = htmlspecialchars($_POST['cantidad'], ENT_QUOTES, 'UTF-8');
    $sale = htmlspecialchars($_POST['sale'], ENT_QUOTES, 'UTF-8');
    $precio = htmlspecialchars($_POST['precio'], ENT_QUOTES, 'UTF-8');
    $oferta = htmlspecialchars($_POST['oferta'], ENT_QUOTES, 'UTF-8');
    $des_oferta = htmlspecialchars($_POST['des_oferta'], ENT_QUOTES, 'UTF-8');
    $descuento = htmlspecialchars($_POST['descuento'], ENT_QUOTES, 'UTF-8');
    $sutotal = htmlspecialchars($_POST['sutotal'], ENT_QUOTES, 'UTF-8');

    $arraglo_idpm = explode(",", $idpm); //aqui separo los datos
    $arraglo_cantidad = explode(",", $cantidad); //aqui separo los datos
    $arraglo_sale = explode(",", $sale); //aqui separo los datos
    $arraglo_precio = explode(",", $precio); //aqui separo los datos
    $arraglo_oferta = explode(",", $oferta); //aqui separo los datos
    $arraglo_des_oferta  = explode(",", $des_oferta); //aqui separo los datos
    $arraglo_descuento  = explode(",", $descuento); //aqui separo los datos
    $arraglo_sutotal = explode(",", $sutotal); //aqui separo los datos  

    //bucle para contar la cantidad de datos
    for ($i = 0; $i < count($arraglo_idpm); $i++) {
        $consulta = $MV->registrar_detalle_venta_producto_a(
            $id,
            $arraglo_idpm[$i],
            $arraglo_cantidad[$i],
            $arraglo_sale[$i],
            $arraglo_precio[$i],
            $arraglo_oferta[$i],
            $arraglo_des_oferta[$i],
            $arraglo_descuento[$i],
            $arraglo_sutotal[$i]
        );
    }
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_ventas_productos") {
    $data = $MV->listar_ventas_productos();
    if ($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
    }

    exit();
}

/////////////////////////
if ($_POST["funcion"] === "cargar_detalle_venta_producto") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MV->cargar_detalle_venta_producto($id);
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////
if ($_POST["funcion"] === "anular_venta_producto") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MV->anular_venta_producto($id);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_ventas_onlinee_productos") {
    $data = $MV->listar_ventas_onlinee_productos();
    if ($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
    }

    exit();
}

/////////////////////////
if ($_POST["funcion"] === "cargar_detalle_venta_onlinee_producto") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MV->cargar_detalle_venta_onlinee_producto($id);
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////
if ($_POST["funcion"] === "anular_venta_online_producto") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MV->anular_venta_online_producto($id);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "lista_transferencia_bancaria") {
    $data = $MV->lista_transferencia_bancaria();
    if ($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
    }

    exit();
}

/////////////////////////
if ($_POST["funcion"] === "procesar_venta_clinte") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MV->procesar_venta_clinte($id);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "lista_efetivo_clinte") {
    $data = $MV->lista_efetivo_clinte();
    if ($data) {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
    }

    exit();
}