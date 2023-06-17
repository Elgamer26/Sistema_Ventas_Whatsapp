<?php
//esto es en caso de que no exista la session me llevara al login index
session_start();
if (isset($_SESSION["id_repa"])) {
	header("location: ../delivery/vistas/");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="layout/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="layout/css/style.css">
</head>

<body>

    <br>
    <br>
    <br>

    <div class="container">
        <div class="booking-content">
            <div class="booking-image">
                <img class="booking-img" src="layout/images/delivry.jpg" style="height: 490px;" alt="Booking Image">
            </div>
            <div class="booking-form">
                <form id="booking-form">
                    <h2>Ingresar sus credenciales!</h2>


                    <div class="alert alert-danger text-center" id="none_usu" style="display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                        <span> Ingrese un usuario para continuar</span>
                    </div>

                    <div class="alert alert-danger text-center" id="none_pass" style="display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                        <span> Ingrese un password para continuar</span>
                    </div>


                    <div class="form-group form-input">
                        <input type="text" name="name" id="usuario_d" value="" required />
                        <label for="usuario_d" class="form-label">Usuario</label>
                    </div>
                    <div class="form-group form-input">
                        <input type="password" name="phone" id="password_d" value="" required />
                        <label for="password_d" class="form-label">Contraseña</label>
                    </div>

                    <div class="alert alert-danger text-center" id="error_logeo" style="display: none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                        <span> Usuario o contraseña incorrectos</span>
                    </div>


                    <div class="form-submit" style="margin: auto; padding: 5px;">
                        <input style="margin: auto;" type="submit" value="Ingresar" class="submit" id="entrar" name="submit" />
                        <br>
                        <a href="../LOGIN/" style="margin: auto; cursor: pointer; color: white;"> <b>Regresar</b> </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="layout/vendor/jquery/jquery.min.js"></script>
    <script src="layout/js/main.js"></script>
    <script src="../ADMIN/plugins/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../ADMIN/js/repartidor.js"></script>
</body>

</html>