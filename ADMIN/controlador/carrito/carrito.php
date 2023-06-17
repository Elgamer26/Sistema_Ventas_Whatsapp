<?php
require '../../modelo/modelo_carrito.php';
$MCA = new modelo_carrito();
session_start();

///////////////////////////////////// 
if ($_POST["funcion"] === "logeo") {
    $usu = htmlspecialchars($_POST['usuario'], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    $resutado = $MCA->verifcar_usuario($usu, $pass);
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
    $id_cli = $_POST["id_cli"];
    $nombre = $_POST["nombre"];

    $_SESSION["id_cli"] = $id_cli;
    $_SESSION["nombre_cli"] = $nombre;
    echo 1;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "calificar_sistema") {
    $id_cli =   $_SESSION["id_cli"];
    $estrella = htmlspecialchars($_POST['estrella'], ENT_QUOTES, 'UTF-8');
    $comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');
    $resutado = $MCA->calificar_sistema($id_cli, $estrella, $comentario);
    echo $resutado;
    exit();
}

///////////////////////////////////// 
if ($_POST["funcion"] === "calificar_poducto_pp") {
    $id_cli =   $_SESSION["id_cli"];
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $estrella = htmlspecialchars($_POST['estrella'], ENT_QUOTES, 'UTF-8');
    $comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');
    $resutado = $MCA->calificar_poducto_pp($id_cli, $estrella, $comentario, $id);
    echo $resutado;
    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "pagination_carrito") {
    $data = $MCA->pagination_carrito();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "pagination_carrito_oferta") {
    $data = $MCA->pagination_carrito_oferta();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////////
if ($_POST["funcion"] === "agregar_producto") {
    if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {
        $id_cli = $_SESSION["id_cli"];
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $precio = htmlspecialchars($_POST['precio'], ENT_QUOTES, 'UTF-8');
        $cantidad = htmlspecialchars($_POST['cantidad'], ENT_QUOTES, 'UTF-8');
        $resutado = $MCA->agregar_producto($id, $precio, $id_cli, $cantidad);
        echo $resutado;
    } else {
        echo 100;
    }
    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "mostrar_carrito_compra_detalle") {
    if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {
        $id_cli = $_SESSION['id_cli'];
        $data = $MCA->mostrar_carrito_compra_detalle($id_cli);
        //jason encode para retornar los datos
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo 100;
    }
    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "quitar_producto_detalle") {
    $id_cli = htmlspecialchars($_POST['id_cli'], ENT_QUOTES, 'UTF-8');
    $id_pro = htmlspecialchars($_POST['id_pro'], ENT_QUOTES, 'UTF-8');
    $data = $MCA->quitar_producto_detalle($id_cli, $id_pro);
    echo $data;

    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "cantidad_producto_carrito") {
    if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {

        $idcli = htmlspecialchars($_POST['idcli'], ENT_QUOTES, 'UTF-8');
        $idpro = htmlspecialchars($_POST['idpro'], ENT_QUOTES, 'UTF-8');
        $cant = htmlspecialchars($_POST['cant'], ENT_QUOTES, 'UTF-8');

        $data = $MCA->cantidad_producto_carrito($idcli, $idpro, $cant);
        //jason encode para retornar los datos
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "count_carrito") {
    if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {
        $id_cli = $_SESSION['id_cli'];
        $data = $MCA->count_carrito($id_cli);
        //jason encode para retornar los datos
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        echo 100;
    }
    exit();
}

/////////////////////////////////////////
if ($_POST["funcion"] === "agregar_producoferta") {
    if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {
        $id_cli = $_SESSION["id_cli"];

        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $cantidad = htmlspecialchars($_POST['cantidad'], ENT_QUOTES, 'UTF-8');

        $resutado = $MCA->agregar_producoferta($id, $id_cli, $cantidad);
        echo $resutado;
    } else {
        echo 100;
    }
    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "vaciar_carrito") {
    if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {

        $id_cli = $_SESSION["id_cli"];
        $data = $MCA->vaciar_carrito($id_cli);
        echo $data;
    } else {
        echo 100;
    }

    exit();
}

////////////////////////
if ($_POST["funcion"] === "listar_banco_combo") {
    $data = $MCA->listar_banco_combo();
    //jason encode para retornar los datos
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "registra_compra_tranferencia") {
    if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {

        $cliente = $_SESSION["id_cli"];
        $banco = htmlspecialchars($_POST["banco"], ENT_QUOTES, 'UTF-8');
        $direccion = htmlspecialchars($_POST["direccion"], ENT_QUOTES, 'UTF-8');
        $referencia = htmlspecialchars($_POST["referencia"], ENT_QUOTES, 'UTF-8');
        $fecha_transf = htmlspecialchars($_POST["fecha_transf"], ENT_QUOTES, 'UTF-8');
        $sub = htmlspecialchars($_POST["sub"], ENT_QUOTES, 'UTF-8');
        $impuesto = htmlspecialchars($_POST["impuesto"], ENT_QUOTES, 'UTF-8');
        $total = htmlspecialchars($_POST["total"], ENT_QUOTES, 'UTF-8');
        $tipo_pago = htmlspecialchars($_POST["tipo_pago"], ENT_QUOTES, 'UTF-8');
        $count = htmlspecialchars($_POST["count"], ENT_QUOTES, 'UTF-8');
        $codigo = htmlspecialchars($_POST["codigo"], ENT_QUOTES, 'UTF-8');

        $nombrearchivo = htmlspecialchars($_POST['nombrearchivo'], ENT_QUOTES, 'UTF-8');

        // $consulta = $MCA->registra_compra_tranferencia($cliente, $banco, $direccion, $referencia, $fecha_transf, $sub, $impuesto, $total, $tipo_pago, $count, $codigo);
        // echo $consulta;

        if (is_array($_FILES) && count($_FILES) > 0) {
            $ruta = "img/transferencia/$nombrearchivo";
            if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/transferencia/" . $nombrearchivo)) {
                $consulta = $MCA->registra_compra_tranferencia($cliente, $banco, $direccion, $referencia, $fecha_transf, $sub, $impuesto, $total, $tipo_pago, $count, $codigo, $ruta);
                echo $consulta;
            } else {
                echo 0;
            }
        } else {
            echo "no_foto";
        }
    } else {
        echo "no_clientes";
    }
    exit();
}

///////////////////////////////////////////// 
if ($_POST["funcion"] === "registra_detalle_compra_trasnferenia") {
    $id_cli = $_SESSION['id_cli'];
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $data = $MCA->registra_detalle_compra_trasnferenia($id_cli, $id);
    echo $data;

    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "listar_ventas_productos_cliente") {
    $cliente = $_SESSION["id_cli"];
    $data = $MCA->listar_ventas_productos_cliente($cliente);
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
if ($_POST["funcion"] === "listar_venta_servicios_cliente") {
    $cliente = $_SESSION["id_cli"];
    $data = $MCA->listar_venta_servicios_cliente($cliente);
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
if ($_POST["funcion"] === "listar_ventas_onlinee_productos_cliente") {
    $cliente = $_SESSION["id_cli"];
    $data = $MCA->listar_ventas_onlinee_productos_cliente($cliente);
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
if ($_POST["funcion"] === "lista_transferencia_bancaria_cliente") {
    $cliente = $_SESSION["id_cli"];
    $data = $MCA->lista_transferencia_bancaria_cliente($cliente);
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
if ($_POST["funcion"] === "subir_phto_transa") {

    $id = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
    $id_venta = htmlspecialchars($_POST["id_venta"], ENT_QUOTES, 'UTF-8');
    $nombrearchivo = htmlspecialchars($_POST["nombrearchivo"], ENT_QUOTES, 'UTF-8');

    //esto es para saber si el file trae datos
    if (is_array($_FILES) && count($_FILES) > 0) {
        if (move_uploaded_file($_FILES['foto']["tmp_name"], "../../img/transferencia/" . $nombrearchivo)) {
            $ruta = "img/transferencia/$nombrearchivo";
            $consulta = $MCA->subir_phto_transa($id, $id_venta, $ruta);
            echo $consulta;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }

    exit();
}

/////////////////
/////////////////////////////////////
if ($_POST["funcion"] === "registra_compra_efectivo") {
    if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {

        $cliente = $_SESSION["id_cli"];
        $direccion = htmlspecialchars($_POST["direccion"], ENT_QUOTES, 'UTF-8');
        $referencia = htmlspecialchars($_POST["referencia"], ENT_QUOTES, 'UTF-8');
        $fecha_efectivo = htmlspecialchars($_POST["fecha_efectivo"], ENT_QUOTES, 'UTF-8');
        $sub = htmlspecialchars($_POST["sub"], ENT_QUOTES, 'UTF-8');
        $impuesto = htmlspecialchars($_POST["impuesto"], ENT_QUOTES, 'UTF-8');
        $total = htmlspecialchars($_POST["total"], ENT_QUOTES, 'UTF-8');
        $tipo_pago = htmlspecialchars($_POST["tipo_pago"], ENT_QUOTES, 'UTF-8');
        $count = htmlspecialchars($_POST["count"], ENT_QUOTES, 'UTF-8');

        $consulta = $MCA->registra_compra_efectivo($cliente, $direccion, $referencia, $fecha_efectivo, $sub, $impuesto, $total, $tipo_pago, $count);
        echo $consulta;
    } else {
        echo "no_clientes";
    }
    exit();
}

/////////////////////////////////////
if ($_POST["funcion"] === "lista_efetivo_clinte") {
    $cliente = $_SESSION["id_cli"];
    $data = $MCA->lista_efetivo_clinte($cliente);
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
if ($_POST["funcion"] === "Enviando_correo") {
    $correo = htmlspecialchars($_POST['correo'], ENT_QUOTES, 'UTF-8');
    $resutado = $MCA->Enviando_correo($correo);
    $data = json_encode($resutado, JSON_UNESCAPED_UNICODE);
    if (!empty($resutado)) {

        $length = 10;
        $key = "";
        $pattern = "*.1234567890abcdefghijklmnopqrstuvwxyz";
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $length; $i++) {
            $key .= substr($pattern, mt_rand(0, $max), 1);
        }
        
        $envio = $MCA->cambiar_pass($correo, $key);

        if ($envio == 1) {
            echo $key;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
    exit();
}

////////////////////////
if ($_POST["funcion"] === "traer_foto_producto") {
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $data = $MCA->traer_foto_producto($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}
