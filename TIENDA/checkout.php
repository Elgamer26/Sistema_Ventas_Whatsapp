<?php include "layout/header.php" ?>

<?php
date_default_timezone_set('America/Guayaquil');
$fecha = date("Y-m-d");
?>

<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/login_overlay.css" rel='stylesheet' type='text/css' />
<link href="css/style6.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/shop.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/checkout.css">
<link href="css/easy-responsive-tabs.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/fontawesome-all.css" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">

<!-- banner -->
<div class="banner_inner">
	<div class="services-breadcrumb">
		<div class="inner_breadcrumb">

			<ul class="short">
				<li>
					<a href="index.php">INICIO</a>
					<i>|</i>
				</li>
				<li>VERIFICAR </li>
			</ul>
		</div>
	</div>

</div>
<!--//banner -->
</div>
<!--// header_top -->
<!--checkout-->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
	<div class="container">
		<div class="inner-sec-shop px-lg-4 px-3">
			<h3 class="tittle-w3layouts my-lg-4 mt-3">Verificar <a class="btn btn-success" href="index.php"><i class="fa fa-shopping-cart"></i> Continuar comprando</a> <button style="display: none;" class="btn btn-danger" onclick="vaciar_carrito();" id="btn_vaciar_"><i class="fa fa-trash"></i> Vaciar carrito</button></h3>
			<div class="checkout-right"><br>
				<table class="timetable_sub" id="tabla_detalle_producto">
					<thead>
						<tr>
							<th>Quitar</th>
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Sale</th>
							<th>Producto nombre</th>
							<th>Precio</th>
							<th>Tipo Oferta</th>
							<th>Descuento</th>
							<th>Total</th>

						</tr>
					</thead>
					<tbody id="unnir_tabla_detalle">

					</tbody>
				</table>
			</div>

			<div class="checkout-left row">
				<div class="col-md-4 checkout-left-basket">
					<h4>CONTINUAR A LA CESTA</h4>
					<ul>
						<li>Subtotal
							<i>-</i>
							<span id="subtotal"> </span>
							<input hidden type="number" id="txt_subtotal">
						</li>
						<li> Iva <label id="lbl_iva_wmpresa"></label>%
							<i>-</i>
							<span id="iva_total"> </span>
							<input hidden type="number" id="txt_iva_total">
						</li>
						<li>
							<i> </i>
							<span> </span>
						</li>
						<li>
							<i> </i>
							<span> </span>
						</li>
						<li>Total
							<i>-</i>
							<span id="grntotal">$0.00</span>
							<input hidden type="number" id="txt_grntotal">
						</li>
					</ul>
				</div>
				<div class="col-md-8 address_form">
					<h4>Detalle de envio</h4>
					<div class="creditly-card-form agileinfo_form">
						<section class="creditly-wrapper wrapper">
							<div class="information-wrapper">
								<div class="first-row form-group">
									<div class="controls">
										<label class="control-label">Dirección: </label> &nbsp;&nbsp; <label style="color:red;" id="direccion_envio_obligg"></label>
										<input class="billing-address-name form-control" id="direccion_envio" type="text" name="name" placeholder="Ingrese dirección de envio">
									</div>

									<div class="controls">
										<label class="control-label">Referencia de ubicación: </label> &nbsp;&nbsp; <label style="color:red;" id="refrencia_envio_obligg"></label>
										<input class="form-control" type="text" id="refrencia_envio" placeholder="Ingrese referencia de ubicación">
									</div>
									<div class="controls">
										<label class="control-label">Tipo de pago: </label>
										<select id="tipo_pagoos" class="form-control option-w3ls">
											<option id="Transferencia">Transferencia</option>
											<option id="Efectivo">Efectivo</option>

										</select>
									</div>
								</div>
								<button style="display: none;" id="boton_pocesar_pagos" onclick="procesar_pago();" class="submit check_out">Procesar</button>
							</div>
						</section>
					</div>
					<!-- <div class="checkout-right-basket">
						<a href="payment.html">Make a Payment </a>
					</div> -->
				</div>
			</div>

		</div>

	</div>
</section>
<!--//checkout-->

<?php include "layout/footer.php" ?>

<script>
	mostrar_carrito_compra_detalle();
	listar_banco_combo();
</script>

<div class="modal fade" id="modal_tranferencia" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #3c8dbc; color:white;">
				<h4 class="modal-title"> Transferencia bancaria</h4>
				<button style="background: red; color:white; border-radius: 10px; font-size: 25px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body text-center p-3 mx-auto mw-100">

				<div class="row">

					<div class="col-sm-12 form-group" class="alert alert-success text-center" id="exito_registro" style="text-align: center; background:      #0356d38f; border-radius: 15px; padding: 10px;">
						<label style="color: black;"><b>*** Estimado cliente el método de pago es mediante transferencia bancaria: deberá seleccionar el nombre de su banco y adjuntar el comprobante de pago. ***</b></label>
					</div>

					<div class="col-sm-6 form-group">
						<label>Seleccione el banco.</label>
						<select class="form-control" style="width: 100%;" id="tipo_banco"></select>
					</div>


					<div class="col-sm-6 form-group">
						<label>Valor:</label>
						<input type="text" readonly class="form-control" id="valor_tranferencia">
					</div>

					<br>

					<div class="col-sm-6 form-group">
						<label>Fecha:</label>
						<input type="date" readonly class="form-control" id="fecha_tranferencia" value="<?php echo $fecha; ?>">
					</div>

					<div class="col-sm-6 form-group">
						<label>N° comprobante pago:</label> &nbsp;&nbsp; <label style="color:red;" id="codigo_tranferess_olgig"></label>
						<input type="text" onkeypress="return soloNumeros(event)" maxlength="13" class="form-control" id="codi_tranf">
					</div>

					<div class="col-sm-12 form-group">
						<label>Subir comprobante</label> &nbsp;&nbsp; <label style="color:red;" id="comprobante_obligg"></label>
						<input type="file" class="form-control" id="comprobante_file">
					</div>

					<br> <br>

					<div class="col-sm-12 form-group">
						<button onclick="procesar_transferencia();" class="btn btn-success" type="button"> Procesar transferencia</button>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modal_efectivo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #3c8dbc; color:white;">
				<h4 class="modal-title"> Efectivo</h4>
				<button style="background: red; color:white; border-radius: 10px; font-size: 25px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body text-center p-3 mx-auto mw-100">

				<div class="row">

					<div class="col-sm-12 form-group" class="alert alert-success text-center" id="exito_registro" style="text-align: center; background:      #0356d38f; border-radius: 15px; padding: 10px;">
						<label style="color: black;"><b>*** Estimado cliente el método de pago es en efectivo, su pedido será enviado a la dirección registrada, Ud deberá entregar el efectivo al repartidor y el sera el encargado de adjuntarlo como evidencia. ***</b></label>
					</div>

					<div class="col-sm-6 form-group">
						<label>Valor:</label>
						<input type="text" readonly class="form-control" id="valor_efectivo">
					</div>

					<div class="col-sm-6 form-group">
						<label>Fecha:</label>
						<input type="date" readonly class="form-control" id="fecha_efectivo" value="<?php echo $fecha; ?>">
					</div>

					<br> <br>

					<div class="col-sm-12 form-group">
						<button onclick="procesar_efectivo();" class="btn btn-success" type="button"> Procesar efectivo</button>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

<script>
	traer_datos_de_empresa();

	document.getElementById("comprobante_file").addEventListener("change", () => {
		var filename = document.getElementById("comprobante_file").value;
		var idxdot = filename.lastIndexOf(".") + 1;
		var extfile = filename.substr(idxdot, filename.length).toLowerCase();
		if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {} else {
			swal.fire(
				"Mensaje de alerta",
				"Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
				"warning"
			);
			document.getElementById("comprobante_file").value = "";
		}
	});

	function traer_datos_de_empresa() {
        funcion = "traer_datos_de_empresa";
        $.ajax({
            url: "../ADMIN/controlador/system/system.php",
            type: "POST",
            data: { funcion: funcion },
        }).done(function (resp) {
            var data = JSON.parse(resp);
            if (data.length > 0) { 
            document.getElementById("lbl_iva_wmpresa").innerHTML = data[0][9]; 
            }
        });
    }
</script>