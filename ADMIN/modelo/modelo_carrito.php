<?php
// session_start();
require_once 'modelo_conexion.php';
class modelo_carrito extends modelo_conexion
{

  function verifcar_usuario($usuario, $passs)
  {
    try {
      $c = modelo_conexion::conexionPDO();
      $sql = "SELECT
          cliente.id_cliente,
          cliente.nombres, 
          cliente.correo, 
          cliente.estado
        FROM
          cliente
        WHERE
          cliente.correo = ?  AND
          cliente.ppassword = ? ";
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

  // paguinador
  function pagination_carrito()
  {
    try {
      $paginaactual = htmlspecialchars($_POST["partida"], ENT_QUOTES, 'UTF-8');

      $c = modelo_conexion::conexionPDO();
      if (!empty($_POST['valor'])) {
        $datos = $_POST['valor'];
        $sql = "SELECT
                COUNT(*) 
                FROM
                    producto
                    INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
                    INNER JOIN marca ON producto.id_marca = marca.id_marca 
                WHERE
                producto.stock IS NOT NULL 
                AND producto.eliminado = 1 AND producto.oferta = 0
                AND producto.nombre_producto LIKE '%" . $datos . "%'";
      } else {
        $sql = "SELECT
                COUNT(*) 
                FROM
                    producto
                    INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
                    INNER JOIN marca ON producto.id_marca = marca.id_marca 
                WHERE
                producto.stock IS NOT NULL AND producto.oferta = 0
                AND producto.eliminado = 1";
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
                                            <a class="page-link" href="javascript:pagination_carrito(' . ($paginaactual - 1) . ');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Anterior</span>
                                            </a>
                                        </li>';
      }
      //
      for ($i = 1; $i <= $nropaguinas; $i++) {
        if ($i == $paginaactual) {
          $lista = $lista . '<li class="page-item active"><a class="page-link" href="javascript:pagination_carrito(' . ($i) . ');">' . $i . '</a></li>';
        } else {
          $lista = $lista . '<li class="page-item"><a class="page-link" href="javascript:pagination_carrito(' . ($i) . ');">' . $i . '</a></li>';
        }
      }
      //
      if ($paginaactual < $nropaguinas) {
        $lista = $lista . ' <li class="page-item">
                                            <a class="page-link" href="javascript:pagination_carrito(' . ($paginaactual + 1) . ');" aria-label="Next">
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
                producto.id_producto,
                producto.codigo,
                producto.nombre_producto,
                tipo_producto.tipo_producto,
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
                    INNER JOIN marca ON producto.id_marca = marca.id_marca 
                WHERE
                producto.stock IS NOT NULL 
                AND producto.eliminado = 1 AND producto.oferta = 0
                AND producto.nombre_producto LIKE '%" . $datos . "%' 
                    ORDER BY producto.id_producto LIMIT $limit, $numlotes";
      } else {
        $sql_p = "SELECT
                producto.id_producto,
                producto.codigo,
                producto.nombre_producto,
                tipo_producto.tipo_producto,
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
                    INNER JOIN marca ON producto.id_marca = marca.id_marca 
                WHERE
                producto.stock IS NOT NULL 
                AND producto.eliminado = 1 AND producto.oferta = 0
                ORDER BY
                producto.id_producto LIMIT $limit, $numlotes";
      }
      //
      $query_p = $c->prepare($sql_p);
      $query_p->execute();
      $result = $query_p->fetchAll(PDO::FETCH_BOTH);

      foreach ($result as $respuesta) {

        $tabla = $tabla . '      <div class="col-md-3 p-3">
                <div class="product-googles-info googles">
                  <div class="men-pro-item">
                    <div class="men-thumb-item">
                      <img src="../ADMIN/' . $respuesta[6] . '" style="height: 200px;" class="img-fluid" alt="" />
                      <div class="men-cart-pro">
                        <div class="inner-men-cart-pro">
                          <a href="single.php?id=' . $respuesta[0] . '" class="link-product-add-cart">VER DETALLE</a>
                        </div>
                      </div>
                    </div>
                    <div class="item-info-product">
                      <div class="info-product-price">
                        <div class="grid_meta">
                          <div class="product_price">
                            <h4>
                              <a>' . $respuesta[2] . '</a>
                            </h4>
                            <div class="grid-price mt-2">
                              <span class="money">$.' . $respuesta[5] . '</span>
                            </div>

                         </div>
                        </div>
                        <div>';

        if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {
          $tabla = $tabla . ' <button style="margin: 0;" onclick="calificar_producto(' . $respuesta[0] . ');" class="googles-cart">
                          <i class="fas fa-star" style="font-size: 15px; paddin: 5px;"></i>
                             </button>   

                            <button style="margin: 0;" onclick="agregar_producto(' . $respuesta[0] . ', ' . $respuesta[5] . ');" type="submit" class="googles-cart pgoogles-cart">
                              <i class="fas fa-cart-plus"></i>
                            </button> ';
        }

        $tabla = $tabla . '  </div>
                      </div>
                      <div class="clearfix"></div>
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

  function pagination_carrito_oferta()
  {
    try {
      $paginaactual = htmlspecialchars($_POST["partida"], ENT_QUOTES, 'UTF-8');

      $c = modelo_conexion::conexionPDO();
      if (!empty($_POST['valor'])) {
        $datos = $_POST['valor'];
        $sql = "SELECT
                COUNT(*)
                FROM
                    producto
                    INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
                    INNER JOIN marca ON producto.id_marca = marca.id_marca
                    INNER JOIN ofertas ON producto.id_producto = ofertas.id_producto 
                WHERE
                    producto.eliminado = 1 AND producto.nombre_producto LIKE '%" . $datos . "%'";
      } else {
        $sql = "SELECT
                COUNT(*)
                FROM
                    producto
                    INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
                    INNER JOIN marca ON producto.id_marca = marca.id_marca
                    INNER JOIN ofertas ON producto.id_producto = ofertas.id_producto 
                WHERE
                    producto.eliminado = 1";
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
                                            <a class="page-link" href="javascript:pagination_carrito_oferta(' . ($paginaactual - 1) . ');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Anterior</span>
                                            </a>
                                        </li>';
      }
      //
      for ($i = 1; $i <= $nropaguinas; $i++) {
        if ($i == $paginaactual) {
          $lista = $lista . '<li class="page-item active"><a class="page-link" href="javascript:pagination_carrito_oferta(' . ($i) . ');">' . $i . '</a></li>';
        } else {
          $lista = $lista . '<li class="page-item"><a class="page-link" href="javascript:pagination_carrito_oferta(' . ($i) . ');">' . $i . '</a></li>';
        }
      }
      //
      if ($paginaactual < $nropaguinas) {
        $lista = $lista . ' <li class="page-item">
                                            <a class="page-link" href="javascript:pagination_carrito_oferta(' . ($paginaactual + 1) . ');" aria-label="Next">
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
                producto.id_producto,
                producto.codigo,
                producto.nombre_producto,
                tipo_producto.tipo_producto,
                marca.marca,
                producto.precio_venta,
                producto.foto,
                producto.stock,
                producto.estado,
                producto.eliminado,
                producto.descripcion,
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
                producto.eliminado = 1 AND producto.nombre_producto LIKE '%" . $datos . "%' 
                ORDER BY producto.id_producto LIMIT $limit, $numlotes";
      } else {
        $sql_p = "SELECT
                producto.id_producto,
                producto.codigo,
                producto.nombre_producto,
                tipo_producto.tipo_producto,
                marca.marca,
                producto.precio_venta,
                producto.foto,
                producto.stock,
                producto.estado,
                producto.eliminado,
                producto.descripcion,
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
                ORDER BY
                producto.id_producto LIMIT $limit, $numlotes";
      }
      //
      $query_p = $c->prepare($sql_p);
      $query_p->execute();
      $result = $query_p->fetchAll(PDO::FETCH_BOTH);
      $valor = 0;
      $monto = 0;
      $desc = "";

      foreach ($result as $respuesta) {

        if ($respuesta[13] == 'Descuento') {
          $valor = number_format($respuesta[5] * $respuesta[14] / 100, 2);
          $monto =  number_format($respuesta[5] - $valor, 2);
          $desc = $respuesta[14] . "%";
        } else {
          $monto = $respuesta[5];
          $desc = "";
        }

        $tabla = $tabla . '<div class="col-md-3 p-3">
                <div class="product-googles-info googles">
                  <div class="men-pro-item">
                    <div class="men-thumb-item">
                      <img src="../ADMIN/' . $respuesta[6] . '" style="height: 200px;" class="img-fluid" alt="" />
                      <div class="men-cart-pro">
                        <div class="inner-men-cart-pro">
                          <a href="single_oferta.php?id=' . $respuesta[0] . '" class="link-product-add-cart">VER DETALLE</a>
                        </div>
                      </div>
                    </div>
                    <div class="item-info-product">
                      <div class="info-product-price">
                        <div class="grid_meta">
                          <div class="product_price">
                            <h4>
                              <a>' . $respuesta[2] . '</a>
                            </h4>
                            <div>
                              <span class="money"> <del style="font-size: 20px; margin: 0px;">$.' . $respuesta[5] . '</del> </span>
                            </div>
                            <span>Fecha fin: ' . $respuesta[12] . '</span>
                            <div class="grid-price">
                              <span>Tipo oferta: ' . $respuesta[13] . ' ' . $desc . '</span>
                            </div>
                            <span>Precio: $.' . $monto . '</span>
                          </div>
                        </div>
                        <div class="googles single-item hvr-outline-out">';

        if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) {
          $tabla = $tabla . ' <button style="margin: 0;" onclick="calificar_producto(' . $respuesta[0] . ');" class="googles-cart">
                                          <i class="fas fa-star" style="font-size: 15px; paddin: 5px;"></i>
                                             </button>   
                
                                             <button onclick="agregar_producoferta(' . $respuesta[0] . ');" type="submit" class="googles-cart pgoogles-cart">
                                             <i class="fas fa-cart-plus"></i>
                                           </button>';
        }




        $tabla = $tabla . ' </div>
                      </div>
                      <div class="clearfix"></div>
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

  function calificar_sistema($id_cli, $estrella, $comentario)
  {
    try {

      date_default_timezone_set('America/Guayaquil');
      $fecha = date("Y-m-d H:m:s");

      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_a = "INSERT INTO calificacion (id_cliente, calificar, detalle, fecha) VALUES (?,?,?,?)";
      $querya = $c->prepare($sql_a);
      $querya->bindParam(1, $id_cli);
      $querya->bindParam(2, $estrella);
      $querya->bindParam(3, $comentario);
      $querya->bindParam(4, $fecha);

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

  function agregar_producto($id, $precio, $id_cli, $cantidad)
  {
    try {
      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_a = "SELECT * FROM agg_cart where cliente_id = ? AND producto_id = ?";
      $query_a = $c->prepare($sql_a);
      $query_a->bindParam(1, $id_cli);
      $query_a->bindParam(2, $id);
      $query_a->execute();
      $data_a = $query_a->fetch(PDO::FETCH_BOTH);
      if (empty($data_a)) {

        //////////////////// saber si hay stock
        $sql_stock = "SELECT
        producto.stock
        FROM
        producto WHERE producto.id_producto = ?";
        $q_stock_a = $c->prepare($sql_stock); 
        $q_stock_a->bindParam(1, $id);
        $q_stock_a->execute();
        $stock_actual = $q_stock_a->fetch(PDO::FETCH_BOTH); 

        if($cantidad > $stock_actual[0]){
          return $res = "Stock " . $stock_actual[0];
        }

        $sql_c = "INSERT INTO agg_cart (cliente_id, producto_id, precio, cantidad, sale, promocion, tipo_promo, porcentaje, descuento_promo) VALUES (?,?,?,?,?,'No oferta','0','0','0')";
        $query_c = $c->prepare($sql_c);
        $query_c->bindParam(1, $id_cli);
        $query_c->bindParam(2, $id);
        $query_c->bindParam(3, $precio);
        $query_c->bindParam(4, $cantidad);
        $query_c->bindParam(5, $cantidad);
        if ($query_c->execute()) {
          $res = 1; // registro exitoso
        } else {
          $res = 0; // error en la inserccion
        }
      } else {

        $cant = "";
        $cant = $data_a[2] + $cantidad;

        $stock = 0;
        $sql_p = "SELECT stock FROM producto WHERE id_producto = ?";
        $query_p = $c->prepare($sql_p);
        $query_p->bindParam(1, $id);
        $query_p->execute();
        $dato_p = $query_p->fetch(PDO::FETCH_BOTH);
        foreach ($dato_p as $respuesto_p) {
          $stock = $respuesto_p;
        }

        if ($cant > $stock) {
          $res = "Stock " . $stock;
        } else {
          $sql_d = "UPDATE agg_cart SET cantidad = ? WHERE producto_id = ? AND cliente_id = ?";
          $query_d = $c->prepare($sql_d);
          $query_d->bindParam(1, $cant);
          $query_d->bindParam(2, $id);
          $query_d->bindParam(3, $id_cli);
          if ($query_d->execute()) {
            $res = 2; // exito atualizacion
          } else {
            $res = 3; // error en la actualizacion
          }
        }
        $res = $res; // el prodcuto ya fue agregado
      }
      return $res;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (PDOException $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  function mostrar_carrito_compra_detalle($id_cli)
  {
    try {
      $tota = 0;
      $gran_to = 0;

      $sub = 0;
      $iva = 0;
      $pago_toral = 0;
      $tabla = "";

      $c = modelo_conexion::conexionPDO();
      $sql_p = "SELECT
      agg_cart.cliente_id,
      agg_cart.producto_id,
      CONCAT_WS( ' ', producto.nombre_producto, tipo_producto.tipo_producto ) AS producto,
      agg_cart.cantidad,
      producto.precio_venta,
      producto.foto,
      agg_cart.promocion,
      agg_cart.tipo_promo,
      agg_cart.porcentaje,
      agg_cart.descuento_promo,
      agg_cart.precio,
      agg_cart.sale
      FROM
      agg_cart
      INNER JOIN producto ON agg_cart.producto_id = producto.id_producto
      INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto WHERE agg_cart.cliente_id = ? ORDER BY agg_cart.producto_id DESC";
      $query_p = $c->prepare($sql_p);
      $query_p->bindParam(1, $id_cli);
      $query_p->execute();
      $result = $query_p->fetchAll(PDO::FETCH_BOTH);
       
      //////////////////// iva
      $sql_iva = "SELECT
      empresa.iva
      FROM
      empresa WHERE empresa_id = 1";
      $q_iva = $c->prepare($sql_iva); 
      $q_iva->execute();
      $iva_e = $q_iva->fetch(PDO::FETCH_BOTH); 

      foreach ($result as $respuesta) {

        $tota = sprintf('%.2f', $respuesta[3] * $respuesta[10]);
        $gran_to = sprintf('%.2f', $tota - $respuesta[9]);

        $sub = $sub + $gran_to;
        $iva = sprintf('%.2f', $sub * $iva_e[0] / 100);
        $pago_toral = $sub + $iva;

        $tabla = $tabla . '		<tr class="rem1">
							<td class="invert">
              <a onclick="quitar_producto(' . $respuesta[0] . ',' . $respuesta[1] . ')">
								<div class="rem">
									<div class="close1">  </div>
								</div>
              </a>
							</td>
							<td class="invert-image">
								<img src="../ADMIN/' . $respuesta[5] . '" alt=" " class="img-responsive" style="height: 150px;">
							</td>
							<td class="invert">
								<div class="quantity">
									<div class="quantity-select">';
        if ($respuesta[3] > 1) {
          $tabla = $tabla . '<a onclick="dismi_cantidad_prod(' . $respuesta[0] . ',' . $respuesta[1] . ',' . $respuesta[3] . ');"> <div class="entry value-minus"></div></a> ';
        } else {
          $tabla = $tabla . '<div class="entry value-minus"></div> ';
        }
        $tabla = $tabla . '<div class="entry value">
											<span>' . $respuesta[3] . '</span>
										</div>
										<a onclick="aumen_cantidad_prod(' . $respuesta[0] . ',' . $respuesta[1] . ',' . $respuesta[3] . ');"><div class="entry value-plus active"></div></a> 

									</div>
								</div>
							</td>
              <td class="invert">' . $respuesta[11] . ' </td>
							<td class="invert">' . $respuesta[2] . ' </td>
							<td class="invert">$.' . $respuesta[4] . '</td>
							<td class="invert">' . $respuesta[6] . ' </td>
							<td class="invert">' . $respuesta[9] . '</td>';
        $tabla = $tabla . '<td class="invert">$.' . $gran_to . '</td>
						</tr>';
      }
      //    
      $array = array(0 => $tabla, 1 => $sub,  2 => $iva, 3 => $pago_toral);
      return $array;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (Exception $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  function quitar_producto_detalle($id_cli, $id_pro)
  {
    try {
      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_c = "DELETE FROM agg_cart WHERE cliente_id = ? AND producto_id = ?";
      $query_c = $c->prepare($sql_c);
      $query_c->bindParam(1, $id_cli);
      $query_c->bindParam(2, $id_pro);
      if ($query_c->execute()) {
        $res = 1; // registro exitoso
      } else {
        $res = 0; // error en la inserccion
      }

      return $res;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (PDOException $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  function cantidad_producto_carrito($idcli, $idpro, $cant)
  {
    try {
      $resp = "";
      $stock = 0;
      $sale = 0;
      $tipo_promo = "";
      $c = modelo_conexion::conexionPDO();

      $sql_t = "SELECT tipo_promo FROM agg_cart WHERE producto_id = ? AND cliente_id = ?";
      $query_t = $c->prepare($sql_t);
      $query_t->bindParam(1, $idpro);
      $query_t->bindParam(2, $idcli);
      $query_t->execute();
      $result_t = $query_t->fetch(PDO::FETCH_BOTH);
      foreach ($result_t as $respuesta_t) {
        $tipo_promo = $respuesta_t;
      }

      if ($tipo_promo === '2x1') {
        $sale = 2 * $cant;
      } else if ($tipo_promo === '3x1') {
        $sale = 3 * $cant;
      } else {
        $sale = $cant;
      }

      $sql_p = "SELECT stock FROM producto WHERE id_producto = ?";
      $query_p = $c->prepare($sql_p);
      $query_p->bindParam(1, $idpro);
      $query_p->execute();
      $result = $query_p->fetch(PDO::FETCH_BOTH);
      foreach ($result as $respuesta) {
        $stock = $respuesta;

        if ($sale > $stock) {
          $resp = "Stock " . $stock;
        } else {

          $sql_p = "UPDATE agg_cart SET cantidad = ?, sale = ? WHERE cliente_id = ? AND producto_id = ?";
          $query_p = $c->prepare($sql_p);
          $query_p->bindParam(1, $cant);
          $query_p->bindParam(2, $sale);
          $query_p->bindParam(3, $idcli);
          $query_p->bindParam(4, $idpro);
          if ($query_p->execute()) {
            $resp = 1; // se aumento con exito
          } else {
            $resp = 0; // error al aumentar
          }
        }
      }

      return $resp;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (Exception $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  function count_carrito($id_cli)
  {
    try {
      $c = modelo_conexion::conexionPDO();
      $sql_p = "SELECT
          COUNT(*) as count
          FROM
          agg_cart WHERE agg_cart.cliente_id = ?";
      $query_p = $c->prepare($sql_p);
      $query_p->bindParam(1, $id_cli);
      $query_p->execute();
      $result = $query_p->fetch(PDO::FETCH_BOTH);

      return $result;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (Exception $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  //////////////////////
  function agregar_producoferta($id, $id_cli, $cantidad)
  {
    try {
      $res = "";
      $sale = 0;

      $c = modelo_conexion::conexionPDO();
      $sql_a = "SELECT * FROM agg_cart where cliente_id = ? AND producto_id = ?";
      $query_a = $c->prepare($sql_a);
      $query_a->bindParam(1, $id_cli);
      $query_a->bindParam(2, $id);
      $query_a->execute();
      $data_a = $query_a->fetch(PDO::FETCH_BOTH);
      if (empty($data_a)) {

        // $cantidadd = 1;
        $tipo_promocion = "";
        $valor = 0;
        $porcentaje = 0;
        $descuento = 0;
        $sql_p = "SELECT
        ofertas.tipo_oferta,
        ofertas.descuento,
        producto.precio_venta 
        FROM
        ofertas
        INNER JOIN producto ON ofertas.id_producto = producto.id_producto WHERE ofertas.id_producto = ?";
        $query_p = $c->prepare($sql_p);
        $query_p->bindParam(1, $id);
        $query_p->execute();
        $dato_p = $query_p->fetchAll(PDO::FETCH_BOTH);
        foreach ($dato_p as $respuesta) {
          $valor = $respuesta[2];
          $porcentaje = $respuesta[1];
          $tipo_promocion = $respuesta[0];
        }
        $descuento = $valor * $porcentaje / 100;

        if ($tipo_promocion === '2x1') {
          $sale = 2 * $cantidad;
        } else if ($tipo_promocion === '3x1') {
          $sale = 3 * $cantidad;
        } else {
          $sale = $cantidad;
        }

        //////////////////// saber si hay stock
        $sql_stock = "SELECT
        producto.stock
        FROM
        producto WHERE producto.id_producto = ?";
        $q_stock_a = $c->prepare($sql_stock); 
        $q_stock_a->bindParam(1, $id);
        $q_stock_a->execute();
        $stock_actual = $q_stock_a->fetch(PDO::FETCH_BOTH); 

        if($sale > $stock_actual[0]){
          return $res = "Es una oferta del: " . $tipo_promocion . " - Stock " . $stock_actual[0];
        }

        $sql_c = "INSERT INTO agg_cart (cliente_id, producto_id, tipo_promo, porcentaje, descuento_promo, promocion, cantidad, precio, sale) VALUES (?,?,?,?,?,?,?,?,?)";
        $query_c = $c->prepare($sql_c);
        $query_c->bindParam(1, $id_cli);
        $query_c->bindParam(2, $id);
        $query_c->bindParam(3, $tipo_promocion);
        $query_c->bindParam(4, $porcentaje);
        $query_c->bindParam(5, $descuento);
        $query_c->bindParam(6, $tipo_promocion);
        $query_c->bindParam(7, $cantidad);
        $query_c->bindParam(8, $valor);
        $query_c->bindParam(9, $sale);

        if ($query_c->execute()) {
          $res = 1; // registro exitoso
        } else {
          $res = 0; // error en la inserccion
        }
      } else {

        $cant = "";
        $cant = $data_a[2] + $cantidad;

        if ($data_a[4] === '2x1') {
          $sale = 2 * $cant;
        } else if ($data_a[4] === '3x1') {
          $sale = 3 * $cant;
        } else {
          $sale = $cant;
        }

        $stock = 0;
        $sql_p = "SELECT stock FROM producto WHERE id_producto = ?";
        $query_p = $c->prepare($sql_p);
        $query_p->bindParam(1, $id);
        $query_p->execute();
        $dato_p = $query_p->fetch(PDO::FETCH_BOTH);
        foreach ($dato_p as $respuesto_p) {
          $stock = $respuesto_p;
        }

        if ($sale > $stock) {
          $res = "Es una oferta del: " . $data_a[4] . " - Stock " . $stock;
        } else {
          $sql_d = "UPDATE agg_cart SET cantidad = ?, sale = ? WHERE producto_id = ? AND cliente_id = ?";
          $query_d = $c->prepare($sql_d);
          $query_d->bindParam(1, $cant);
          $query_d->bindParam(2, $sale);
          $query_d->bindParam(3, $id);
          $query_d->bindParam(4, $id_cli);
          if ($query_d->execute()) {
            $res = 2; // exito atualizacion
          } else {
            $res = 3; // error en la actualizacion
          }
        }
      }
      return $res;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (PDOException $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  function vaciar_carrito($id_cli)
  {
    try {
      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_c = "DELETE FROM agg_cart WHERE cliente_id = ?";
      $query_c = $c->prepare($sql_c);
      $query_c->bindParam(1, $id_cli);
      if ($query_c->execute()) {
        $res = 1; // registro exitoso
      } else {
        $res = 0; // error en la inserccion
      }

      return $res;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (PDOException $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  function listar_banco_combo()
  {
    try {
      $c = modelo_conexion::conexionPDO();
      $sql = "SELECT * FROM banco WHERE estado = 1";
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

  function registra_compra_tranferencia($cliente, $banco, $direccion, $referencia, $fecha_transf, $sub, $impuesto, $total, $tipo_pago, $count, $codigo, $ruta)
  {
    try {

      // esta es la fecha correcta
      date_default_timezone_set('America/Guayaquil');
      $fecha_venta = date('Y-m-d');
      $numero = date("YmdHms");

      $id = 0;
      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_c = "INSERT INTO venta_online (cliente_id, tipo_pago, numero_compra, fecha, cantidad, subtotal, impuesto, total, direccion, referencia, pago) 
                          VALUES (?,?,?,?,?,?,?,?,?,?,1)";
      $query_c = $c->prepare($sql_c);
      $query_c->bindParam(1, $cliente);
      $query_c->bindParam(2, $tipo_pago);
      $query_c->bindParam(3, $numero);
      $query_c->bindParam(4, $fecha_venta);
      $query_c->bindParam(5, $count);
      $query_c->bindParam(6, $sub);
      $query_c->bindParam(7, $impuesto);
      $query_c->bindParam(8, $total);
      $query_c->bindParam(9, $direccion);
      $query_c->bindParam(10, $referencia);
      if ($query_c->execute()) {
        $id = $c->lastInsertId(); // me devulev el ultim ID insertado 

        $sql_t = "INSERT INTO transferencia (id_venta_online, tipo_banco, fecha, monto, codigo, foto, fecha_deposito, estado)
        VALUES (?,?,?,?,?,?,?,1)";
        $query_t = $c->prepare($sql_t);
        $query_t->bindParam(1, $id);
        $query_t->bindParam(2, $banco);
        $query_t->bindParam(3, $fecha_transf);
        $query_t->bindParam(4, $total);
        $query_t->bindParam(5, $codigo);
        $query_t->bindParam(6, $ruta);
        $query_t->bindParam(7, $fecha_venta); 

        if ($query_t->execute()) {
          $res = $id;
        } else {
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

  function registra_detalle_compra_trasnferenia($id_cli, $id)
  {
    try {
      $res = "";
      $stock = 0;
      $stock_e = 0;

      $c = modelo_conexion::conexionPDO();
      $sql_p = "SELECT
          agg_cart.cliente_id, 
          agg_cart.producto_id, 
          agg_cart.cantidad, 
          agg_cart.promocion, 
          agg_cart.tipo_promo, 
          agg_cart.porcentaje, 
          agg_cart.descuento_promo, 
          agg_cart.precio, 
          agg_cart.sale
          FROM
          agg_cart
          WHERE
          agg_cart.cliente_id = ?";
      $query_p = $c->prepare($sql_p);
      $query_p->bindParam(1, $id_cli);
      $query_p->execute();
      $data = $query_p->fetchAll(PDO::FETCH_BOTH);
      $arreglo = array();
      foreach ($data as $respuesta) {

        $tota = sprintf('%.2f', $respuesta[2] * $respuesta[7]);
        $gran_to = sprintf('%.2f', $tota - $respuesta[6]);

        $sql_c = "INSERT INTO detalle_venta_online_transferencia (id_venta_online, producto_id, cantidad, precio, descuento_oferta, tipo_oferta, subtotal) 
                          VALUES (?,?,?,?,?,?,?)";
        $query_c = $c->prepare($sql_c);
        $query_c->bindParam(1, $id);
        $query_c->bindParam(2, $respuesta[1]);
        $query_c->bindParam(3, $respuesta[8]);
        $query_c->bindParam(4, $respuesta[7]);
        $query_c->bindParam(5, $respuesta[6]);
        $query_c->bindParam(6, $respuesta[3]);
        $query_c->bindParam(7, $gran_to);
        if ($query_c->execute()) {

          $sql_p = "SELECT stock FROM producto where id_producto = ?";
          $query_p = $c->prepare($sql_p);
          $query_p->bindParam(1, $respuesta[1]);
          $query_p->execute();
          $data = $query_p->fetch(PDO::FETCH_BOTH);
          $arreglo = array();
          foreach ($data as $respuesta_s) {
            $arreglo[] = $respuesta_s;
          }

          $stock = $arreglo[0];
          if ($stock == "" || $stock == 0) {
            $stock = 0;
          }
          $stock = $stock - $respuesta[8];

          $sql_m = "UPDATE producto SET stock = ? where id_producto = ?";
          $query_m = $c->prepare($sql_m);
          $query_m->bindParam(1, $stock);
          $query_m->bindParam(2, $respuesta[1]);
          if ($query_m->execute()) {

            $sql_e = "SELECT stock FROM producto where id_producto = ?";
            $query_e = $c->prepare($sql_e);
            $query_e->bindParam(1, $respuesta[1]);
            $query_e->execute();
            $data_e = $query_e->fetch(PDO::FETCH_BOTH);
            $arreglo_e = array();
            foreach ($data_e as $respuesta_e) {
              $arreglo_e[] = $respuesta_e;
            }

            $stock_e = $arreglo_e[0];
            if ($stock_e == 0 || $stock_e < 0) {
              $sql_ee = "UPDATE producto SET estado = 'Agotado', stock = 0 where id_producto = ?";
              $query_ee = $c->prepare($sql_ee);
              $query_ee->bindParam(1, $respuesta[1]);
              if ($query_ee->execute()) {
                $res = 1;
              } else {
                $res = 0;
              }
            }

            $sql_del = "DELETE FROM agg_cart where cliente_id = ?";
            $query_del = $c->prepare($sql_del);
            $query_del->bindParam(1, $id_cli);
            if ($query_del->execute()) {
              $res = 1;
            } else {
              $res = 0;
            }
          } else {
            $res = 2; // error de update
          }
        } else {
          $res = 0;
        }
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

  function listar_ventas_productos_cliente($cliente)
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
          INNER JOIN cliente ON venta.id_cliente = cliente.id_cliente
          WHERE venta.id_cliente = ?";
      $query = $c->prepare($sql);
      $query->bindParam(1, $cliente);
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

  function listar_venta_servicios_cliente($cliente)
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
          INNER JOIN cliente ON venta_servicio.id_cliente = cliente.id_cliente
          WHERE venta_servicio.id_cliente = ?";
      $query = $c->prepare($sql);
      $query->bindParam(1, $cliente);
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

  function listar_ventas_onlinee_productos_cliente($id)
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
              WHERE venta_online.cliente_id = ?
          ORDER BY
          venta_online.id_venta_online_trans DESC";
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

  function lista_transferencia_bancaria_cliente($id)
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
              WHERE venta_online.cliente_id = ?
          ORDER BY
          transferencia.transferencia_id DESC";
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

  function subir_phto_transa($id, $id_venta, $ruta)
  {
    try {

      // esta es la fecha correcta
      date_default_timezone_set('America/Guayaquil');
      $fecha_depo = date('Y-m-d');

      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_c = "UPDATE transferencia SET foto = ?, fecha_deposito = ?, estado = 1 WHERE transferencia_id = ? AND id_venta_online = ?";
      $query_c = $c->prepare($sql_c);
      $query_c->bindParam(1, $ruta);
      $query_c->bindParam(2, $fecha_depo);
      $query_c->bindParam(3, $id);
      $query_c->bindParam(4, $id_venta);
      if ($query_c->execute()) {

        $sql_t = "UPDATE venta_online SET pago = 1 WHERE id_venta_online_trans = ?";
        $query_t = $c->prepare($sql_t);
        $query_t->bindParam(1, $id_venta);
        if ($query_t->execute()) {
          $res = 1;
        } else {
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

  function registra_compra_efectivo($cliente, $direccion, $referencia, $fecha_efectivo, $sub, $impuesto, $total, $tipo_pago, $count)
  {
    try {

      // esta es la fecha correcta
      date_default_timezone_set('America/Guayaquil');
      $fecha_venta = date('Y-m-d');
      $numero = date("YmdHms");

      $id = 0;
      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_c = "INSERT INTO venta_online (cliente_id, tipo_pago, numero_compra, fecha, cantidad, subtotal, impuesto, total, direccion, referencia) 
                          VALUES (?,?,?,?,?,?,?,?,?,?)";
      $query_c = $c->prepare($sql_c);
      $query_c->bindParam(1, $cliente);
      $query_c->bindParam(2, $tipo_pago);
      $query_c->bindParam(3, $numero);
      $query_c->bindParam(4, $fecha_venta);
      $query_c->bindParam(5, $count);
      $query_c->bindParam(6, $sub);
      $query_c->bindParam(7, $impuesto);
      $query_c->bindParam(8, $total);
      $query_c->bindParam(9, $direccion);
      $query_c->bindParam(10, $referencia);
      if ($query_c->execute()) {
        $id = $c->lastInsertId(); // me devulev el ultim ID insertado 

        $sql_t = "INSERT INTO efectivo (id_venta_online, direccion, referencia, fecha, monto) 
        VALUES (?,?,?,?,?)";
        $query_t = $c->prepare($sql_t);
        $query_t->bindParam(1, $id);
        $query_t->bindParam(2, $direccion);
        $query_t->bindParam(3, $referencia);
        $query_t->bindParam(4, $fecha_efectivo);
        $query_t->bindParam(5, $total);
        if ($query_t->execute()) {
          $res = $id;
        } else {
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

  function lista_efetivo_clinte($id)
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
      efectivo.fecha_proceso
      FROM
        efectivo
        INNER JOIN venta_online ON efectivo.id_venta_online = venta_online.id_venta_online_trans
        INNER JOIN cliente ON venta_online.cliente_id = cliente.id_cliente
      WHERE venta_online.cliente_id = ?
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

  function Enviando_correo($correo)
  {
    try {
      $c = modelo_conexion::conexionPDO();
      $sql = "SELECT correo FROM cliente WHERE correo = ?";
      $query = $c->prepare($sql);
      $query->bindParam(1, $correo);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_BOTH);
      return $result;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (Exception $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  function cambiar_pass($correo, $key)
  {
    try {

      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_c = "UPDATE cliente SET ppassword = ? WHERE correo = ?";
      $query_c = $c->prepare($sql_c);
      $query_c->bindParam(1, $key);
      $query_c->bindParam(2, $correo);
      if ($query_c->execute()) {
        $res = 1; // ok
      } else {
        $res = 0; // error
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

  function traer_foto_producto($id)
  {
    try {
      $c = modelo_conexion::conexionPDO();
      $sql = "SELECT foto
      FROM
      producto
      WHERE id_producto = ?";
      $query = $c->prepare($sql);
      $query->bindParam(1, $id);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_BOTH);
      return $result;
      //cerramos la conexion
      modelo_conexion::cerrar_conexion();
    } catch (Exception $e) {
      modelo_conexion::cerrar_conexion();
      echo "Error: " . $e->getMessage();
    }
    exit();
  }

  function calificar_poducto_pp($id_cli, $estrella, $comentario, $id)
  {
    try {

      date_default_timezone_set('America/Guayaquil');
      $fecha = date("Y-m-d H:m:s");

      $res = "";
      $c = modelo_conexion::conexionPDO();
      $sql_a = "INSERT INTO calificacion_producto (id_cliente, calificar, detalle, fecha, id_producto) VALUES (?,?,?,?,?)";
      $querya = $c->prepare($sql_a);
      $querya->bindParam(1, $id_cli);
      $querya->bindParam(2, $estrella);
      $querya->bindParam(3, $comentario);
      $querya->bindParam(4, $fecha);
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
