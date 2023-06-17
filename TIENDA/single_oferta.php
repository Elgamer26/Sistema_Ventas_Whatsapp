<?php include "layout/header.php" ?>

<?php require '../ADMIN/modelo/conect/conect_r.php'; ?>

<?php

$id = $_GET['id'];

$consult_producto = 'SELECT
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
ofertas.fecha_inicio,
ofertas.fecha_fin,
ofertas.tipo_oferta,
ofertas.descuento 
FROM
producto
INNER JOIN tipo_producto ON producto.id_tipo_producto = tipo_producto.id_tipo_produto
INNER JOIN marca ON producto.id_marca = marca.id_marca
INNER JOIN ofertas ON producto.id_producto = ofertas.id_producto
WHERE
producto.id_producto = ' . $id . '';
$resulta_producto = $mysqli->query($consult_producto);
$data_producto = mysqli_fetch_assoc($resulta_producto);
// print_r($data_producto);
$valor = 0;
$costo = 0;

$valor = number_format($data_producto['precio_venta'] * $data_producto['descuento'] / 100, 2);
$costo =  number_format($data_producto['precio_venta'] - $valor, 2);

//////////////////
$comentario = 'SELECT
calificacion_producto.id_producto,
CONCAT_WS( " ", cliente.nombres ) AS cliente,
calificacion_producto.calificar,
calificacion_producto.detalle,
calificacion_producto.fecha 
FROM
	calificacion_producto
	INNER JOIN cliente ON calificacion_producto.id_cliente = cliente.id_cliente 
WHERE
calificacion_producto.id_producto = ' . $id . '
ORDER BY
calificacion_producto.fecha DESC';

$r_c = $mysqli->query($comentario);

////////////////////////
$coment = $mysqli->query("Call caificacion(" . $id . ")");
?>

<!-- banner -->
<div class="banner_inner">
	<div class="services-breadcrumb">
		<div class="inner_breadcrumb">

			<ul class="short">
				<li>
					<a href="index.php">Inicio</a>
					<i>|</i>
				</li>
				<li>Detalle producto ofertas</li>
			</ul>
		</div>
	</div>
</div>

</div>
<!--//banner -->
<!--/shop-->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
	<div class="container">
		<div class="inner-sec-shop pt-lg-4 pt-3">
			<div class="row">
				<div class="col-lg-4 single-right-left ">
					<div class="grid images_3_of_2">
						<div class="flexslider1">
							<div class="thumb-image"> <img src="../ADMIN/<?php echo $data_producto['foto']; ?>" data-imagezoom="true" class="img-fluid" alt=" "> </div>
							<div class="clearfix">
								<br>
								<?php

								if ($count_c = mysqli_num_rows($coment) > 0) {
									while ($row_c = $coment->fetch_assoc()) {
								?>
										<div class="col-lg-7 single-right-left simpleCart_shelfItem">
											<h3 style="text-align: center;"><b>Calificación</b></h3>
											<b>Excelente - <?php echo $row_c["exelente"] ?>%</b>
											<div class="progress">
												<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $row_c["exelente"] ?>%;" aria-valuenow="<?php echo $row_c["exelente"] ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row_c["exelente"] ?>%</div>
											</div>
											<b>Muy Bueno - <?php echo $row_c["muy_bueno"] ?>%</b>
											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: <?php echo $row_c["muy_bueno"] ?>%;" aria-valuenow="<?php echo $row_c["muy_bueno"] ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row_c["muy_bueno"] ?>%</div>
											</div>
											<b>Bueno - <?php echo $row_c["bueno"] ?>%</b>
											<div class="progress">
												<div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $row_c["bueno"] ?>%;" aria-valuenow="<?php echo $row_c["bueno"] ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row_c["bueno"] ?>%</div>
											</div>
											<b>Regular - <?php echo $row_c["regular"] ?>%</b>
											<div class="progress">
												<div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $row_c["regular"] ?>%;" aria-valuenow="<?php echo $row_c["regular"] ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row_c["regular"] ?>%</div>
											</div>
											<b>Necesita Mejorar - <?php echo $row_c["nejorar"] ?>%</b>
											<div class="progress">
												<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $row_c["nejorar"] ?>%;" aria-valuenow="<?php echo $row_c["nejorar"] ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row_c["nejorar"] ?>%</div>
											</div>
										</div>

								<?php 			}
								} ?>


							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-8 single-right-left simpleCart_shelfItem">
					<h3><?php echo $data_producto['nombre_producto']; ?></h3>
					<p><span class="item_price">$.<?php echo $costo; ?></span>
						<del>$.<?php echo $data_producto['precio_venta']; ?></del>
					</p>

					<div class="description p-0 m-0">
						<h5><b>Tipo producto: </b><?php echo $data_producto['tipo_producto']; ?> </h5>
						<h5><b>Marca producto:</b> <?php echo $data_producto['marca']; ?> </h5>
						<h5><b>Detalle del producto:</b> <?php echo $data_producto['descripcion']; ?></h5>

					</div>
					<div class="color-quality">
						<div class="color-quality-right">
							<h5><b>Stock:</b> <?php echo $data_producto['stock']; ?></h5>
							<h5><b>Fecha fin oferta:</b> <?php echo $data_producto['fecha_fin']; ?></h5>
							<h5><b>Tipo de oferta:</b> <?php echo $data_producto['tipo_oferta']; ?></h5>
							<h5><b>Descuento:</b> <?php echo $data_producto['descuento']; ?>%</h5>
						</div>
					</div>

					<?php

					echo '<div class="occasion-cart">';
					echo '<div class="googles single-item singlepage">';
					echo '<button type="submit" onclick="agregar_producoferta(' . $data_producto['id_producto'] . ')" class="googles-cart pgoogles-cart">';
					echo 'Agregar al carrito';
					echo '</button>';
					echo '</div>';
					echo '</div>';

					?>

					<br>

					<div class="col-lg-12 single-right-left simpleCart_shelfItem">

						<h3 style="text-align: center;"><b>Comentarios</b></h3>

						<style>
							::-webkit-scrollbar {
								width: 4px;
							}

							::-webkit-scrollbar-thumb {
								background-color: #4c4c6a;
								border-radius: 2px;
							}

							.chatbox {
								width: 100%;
								height: 400px;
								max-height: 400px;
								display: flex;
								flex-direction: column;
								overflow: hidden;
								box-shadow: 0 0 4px rgba(0, 0, 0, .14), 0 4px 8px rgba(0, 0, 0);
								border-radius: 10px;
							}

							.chat-window {
								flex: auto;
								/*	max-height: calc(100% - 60px); */
								background: #2a2a2a;
								overflow: auto;
							}

							.chat-input {
								flex: 0 0 auto;
								height: 60px;
								background: #40434e;
								border-top: 1px solid #2671ff;
								box-shadow: 0 0 4px rgba(0, 0, 0, .14), 0 4px 8px rgba(0, 0, 0, .28);
							}

							.chat-input input {
								height: 59px;
								line-height: 60px;
								outline: 0 none;
								border: none;
								width: calc(100% - 60px);
								color: white;
								text-indent: 10px;
								font-size: 12pt;
								padding: 0;
								background: #40434e;
							}

							.chat-input button {
								float: right;
								outline: 0 none;
								border: none;
								background: rgba(255, 255, 255, .25);
								height: 40px;
								width: 40px;
								border-radius: 50%;
								padding: 2px 0 0 0;
								margin: 10px;
								transition: all 0.15s ease-in-out;
							}

							.chat-input input[good]+button {
								box-shadow: 0 0 2px rgba(0, 0, 0, .12), 0 2px 4px rgba(0, 0, 0, .24);
								background: #2671ff;
							}

							.chat-input input[good]+button:hover {
								box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
							}

							.chat-input input[good]+button path {
								fill: white;
							}

							.msg-container {
								position: relative;
								display: inline-block;
								width: 100%;
								margin: 0;
								padding: 5px;
							}

							.msg-box {
								display: flex;
								background: #5b5e6c;
								padding: 10px 10px 0 10px;
								border-radius: 0 6px 6px 0;
								/* max-width: 80%; */
								width: auto;
								float: left;
								box-shadow: 0 0 2px rgba(0, 0, 0, .12), 0 2px 4px rgba(0, 0, 0, .24);
							}

							.user-img {
								display: inline-block;
								border-radius: 50%;
								height: 40px;
								width: 40px;
								background: #2671ff;
								margin: 0 10px 10px 0;
							}

							.flr {
								flex: 1 0 auto;
								display: flex;
								flex-direction: column;
								width: calc(100% - 50px);
							}

							.messages {
								flex: 1 0 auto;
							}

							.msg {
								display: inline-block;
								font-size: 11pt;
								line-height: 13pt;
								color: rgba(255, 255, 255, .7);
								margin: 0 0 4px 0;
							}

							.msg:first-of-type {
								margin-top: 8px;
							}

							.timestamp {
								color: rgba(0, 0, 0, .38);
								font-size: 8pt;
								margin-bottom: 10px;
							}

							.username {
								margin-right: 3px;
							}

							.posttime {
								margin-left: 3px;
							}

							.msg-self .msg-box {
								border-radius: 6px 0 0 6px;
								background: #2671ff;
								float: right;
							}

							.msg-self .user-img {
								margin: 0 0 10px 10px;
							}

							.msg-self .msg {
								text-align: right;
							}

							.msg-self .timestamp {
								text-align: right;
							}
						</style>

						<body>
							<section class="chatbox">
								<section class="chat-window">

									<?php

									if ($count = mysqli_num_rows($r_c) > 0) {
										$color_bg = "";
										while ($row = $r_c->fetch_assoc()) {
											if ($row['calificar'] == "Excelente") {
												$color_bg = "#0bbf21";
											} else if ($row['calificar'] == "Muy Bueno") {
												$color_bg = "#96bd20";
											} else if ($row['calificar'] == "Bueno") {
												$color_bg = "#3f95ed";
											} else if ($row['calificar'] == "Regular") {
												$color_bg = "#e79735";
											} else {
												$color_bg = "#ff4e4e";
											}
									?>

											<article class="msg-container msg-self" id="msg-0">
												<div class="msg-box" style="width: 100%;  background: #1d1d1d;">
													<div class="flr">
														<div class="messages">
															<p class="msg" style="padding: 0; margin: 0; text-align: center; color:<?php echo $color_bg; ?>;" id="msg-1">
																<b><?php echo $row['calificar']; ?></b>
															</p>
															<br>
															<span style="color: white">
																<?php echo $row['detalle']; ?>
															</span>
														</div>
														<span style="color: white;" class="timestamp"><span class="username"><b><?php echo $row['cliente']; ?></span>&bull;<span class="posttime"><?php echo $row['fecha']; ?></b></span></span>
													</div>
												</div>
											</article>

										<?php
										}
									} else {
										?>

										<article class="msg-container msg-self" id="msg-0" style="text-align: center;">
											<div class="msg-box" style="width: 100%;">
												<div class="flr">
													<div class="messages">
														<p class="msg" style="padding: 0; margin: 0; text-align: center; color: white;" id="msg-1">
															No hay comentario para este producto
														</p>
													</div>
												</div>
											</div>
										</article>

									<?php
									}
									?>

								</section>
							</section>
						</body>

					</div>
				</div>

			</div>
		</div>
	</div>
</section>

<?php include "layout/footer.php" ?>