<?php
require '../../modelo/model_cliente.php';
require '../../modelo/envio_correo/envio_correo.php';
$MC = new model_cliente();
$ME_CO = new envio_correo();
session_start();

/////////////////////////////////////
if ($_POST["funcion"] === "registrar_clientes") {
    $nombress = htmlspecialchars($_POST["nombress"], ENT_QUOTES, 'UTF-8');
    $apellidoss = htmlspecialchars($_POST["apellidoss"], ENT_QUOTES, 'UTF-8');
    $numero_docu = htmlspecialchars($_POST["numero_docu"], ENT_QUOTES, 'UTF-8');
    $telefono_p = htmlspecialchars($_POST["telefono_p"], ENT_QUOTES, 'UTF-8');
    $correo_p = htmlspecialchars($_POST["correo_p"], ENT_QUOTES, 'UTF-8');
    $direccions = htmlspecialchars($_POST["direccions"], ENT_QUOTES, 'UTF-8');
    $sexo = htmlspecialchars($_POST["sexo"], ENT_QUOTES, 'UTF-8');
    $web = 0;

    ///////
    $length = 10;
    $key = "";
    $pattern = "*.1234567890abcdefghijklmnopqrstuvwxyz";
    $max = strlen($pattern) - 1;
    for ($i = 0; $i < $length; $i++) {
        $key .= substr($pattern, mt_rand(0, $max), 1);
    }

    $consulta = $MC->registrar_clientes($nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $key, $web);

    if ($consulta == "1") {

        $location = "http://instechsystema.i-sistener.xyz/TIENDA/index.php";
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
            <h1><strong>.:Password de cliente:.</strong></h1>
            </td>
            </tr>
            <tr style="height: 188px;">
            <td style="height: 134px; text-align: center;" width="20%">Estimando cliente su password fue creado con exito, use este password: <b>"' . $key . '"</b> para ingresar al sistema, gracias por confiar en nosotros :)</td>
            </tr>
            <tr style="height: 188px;">
            <td style="height: 51px; text-align: center;" width="20%"><a href=' . $location . '>Link de nuestro sistema.</a></td>
            </tr>
            </thead>
            </table>
        
            </body>
            </html>';

        $sms = "Password de cliente";
        $ME_CO->enviar_correo($correo_p, $html, $sms);
    }

    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registrar_clientes_carrito") {
    $nombress = htmlspecialchars($_POST["nombress"], ENT_QUOTES, 'UTF-8');
    $apellidoss = htmlspecialchars($_POST["apellidoss"], ENT_QUOTES, 'UTF-8');
    $numero_docu = htmlspecialchars($_POST["numero_docu"], ENT_QUOTES, 'UTF-8');
    $telefono_p = htmlspecialchars($_POST["telefono_p"], ENT_QUOTES, 'UTF-8');
    $correo_p = htmlspecialchars($_POST["correo_p"], ENT_QUOTES, 'UTF-8');
    $direccions = htmlspecialchars($_POST["direccions"], ENT_QUOTES, 'UTF-8');
    $sexo = htmlspecialchars($_POST["sexo"], ENT_QUOTES, 'UTF-8');
    $key = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
    $web = 1;

    ///////
    $consulta = $MC->registrar_clientes($nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $key, $web);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_clientes") {
    $data = $MC->listar_clientes();
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
if ($_POST["funcion"] === "listar_clientes_web") {
    $data = $MC->listar_clientes_web();
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
if ($_POST["funcion"] === "estado_cliente") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');

    $consulta = $MC->estado_cliente($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editando_cliente_clientes") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombress = htmlspecialchars($_POST["nombress"], ENT_QUOTES, 'UTF-8');
    $apellidoss = htmlspecialchars($_POST["apellidoss"], ENT_QUOTES, 'UTF-8');
    $numero_docu = htmlspecialchars($_POST["numero_docu"], ENT_QUOTES, 'UTF-8');
    $telefono_p = htmlspecialchars($_POST["telefono_p"], ENT_QUOTES, 'UTF-8');
    $correo_p = htmlspecialchars($_POST["correo_p"], ENT_QUOTES, 'UTF-8');
    $direccions = htmlspecialchars($_POST["direccions"], ENT_QUOTES, 'UTF-8');
    $sexo = htmlspecialchars($_POST["sexo"], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');

    $consulta = $MC->editando_cliente_clientes($id, $nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $password);
    echo $consulta;
    exit();
}
