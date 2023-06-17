<?php
require '../../modelo/modelo_repartidor.php';
$MRP = new modelo_repartidor();
session_start();

///////////////////////////////////// 
if ($_POST["funcion"] === "logeo") {
    $usu = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    $resutado = $MRP->verifcar_usuario($usu, $pass);
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
    $id_repa = $_POST["id_repa"];
    $nombre_re = $_POST["nombre_re"];

    $_SESSION["id_repa"] = $id_repa;
    $_SESSION["nombre_re"] = $nombre_re;
    echo 1;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "trear_datos") {
    $id =  $_SESSION["id_repa"];
    $consulta = $MRP->trear_datos($id);
    $datos = json_encode($consulta, JSON_UNESCAPED_UNICODE);
    if (count($consulta) > 0) {
        echo $datos;
    } else {
        echo 0;
    }
    exit();
}

if ($_POST["funcion"] === "editar_datos") {
    $id = $_SESSION["id_repa"];
    $nombress = htmlspecialchars($_POST["nombress"], ENT_QUOTES, 'UTF-8');
    $apellidoss = htmlspecialchars($_POST["apellidoss"], ENT_QUOTES, 'UTF-8');
    $numero_docu = htmlspecialchars($_POST["numero_docu"], ENT_QUOTES, 'UTF-8');
    $telefono_p = htmlspecialchars($_POST["telefono_p"], ENT_QUOTES, 'UTF-8');
    $correo_p = htmlspecialchars($_POST["correo_p"], ENT_QUOTES, 'UTF-8');
    $direccions = htmlspecialchars($_POST["direccions"], ENT_QUOTES, 'UTF-8');
    $sexo = htmlspecialchars($_POST["sexo"], ENT_QUOTES, 'UTF-8');
    $tipo_licencia = htmlspecialchars($_POST["tipo_licencia"], ENT_QUOTES, 'UTF-8');
    $usuario = htmlspecialchars($_POST["usuario"], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');

    $consulta = $MRP->editar_datos($id, $nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $tipo_licencia, $usuario, $password);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_envios_repartidor") {
    $id = $_SESSION["id_repa"];
    $data = $MRP->listar_envios_repartidor($id);
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

//////////////////
if ($_POST["funcion"] === "finalizar_entregas") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $consulta = $MRP->finalizar_entregas($id);
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_efectivo_espera") {
    $id = $_SESSION["id_repa"];
    $data = $MRP->listar_efectivo_espera($id);
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
if ($_POST["funcion"] === "subir_foto_efectivo") {

    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $id_clie = htmlspecialchars($_POST["id_clie"], ENT_QUOTES, 'UTF-8');
    $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');
    $detalle = htmlspecialchars($_POST["detalle"], ENT_QUOTES, 'UTF-8');

    //esto es para saber si el file trae datos
    if (is_array($_FILES) && count($_FILES) > 0) {

        $ruta = "img/efectivo/$nombrearchivo";
        $consulta = $MRP->subir_foto_efectivo($id, $id_clie, $ruta, $detalle);

        if ($consulta == "1") {
            if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/efectivo/" . $nombrearchivo)) {
                echo $consulta;
            } else {
                echo 0;
            }
        } else {
            echo $consulta;
        }
        
    } else {
        echo 0;
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "ver_efectivo_procesado") {
    $id = $_SESSION["id_repa"];
    $data = $MRP->ver_efectivo_procesado($id);
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
