<?php

require_once "../conect/conect_r.php";
require "envio.php";
$ENV = new whatsapp();

$codpromocion = $_POST["id"];
$sms = "";
$imagen = "";
$telefono = "";
$postal = "";

$consulta = $mysqli->query("SELECT
    ofertas.id_ofertas, 
    producto.nombre_producto, 
    ofertas.fecha_fin, 
    ofertas.tipo_oferta, 
    ofertas.descuento, 
    producto.foto
    FROM
    producto
    INNER JOIN
    ofertas
    ON 
    producto.id_producto = ofertas.id_producto WHERE ofertas.id_ofertas='$codpromocion'");

while ($reg = $consulta->fetch_object()) {
    $termina = $reg->fecha_fin;
    $nombre_oferta = $reg->nombre_producto;
    $tipo_oferta = $reg->tipo_oferta;

    if ($reg->foto === "" || $reg->foto === null) {
        $fotos = 'img/producto/foto.jpg';
    } else {
        $fotos = $reg->foto;
    }
}

$datos = $mysqli->query("SELECT
                            cliente.id_cliente, 
                            cliente.nombres, 
                            cliente.apellidos, 
                            cliente.correo, 
                            cliente.estado,
                            cliente.telefono
                            FROM
                            cliente WHERE cliente.estado = 1");

$sms = [];
while ($dat = $datos->fetch_object()) {
    try {
        if (mb_strlen($dat->telefono) == 10) {
            $telefono = substr($dat->telefono, 1);
            $postal = "593" . $telefono;

            // $sms = 'ESTIMADO(A) ' . $dat->apellidos . ' ' . $dat->nombres . ', TENEMOS UNA NUEVA PROMOCION ESPECIALMENTE PARA TI HASTA ' . $termina . ', NOMBRE DE LA OFERTA ' . $nombre_oferta . ', EL TIPO DE OFERTA ES: ' . $tipo_oferta . ', INGRESA A NUESTRA PAGINA WEB http://instechsystema.i-sistener.xyz/TIENDA/index.php Link de nuestro sistema';
            // $imagen = 'http://instechsystema.i-sistener.xyz/ADMIN/' . $fotos . '';

            $sms[] = ["numero" => $postal, "mensaje" => "INSETECH LE RECUERDA: ESTIMADO(A) CLIENTE(A): $dat->nombres $dat->apellidos, TENEMOS UNA OFERTA ESPECIALMENTE PARA TI, HASTA EL: $termina, NOMBRE DE LA OFERTA: $nombre_oferta, EL TIPO DE OFERTA ES: $tipo_oferta, INGRESE A NUESTRA PAGINA WEB http://instechsystema.i-sistener.xyz/TIENDA/index.php PARA VER MAS DETALLE DE LA OFERTA, GRACIAS POR CONFIAR EN NOSOTROS"];   
            $sms[] = ["numero" => $postal, "url" => "http://instechsystema.i-sistener.xyz/ADMIN/" . $fotos . ""];            

        }
    } catch (Exception $e) {
        echo "Mensaje de error: {$ex}";
    }
}
$ENV->enviar_mensaje($sms);

// print_r($sms);

// $op = [
//     array("numero" => "593985906677", "mensaje" => "prueba"),
//     array("numero" => "593985906677", "url" => "http://instechsystema.i-sistener.xyz/ADMIN/img/prouducto/foto.jpg"),
// ];

// print_r($op);
