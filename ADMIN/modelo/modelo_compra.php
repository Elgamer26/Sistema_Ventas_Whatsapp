<?php
require_once 'modelo_conexion.php';
class modelo_compra extends modelo_conexion
{

    function listar_proveedor_combo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM proveedor WHERE estado = 1";
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

    function listar_producto_seelct()
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
            INNER JOIN marca ON producto.id_marca = marca.id_marca WHERE producto.eliminado = 1";
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

    function crear_nueva_compra($proveedor, $numero_compra, $comprobante_tipo, $impuesto, $fecha_compra, $txt_totalneto, $txt_impuesto, $txt_a_pagar, $count)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM compra where numero_compra = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $numero_compra);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {
                $sql_a = "INSERT INTO compra (id_proveedor, numero_compra, tipo_doc, iva, fecha, sub_total, sub_iva, total, cantidad) VALUES (?,?,?,?,?,?,?,?,?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $proveedor);
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

    function registrar_detalle_compra(
        $id,
        $arraglo_idpm,
        $arraglo_cantidad,
        $arraglo_precio,
        $arraglo_des,
        $arraglo_sutotal
    ) {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "INSERT INTO detalle_compra (id_compra, id_producto, cantidad, precio, descuento, total) VALUES (?,?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            $querya->bindParam(2, $arraglo_idpm);
            $querya->bindParam(3, $arraglo_cantidad);
            $querya->bindParam(4, $arraglo_precio);
            $querya->bindParam(5, $arraglo_des);
            $querya->bindParam(6, $arraglo_sutotal);

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
                $stock = $stock + $arraglo_cantidad;

                $sql_m = "UPDATE producto SET stock = ?, estado = 'Activo' where id_producto = ?";
                $query_m = $c->prepare($sql_m);
                $query_m->bindParam(1, $stock);
                $query_m->bindParam(2, $arraglo_idpm);
                if ($query_m->execute()) {
                    $res = 1;
                } else {
                    $res = 0; // error de update
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

    function listar_compras()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            compra.id_compra,
            proveedor.razon_social,
            compra.fecha,
            compra.tipo_doc,
            compra.numero_compra,
            compra.iva,
            compra.cantidad,
            compra.estado,
            compra.sub_total,
            compra.total,
            compra.sub_iva 
            FROM
            compra
            INNER JOIN proveedor ON compra.id_proveedor = proveedor.id_proveedor";
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

    function cargar_detalle_compra($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            detalle_compra.id_compra,
            producto.nombre_producto,
            tipo_producto.tipo_producto,
            detalle_compra.cantidad,
            detalle_compra.precio,
            detalle_compra.descuento,
            detalle_compra.total 
            FROM
                detalle_compra
                INNER JOIN producto ON detalle_compra.id_producto = producto.id_producto
                INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto 
            WHERE
            detalle_compra.id_compra = ?";
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

    function anular_compra($id)
    {
        try {
            $res = "";
            $stock = 0;
            $c = modelo_conexion::conexionPDO();

            $sql_c = "SELECT * FROM detalle_compra WHERE id_compra = ?";
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

                    $stock =  $respuesto[7] - $respuesta[3];

                    $sql_p = "UPDATE producto SET stock = ? where id_producto = ?";
                    $query_p = $c->prepare($sql_p);
                    $query_p->bindParam(1, $stock);
                    $query_p->bindParam(2, $respuesta[2]);

                    if ($query_p->execute()) {
                        $sql_d = "UPDATE detalle_compra SET estado = 0 where id_compra = ?";
                        $query_d = $c->prepare($sql_d);
                        $query_d->bindParam(1, $id);
                        $query_d->execute();
                    }
                }
            }

            $sql_F = "UPDATE compra SET estado = 0 WHERE id_compra = ?";
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
}