<?php
require '../../modelo/modelo_promocion.php';
$MO = new modelo_promocion();

////////////// producto
if ($_POST["funcion"] === "listar_productos_combo") {
    $data = $MO->listar_productos_combo();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registra_oofertaa") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $fecha_inicio = htmlspecialchars($_POST["fecha_inicio"], ENT_QUOTES, 'UTF-8');
    $fecha_fin = htmlspecialchars($_POST["fecha_fin"], ENT_QUOTES, 'UTF-8');
    $tipo_promo = htmlspecialchars($_POST["tipo_promo"], ENT_QUOTES, 'UTF-8');
    $descuento = htmlspecialchars($_POST["descuento"], ENT_QUOTES, 'UTF-8');
    $consulta = $MO->registra_oofertaa($id, $fecha_inicio, $fecha_fin, $tipo_promo, $descuento);
    echo $consulta;
    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "paguinar_ofertas") {
    $data = $MO->paguinar_ofertas(); 
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "eliminar_oferta") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8'); 
    $consulta = $MO->eliminar_oferta($id);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_ofertss") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8'); 
    $consulta = $MO->editar_ofertss($id);
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_ofertaaaaa") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $fecha_inicio = htmlspecialchars($_POST["fecha_inicio"], ENT_QUOTES, 'UTF-8');
    $fecha_fin = htmlspecialchars($_POST["fecha_fin"], ENT_QUOTES, 'UTF-8');
    $tipo_promo = htmlspecialchars($_POST["tipo_promo"], ENT_QUOTES, 'UTF-8');
    $descuento = htmlspecialchars($_POST["descuento"], ENT_QUOTES, 'UTF-8');
    $consulta = $MO->editar_ofertaa($id, $fecha_inicio, $fecha_fin, $tipo_promo, $descuento);
    echo $consulta;
    exit();
}