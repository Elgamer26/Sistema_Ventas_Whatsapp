<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Enviarcorreo/PHPMailer/Exception.php';
require 'Enviarcorreo/PHPMailer/PHPMailer.php';
require 'Enviarcorreo/PHPMailer/SMTP.php';

require_once "../conect/conect_r.php";
$codpromocion = $_POST["id"];

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
                            cliente.estado
                            FROM
                            cliente WHERE cliente.estado = 1");
while ($dat = $datos->fetch_object()) {
    try {
        $mail = new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username = 'jorgemoisesramirez201422@gmail.com';
        $mail->Password = 'wjccepzidsqimbso';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom($dat->correo, 'InseTech');
        $mail->addAddress($dat->correo, 'InseTech');
        // Content
        $mail->isHTML(true);
        $mail->Subject = "NUEVA OFERTA";
        $mail->Body    = 'ESTIMADO(A) <strong>' . $dat->apellidos . ' ' . $dat->nombres . '</strong>, TENEMOS UNA NUEVA PROMOCION ESPECIALMENTE PARA TI HASTA <strong>' . $termina . '</strong>, NOMBRE DE LA OFERTA <b>' . $nombre_oferta . '</b>, EL TIPO DE OFERTA ES: <b>' . $tipo_oferta . '</b>, INGRESA A NUESTRA PAGINA WEB <a href="http://instechsystema.i-sistener.xyz/TIENDA/index.php#"> Link de nuestro sistema</a> <br><br><img alt="Promocion" src="http://instechsystema.i-sistener.xyz/ADMIN/' . $fotos . '" style="width: 400px;height: 250px">';

        $mail->send();
    } catch (Exception $e) {
        return "Mensaje de error: {$mail->ErrorInfo}";
    }
}
