<?php
require_once 'modelo_conexion.php';
class modelo_promocion extends modelo_conexion
{

    function listar_productos_combo()
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT
            producto.id_producto,
            CONCAT_WS( ' ', ' Codigo: ', producto.codigo, ' - Nombre ', producto.nombre_producto, ' - Tipo: ', tipo_producto.tipo_producto, ' - Marca: ', marca.marca ) AS producto,
            producto.precio_venta,
            producto.oferta,
            producto.eliminado,
            producto.estado 
            FROM
                producto
                INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
                INNER JOIN marca ON producto.id_marca = marca.id_marca 
            WHERE
            producto.oferta = 0 
            AND producto.eliminado = 1 AND producto.stock IS NOT NULL";
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

    function registra_oofertaa($id, $fecha_inicio, $fecha_fin, $tipo_promo, $descuento)
    {
        try {
            $res = "";
            $iddd = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "INSERT INTO ofertas (id_producto, fecha_inicio, fecha_fin, tipo_oferta, descuento) VALUES (?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            $querya->bindParam(2, $fecha_inicio);
            $querya->bindParam(3, $fecha_fin);
            $querya->bindParam(4, $tipo_promo);
            $querya->bindParam(5, $descuento);

            if ($querya->execute()) {
                $iddd = $c->lastInsertId();

                $sql_b = "UPDATE producto SET oferta = 1 WHERE id_producto = ?";
                $queryb = $c->prepare($sql_b);
                $queryb->bindParam(1, $id);

                if ($queryb->execute()) {
                    $res = $iddd;
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

    // paguinador
    function paguinar_ofertas()
    {
        try {
            $paginaactual = htmlspecialchars($_POST["partida"], ENT_QUOTES, 'UTF-8');

            $c = modelo_conexion::conexionPDO();
            if (!empty($_POST['valor'])) {
                $datos = $_POST['valor'];
                $sql = "SELECT
                COUNT(*) 
                FROM
                    ofertas
                    INNER JOIN producto ON ofertas.id_producto = producto.id_producto
                    INNER JOIN marca ON producto.id_marca = marca.id_marca
                    INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto 
                WHERE
                producto.eliminado = 1 
                AND producto.codigo LIKE '%" . $datos . "%' 
                OR producto.nombre_producto LIKE '%" . $datos . "%'";
            } else {
                $sql = "SELECT
                COUNT(*) 
                FROM
                ofertas
                INNER JOIN producto ON ofertas.id_producto = producto.id_producto
                INNER JOIN marca ON producto.id_marca = marca.id_marca
                INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
                WHERE producto.eliminado = 1  ";
            }
            $query = $c->prepare($sql);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_BOTH);
            $arreglo = array();
            //
            foreach ($data as $respuesta) {
                $arreglo[] = $respuesta;
            }
            //
            $numlotes = 12;
            $nropaguinas = ceil($arreglo[0] / $numlotes);
            $lista = "";
            $tabla = "";
            //
            if ($paginaactual > 1) {
                $lista = $lista . ' <li class="page-item">
                                        <a class="page-link" href="javascript:pagination(' . ($paginaactual - 1) . ');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                    </li>';
            }
            //
            for ($i = 1; $i <= $nropaguinas; $i++) {
                if ($i == $paginaactual) {
                    $lista = $lista . '<li class="page-item active"><a class="page-link" href="javascript:pagination(' . ($i) . ');">' . $i . '</a></li>';
                } else {
                    $lista = $lista . '<li class="page-item"><a class="page-link" href="javascript:pagination(' . ($i) . ');">' . $i . '</a></li>';
                }
            }
            //
            if ($paginaactual < $nropaguinas) {
                $lista = $lista . ' <li class="page-item">
                                        <a class="page-link" href="javascript:pagination(' . ($paginaactual + 1) . ');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Próximo</span>
                                        </a>
                                    </li>';
            }
            //
            if ($paginaactual <= 1) {
                $limit = 0;
            } else {
                $limit = $numlotes * ($paginaactual - 1);
            }
            //
            if (!empty($_POST['valor'])) {
                $datos = $_POST['valor'];
                $sql_p = "SELECT
                ofertas.id_ofertas,
                producto.codigo,
                producto.nombre_producto,
                tipo_producto.tipo_producto,
                marca.marca,
                producto.precio_venta,
                producto.foto,
                producto.stock,
                producto.estado,
                producto.descripcion,
                ofertas.fecha_inicio,
                ofertas.fecha_fin,
                ofertas.tipo_oferta,
                ofertas.descuento,
                ofertas.id_producto
                FROM
                    ofertas
                    INNER JOIN producto ON ofertas.id_producto = producto.id_producto
                    INNER JOIN marca ON producto.id_marca = marca.id_marca
                    INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto 
                    WHERE
                    producto.eliminado = 1 
                AND producto.codigo LIKE '%" . $datos . "%' 
                OR producto.nombre_producto LIKE '%" . $datos . "%' 
                ORDER BY
                ofertas.id_ofertas LIMIT $limit, $numlotes";
            } else {
                $sql_p = "SELECT
                ofertas.id_ofertas,
                producto.codigo,
                producto.nombre_producto,
                tipo_producto.tipo_producto,
                marca.marca,
                producto.precio_venta,
                producto.foto,
                producto.stock,
                producto.estado,
                producto.descripcion,
                ofertas.fecha_inicio,
                ofertas.fecha_fin,
                ofertas.tipo_oferta,
                ofertas.descuento,
                ofertas.id_producto
                FROM
                    ofertas
                    INNER JOIN producto ON ofertas.id_producto = producto.id_producto
                    INNER JOIN marca ON producto.id_marca = marca.id_marca
                    INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto 
                WHERE
                    producto.eliminado = 1 
                ORDER BY
                ofertas.id_ofertas LIMIT $limit, $numlotes";
            }
            //
            $query_p = $c->prepare($sql_p);
            $query_p->execute();
            $result = $query_p->fetchAll(PDO::FETCH_BOTH);

            foreach ($result as $respuesta) {

                $tabla = $tabla . '<div class="col-lg-3 col-md-4">
                                    <div class="ibox">
                                        <div class="ibox-body text-center">
                                            <div class="m-t-20">
                                                <img class="img-circle" src="../ADMIN/' . $respuesta[6] . '" style="height: 90px;">
                                            </div>
                                            <h6 class="font-strong m-b-5 m-t-5">Código: ' . $respuesta[1] . '</h6>
                                            <h5 class="font-strong m-b-5 m-t-5">' . $respuesta[2] . '</h5>
                                            <div class="text-muted">Tipo: ' . $respuesta[3] . '</div>
                                            <div class="text-muted">Marca: ' . $respuesta[4] . '</div>
                                            <div class="text-muted">Precio: $. ' . $respuesta[5] . '</div>
                                            <div class="text-muted">Stock: ' . $respuesta[7] . '</div>
                                            <div class="text-muted">Estado: ' . $respuesta[8] . '</div>

                                            <div class="text-muted">Fecha inicio: ' . $respuesta[10] . '</div>
                                            <div class="text-muted">Fecha fin: ' . $respuesta[11] . '</div>
                                            <div class="text-muted">Tipo oferta: ' . $respuesta[12] . '</div>
                                            <div class="m-b-20 text-muted">Descuento: ' . $respuesta[13] . '%</div>                                         
                        
                                            <div>
                                            <button title="envio de oferta" class="btn btn-success btn-rounded m-b-5" onclick="enviar_whatsapp(' . $respuesta[0] . ')";><i class="fa fa-whatsapp"></i></button>
                                                <button title="envio de oferta" class="btn btn-primary btn-rounded m-b-5" onclick="enviar_oferta(' . $respuesta[0] . ')";><i class="fa fa-envelope"></i></button>
                                                <button title="eliminar oferta" class="btn btn-danger btn-rounded m-b-5" onclick="eliminar_ofert(' . $respuesta[14] . ')";><i class="fa fa-trash"></i></button>
                                                <button title="editar oferta" class="btn btn-info btn-rounded m-b-5" onclick="editar_ofert(' . $respuesta[0] . ')";><i class="fa fa-edit"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            }

            $array = array(0 => $tabla, 1 => $lista);
            return $array;
            //cerramos la conexion
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }


    function eliminar_oferta($id)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "DELETE FROM ofertas WHERE id_producto = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            if ($querya->execute()) {
                $sql_b = "UPDATE producto SET oferta = 0 WHERE id_producto = ?";
                $queryb = $c->prepare($sql_b);
                $queryb->bindParam(1, $id);
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
            modelo_conexion::cerrar_conexion();
        } catch (Exception $e) {
            modelo_conexion::cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function editar_ofertss($id)
    {
        try {
            $c = modelo_conexion::conexionPDO();
            $sql = "SELECT 
            ofertas.id_ofertas, 
            ofertas.fecha_inicio, 
            ofertas.fecha_fin, 
            ofertas.tipo_oferta, 
            ofertas.descuento
            FROM
            ofertas WHERE ofertas.id_ofertas = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_BOTH);
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

    function editar_ofertaa($id, $fecha_inicio, $fecha_fin, $tipo_promo, $descuento)
    {
        try {
            $res = "";
            $c = modelo_conexion::conexionPDO();
            $sql_a = "UPDATE ofertas SET fecha_inicio = ?, fecha_fin = ?, tipo_oferta = ?, descuento = ? WHERE id_ofertas = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $fecha_inicio);
            $querya->bindParam(2, $fecha_fin);
            $querya->bindParam(3, $tipo_promo);
            $querya->bindParam(4, $descuento);
            $querya->bindParam(5, $id);

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
