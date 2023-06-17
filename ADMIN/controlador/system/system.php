<?php
require '../../modelo/modelo_system.php';
$MSY = new modelo_system();
session_start();

/////////////////////////////////////
if ($_POST["funcion"] === "traer_datos_de_empresa") {
    $consulta = $MSY->traer_datos_de_empresa();
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "cambiar_foto_perfilempresa") {

    $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');
    $ruta_actual = htmlspecialchars($_POST["ruta_actual"], ENT_QUOTES, 'UTF-8');

    //esto es para saber si el file trae datos
    if (is_array($_FILES) && count($_FILES) > 0) {
        if ($ruta_actual != "img/empresa/banano.jpg") {
            $delete = $ruta_actual;
            unlink("../../" . $delete);
        }
        if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/empresa/" . $nombrearchivo)) {
            $ruta = "img/empresa/$nombrearchivo";
            $consulta = $MSY->editar_foto_perfil_empresa($ruta);
            echo $consulta;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "cambiar_datos_empresa") {

    $nomber = htmlspecialchars($_POST['nomber'], ENT_QUOTES, 'UTF-8');
    $ruc = htmlspecialchars($_POST['ruc'], ENT_QUOTES, 'UTF-8');
    $direcc = htmlspecialchars($_POST['direcc'], ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
    $correo = htmlspecialchars($_POST['correo'], ENT_QUOTES, 'UTF-8');
    $dueño = htmlspecialchars($_POST['dueño'], ENT_QUOTES, 'UTF-8');
    $descrp = htmlspecialchars($_POST['descrp'], ENT_QUOTES, 'UTF-8');
    $iva = htmlspecialchars($_POST['iva'], ENT_QUOTES, 'UTF-8');

    $consulta = $MSY->editar_empresa($nomber, $ruc, $direcc, $telefono, $correo, $dueño, $descrp, $iva);
    echo $consulta;

    exit();
}

////////// datos cliente usuario
///////////////////////////////////// 
if ($_POST["funcion"] === "traer_datos_cliente") {
    $id =  $_SESSION["id_cli"];
    $consulta = $MSY->traer_datos_cliente($id);
    $datos = json_encode($consulta, JSON_UNESCAPED_UNICODE);
    if (count($consulta) > 0) {
        echo $datos;
    } else {
        echo 0;
    }
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "actuaizar_datos_ciente") {
    $id = $_SESSION["id_cli"];
    $nombress = htmlspecialchars($_POST["nombress"], ENT_QUOTES, 'UTF-8');
    $apellidoss = htmlspecialchars($_POST["apellidoss"], ENT_QUOTES, 'UTF-8');
    $numero_docu = htmlspecialchars($_POST["numero_docu"], ENT_QUOTES, 'UTF-8');
    $telefono_p = htmlspecialchars($_POST["telefono_p"], ENT_QUOTES, 'UTF-8');
    $correo_p = htmlspecialchars($_POST["correo_p"], ENT_QUOTES, 'UTF-8');
    $direccions = htmlspecialchars($_POST["direccions"], ENT_QUOTES, 'UTF-8');
    $sexo = htmlspecialchars($_POST["sexo"], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');

    $consulta = $MSY->actuaizar_datos_ciente($id, $nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $password);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "productos_mas_comprados") {

    $datos = $MSY->productos_mas_comprados();
    if (!empty($datos)) {
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    } else {
        echo 0;
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "servicios_mas_comprados") {

    $datos = $MSY->servicios_mas_comprados();
    if (!empty($datos)) {
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    } else {
        echo 0;
    }

    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "traer_datos_dasboard_admin") {
    $total_cliente = $MSY->traer_datos_dasboard_admin();
    echo json_encode($total_cliente, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "ventas_productos") {

    $fecha_inicio = htmlspecialchars($_POST["fecha_inicio"], ENT_QUOTES, 'UTF-8');
    $fecha_fin = htmlspecialchars($_POST["fecha_fin"], ENT_QUOTES, 'UTF-8');

    $datos = $MSY->ventas_productos($fecha_inicio, $fecha_fin);
    if (!empty($datos)) {
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    } else {
        echo 0;
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "ventas_servicio") {

    $fecha_inicio = htmlspecialchars($_POST["fecha_inicio"], ENT_QUOTES, 'UTF-8');
    $fecha_fin = htmlspecialchars($_POST["fecha_fin"], ENT_QUOTES, 'UTF-8');

    $datos = $MSY->ventas_servicio($fecha_inicio, $fecha_fin);
    if (!empty($datos)) {
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    } else {
        echo 0;
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "ventas_online") {

    $fecha_inicio = htmlspecialchars($_POST["fecha_inicio"], ENT_QUOTES, 'UTF-8');
    $fecha_fin = htmlspecialchars($_POST["fecha_fin"], ENT_QUOTES, 'UTF-8');

    $datos = $MSY->ventas_online($fecha_inicio, $fecha_fin);
    if (!empty($datos)) {
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    } else {
        echo 0;
    }

    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "verificar_ofertas") {
    $resutado = $MSY->eliminar_ofertas_pasadas();
    echo $resutado;
    exit();
}

///////////////// cambiar foto 1
///////////////////////////////////// 
if ($_POST["funcion"] === "cambiat_foto_1") {

    $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');
    $ruta_actual = htmlspecialchars($_POST["ruta_actual"], ENT_QUOTES, 'UTF-8');

    //esto es para saber si el file trae datos
    if (is_array($_FILES) && count($_FILES) > 0) {
        if ($ruta_actual != "img/web/web.jpg") {
            $delete = $ruta_actual;
            unlink("../../" . $delete);
        }

        if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/web/" . $nombrearchivo)) {
            $ruta = "img/web/$nombrearchivo";
            $consulta = $MSY->editar_foto_web_1($ruta);
            echo $consulta;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }

exit();
}

if ($_POST["funcion"] === "cambiat_foto_2") {

    $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');
    $ruta_actual = htmlspecialchars($_POST["ruta_actual"], ENT_QUOTES, 'UTF-8');

    //esto es para saber si el file trae datos
    if (is_array($_FILES) && count($_FILES) > 0) {
        if ($ruta_actual != "img/web/web.jpg") {
            $delete = $ruta_actual;
            unlink("../../" . $delete);
        }
        
        if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/web/" . $nombrearchivo)) {
            $ruta = "img/web/$nombrearchivo";
            $consulta = $MSY->editar_foto_web_2($ruta);
            echo $consulta;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }

exit();
}

if ($_POST["funcion"] === "cambiat_foto_3") {

    $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');
    $ruta_actual = htmlspecialchars($_POST["ruta_actual"], ENT_QUOTES, 'UTF-8');

    //esto es para saber si el file trae datos
    if (is_array($_FILES) && count($_FILES) > 0) {
        if ($ruta_actual != "img/web/web.jpg") {
            $delete = $ruta_actual;
            unlink("../../" . $delete);
        }
        
        if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/web/" . $nombrearchivo)) {
            $ruta = "img/web/$nombrearchivo";
            $consulta = $MSY->editar_foto_web_3($ruta);
            echo $consulta;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }

exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "traer_datos_web") {
    $consulta = $MSY->traer_datos_web();
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_detalle_foto") {

    $detalle1 = htmlspecialchars($_POST['detalle1'], ENT_QUOTES, 'UTF-8');
    $detalle2 = htmlspecialchars($_POST['detalle2'], ENT_QUOTES, 'UTF-8');
    $detalle3 = htmlspecialchars($_POST['detalle3'], ENT_QUOTES, 'UTF-8'); 

    $consulta = $MSY->editar_detalle_foto($detalle1, $detalle2, $detalle3);
    echo $consulta;

    exit();
}