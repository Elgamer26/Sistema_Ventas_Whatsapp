<?php
require '../../modelo/modelo_usuario.php';
$MU = new modelo_usuario();
session_start();

///////////////////////////////////// 
if ($_POST["funcion"] === "logeo") {
    $usu = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    $resutado = $MU->verifcar_usuario($usu, $pass);
    $data = json_encode($resutado, JSON_UNESCAPED_UNICODE);
    if (count($resutado) > 0) {
        echo $data;
    } else {
        echo 0;
    }
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "session") {
    $id_usu = $_POST["id_usu"];
    $id_rol = $_POST["rol"];

    $_SESSION["id_usu"] = $id_usu;
    $_SESSION["id_rol"] = $id_rol;
    echo 1;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "traer_usuario_perfil") {

    $id =  $_SESSION["id_usu"];
    $consulta = $MU->traer_usuario_perfil($id);
    $datos = json_encode($consulta, JSON_UNESCAPED_UNICODE);
    if (count($consulta) > 0) {
        echo $datos;
    } else {
        echo 0;
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registrar_rol") {
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->crear_rol($nombre);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_rol") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->editar_rol($nombre, $id);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_roles") {

    $data = $MU->listar_roles();
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
if ($_POST["funcion"] === "estado_rol") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->estado_rol($id, $dato);
    echo $consulta;
    exit();
}


///////////////////////////
///////////////////usuarios
if ($_POST["funcion"] === "listar_rl_usu") {
    $data = $MU->listar_tipo_rol_seelct();
    //jason encode para retornar los datos
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registra_usuario") {

    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    $apellidos = htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8');
    $tipo_rol_usu = htmlspecialchars($_POST['tipo_rol_usu'], ENT_QUOTES, 'UTF-8');
    $numero_docu = htmlspecialchars($_POST['numero_docu'], ENT_QUOTES, 'UTF-8');

    $nombrearchivo = htmlspecialchars($_POST['nombrearchivo'], ENT_QUOTES, 'UTF-8');
    //esto es para saber si el file trae datos

    if (is_array($_FILES) && count($_FILES) > 0) {
        $ruta = "img/usuarios/$nombrearchivo";
        $consulta = $MU->registra_usuario($nombre, $usuario, $password, $apellidos, $tipo_rol_usu, $numero_docu, $ruta);
        if ($consulta == 1) {
            if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/usuarios/" . $nombrearchivo)) {
                echo $consulta;
            } else {
                echo 0;
            }
        } else {
            echo $consulta;
        }
    } else {
        $ruta = "img/usuarios/user.jpg";
        $consulta = $MU->registra_usuario($nombre, $usuario, $password, $apellidos, $tipo_rol_usu, $numero_docu, $ruta);
        echo $consulta;
    }

    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "crear_permisos_usuario") {

    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $usuario = htmlspecialchars($_POST["usuario"], ENT_QUOTES, 'UTF-8');
    $clientes = htmlspecialchars($_POST["clientes"], ENT_QUOTES, 'UTF-8');
    $proveedor = htmlspecialchars($_POST["proveedor"], ENT_QUOTES, 'UTF-8');
    $datos_empresa = htmlspecialchars($_POST["datos_empresa"], ENT_QUOTES, 'UTF-8');
    $banco = htmlspecialchars($_POST["banco"], ENT_QUOTES, 'UTF-8');
    $tipo_servicio = htmlspecialchars($_POST["tipo_servicio"], ENT_QUOTES, 'UTF-8');
    $productos = htmlspecialchars($_POST["productos"], ENT_QUOTES, 'UTF-8');
    $compras = htmlspecialchars($_POST["compras"], ENT_QUOTES, 'UTF-8');
    $facturacion = htmlspecialchars($_POST["facturacion"], ENT_QUOTES, 'UTF-8');
    $calificacion = htmlspecialchars($_POST["calificacion"], ENT_QUOTES, 'UTF-8');
    $ventas_online = htmlspecialchars($_POST["ventas_online"], ENT_QUOTES, 'UTF-8');
    $tipos_pagos = htmlspecialchars($_POST["tipos_pagos"], ENT_QUOTES, 'UTF-8');
    $envios = htmlspecialchars($_POST["envios"], ENT_QUOTES, 'UTF-8');
    $registro_promo = htmlspecialchars($_POST["registro_promo"], ENT_QUOTES, 'UTF-8');
    $promo_vigente = htmlspecialchars($_POST["promo_vigente"], ENT_QUOTES, 'UTF-8');
    $reportes = htmlspecialchars($_POST["reportes"], ENT_QUOTES, 'UTF-8');

    $consulta = $MU->crear_permisos_usuario(
        $id,
        $usuario,
        $clientes,
        $proveedor,
        $datos_empresa,
        $banco,
        $tipo_servicio,
        $productos,
        $compras,
        $facturacion,
        $calificacion,
        $ventas_online,
        $tipos_pagos,
        $envios,
        $registro_promo,
        $promo_vigente,
        $reportes
    );

    echo $consulta;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "editar_permisos_usuario") {

    $id_permiso = htmlspecialchars($_POST["id_permiso"], ENT_QUOTES, 'UTF-8');
    $id_usu = htmlspecialchars($_POST["id_usu"], ENT_QUOTES, 'UTF-8');
    $usuario = htmlspecialchars($_POST["usuario"], ENT_QUOTES, 'UTF-8');
    $clientes = htmlspecialchars($_POST["clientes"], ENT_QUOTES, 'UTF-8');
    $proveedor = htmlspecialchars($_POST["proveedor"], ENT_QUOTES, 'UTF-8');
    $datos_empresa = htmlspecialchars($_POST["datos_empresa"], ENT_QUOTES, 'UTF-8');
    $banco = htmlspecialchars($_POST["banco"], ENT_QUOTES, 'UTF-8');
    $tipo_servicio = htmlspecialchars($_POST["tipo_servicio"], ENT_QUOTES, 'UTF-8');
    $productos = htmlspecialchars($_POST["productos"], ENT_QUOTES, 'UTF-8');
    $compras = htmlspecialchars($_POST["compras"], ENT_QUOTES, 'UTF-8');
    $facturacion = htmlspecialchars($_POST["facturacion"], ENT_QUOTES, 'UTF-8');
    $calificacion = htmlspecialchars($_POST["calificacion"], ENT_QUOTES, 'UTF-8');
    $ventas_online = htmlspecialchars($_POST["ventas_online"], ENT_QUOTES, 'UTF-8');
    $tipos_pagos = htmlspecialchars($_POST["tipos_pagos"], ENT_QUOTES, 'UTF-8');
    $envios = htmlspecialchars($_POST["envios"], ENT_QUOTES, 'UTF-8');
    $registro_promo = htmlspecialchars($_POST["registro_promo"], ENT_QUOTES, 'UTF-8');
    $promo_vigente = htmlspecialchars($_POST["promo_vigente"], ENT_QUOTES, 'UTF-8');
    $reportes = htmlspecialchars($_POST["reportes"], ENT_QUOTES, 'UTF-8');

    $consulta = $MU->editar_permisos_usuario(
        $id_permiso,
        $id_usu,
        $usuario,
        $clientes,
        $proveedor,
        $datos_empresa,
        $banco,
        $tipo_servicio,
        $productos,
        $compras,
        $facturacion,
        $calificacion,
        $ventas_online,
        $tipos_pagos,
        $envios,
        $registro_promo,
        $promo_vigente,
        $reportes
    );

    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_usuarios") {
    $data = $MU->listra_usuario();
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
if ($_POST["funcion"] === "estado_usuario") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->estado_usuario($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_usuario") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $usuario = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $apellidos = htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8');
    $tipo_rol_usu = htmlspecialchars($_POST['tipo_rol_usu'], ENT_QUOTES, 'UTF-8');
    $numero_docu = htmlspecialchars($_POST['numero_docu'], ENT_QUOTES, 'UTF-8');

    $consulta = $MU->editar_usuario($id, $nombre, $usuario, $apellidos, $tipo_rol_usu, $numero_docu);
    echo $consulta;
    exit();
}

if ($_POST["funcion"] === "editar_password_usuario") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $nueva = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->editar_password($id, $nueva);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_banco") {
    $data = $MU->listar_banco();
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
if ($_POST["funcion"] === "registrar_banco") {
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->registrar_banco($nombre);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "estado_banco") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->estado_banco($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_banco") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->editar_banco($nombre, $id);
    echo $consulta;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "obtener_permisos") {

    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->obtener_permisos($id);
    $datos = json_encode($consulta, JSON_UNESCAPED_UNICODE);
    if (count($consulta) > 0) {
        echo $datos;
    } else {
        echo 0;
    }

    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "obtener_permisos_usuario_logeado") {

    $id =  $_SESSION["id_usu"];
    $consulta = $MU->obtener_pemisos($id);
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);

    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "editar_foto_usuarioo") {

    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');
    $ruta_actual = htmlspecialchars($_POST["ruta_actual"], ENT_QUOTES, 'UTF-8');

    //esto es para saber si el file trae datos
    if (is_array($_FILES) && count($_FILES) > 0) {
        if ($ruta_actual != "img/usuarios/user.jpg") {
            $delete = $ruta_actual;
            unlink("../../" . $delete);
        }
        if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/usuarios/" . $nombrearchivo)) {
            $ruta = "img/usuarios/$nombrearchivo";
            $consulta = $MU->editar_foto_usuarioo($id, $ruta);
            echo $consulta;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }

exit();
}
