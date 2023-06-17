<?php
require_once 'modelo_conexion.php';
class modelo_usuario extends modelo_conexion
{
    function verifcar_usuario($usuario, $passs)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            usuario.id_usuario,
            usuario.usuario,
            usuario.`password`,
            usuario.foto,
            usuario.nombres,
            usuario.id_tipo_usuario,
            tipo_usuario.tipo_usuario,
            usuario.estado 
            FROM
                usuario
                INNER JOIN tipo_usuario ON usuario.id_tipo_usuario = tipo_usuario.id_tipo_usuario 
            WHERE
                BINARY usuario.`password` = ? 
                AND BINARY usuario.usuario = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $passs);
            $query->bindParam(2, $usuario);
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

    function crear_rol($nombre)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM tipo_usuario where tipo_usuario = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nomber);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_BOTH);

            if (empty($data)) {
                $sql_a = "INSERT INTO tipo_usuario (tipo_usuario) VALUES (?)";
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

    function listar_roles()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM tipo_usuario";
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

    function estado_rol($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE tipo_usuario SET estado = ? WHERE id_tipo_usuario = ?";
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

    function editar_rol($nombre, $id)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM tipo_usuario where tipo_usuario = ? AND id_tipo_usuario != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nomber);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_BOTH);

            if (empty($data)) {
                $sql_a = "UPDATE tipo_usuario SET tipo_usuario = ? WHERE id_tipo_usuario = ?";
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

    //////////////////////
    /////////////////usuarios
    function listar_tipo_rol_seelct()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM tipo_usuario WHERE estado = 1";
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

    function registra_usuario($nombre, $usuario, $password, $apellidos, $tipo_rol_usu, $numero_docu, $ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM usuario where binary usuario = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {

                $sql_r = "SELECT * FROM repartidor where binary usuario = ?";
                $query_r = $c->prepare($sql_r);
                $query_r->bindParam(1, $usuario);
                $query_r->execute();
                $data_r = $query_r->fetch(PDO::FETCH_ASSOC);

                if (empty($data_r)) {

                    $sql_b = "SELECT * FROM usuario where nombres = ? AND apellidos = ?";
                    $query_b = $c->prepare($sql_b);
                    $query_b->bindParam(1, $nombre);
                    $query_b->bindParam(2, $apellidos);
                    $query_b->execute();
                    $data_b = $query_b->fetch(PDO::FETCH_ASSOC);

                    if (empty($data_b)) {

                        $sql_a = "INSERT INTO usuario (nombres, apellidos, usuario, password, foto, id_tipo_usuario, documento) VALUES (?,?,?,?,?,?,?)";
                        $querya = $c->prepare($sql_a);
                        $querya->bindParam(1, $nombre);
                        $querya->bindParam(2, $apellidos);
                        $querya->bindParam(3, $usuario);
                        $querya->bindParam(4, $password);
                        $querya->bindParam(5, $ruta);
                        $querya->bindParam(6, $tipo_rol_usu);
                        $querya->bindParam(7, $numero_docu);

                        if ($querya->execute()) {
                            $res = $c->lastInsertId();
                        } else {
                            $res = 'a';
                        }
                    } else {
                        $res = 'c';
                    }
                } else {
                    $res = 'b';
                }
            } else {
                $res = 'b';
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

    function crear_permisos_usuario(
        $id,
        string $usuario,
        string $clientes,
        string $proveedor,
        string $datos_empresa,
        string $banco,
        string $tipo_servicio,
        string $productos,
        string $compras,
        string $facturacion,
        string $calificacion,
        string $ventas_online,
        string $tipos_pagos,
        string $envios,
        string $registro_promo,
        string $promo_vigente,
        string $reportes
    ) {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "INSERT INTO permisos (usuario_id, usuario, cliente, proveedor, datos_empresa, banco, tipo_servicio, producto, compras, facturacion, calificacion, ventas_online, tipos_pagos, envios, registro_promo, promo_vigentes, reportes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            $querya->bindParam(2, $usuario);
            $querya->bindParam(3, $clientes);
            $querya->bindParam(4, $proveedor);
            $querya->bindParam(5, $datos_empresa);
            $querya->bindParam(6, $banco);
            $querya->bindParam(7, $tipo_servicio);
            $querya->bindParam(8, $productos);
            $querya->bindParam(9, $compras);
            $querya->bindParam(10, $facturacion);
            $querya->bindParam(11, $calificacion);
            $querya->bindParam(12, $ventas_online);
            $querya->bindParam(13, $tipos_pagos);
            $querya->bindParam(14, $envios);
            $querya->bindParam(15, $registro_promo);
            $querya->bindParam(16, $promo_vigente);
            $querya->bindParam(17, $reportes);

            if ($querya->execute()) {
                $res = 1; // SE INSERT CORRECTAMENTE
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

    function editar_permisos_usuario(
        $id_permiso,
        $id_usu,
        string $usuario,
        string $clientes,
        string $proveedor,
        string $datos_empresa,
        string $banco,
        string $tipo_servicio,
        string $productos,
        string $compras,
        string $facturacion,
        string $calificacion,
        string $ventas_online,
        string $tipos_pagos,
        string $envios,
        string $registro_promo,
        string $promo_vigente,
        string $reportes
    ) {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE permisos SET usuario = ?, cliente = ?, proveedor = ?, datos_empresa = ?, banco = ?, tipo_servicio = ?, producto = ?, compras = ?, facturacion = ?, calificacion = ?, ventas_online = ?, tipos_pagos = ?, envios = ?, registro_promo = ?, promo_vigentes = ?, reportes = ? WHERE usuario_id = ? AND permisos_id = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $usuario);
            $querya->bindParam(2, $clientes);
            $querya->bindParam(3, $proveedor);
            $querya->bindParam(4, $datos_empresa);
            $querya->bindParam(5, $banco);
            $querya->bindParam(6, $tipo_servicio);
            $querya->bindParam(7, $productos);
            $querya->bindParam(8, $compras);
            $querya->bindParam(9, $facturacion);
            $querya->bindParam(10, $calificacion);
            $querya->bindParam(11, $ventas_online);
            $querya->bindParam(12, $tipos_pagos);
            $querya->bindParam(13, $envios);
            $querya->bindParam(14, $registro_promo);
            $querya->bindParam(15, $promo_vigente);
            $querya->bindParam(16, $reportes);
            $querya->bindParam(17, $id_usu);
            $querya->bindParam(18, $id_permiso);

            if ($querya->execute()) {
                $res = 1; // SE INSERT CORRECTAMENTE
            } else {
                $res = 0; // FALLO EN LA MATRIX
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

    function obtener_permisos($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM permisos WHERE usuario_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
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

    function listra_usuario()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            usuario.id_usuario, 
            usuario.usuario, 
            usuario.`password`, 
            usuario.foto, 
            usuario.nombres, 
            usuario.apellidos, 
            usuario.documento, 
            usuario.id_tipo_usuario, 
            tipo_usuario.tipo_usuario, 
            usuario.estado
            FROM
            usuario
            INNER JOIN
            tipo_usuario
            ON 
            usuario.id_tipo_usuario = tipo_usuario.id_tipo_usuario";
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

    function estado_usuario($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE usuario set estado = ? WHERE id_usuario = ?";
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

    function editar_usuario($id, $nombre, $usuario, $apellidos, $tipo_rol_usu, $numero_docu)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM usuario where binary usuario = ? AND id_usuario != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {

                $sql_b = "SELECT * FROM usuario where nombres = ? AND apellidos = ? AND id_usuario != ?";
                $query_b = $c->prepare($sql_b);
                $query_b->bindParam(1, $nombre);
                $query_b->bindParam(2, $apellidos);
                $query_b->bindParam(3, $id);
                $query_b->execute();
                $data_b = $query_b->fetch(PDO::FETCH_ASSOC);

                if (empty($data_b)) {

                    $sql_a = "UPDATE usuario SET nombres = ?, apellidos = ?, usuario = ?, id_tipo_usuario = ?, documento = ? WHERE id_usuario = ?";
                    $querya = $c->prepare($sql_a);
                    $querya->bindParam(1, $nombre);
                    $querya->bindParam(2, $apellidos);
                    $querya->bindParam(3, $usuario);
                    $querya->bindParam(4, $tipo_rol_usu);
                    $querya->bindParam(5, $numero_docu);
                    $querya->bindParam(6, $id);

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

    function editar_password($id, $nueva)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "UPDATE usuario SET password = ? WHERE id_usuario = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nueva);
            $query->bindParam(2, $id);
            if ($query->execute()) {
                return 1;
            } else {
                return 0;
            }
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function listar_banco()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM banco";
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

    function registrar_banco($nombre)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM banco where nombre_banco = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {
                $sql_a = "INSERT INTO banco (nombre_banco) VALUES (?)";
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

    function estado_banco($id, $dato)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE banco set estado = ? WHERE id_banco = ?";
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

    function editar_banco($nombre, $id)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM banco where nombre_banco = ? AND id_banco != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $id);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($data)) {
                $sql_a = "UPDATE banco SET nombre_banco = ? WHERE id_banco = ?";
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

    function obtener_pemisos($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT * FROM permisos WHERE usuario_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
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

    function traer_usuario_perfil($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            usuario.id_usuario,
            usuario.usuario,
            usuario.`password`,
            usuario.foto,
            usuario.nombres,
            usuario.apellidos,
            usuario.documento,
            tipo_usuario.tipo_usuario 
            FROM
                usuario
                INNER JOIN tipo_usuario ON usuario.id_tipo_usuario = tipo_usuario.id_tipo_usuario 
            WHERE
            usuario.id_usuario = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
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

    function editar_foto_usuarioo($id, $ruta)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE usuario SET foto = ? WHERE id_usuario = ?";
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
}
