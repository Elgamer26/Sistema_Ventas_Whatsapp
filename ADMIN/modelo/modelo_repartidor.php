<?php
// session_start();
require_once 'modelo_conexion.php';
class modelo_repartidor extends modelo_conexion
{

    function verifcar_usuario($usuario, $passs)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
      repartidor.repartidor_id,
      repartidor.nombres,
      repartidor.correo,
      repartidor.estado 
        FROM
            repartidor 
        WHERE
      repartidor.usuario = ? 
      AND repartidor.passwordd = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario);
            $query->bindParam(2, $passs);
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

    function trear_datos($id)
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
            repartidor.usuario, 
            repartidor.passwordd
            FROM
                repartidor
            WHERE
            repartidor.repartidor_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
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

    function editar_datos($id, $nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $tipo_licencia, $usuario, $password)
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
                    $querya->bindParam(9, $usuario);
                    $querya->bindParam(10, $password);
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

    function listar_envios_repartidor($id)
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
            INNER JOIN vehiculo ON envios.`vehículo_id` = vehiculo.id_vehiculo WHERE envios.repartidor_id = ?";
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

    function finalizar_entregas($id)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();

            $sql = "SELECT
            detalle_envios.envio_id,
            venta_online.id_venta_online_trans 
            FROM
            venta_online
            INNER JOIN detalle_envios ON venta_online.id_venta_online_trans = detalle_envios.venta_online_id WHERE detalle_envios.envio_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_BOTH);
            foreach ($result as $respuesta) {
                $sql_a = "UPDATE venta_online SET estado_envio = 'Entregado' WHERE id_venta_online_trans = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $respuesta[1]);
                $querya->execute();
            }

            $sql_a = "UPDATE envios SET estado = 2 WHERE envio_id = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
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

    function listar_efectivo_espera($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            efectivo.efectivo_id,
            venta_online.numero_compra,
            CONCAT_WS( ' ', cliente.nombres, cliente.apellidos ) AS clientee,
            efectivo.direccion,
            efectivo.referencia,
            efectivo.fecha,
            efectivo.monto,
            efectivo.estado,
            efectivo.foto,
            efectivo.fecha_proceso,
            repartidor.repartidor_id,
            venta_online.id_venta_online_trans 
            FROM
                efectivo
                INNER JOIN venta_online ON efectivo.id_venta_online = venta_online.id_venta_online_trans
                INNER JOIN cliente ON venta_online.cliente_id = cliente.id_cliente
                INNER JOIN envios
                INNER JOIN detalle_envios ON envios.envio_id = detalle_envios.envio_id 
                AND venta_online.id_venta_online_trans = detalle_envios.venta_online_id
                INNER JOIN repartidor ON envios.repartidor_id = repartidor.repartidor_id 
                WHERE efectivo.foto IS NULL AND repartidor.repartidor_id = ?
            ORDER BY
            efectivo.efectivo_id DESC";
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

    function subir_foto_efectivo($id, $id_clie, $ruta, $detalle)
    {
        date_default_timezone_set('America/Guayaquil');
        $fecha = date("Y-m-d");

        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_b = "UPDATE efectivo SET foto = ?, fecha_proceso = ?, estado = 1, detalle = ? WHERE efectivo_id = ?";
            $query_b = $c->prepare($sql_b);
            $query_b->bindParam(1, $ruta);
            $query_b->bindParam(2, $fecha);
            $query_b->bindParam(3, $detalle);
            $query_b->bindParam(4, $id);
            if ($query_b->execute()) {

                $sql_e = "UPDATE venta_online SET pago = 2 WHERE id_venta_online_trans = ?";
                $query_e = $c->prepare($sql_e);
                $query_e->bindParam(1, $id_clie); 
                if ($query_e->execute()) {
                    $res = 1; // ok
                }else{
                    $res = 0; // error en la inserccion
                }

            } else {
                $res = 0; // error en la inserccion
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

    function ver_efectivo_procesado($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            efectivo.efectivo_id,
            venta_online.numero_compra,
            CONCAT_WS( ' ', cliente.nombres, cliente.apellidos ) AS clientee,
            efectivo.direccion,
            efectivo.referencia,
            efectivo.fecha,
            efectivo.monto,
            efectivo.estado,
            efectivo.foto,
            efectivo.fecha_proceso,
            repartidor.repartidor_id,
            venta_online.cliente_id 
            FROM
                efectivo
                INNER JOIN venta_online ON efectivo.id_venta_online = venta_online.id_venta_online_trans
                INNER JOIN cliente ON venta_online.cliente_id = cliente.id_cliente
                INNER JOIN envios
                INNER JOIN detalle_envios ON envios.envio_id = detalle_envios.envio_id 
                AND venta_online.id_venta_online_trans = detalle_envios.venta_online_id
                INNER JOIN repartidor ON envios.repartidor_id = repartidor.repartidor_id 
                WHERE efectivo.foto IS NOT NULL AND repartidor.repartidor_id = ?
            ORDER BY
            efectivo.efectivo_id DESC";
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
}
