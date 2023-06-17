<?php
require_once 'modelo_conexion.php';
class modelo_venta extends modelo_conexion
{

    function listar_cliente_combo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            cliente.id_cliente,
            CONCAT_WS( ' ', 'Cliente: ', cliente.nombres, cliente.apellidos, ' - Cedula: ', cliente.cedula, ' - Correo: ', cliente.correo ) AS cliente 
            FROM
            cliente WHERE cliente.estado = 1";
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

    function listar_servicio_combo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            *
            FROM
            servicio WHERE estado = 1";
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

    function traer_precio_servicio($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            precio
            FROM
            servicio WHERE id_servicio = ?";

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

    function registrar_servicio_venta($cliente, $numero_compra, $comprobante_tipo, $impuesto, $fecha_compra, $txt_totalneto, $txt_impuesto, $txt_a_pagar, $count)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM venta_servicio where numero_compra = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $numero_compra);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {
                $sql_a = "INSERT INTO venta_servicio (id_cliente, numero_compra, tipo_doc, iva, fecha, sub_total, sub_iva, total, cantidad) VALUES (?,?,?,?,?,?,?,?,?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $cliente);
                $querya->bindParam(2, $numero_compra);
                $querya->bindParam(3, $comprobante_tipo);
                $querya->bindParam(4, $impuesto);
                $querya->bindParam(5, $fecha_compra);
                $querya->bindParam(6, $txt_totalneto);
                $querya->bindParam(7, $txt_impuesto);
                $querya->bindParam(8, $txt_a_pagar);
                $querya->bindParam(9, $count);

                if ($querya->execute()) {
                    $res = $c->lastInsertId();
                } else {
                    $res = 0;
                }
            } else {
                $res = 2;
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

    function registrar_detalle_venta_servicio($id, $arraglo_idpm, $arraglo_cantidad, $arraglo_precio, $arraglo_des, $arraglo_sutotal)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "INSERT INTO detalle_venta_servicio (id_venta_servicio, id_servicio, cantidad, precio, descuento, total) VALUES (?,?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            $querya->bindParam(2, $arraglo_idpm);
            $querya->bindParam(3, $arraglo_cantidad);
            $querya->bindParam(4, $arraglo_precio);
            $querya->bindParam(5, $arraglo_des);
            $querya->bindParam(6, $arraglo_sutotal);

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

    function listar_venta_servicios()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            venta_servicio.id_venta_servico,
            CONCAT_WS( ' ', cliente.nombres, cliente.apellidos ) AS cliente,
            venta_servicio.numero_compra,
            venta_servicio.tipo_doc,
            venta_servicio.iva,
            venta_servicio.fecha,
            venta_servicio.sub_total,
            venta_servicio.sub_iva,
            venta_servicio.total,
            venta_servicio.cantidad,
            venta_servicio.estado 
            FROM
            venta_servicio
            INNER JOIN cliente ON venta_servicio.id_cliente = cliente.id_cliente";
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

    function anular_venta_servicio($id)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE venta_servicio SET estado = 0 WHERE id_venta_servico = ?";
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

    function cargar_detalle_venta_servicios($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            detalle_venta_servicio.id_venta_servicio,
            servicio.servicio,
            detalle_venta_servicio.cantidad,
            detalle_venta_servicio.precio,
            detalle_venta_servicio.descuento,
            detalle_venta_servicio.total 
            FROM
            detalle_venta_servicio
            INNER JOIN servicio ON detalle_venta_servicio.id_servicio = servicio.id_servicio 
            WHERE
            detalle_venta_servicio.id_venta_servicio = ?";
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

    function listar_producto_selecionar()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            producto.id_producto,
            producto.codigo,
            producto.nombre_producto,
            producto.id_tipo_producto,
            tipo_producto.tipo_producto,
            producto.id_marca,
            marca.marca,
            producto.precio_venta,
            producto.foto,
            producto.stock,
            producto.estado,
            producto.eliminado,
            producto.descripcion,
            producto.oferta 
            FROM
            producto
            INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
            INNER JOIN marca ON producto.id_marca = marca.id_marca WHERE producto.eliminado = 1 AND producto.stock IS NOT NULL AND producto.stock > 0";
            $query = $c->prepare($sql);
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

    function listar_producto_oferta_selecionar()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            producto.id_producto,
            producto.codigo,
            producto.nombre_producto,
            producto.id_tipo_producto,
            tipo_producto.tipo_producto,
            producto.id_marca,
            marca.marca,
            producto.precio_venta,
            producto.stock,
            producto.oferta,
            ofertas.fecha_fin,
            ofertas.tipo_oferta,
            ofertas.descuento 
            FROM
                producto
                INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
                INNER JOIN marca ON producto.id_marca = marca.id_marca
                INNER JOIN ofertas ON producto.id_producto = ofertas.id_producto 
            WHERE
            producto.eliminado = 1 
            AND producto.stock IS NOT NULL AND producto.stock > 0";
            $query = $c->prepare($sql);
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

    function registrar_producto_venta($cliente, $numero_compra, $comprobante_tipo, $impuesto, $fecha_compra, $txt_totalneto, $txt_impuesto, $txt_a_pagar, $count)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM venta where numero_compra = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $numero_compra);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {
                $sql_a = "INSERT INTO venta (id_cliente, numero_compra, tipo_doc, iva, fecha, sub_total, sub_iva, total, cantidad) VALUES (?,?,?,?,?,?,?,?,?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $cliente);
                $querya->bindParam(2, $numero_compra);
                $querya->bindParam(3, $comprobante_tipo);
                $querya->bindParam(4, $impuesto);
                $querya->bindParam(5, $fecha_compra);
                $querya->bindParam(6, $txt_totalneto);
                $querya->bindParam(7, $txt_impuesto);
                $querya->bindParam(8, $txt_a_pagar);
                $querya->bindParam(9, $count);

                if ($querya->execute()) {
                    $res = $c->lastInsertId();
                } else {
                    $res = 0;
                }
            } else {
                $res = 2;
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

    function registrar_detalle_venta_producto_a($id, $arraglo_idpm, $arraglo_cantidad, $arraglo_sale, $arraglo_precio, $arraglo_oferta, $arraglo_des_oferta, $arraglo_descuento, $arraglo_sutotal)
    {
        try {
            $res = "";
            $stock = 0;
            $stock_e = 0;
            $c = modelo_conexion::conexionPDO();
            $sql_a = "INSERT INTO detalle_vent_pro (id_venta, id_producto, cantidad, sale, precio, tipo_oferta, des_pferta, descuento, total) VALUES (?,?,?,?,?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            $querya->bindParam(2, $arraglo_idpm);
            $querya->bindParam(3, $arraglo_cantidad);
            $querya->bindParam(4, $arraglo_sale);
            $querya->bindParam(5, $arraglo_precio);
            $querya->bindParam(6, $arraglo_oferta);
            $querya->bindParam(7, $arraglo_des_oferta);
            $querya->bindParam(8, $arraglo_descuento);
            $querya->bindParam(9, $arraglo_sutotal);

            if ($querya->execute()) {

                $sql_p = "SELECT stock FROM producto where id_producto = ?";
                $query_p = $c->prepare($sql_p);
                $query_p->bindParam(1, $arraglo_idpm);
                $query_p->execute();
                $data = $query_p->fetch(PDO::FETCH_BOTH);
                $arreglo = array();
                foreach ($data as $respuesta) {
                    $arreglo[] = $respuesta;
                }

                $stock = $arreglo[0];
                if ($stock == "" || $stock == 0) {
                    $stock = 0;
                }
                $stock = $stock - $arraglo_sale;

                $sql_m = "UPDATE producto SET stock = ? where id_producto = ?";
                $query_m = $c->prepare($sql_m);
                $query_m->bindParam(1, $stock);
                $query_m->bindParam(2, $arraglo_idpm);

                if ($query_m->execute()) {

                    $sql_e = "SELECT stock FROM producto where id_producto = ?";
                    $query_e = $c->prepare($sql_e);
                    $query_e->bindParam(1, $arraglo_idpm);
                    $query_e->execute();
                    $data_e = $query_e->fetch(PDO::FETCH_BOTH);
                    $arreglo_e = array();
                    foreach ($data_e as $respuesta_e) {
                        $arreglo_e[] = $respuesta_e;
                    }

                    $stock_e = $arreglo_e[0];
                    if ($stock_e <= 0) {
                        $sql_ee = "UPDATE producto SET estado = 'Agotado', stock = 0 where id_producto = ?";
                        $query_ee = $c->prepare($sql_ee);
                        $query_ee->bindParam(1, $arraglo_idpm);
                        if ($query_ee->execute()) {
                            $res = 1;
                        } else {
                            $res = 0;
                        }
                    }
                    $res = 1; // registro del detalle es exitoso
                } else {
                    $res = 2; // error de update
                }
            } else {
                $res = 0; // error en la inserccion detalle
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

    function listar_ventas_productos()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            venta.id_venta,
            CONCAT_WS( ' ', cliente.nombres, cliente.apellidos ) AS cliente,
            cliente.cedula,
            cliente.correo,
            cliente.direcion,
            venta.fecha,
            venta.tipo_doc,
            venta.numero_compra,
            venta.iva,
            venta.sub_total,
            venta.sub_iva,
            venta.total,
            venta.cantidad,
            venta.estado 
            FROM
            venta
            INNER JOIN cliente ON venta.id_cliente = cliente.id_cliente ";
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

    function cargar_detalle_venta_producto($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            detalle_vent_pro.id_venta,
            producto.nombre_producto,
            detalle_vent_pro.cantidad,
            detalle_vent_pro.sale,
            detalle_vent_pro.precio,
            detalle_vent_pro.tipo_oferta,
            detalle_vent_pro.des_pferta,
            detalle_vent_pro.descuento,
            detalle_vent_pro.total,
            detalle_vent_pro.estado 
            FROM
                detalle_vent_pro
                INNER JOIN producto ON detalle_vent_pro.id_producto = producto.id_producto 
            WHERE
            detalle_vent_pro.id_venta = ?";
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

    function anular_venta_producto($id)
    {
        try {
            $res = "";
            $stock = 0;
            $c = modelo_conexion::conexionPDO();

            $sql_c = "SELECT * FROM detalle_vent_pro WHERE id_venta = ?";
            $query_c = $c->prepare($sql_c);
            $query_c->bindParam(1, $id);
            $query_c->execute();
            $data = $query_c->fetchAll(PDO::FETCH_BOTH);
            foreach ($data as $respuesta) {

                $sql_a = "SELECT * FROM producto WHERE id_producto = ?";
                $query_a = $c->prepare($sql_a);
                $query_a->bindParam(1, $respuesta[2]);
                $query_a->execute();
                $dato = $query_a->fetchAll(PDO::FETCH_BOTH);
                foreach ($dato as $respuesto) {

                    $stock =  $respuesto[7] + $respuesta[3];

                    $sql_p = "UPDATE producto SET stock = ?, estado = 'Activo' where id_producto = ?";
                    $query_p = $c->prepare($sql_p);
                    $query_p->bindParam(1, $stock);
                    $query_p->bindParam(2, $respuesta[2]);

                    if ($query_p->execute()) {
                        $sql_d = "UPDATE detalle_vent_pro SET estado = 0 where id_venta = ?";
                        $query_d = $c->prepare($sql_d);
                        $query_d->bindParam(1, $id);
                        $query_d->execute();
                    }
                }
            }

            $sql_F = "UPDATE venta SET estado = 0 WHERE id_venta = ?";
            $query_F = $c->prepare($sql_F);
            $query_F->bindParam(1, $id);
            if ($query_F->execute()) {
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

    function listar_ventas_onlinee_productos()
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
            venta_online.pago,
            venta_online.fecha_envio,
            venta_online.cod_envio,
            venta_online.estado_envio 
            FROM
                venta_online
                INNER JOIN cliente ON venta_online.cliente_id = cliente.id_cliente 
            ORDER BY
            venta_online.id_venta_online_trans DESC";
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

    function cargar_detalle_venta_onlinee_producto($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            detalle_venta_online_transferencia.id_venta_online,
            producto.nombre_producto,
            detalle_venta_online_transferencia.cantidad,
            detalle_venta_online_transferencia.precio,
            detalle_venta_online_transferencia.descuento_oferta,
            detalle_venta_online_transferencia.tipo_oferta,
            detalle_venta_online_transferencia.subtotal,
            detalle_venta_online_transferencia.estado 
            FROM
                detalle_venta_online_transferencia
                INNER JOIN producto ON detalle_venta_online_transferencia.producto_id = producto.id_producto
                INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto 
            WHERE
            detalle_venta_online_transferencia.id_venta_online = ?";
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

    function anular_venta_online_producto($id)
    {
        try {
            $res = "";
            $stock = 0;
            $c = modelo_conexion::conexionPDO();

            $sql_c = "SELECT * FROM detalle_venta_online_transferencia WHERE id_venta_online = ?";
            $query_c = $c->prepare($sql_c);
            $query_c->bindParam(1, $id);
            $query_c->execute();
            $data = $query_c->fetchAll(PDO::FETCH_BOTH);
            foreach ($data as $respuesta) {

                $sql_a = "SELECT * FROM producto WHERE id_producto = ?";
                $query_a = $c->prepare($sql_a);
                $query_a->bindParam(1, $respuesta[2]);
                $query_a->execute();
                $dato = $query_a->fetchAll(PDO::FETCH_BOTH);
                foreach ($dato as $respuesto) {

                    $stock =  $respuesto[7] + $respuesta[3];

                    $sql_p = "UPDATE producto SET stock = ?, estado = 'Activo' where id_producto = ?";
                    $query_p = $c->prepare($sql_p);
                    $query_p->bindParam(1, $stock);
                    $query_p->bindParam(2, $respuesta[2]);

                    if ($query_p->execute()) {
                        $sql_d = "UPDATE detalle_venta_online_transferencia SET estado = 0 where id_venta_online = ?";
                        $query_d = $c->prepare($sql_d);
                        $query_d->bindParam(1, $id);
                        $query_d->execute();
                    }
                }
            }

            $sql_F = "UPDATE venta_online SET estado = 0 WHERE id_venta_online_trans = ?";
            $query_F = $c->prepare($sql_F);
            $query_F->bindParam(1, $id);
            if ($query_F->execute()) {
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

    function lista_transferencia_bancaria()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            transferencia.transferencia_id,
            transferencia.id_venta_online,
            venta_online.numero_compra,
            CONCAT_WS( ' ', cliente.nombres, cliente.apellidos ) AS cliente,
            banco.nombre_banco,
            transferencia.fecha,
            transferencia.monto,
            transferencia.foto,
            transferencia.fecha_deposito,
            transferencia.fecha_proceso,
            transferencia.estado,
            transferencia.codigo
            FROM
                transferencia
                INNER JOIN venta_online ON transferencia.id_venta_online = venta_online.id_venta_online_trans
                INNER JOIN banco ON transferencia.tipo_banco = banco.id_banco
                INNER JOIN cliente ON venta_online.cliente_id = cliente.id_cliente 
            ORDER BY
            transferencia.transferencia_id DESC";
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

    function procesar_venta_clinte($id)
    {
        try {

            // esta es la fecha correcta
            date_default_timezone_set('America/Guayaquil');
            $fecha_proceso = date('Y-m-d');
            $res = "";
            $c = modelo_conexion::conexionPDO();

            $sql_c = "UPDATE venta_online SET pago = 2 WHERE id_venta_online_trans = ?";
            $query_c = $c->prepare($sql_c);
            $query_c->bindParam(1, $id);
            if ($query_c->execute()) {

                $sql_p = "UPDATE transferencia SET estado = 2, fecha_proceso = ? where id_venta_online = ?";
                $query_p = $c->prepare($sql_p);
                $query_p->bindParam(1, $fecha_proceso);
                $query_p->bindParam(2, $id);
                if ($query_p->execute()) {
                    $res = 1;
                } else {
                    $res = 0;
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

    function lista_efetivo_clinte()
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
        efectivo.detalle
        FROM
          efectivo
          INNER JOIN venta_online ON efectivo.id_venta_online = venta_online.id_venta_online_trans
          INNER JOIN cliente ON venta_online.cliente_id = cliente.id_cliente
        ORDER BY
        efectivo.efectivo_id DESC";
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
}
