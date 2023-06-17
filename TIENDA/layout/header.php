<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Tienda Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="keywords" content="Goggles a Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
            Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script>
        addEventListener(
            "Cargando...",
            function() {
                setTimeout(hideURLbar, 0);
            },
            false
        );

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/login_overlay.css" rel="stylesheet" type="text/css" />
    <link href="css/style6.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/shop.css" type="text/css" />
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/owl.theme.css" type="text/css" media="all" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/fontawesome-all.css" rel="stylesheet" />
    <link href="//fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet" />
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet" />

    <link href="css/contact.css" rel='stylesheet' type='text/css' />

    <link rel="icon" href="../ADMIN/img/icono_t.png">

</head>

<style>
    .swal2-confirm {
        padding: 3px !important;
    }
</style>

<body>
    <div class="banner-top container-fluid" id="home">
        <!-- header -->
        <header>
            <div class="row">
                <div class="col-md-3 top-info text-left mt-lg-4">
                    <h6></h6>
                    <ul>
                        <li></li>
                        <li class="number-phone mt-3"></li>
                    </ul>
                </div>

                <div class="col-md-1 logo-w3layouts text-center"> 
                    <br>
                    <img src="images/tienda.png" width="100" style="border-radius: 50px;" alt="logo">
                </div>

                <div class="col-md-4 logo-w3layouts text-center">
                    <h1 class="logo-w3layouts">
                        <a class="navbar-brand " href="index.php"> <img src="images/logo.png" width="50" style="border-radius: 50px;" alt="logo"> INSETECH <br> <span style="font-size: 48px;"> Tienda Online </span></a>
                    </h1>
                </div>

                <div class="col-md-1 logo-w3layouts text-center"> 
                    <br>
                    <img src="images/carro.png" width="100" style="border-radius: 50px;" alt="logo">
                </div>

                <div class="col-md-3 top-info-cart text-right mt-lg-4">
                    <ul class="cart-inner-info">
                        <li class="button-log">

                            <?php if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) { ?>
                                <span><i class="fa fa-user"></i> <?php echo $_SESSION["nombre_cli"]; ?></span>
                        <li class="galssescart galssescart2 cart cart box_1">
                            <button class="top_googles_cart" type="submit" name="submit">
                                <a href="checkout.php"><span id="count_cartt"></span></a>
                                <i class="fas fa-cart-arrow-down"></i>
                            </button>
                        </li>
                    <?php } else { ?>
                        <a class="btn-open" href="#" style="border: solid; padding: 3px;">
                            <span class="fa fa-user" aria-hidden="true"> </span> Cliente
                        </a>

                        <p style="padding: 5px;"></p>

                        <button onclick="administrador();" style="border: solid; padding: 3px; cursor: pointer;">
                            <i class="fa fa-user"> </i> Administrador
                        </button>
                    <?php } ?>
                    </li>

                    </ul>
                    <!---->
                    <div class="overlay-login text-left">

                        <button type="button" class="overlay-close1">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>

                        <div class="wrap">
                            <h5 class="text-center">Inicia sesión ahora</h5>
                            <div class="login p-3 bg-dark mx-auto mw-100">
                                <form>

                                    <div class="alert alert-danger text-center" id="none_usu" style="display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span style="color: white;"> Ingrese un email</span>
                                    </div>
                                    <div class="alert alert-danger text-center" id="none_pass" style="display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span style="color: white;"> Ingrese una password</span>
                                    </div>
                                    <div class="alert alert-danger text-center" id="none_pass_confirm" style="display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span style="color: white;"> Confirme el password</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="mb-2">Correo electrónico</label>
                                        <input type="email" class="form-control" id="user_email" aria-describedby="emailHelp" placeholder="Ingrese email" />
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2">Password</label>
                                        <input type="password" class="form-control" id="user_pass" placeholder="Ingrese password" />
                                    </div>

                                    <div class="alert alert-danger text-center" id="error_logeo" style="display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                                        <span style="color: white;"> Correo o contraseña incorrectos</span>
                                        <br>
                                        <a class="btn btn-info" onclick="modal_recuperar_pass();" title="recuperar password"><i class="fa fa-key"></i></a>
                                    </div>

                                    <button type="submit" id="ingresar_cliente" class="btn btn-primary submit mb-4">
                                        Ingresar
                                    </button>

                                    <!-- <a href="../LOGIN/" title="Ingresar admin" class="btn btn-success submit mb-4"><i class="fa fa-user"></i></a> -->

                                </form>
                            </div>
                            <!---->
                        </div>
                    </div>
                    <!---->
                </div>
            </div>

            <label class="top-log mx-auto"></label>
            <nav class="navbar navbar-expand-lg navbar-light bg-light top-header mb-2">
                <button class="navbar-toggler mx-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"> </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav nav-mega mx-auto">
                        <li class="nav-item active">
                            <a class="nav-link ml-lg-0" href="index.php">Inicio </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ofertas.php">Ofertas</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contacto</a>
                        </li> -->

                        <?php if (isset($_SESSION["id_cli"]) && isset($_SESSION["nombre_cli"])) { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link" style="background: #6e9de3; color: black;" href="checkout.php"><i class="fa fa-shopping-cart"></i> DETALLE DE CARRITO</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a style="background: orange; color: white;" class="nav-link" href="../CLIENTE/"><i class="fa fa-home"></i> Cuenta</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a onclick="modal_calificar();" style="background: yellow; color: black;" class="nav-link" href="#"><i class="fa fa-star"></i> Calificar sistema</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a style="background: red; color: white;" class="nav-link" href="layout/cerrar.php"><i class="fa fa-power-off"></i> Cerrar sesion</a>
                            </li>

                        <?php } else { ?>

                            <li class="nav-item dropdown">
                                <a onclick="modal_registra_cliente();" style="background: #138496; color:white;" class="nav-link" href="#">Registrarse</a>
                            </li>

                        <?php } ?>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- //header -->