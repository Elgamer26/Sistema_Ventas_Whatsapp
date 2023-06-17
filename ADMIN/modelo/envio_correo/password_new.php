<?php
require 'envio_correo.php';
$ME_CO = new envio_correo();

//cambiar por la direccion del hosting
$location = "http://instechsystema.i-sistener.xyz/TIENDA/index.php";
$password = $_POST["response"];
$correo = $_POST["correo"];

$html = "";
$html = '<!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

    <table style="border: 1px solid black; width: 100%; height: 258px;">
    <thead>
    <tr style="height: 73px;">
    <td style="text-align: center; background: red; color: white; height: 73px;" colspan="2">
    <h1><strong>.:Cambio de password:.</strong></h1>
    </td>
    </tr>
    <tr style="height: 188px;">
    <td style="height: 134px; text-align: center;" width="20%">Estimando cliente su password fue actualizado, use este nuevo password: <b>"' . $password . '"</b> para ingresar al sistema, usted puede cambiar la contraseña de su cuenta en cualquier momento, gracias por confiar en nosotros :)</td>
    </tr>
    <tr style="height: 188px;">
    <td style="height: 51px; text-align: center;" width="20%"><a href=' . $location . '>Link de nuestro sistema.</a></td>
    </tr>
    </thead>
    </table>

    </body>
    </html>';

$sms = "Cambio de password";
$resultado = $ME_CO->enviar_correo($correo, $html, $sms);
echo $resultado;
exit();
