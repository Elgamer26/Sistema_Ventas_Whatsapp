<?php
require '../../modelo/modelo_producto.php';
$MP = new modelo_producto();

/////////////////////////////////////
if ($_POST["funcion"] === "registrar_marca") {
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->registrar_marca($nombre);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_marca") {

    $data = $MP->listar_marca();
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
if ($_POST["funcion"] === "estado_marca") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->estado_marca($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_marca") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->editar_marca($nombre, $id);
    echo $consulta;
    exit();
}

//////////////////
/////////// tipo
/////////////////////////////////////
if ($_POST["funcion"] === "registrar_tipo") {
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->registrar_tipo($nombre);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_tipo") {

    $data = $MP->listar_tipo();
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
if ($_POST["funcion"] === "estado_tipo") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->estado_tipo($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_tipo") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->editar_tipo($nombre, $id);
    echo $consulta;
    exit();
}

////////////////
////////////// producto
if ($_POST["funcion"] === "listar_marca_combo") {
    $data = $MP->listar_marca_combo();
    //jason encode para retornar los datos
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

////////////////////////
if ($_POST["funcion"] === "listar_tipo_comobo") {
    $data = $MP->listar_tipo_comobo();
    //jason encode para retornar los datos
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registra_producto") {
    $codigos = htmlspecialchars($_POST["codigos"], ENT_QUOTES, 'UTF-8');
    $nombres = htmlspecialchars($_POST["nombres"], ENT_QUOTES, 'UTF-8');
    $marca = htmlspecialchars($_POST["marca"], ENT_QUOTES, 'UTF-8');
    $tipo = htmlspecialchars($_POST["tipo"], ENT_QUOTES, 'UTF-8');
    $precio_venta = htmlspecialchars($_POST["precio_venta"], ENT_QUOTES, 'UTF-8');
    $decripcion = htmlspecialchars($_POST["decripcion"], ENT_QUOTES, 'UTF-8');

    $nombrearchivo = htmlspecialchars($_POST['nombrearchivo'], ENT_QUOTES, 'UTF-8');
    //esto es para saber si el file trae datos

    if (is_array($_FILES) && count($_FILES) > 0) {
        $ruta = "img/prouducto/$nombrearchivo";
        $consulta = $MP->registra_producto($codigos, $nombres, $marca, $tipo, $precio_venta, $decripcion, $ruta);
        if ($consulta == 1) {
            if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/prouducto/" . $nombrearchivo)) {
                echo $consulta;
            } else {
                echo 0;
            }
        } else {
            echo $consulta;
        }
    } else {
        $ruta = "img/prouducto/foto.jpg";
        $consulta = $MP->registra_producto($codigos, $nombres, $marca, $tipo, $precio_venta, $decripcion, $ruta);
        echo $consulta;
    }

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_prodcuto") {
    $data = $MP->listar_prodcuto();
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
if ($_POST["funcion"] === "editar_foto_producto") {

        $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
        $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');
        $ruta_actual = htmlspecialchars($_POST["ruta_actual"], ENT_QUOTES, 'UTF-8');

        //esto es para saber si el file trae datos
        if (is_array($_FILES) && count($_FILES) > 0) {
            if ($ruta_actual != "img/prouducto/foto.jpg") {
                $delete = $ruta_actual;
                unlink("../../" . $delete);
            }
            if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/prouducto/" . $nombrearchivo)) {
                $ruta = "img/prouducto/$nombrearchivo";
                $consulta = $MP->editar_foto_producto($id, $ruta);
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
if ($_POST["funcion"] === "estado_producto") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->estado_producto($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editar_producto") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $codigos = htmlspecialchars($_POST["codigos"], ENT_QUOTES, 'UTF-8');
    $nombres = htmlspecialchars($_POST["nombres"], ENT_QUOTES, 'UTF-8');
    $marca = htmlspecialchars($_POST["marca"], ENT_QUOTES, 'UTF-8');
    $tipo = htmlspecialchars($_POST["tipo"], ENT_QUOTES, 'UTF-8');
    $precio_venta = htmlspecialchars($_POST["precio_venta"], ENT_QUOTES, 'UTF-8');
    $decripcion = htmlspecialchars($_POST["decripcion"], ENT_QUOTES, 'UTF-8');

    $consulta = $MP->editar_producto($id, $codigos, $nombres, $marca, $tipo, $precio_venta, $decripcion);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registrar_servicio") {
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $precio = htmlspecialchars($_POST["precio"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->registrar_servicio($nombre, $precio);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_servicios") {

    $data = $MP->listar_servicios();
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
if ($_POST["funcion"] === "estado_servicio") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $dato = htmlspecialchars($_POST["dato"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->estado_servicio($id, $dato);
    echo $consulta;
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "editarr_servicio") {
    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES, 'UTF-8');
    $precio = htmlspecialchars($_POST["precio"], ENT_QUOTES, 'UTF-8');
    $consulta = $MP->editarr_servicio($id, $nombre, $precio);
    echo $consulta;
    exit();
}


