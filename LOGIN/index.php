<?php
//esto es en caso de que no exista la session me llevara al login index
session_start();
if (isset($_SESSION["id_usu"])) {
	header("location: ../ADMIN/");
}

if (isset($_SESSION["id_repa"])) {
	header("location: ../delivery/vistas/");
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Login insetech</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

	<!-- MATERIAL DESIGN ICONIC FONT -->
	<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- STYLE CSS -->
	<link rel="stylesheet" href="css/style.css">

	<link rel="icon" href="../ADMIN/img/candado.png">
	
</head>

<body>
	<div class="wrapper">
		<div class="image-holder">
			<img src="https://t4.ftcdn.net/jpg/04/60/71/01/360_F_460710131_YkD6NsivdyYsHupNvO3Y8MPEwxTAhORh.jpg" alt="">
		</div>
		<div class="form-inner">

			<form>

				<div class="form-header">
					<h3>inicia sesión</h3>
					<img src="images/sign-up.png" alt="" class="sign-up-icon">
				</div>

				<div class="m-12">
					<div class="card text-center">
						<div class="card-header">
							<ul class="nav nav-tabs card-header-tabs" id="myTab">
								<li class="nav-item">
									<a href="#admi" class="nav-link active" data-bs-toggle="tab"><b>Administrador</b></a>
								</li>
								<li class="nav-item">
									<a href="#repar" class="nav-link" data-bs-toggle="tab"><b>Repartidor</b></a>
								</li>
							</ul>
						</div>
						<div class="card-body" style="background: #001004;">
							<div class="tab-content">

								<div class="tab-pane fade show active" id="admi">

									<div class="alert alert-danger text-center" id="none_usu" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
										<span> Ingrese un usuario para continuar</span>
									</div>

									<div class="alert alert-danger text-center" id="none_pass" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
										<span> Ingrese un password para continuar</span>
									</div>

									<div class="form-group">
										<label for="">Usuario:</label>
										<input type="text" class="form-control" id="usuario">
									</div>

									<div class="form-group">
										<label for="">Password:</label>
										<input type="password" class="form-control" id="password">
									</div>

									<div class="alert alert-danger text-center" id="error_logeo" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
										<span> Usuario o contraseña incorrectos</span>
									</div>

									<button id="ingresar">Ingresar</button>

								</div>

								<div class="tab-pane fade" id="repar">

									<div class="alert alert-danger text-center" id="p_none_usu" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
										<span> Ingrese un usuario para continuar</span>
									</div>

									<div class="alert alert-danger text-center" id="p_none_pass" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
										<span> Ingrese un password para continuar</span>
									</div>

									<div class="form-group">
										<label for="">Usuario repartidor:</label>
										<input type="text" class="form-control" id="usuario_d">
									</div>

									<div class="form-group">
										<label for="">Password repartidor:</label>
										<input type="password" class="form-control" id="password_d">
									</div>

									<div class="alert alert-danger text-center" id="p_error_logeo" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
										<span> Usuario o contraseña incorrectos</span>
									</div>

									<button id="entrar">Ingresar Repartidor</button>

								</div>

							</div>
						</div>
					</div>
				</div>

				<br>

				<!-- <a href="../delivery/">
					<div style="background: orange; text-align: center; border-radius: 15px; border: solid 1px; padding: 8px; cursor: pointer;"><b>LOGIN DEL REPARTIDOR</b></div>
				</a> -->

				<a href="../TIENDA/">
					<div style="background: greenyellow; text-align: center; border-radius: 15px; border: solid 1px; padding: 8px; cursor: pointer;"><b>TIENDA PRINCIPAL</b></div>
				</a>

			</form>
		</div>

	</div>

	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form-validator.min.js"></script>
	<script src="js/main.js"></script>
	<script src="../ADMIN/plugins/js/sweetalert2/sweetalert2.all.min.js"></script>

	<script src="../ADMIN/js/usuario.js"></script>
	<script src="../ADMIN/js/repartidor.js"></script>
</body>

</html>