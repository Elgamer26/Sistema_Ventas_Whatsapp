<?php
require_once 'modelo_conexion.php';
class modelo_system extends modelo_conexion
{
    function traer_datos_de_empresa()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM empresa WHERE empresa_id = 1";
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

    function editar_foto_perfil_empresa($ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE empresa SET foto = ? WHERE empresa_id = 1";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $ruta);
            if ($querya->execute()) {
                $res = 1; // SE UPDATE CORRECTAMENTE
            } else {
                $res = 0; // FALLO EN LA MATRIX
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

    function editar_empresa($nomber, $ruc, $direcc, $telefono, $correo, $dueño, $descrp, $iva)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE empresa SET nombre = ?, ruc = ?, direccion = ?, telefono = ?, correo = ?, propietario = ?, descripcion = ?, iva = ? WHERE empresa_id = 1";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $nomber);
            $querya->bindParam(2, $ruc);
            $querya->bindParam(3, $direcc);
            $querya->bindParam(4, $telefono);
            $querya->bindParam(5, $correo);
            $querya->bindParam(6, $dueño);
            $querya->bindParam(7, $descrp);
            $querya->bindParam(8, $iva);

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

    ///////////// ciente usuario
    function traer_datos_cliente($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
                cliente.id_cliente, 
                cliente.nombres, 
                cliente.apellidos, 
                cliente.cedula, 
                cliente.correo, 
                cliente.direcion, 
                cliente.sexo, 
                cliente.estado, 
                cliente.telefono,
                cliente.ppassword
                FROM
                cliente WHERE cliente.id_cliente = ?";
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

    function actuaizar_datos_ciente($id, $nombress, $apellidoss, $numero_docu, $telefono_p, $correo_p, $direccions, $sexo, $password)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM cliente where cedula = ? AND id_cliente != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $numero_docu);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($data)) {
                $sql_b = "SELECT * FROM cliente where correo = ? AND id_cliente != ?";
                $query_b = $c->prepare($sql_b);
                $query_b->bindParam(1, $correo_p);
                $query_b->bindParam(2, $id);
                $query_b->execute();
                $data_b = $query_b->fetch(PDO::FETCH_ASSOC);
                if (empty($data_b)) {
                    $sql_a = "UPDATE cliente SET nombres = ?, apellidos = ?, cedula = ?, telefono = ?, correo = ?, direcion = ?, sexo = ?, ppassword = ? WHERE id_cliente = ?";
                    $querya = $c->prepare($sql_a);
                    $querya->bindParam(1, $nombress);
                    $querya->bindParam(2, $apellidoss);
                    $querya->bindParam(3, $numero_docu);
                    $querya->bindParam(4, $telefono_p);
                    $querya->bindParam(5, $correo_p);
                    $querya->bindParam(6, $direccions);
                    $querya->bindParam(7, $sexo);
                    $querya->bindParam(8, $password);
                    $querya->bindParam(9, $id);

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

    ////
    function productos_mas_comprados()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
                producto.nombre_producto,
                SUM( detalle_vent_pro.cantidad ) AS suma 
                FROM
                    detalle_vent_pro
                    INNER JOIN producto ON detalle_vent_pro.id_producto = producto.id_producto 
                WHERE
                    detalle_vent_pro.estado = 1 
                GROUP BY
                detalle_vent_pro.id_producto 
                ORDER BY
                SUM( detalle_vent_pro.cantidad ) DESC 
                LIMIT 5";
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

    ////
    function servicios_mas_comprados()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            servicio.servicio,
            SUM( detalle_venta_servicio.cantidad ) AS suma 
        FROM
            detalle_venta_servicio
            INNER JOIN servicio ON detalle_venta_servicio.id_servicio = servicio.id_servicio 
        GROUP BY
            detalle_venta_servicio.id_servicio 
        ORDER BY
            SUM( detalle_venta_servicio.cantidad ) DESC 
            LIMIT 5";
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

    ////
    function ventas_productos($fecha_inicio, $fecha_fin)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
                venta.fecha,
                SUM( venta.total ) AS suma 
                FROM
                    venta 
                WHERE
                    venta.estado = 1 
                    AND DATE( venta.fecha ) BETWEEN 
                 ? AND ? 
                GROUP BY
                    venta.fecha 
                ORDER BY
                venta.fecha DESC";
            $query = $c->prepare($sql);
            $query->bindParam(1, $fecha_inicio);
            $query->bindParam(2, $fecha_fin);
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

    ////
    function ventas_servicio($fecha_inicio, $fecha_fin)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            venta_servicio.fecha,
            SUM( venta_servicio.total ) AS sumsa,
            venta_servicio.estado 
            FROM
                venta_servicio 
            WHERE
                venta_servicio.estado = 1 
                AND DATE( venta_servicio.fecha ) BETWEEN 
            ? AND ? 
            GROUP BY
                venta_servicio.fecha 
            ORDER BY
            venta_servicio.fecha DESC";
            $query = $c->prepare($sql);
            $query->bindParam(1, $fecha_inicio);
            $query->bindParam(2, $fecha_fin);
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

    ////
    function ventas_online($fecha_inicio, $fecha_fin)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            venta_online.fecha,
            SUM( venta_online.total ) AS suma 
            FROM
                venta_online 
            WHERE
                venta_online.estado = 1 AND DATE(venta_online.fecha) BETWEEN ? AND ?
            GROUP BY
                venta_online.fecha 
            ORDER BY
            venta_online.fecha DESC";
            $query = $c->prepare($sql);
            $query->bindParam(1, $fecha_inicio);
            $query->bindParam(2, $fecha_fin);
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

    ////
    function traer_datos_dasboard_admin()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "CALL datadeshboard()";
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

    function eliminar_ofertas_pasadas()
    {
        date_default_timezone_set('America/Guayaquil');
        $fecha = date("Y-m-d");

        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM ofertas where DATE(fecha_fin) <= ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $fecha);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_BOTH);
            if (!empty($result)) {

                foreach ($result as $respuesta) {
                    $sql_a = "DELETE FROM ofertas where id_ofertas = ?";
                    $query_a = $c->prepare($sql_a);
                    $query_a->bindParam(1, $respuesta[0]);
                    if ($query_a->execute()) {

                        $sql_b = "UPDATE producto SET oferta = 0 WHERE id_producto = ?";
                        $query_b = $c->prepare($sql_b);
                        $query_b->bindParam(1, $respuesta[1]);
                        if ($query_b->execute()) {
                            $res = 1; // ok
                        } else {
                            $res = 0; // error en la inserccion
                        }
                    } else {
                        $res = 0;
                    }
                }
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


    /// editar las foto de la pagina web
    function editar_foto_web_1($ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE web SET foto1 = ? WHERE id_web = 1";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $ruta);

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

    function editar_foto_web_2($ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE web SET foto2 = ? WHERE id_web = 1";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $ruta);

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

    function editar_foto_web_3($ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE web SET foto3 = ? WHERE id_web = 1";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $ruta);

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

    function traer_datos_web()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM web WHERE id_web = 1";
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

    function editar_detalle_foto($detalle1, $detalle2, $detalle3)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE web SET detalle1 = ?, detalle2 = ?, detalle3 = ? WHERE id_web = 1";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $detalle1);
            $querya->bindParam(2, $detalle2);
            $querya->bindParam(3, $detalle3);

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
}
