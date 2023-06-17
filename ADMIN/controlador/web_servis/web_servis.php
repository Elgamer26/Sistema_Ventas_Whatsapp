<?php
require '../../modelo/modelo_web.php';
$MW = new modelo_web();

/////////////////////////////////////
if ($_POST["funcion"] === "listar_calificacion") {
    $data = $MW->listar_calificacion();
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
if ($_POST["funcion"] === "listar_calificacion_producto") {
    $data = $MW->listar_calificacion_producto();
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
if ($_POST["funcion"] === "traer_calidifcacion") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $data = $MW->traer_calidifcacion($id);
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
if ($_POST["funcion"] === "registrar_vehiculo") {
    $tipo = htmlspecialchars($_POST["tipo"], ENT_QUOTES, 'UTF-8');
    $marca = htmlspecialchars($_POST["marca"], ENT_QUOTES, 'UTF-8');
    $matricula = htmlspecialchars($_POST["matricula"], ENT_QUOTES, 'UTF-8');
    $numero_serie = htmlspecialchars($_POST["numero_serie"], ENT_QUOTES, 'UTF-8');
    $detalle_p = htmlspecialchars($_POST["detalle_p"], ENT_QUOTES, 'UTF-8');
    $modelo = htmlspecialchars($_POST["modelo"], ENT_QUOTES, 'UTF-8');

    $consulta = $MW->registrar_vehiculo($tipo, $marca, $matricula, $numero_serie, $detalle_p, $modelo);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_vwhiculos") {
    $data = $MW->listar_vwhiculos();
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
if ($_POST["funcion"] === "cambiar_estado_vehculo") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MW->cambiar_estado_vehculo($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_vehiculo") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $tipo = htmlspecialchars($_POST["tipo"], ENT_QUOTES, 'UTF-8');
    $marca = htmlspecialchars($_POST["marca"], ENT_QUOTES, 'UTF-8');
    $matricula = htmlspecialchars($_POST["matricula"], ENT_QUOTES, 'UTF-8');
    $numero_serie = htmlspecialchars($_POST["numero_serie"], ENT_QUOTES, 'UTF-8');
    $detalle_p = htmlspecialchars($_POST["detalle_p"], ENT_QUOTES, 'UTF-8');
    $modelo = htmlspecialchars($_POST["modelo"], ENT_QUOTES, 'UTF-8');

    $consulta = $MW->editar_vehiculo($id, $tipo, $marca, $matricula, $numero_serie, $detalle_p, $modelo);
    echo $consulta;
    exit();
}





/////////////////////////////////////
if ($_POST["funcion"] === "registrar_repartidors") {
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

    $nombrearchivo = htmlspecialchars($_POST['nombrearchivo'], ENT_QUOTES, 'UTF-8');
    //esto es para saber si el file trae datos

    if (is_array($_FILES) && count($_FILES) > 0) {
        $ruta = "img/repartidor/$nombrearchivo";

        $consulta = $MW->registrar_repartidors($nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $tipo_licencia, $usuario, $password, $ruta);

        if ($consulta == 1) {
            if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/repartidor/" . $nombrearchivo)) {
                echo $consulta;
            } else {
                echo 0;
            }
        } else {
            echo $consulta;
        }
    } else {
        $ruta = "img/repartidor/repartidor.jpg";

        $consulta = $MW->registrar_repartidors($nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $tipo_licencia, $usuario, $password, $ruta);
        
        echo $consulta;
    }

   
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "editar_foto_repartidor") {

    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');
    $ruta_actual = htmlspecialchars($_POST["ruta_actual"], ENT_QUOTES, 'UTF-8');

    //esto es para saber si el file trae datos
    if (is_array($_FILES) && count($_FILES) > 0) {
        if ($ruta_actual != "img/repartidor/repartidor.jpg") {
            $delete = $ruta_actual;
            unlink("../../" . $delete);
        }
        if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/repartidor/" . $nombrearchivo)) {
            $ruta = "img/repartidor/$nombrearchivo";
            $consulta = $MW->editar_foto_repartidor($id, $ruta);
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
if ($_POST["funcion"] === "listar_repartidor") {
    $data = $MW->listar_repartidor();
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
if ($_POST["funcion"] === "cambiar_estado_repatrdiro") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MW->cambiar_estado_repatrdiro($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editarr_repartidors") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombress = htmlspecialchars($_POST["nombress"], ENT_QUOTES, 'UTF-8');
    $apellidoss = htmlspecialchars($_POST["apellidoss"], ENT_QUOTES, 'UTF-8');
    $numero_docu = htmlspecialchars($_POST["numero_docu"], ENT_QUOTES, 'UTF-8');
    $telefono_p = htmlspecialchars($_POST["telefono_p"], ENT_QUOTES, 'UTF-8');
    $correo_p = htmlspecialchars($_POST["correo_p"], ENT_QUOTES, 'UTF-8');
    $direccions = htmlspecialchars($_POST["direccions"], ENT_QUOTES, 'UTF-8');
    $sexo = htmlspecialchars($_POST["sexo"], ENT_QUOTES, 'UTF-8');
    $tipo_licencia = htmlspecialchars($_POST["tipo_licencia"], ENT_QUOTES, 'UTF-8');

    $usuario_e = htmlspecialchars($_POST["usuario_e"], ENT_QUOTES, 'UTF-8');
    $password_e = htmlspecialchars($_POST["password_e"], ENT_QUOTES, 'UTF-8');

    $consulta = $MW->editarr_repartidors($id, $nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $tipo_licencia, $usuario_e, $password_e);
    echo $consulta;
    exit();
}

//////////////  
if ($_POST["funcion"] === "listar_repartiro_combo") {
    $data = $MW->listar_repartiro_combo();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

//////////////  
if ($_POST["funcion"] === "listar_vehiculo_combo") {
    $data = $MW->listar_vehiculo_combo();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

//////////////  
if ($_POST["funcion"] === "traer_datos_vehculos") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $data = $MW->traer_datos_vehculos($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_ventass_selecionar") {
    $data = $MW->listar_ventass_selecionar();
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
if ($_POST["funcion"] === "listar_envioss") {
    $data = $MW->listar_envioss();
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
if ($_POST["funcion"] === "registra_envio_venta") {
    $repartidor = htmlspecialchars($_POST["repartidor"], ENT_QUOTES, 'UTF-8');
    $vehículo = htmlspecialchars($_POST["vehículo"], ENT_QUOTES, 'UTF-8');
    $numero_compra = htmlspecialchars($_POST["numero_compra"], ENT_QUOTES, 'UTF-8');
    $fecha_envio = htmlspecialchars($_POST["fecha_envio"], ENT_QUOTES, 'UTF-8');
    $total = htmlspecialchars($_POST["total"], ENT_QUOTES, 'UTF-8');
    $count = htmlspecialchars($_POST["count"], ENT_QUOTES, 'UTF-8');

    $consulta = $MW->registra_envio_venta($repartidor, $vehículo, $numero_compra, $fecha_envio, $total, $count);
    echo $consulta;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "detalle_envio_ventas") {

    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $id_venta = htmlspecialchars($_POST['id_venta'], ENT_QUOTES, 'UTF-8');
    $direccion = htmlspecialchars($_POST['direccion'], ENT_QUOTES, 'UTF-8');
    $referencia = htmlspecialchars($_POST['referencia'], ENT_QUOTES, 'UTF-8');
    $nu_venta = htmlspecialchars($_POST['nu_venta'], ENT_QUOTES, 'UTF-8');
    $cantidad = htmlspecialchars($_POST['cantidad'], ENT_QUOTES, 'UTF-8');
    $valor = htmlspecialchars($_POST['valor'], ENT_QUOTES, 'UTF-8');
    $codigo = htmlspecialchars($_POST['codigo'], ENT_QUOTES, 'UTF-8');

    $arraglo_id_venta = explode(",", $id_venta); //aqui separo los datos
    $arraglo_direccion = explode(",", $direccion); //aqui separo los datos
    $arraglo_referencia = explode(",", $referencia); //aqui separo los datos
    $arraglo_nu_venta = explode(",", $nu_venta); //aqui separo los datos
    $arraglo_cantidad = explode(",", $cantidad); //aqui separo los datos
    $arraglo_valor = explode(",", $valor); //aqui separo los datos 

    //bucle para contar la cantidad de datos
    for ($i = 0; $i < count($arraglo_id_venta); $i++) {
        $consulta = $MW->detalle_envio_ventas(
            $id,
            $codigo,
            $arraglo_id_venta[$i],
            $arraglo_direccion[$i],
            $arraglo_referencia[$i],
            $arraglo_nu_venta[$i],
            $arraglo_cantidad[$i],
            $arraglo_valor[$i],
        );
    }
    echo $consulta;
    exit();
}

/////////////////////////
if ($_POST["funcion"] === "cargar_detalle_envio") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MW->cargar_detalle_envio($id);
    echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
    exit();
}