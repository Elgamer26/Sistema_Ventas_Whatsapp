<?php
require_once 'modelo_conexion.php';
class modelo_web extends modelo_conexion
{

    function listar_calificacion()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            calificacion.id_calificacion,
            CONCAT_WS(' ', cliente.nombres,
            cliente.apellidos) as ciente,
            calificacion.calificar,
            calificacion.detalle,
            calificacion.fecha,
            calificacion.estado 
            FROM
                calificacion
                INNER JOIN cliente ON calificacion.id_cliente = cliente.id_cliente 
            WHERE
            calificacion.estado = 1";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo["data"][] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function listar_calificacion_producto()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            calificacion_producto.id_producto,
            producto.nombre_producto,
            producto.foto,
            tipo_producto.tipo_producto,
            marca.marca ,
            COUNT(calificacion_producto.id_producto) as cantidad
            FROM
            calificacion_producto
            INNER JOIN producto ON calificacion_producto.id_producto = producto.id_producto
            INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
            INNER JOIN marca ON producto.id_marca = marca.id_marca GROUP BY calificacion_producto.id_producto";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo["data"][] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function traer_calidifcacion($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            calificacion_producto.calificaion_pro_id,
            CONCAT_WS( ' ', cliente.nombres, cliente.apellidos ) AS cliente,
            calificacion_producto.calificar,
            calificacion_producto.detalle,
            calificacion_producto.fecha,
            calificacion_producto.id_producto 
            FROM
                calificacion_producto
                INNER JOIN cliente ON calificacion_producto.id_cliente = cliente.id_cliente 
            WHERE
            calificacion_producto.id_producto = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo["data"][] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function listar_vwhiculos()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            vehiculo.id_vehiculo, 
            vehiculo.tipo, 
            vehiculo.marca, 
            vehiculo.matricula, 
            vehiculo.numero_serie, 
            vehiculo.detalle_p, 
            vehiculo.modelo, 
            vehiculo.estado
             FROM
            vehiculo";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo["data"][] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function registrar_vehiculo($tipo, $marca, $matricula, $numero_serie, $detalle_p, $modelo)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "INSERT INTO vehiculo (tipo, marca, matricula, numero_serie, detalle_p, modelo) VALUES (?,?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $tipo);
            $querya->bindParam(2, $marca);
            $querya->bindParam(3, $matricula);
            $querya->bindParam(4, $numero_serie);
            $querya->bindParam(5, $detalle_p);
            $querya->bindParam(6, $modelo);

            if ($querya->execute()) {
                $res = 1;
            } else {
                $res = 0;
            }

            return $res;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function editar_vehiculo($id, $tipo, $marca, $matricula, $numero_serie, $detalle_p, $modelo)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE vehiculo SET tipo = ?, marca = ?, matricula = ?, numero_serie = ?, detalle_p = ?, modelo = ? WHERE id_vehiculo = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $tipo);
            $querya->bindParam(2, $marca);
            $querya->bindParam(3, $matricula);
            $querya->bindParam(4, $numero_serie);
            $querya->bindParam(5, $detalle_p);
            $querya->bindParam(6, $modelo);
            $querya->bindParam(7, $id);

            if ($querya->execute()) {
                $res = 1;
            } else {
                $res = 0;
            }

            return $res;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function cambiar_estado_vehculo($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE vehiculo SET estado = ? WHERE id_vehiculo = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $dato);
            $querya->bindParam(2, $id);

            if ($querya->execute()) {
                $res = 1;
            } else {
                $res = 0;
            }

            return $res;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }


    /////
    function registrar_repartidors($nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $tipo_licencia, $usuario, $password, $ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM repartidor where cedula = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $numero_docu);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($data)) {
                $sql_b = "SELECT * FROM repartidor where correo = ?";
                $query_b = $c->prepare($sql_b);
                $query_b->bindParam(1, $correo_p);
                $query_b->execute();
                $data_b = $query_b->fetch(PDO::FETCH_ASSOC);
                if (empty($data_b)) {
                    $sql_a = "INSERT INTO repartidor (nombres, apellidos, cedula, telefono, correo, direcion, sexo, tipo_licencia, usuario, passwordd, imagen) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                    $querya = $c->prepare($sql_a);
                    $querya->bindParam(1, $nombress);
                    $querya->bindParam(2, $apellidoss);
                    $querya->bindParam(3, $numero_docu);
                    $querya->bindParam(4, $telefono_p);
                    $querya->bindParam(5, $correo_p);
                    $querya->bindParam(6, $direccions);
                    $querya->bindParam(7, $sexo);
                    $querya->bindParam(8, $tipo_licencia);
                    $querya->bindParam(9, $usuario);
                    $querya->bindParam(10, $password);
                    $querya->bindParam(11, $ruta);

                    if ($querya->execute()) {
                        $res = 1;
                    } else {
                        $res = 0;
                    }
                } else {
                    $res = 3; /// correo ya existe
                }
            } else {
                $res = 2; // cedula ya eistes
            }
            return $res;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function listar_repartidor()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            repartidor.repartidor_id, 
            repartidor.nombres, 
            repartidor.apellidos, 
            repartidor.cedula, 
            repartidor.telefono, 
            repartidor.correo, 
            repartidor.direcion, 
            repartidor.sexo, 
            repartidor.tipo_licencia, 
            repartidor.estado,
            repartidor.usuario, 
            repartidor.passwordd,
            repartidor.imagen
            FROM
            repartidor";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo["data"][] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function editar_foto_repartidor($id, $ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE repartidor SET imagen = ? WHERE repartidor_id = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $ruta);
            $querya->bindParam(2, $id);

            if ($querya->execute()) {
                $res = 1;
            } else {
                $res = 0;
            }

            return $res;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }


    
    function cambiar_estado_repatrdiro($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE repartidor SET estado = ? WHERE repartidor_id = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $dato);
            $querya->bindParam(2, $id);

            if ($querya->execute()) {
                $res = 1;
            } else {
                $res = 0;
            }

            return $res;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function editarr_repartidors($id, $nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $tipo_licencia, $usuario_e, $password_e)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM repartidor where cedula = ? AND repartidor_id != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $numero_docu);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($data)) {
                $sql_b = "SELECT * FROM repartidor where correo = ? AND repartidor_id != ?";
                $query_b = $c->prepare($sql_b);
                $query_b->bindParam(1, $correo_p);
                $query_b->bindParam(2, $id);
                $query_b->execute();
                $data_b = $query_b->fetch(PDO::FETCH_ASSOC);
                if (empty($data_b)) {
                    $sql_a = "UPDATE repartidor SET nombres = ?, apellidos = ?, cedula = ?, telefono = ?, correo = ?, direcion = ?, sexo = ?, tipo_licencia = ?, usuario = ?, passwordd = ? WHERE repartidor_id = ?";
                    $querya = $c->prepare($sql_a);
                    $querya->bindParam(1, $nombress);
                    $querya->bindParam(2, $apellidoss);
                    $querya->bindParam(3, $numero_docu);
                    $querya->bindParam(4, $telefono_p);
                    $querya->bindParam(5, $correo_p);
                    $querya->bindParam(6, $direccions);
                    $querya->bindParam(7, $sexo);
                    $querya->bindParam(8, $tipo_licencia);
                    $querya->bindParam(9, $usuario_e);
                    $querya->bindParam(10, $password_e);
                    $querya->bindParam(11, $id);

                    if ($querya->execute()) {
                        $res = 1;
                    } else {
                        $res = 0;
                    }
                } else {
                    $res = 3; /// correo ya existe
                }
            } else {
                $res = 2; // cedula ya eistes
            }
            return $res;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function listar_repartiro_combo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            repartidor.repartidor_id, 
            repartidor.nombres, 
            repartidor.apellidos, 
            repartidor.cedula, 
            repartidor.telefono, 
            repartidor.correo, 
            repartidor.direcion, 
            repartidor.sexo, 
            repartidor.tipo_licencia, 
            repartidor.estado
            FROM
            repartidor WHERE repartidor.estado = 1";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_BOTH);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo[] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function listar_vehiculo_combo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            vehiculo.id_vehiculo, 
            vehiculo.tipo, 
            vehiculo.marca, 
            vehiculo.matricula, 
            vehiculo.numero_serie, 
            vehiculo.detalle_p, 
            vehiculo.estado
             FROM
            vehiculo WHERE vehiculo.estado = 1";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_BOTH);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo[] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function traer_datos_vehculos($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            vehiculo.id_vehiculo, 
            vehiculo.tipo, 
            vehiculo.marca, 
            vehiculo.matricula, 
            vehiculo.numero_serie, 
            vehiculo.detalle_p, 
            vehiculo.estado
            FROM
            vehiculo WHERE id_vehiculo = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_BOTH);
            return $result;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function listar_ventass_selecionar()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            venta_online.id_venta_online_trans,
            CONCAT_WS( ' ', cliente.nombres, cliente.apellidos ) AS cliente,
            venta_online.tipo_pago,
            venta_online.numero_compra,
            venta_online.fecha,
            venta_online.cantidad,
            venta_online.subtotal,
            venta_online.impuesto,
            venta_online.total,
            venta_online.direccion,
            venta_online.referencia,
            venta_online.estado,
            venta_online.pago 
            FROM
            venta_online
            INNER JOIN cliente ON venta_online.cliente_id = cliente.id_cliente 
            WHERE
            venta_online.estado = 1 
            AND venta_online.estado_envio IS NULL 
            AND venta_online.tipo_pago = 'Efectivo' 
            AND venta_online.pago = 0 
            OR venta_online.tipo_pago = 'Transferencia' 
            AND venta_online.pago = 2 
            AND venta_online.estado = 1 
            AND venta_online.estado_envio IS NULL";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo["data"][] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function listar_envioss()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            envios.envio_id,
            CONCAT_WS( ' ', repartidor.nombres, repartidor.apellidos ) AS repartidor,
            CONCAT_WS( ' ', vehiculo.tipo, '/', vehiculo.marca, '/', vehiculo.matricula ) AS vehiculos,
            envios.num_envio,
            envios.fecha_envio,
            envios.total,
            envios.countt,
            envios.estado 
            FROM
            envios
            INNER JOIN repartidor ON envios.repartidor_id = repartidor.repartidor_id
            INNER JOIN vehiculo ON envios.`vehículo_id` = vehiculo.id_vehiculo";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo["data"][] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function registra_envio_venta($repartidor, $vehículo, $numero_compra, $fecha_envio, $total, $count)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "INSERT INTO envios (repartidor_id, vehículo_id, num_envio, fecha_envio, total, countt) VALUES (?,?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $repartidor);
            $querya->bindParam(2, $vehículo);
            $querya->bindParam(3, $numero_compra);
            $querya->bindParam(4, $fecha_envio);
            $querya->bindParam(5, $total);
            $querya->bindParam(6, $count);

            if ($querya->execute()) {
                $res = $c->lastInsertId();
            } else {
                $res = 0;
            }

            return $res;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function detalle_envio_ventas($id, $codigo, $arraglo_id_venta, $arraglo_direccion, $arraglo_referencia, $arraglo_nu_venta, $arraglo_cantidad, $arraglo_valor)
    {
        try {
            date_default_timezone_set('America/Guayaquil');
            $fecha = date("Y-m-d");
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "INSERT INTO detalle_envios (envio_id, venta_online_id, direccion, refrencia, num_venta, cantidad, valor) VALUES (?,?,?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            $querya->bindParam(2, $arraglo_id_venta);
            $querya->bindParam(3, $arraglo_direccion);
            $querya->bindParam(4, $arraglo_referencia);
            $querya->bindParam(5, $arraglo_nu_venta);
            $querya->bindParam(6, $arraglo_cantidad);
            $querya->bindParam(7, $arraglo_valor);

            if ($querya->execute()) {
                $sql_b = "UPDATE venta_online SET fecha_envio = ?, cod_envio = ?, estado_envio = 'Enviado' WHERE id_venta_online_trans = ?";
                $queryb = $c->prepare($sql_b);
                $queryb->bindParam(1, $fecha);
                $queryb->bindParam(2, $codigo);
                $queryb->bindParam(3, $arraglo_id_venta);
                if ($queryb->execute()) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            } else {
                $res = 0;
            }

            return $res;
            //cerramos la conexion
            // modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            // modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function cargar_detalle_envio($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            detalle_envios.envio_id, 
            CONCAT_WS(' ', cliente.nombres, cliente.apellidos ) AS cliente, 
            detalle_envios.direccion, 
            detalle_envios.refrencia, 
            detalle_envios.num_venta, 
            detalle_envios.cantidad, 
            detalle_envios.valor, 
            venta_online.tipo_pago
            FROM
            detalle_envios
            INNER JOIN
            venta_online
            ON 
                detalle_envios.venta_online_id = venta_online.id_venta_online_trans
            INNER JOIN
            cliente
            ON 
                venta_online.cliente_id = cliente.id_cliente
            WHERE
            detalle_envios.envio_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_BOTH);
            $arreglo = array();
            foreach ($result as $respuesta) {
                $arreglo["data"][] = $respuesta;
            }
            return $arreglo;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }
}
