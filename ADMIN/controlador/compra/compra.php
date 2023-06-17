<?php
require '../../modelo/modelo_compra.php';
$MC = new modelo_compra();

////////////// producto
if ($_POST["funcion"] === "listar_proveedor_combo") {
    $data = $MC->listar_proveedor_combo();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_producto_seelct") {
    $data = $MC->listar_producto_seelct();
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
if ($_POST["funcion"] === "registrar_compra_producto") {
    $proveedor = htmlspecialchars($_POST["proveedor"], ENT_QUOTES, 'UTF-8');
    $numero_compra = htmlspecialchars($_POST["numero_compra"], ENT_QUOTES, 'UTF-8');
    $comprobante_tipo = htmlspecialchars($_POST["comprobante_tipo"], ENT_QUOTES, 'UTF-8');
    $impuesto = htmlspecialchars($_POST["impuesto"], ENT_QUOTES, 'UTF-8');
    $fecha_compra = htmlspecialchars($_POST["fecha_compra"], ENT_QUOTES, 'UTF-8');
    $txt_totalneto = htmlspecialchars($_POST["txt_totalneto"], ENT_QUOTES, 'UTF-8');
    $txt_impuesto = htmlspecialchars($_POST["txt_impuesto"], ENT_QUOTES, 'UTF-8');
    $txt_a_pagar = htmlspecialchars($_POST["txt_a_pagar"], ENT_QUOTES, 'UTF-8');
    $count = htmlspecialchars($_POST["count"], ENT_QUOTES, 'UTF-8');

    $consulta = $MC->crear_nueva_compra($proveedor, $numero_compra, $comprobante_tipo, $impuesto, $fecha_compra, $txt_totalneto, $txt_impuesto, $txt_a_pagar, $count);
    echo $consulta;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "registrar_detalle_compra") {

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
        $consulta = $MC->registrar_detalle_compra(
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
if ($_POST["funcion"] === "listar_compras") {
    $data = $MC->listar_compras();
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
if ($_POST["funcion"] === "cargar_detalle_compra") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MC->cargar_detalle_compra($id);
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////
if ($_POST["funcion"] === "anular_compra") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MC->anular_compra($id);
    echo $consulta;
    exit();
}
