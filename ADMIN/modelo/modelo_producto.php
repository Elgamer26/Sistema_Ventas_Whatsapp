<?php
require_once 'modelo_conexion.php';
class modelo_producto extends modelo_conexion
{

    function registrar_marca($nombre)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM marca where marca = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {

                $sql_a = "INSERT INTO marca (marca) VALUES (?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);

                if ($querya->execute()) {
                    $res = 1;
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

    function listar_marca()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM marca";
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

    function estado_marca($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();

            $sql_a = "UPDATE marca SET estado = ? WHERE id_marca = ?";
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

    function editar_marca($nombre, $id)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM marca where marca = ? AND id_marca != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {

                $sql_a = "UPDATE marca SET marca = ? WHERE id_marca = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $id);

                if ($querya->execute()) {
                    $res = 1;
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

    function registrar_tipo($nombre)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM tipo_producto where tipo_producto = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {

                $sql_a = "INSERT INTO tipo_producto (tipo_producto) VALUES (?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);

                if ($querya->execute()) {
                    $res = 1;
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

    function listar_tipo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM tipo_producto";
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

    function estado_tipo($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();

            $sql_a = "UPDATE tipo_producto SET estado = ? WHERE id_tipo_produto = ?";
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

    function editar_tipo($nombre, $id)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM tipo_producto where tipo_producto = ? AND id_tipo_produto != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {

                $sql_a = "UPDATE tipo_producto SET tipo_producto = ? WHERE id_tipo_produto = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $id);

                if ($querya->execute()) {
                    $res = 1;
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

    function listar_marca_combo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM marca WHERE estado = 1";
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

    function listar_tipo_comobo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM tipo_producto WHERE estado = 1";
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

    function registra_producto($codigos, $nombres, $marca, $tipo, $precio_venta, $decripcion, $ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM producto where codigo = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $codigos);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {
                $sql_b = "SELECT * FROM producto where nombre_producto = ?";
                $query_b = $c->prepare($sql_b);
                $query_b->bindParam(1, $nombres);
                $query_b->execute();
                $data_b = $query_b->fetch(PDO::FETCH_ASSOC);

                if (empty($data_b)) {
                    $sql_a = "INSERT INTO producto (codigo, nombre_producto, id_marca, id_tipo_producto, precio_venta, descripcion, foto, estado) VALUES (?,?,?,?,?,?,?,'Activo')";
                    $querya = $c->prepare($sql_a);
                    $querya->bindParam(1, $codigos);
                    $querya->bindParam(2, $nombres);
                    $querya->bindParam(3, $marca);
                    $querya->bindParam(4, $tipo);
                    $querya->bindParam(5, $precio_venta);
                    $querya->bindParam(6, $decripcion);
                    $querya->bindParam(7, $ruta);

                    if ($querya->execute()) {
                        $res = 1;
                    } else {
                        $res = 0;
                    }
                } else {
                    $res = 3;
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

    function listar_prodcuto()
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
            INNER JOIN marca ON producto.id_marca = marca.id_marca";
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

    function editar_foto_producto($id, $ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE producto SET foto = ? WHERE id_producto = ?";
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

    function estado_producto($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();

            $sql_a = "UPDATE producto SET eliminado = ? WHERE id_producto = ?";
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

    function editar_producto($id, $codigos, $nombres, $marca, $tipo, $precio_venta, $decripcion)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM producto where codigo = ? AND id_producto != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $codigos);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {
                $sql_b = "SELECT * FROM producto where nombre_producto = ? AND id_producto != ?";
                $query_b = $c->prepare($sql_b);
                $query_b->bindParam(1, $nombres);
                $query_b->bindParam(2, $id);
                $query_b->execute();
                $data_b = $query_b->fetch(PDO::FETCH_ASSOC);

                if (empty($data_b)) {
                    $sql_a = "UPDATE producto SET codigo = ?, nombre_producto = ?, id_marca = ?, id_tipo_producto = ?, precio_venta = ?, descripcion = ? WHERE id_producto = ?";
                    $querya = $c->prepare($sql_a);
                    $querya->bindParam(1, $codigos);
                    $querya->bindParam(2, $nombres);
                    $querya->bindParam(3, $marca);
                    $querya->bindParam(4, $tipo);
                    $querya->bindParam(5, $precio_venta);
                    $querya->bindParam(6, $decripcion);
                    $querya->bindParam(7, $id);

                    if ($querya->execute()) {
                        $res = 1;
                    } else {
                        $res = 0;
                    }
                } else {
                    $res = 3;
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

    function registrar_servicio($nombre, $precio)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM servicio where servicio = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {

                $sql_a = "INSERT INTO servicio (servicio, precio) VALUES (?,?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $precio);

                if ($querya->execute()) {
                    $res = 1;
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

    function listar_servicios()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            *
            FROM
            servicio";
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

    function estado_servicio($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();

            $sql_a = "UPDATE servicio SET estado = ? WHERE id_servicio = ?";
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

    function editarr_servicio($id, $nombre, $precio)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM servicio where servicio = ? AND id_servicio != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {

                $sql_a = "UPDATE servicio SET servicio = ?, precio = ? WHERE id_servicio = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $precio);
                $querya->bindParam(3, $id);

                if ($querya->execute()) {
                    $res = 1;
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


}
