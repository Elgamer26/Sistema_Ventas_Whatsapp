<?php
//esto es en caso de que no exista la session me llevara al login index
session_start();
if (!isset($_SESSION["id_cli"])) {
    header("location: ../");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Sistema de control</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="../ADMIN/template/dist/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../ADMIN/template/dist/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../ADMIN/template/dist/assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="../ADMIN/template/dist/assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="../ADMIN/template/dist/assets/css/main.min.css" rel="stylesheet" />
    <link href="../ADMIN/plugins/DATATABLES/datatables.min.css" rel="stylesheet" />
    <link href="../ADMIN/plugins/SELECT2/css/select2.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link rel="icon" href="../ADMIN/img/cliente.png">
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link" href="index.php">
                    <span class="brand">INSE
                        <span class="brand-tip">TECH</span>
                    </span>
                    <span class="brand-mini">IT</span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                    <li>

                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">

                    <li class="dropdown-menu-header" style="padding: 13px;">
                        <div>
                            <?php
                            date_default_timezone_set('America/Guayaquil');
                            function fechaC()
                            {
                                $mes = array(
                                    "", "Enero",
                                    "Febrero",
                                    "Marzo",
                                    "Abril",
                                    "Mayo",
                                    "Junio",
                                    "Julio",
                                    "Agosto",
                                    "Septiembre",
                                    "Octubre",
                                    "Noviembre",
                                    "Diciembre"
                                );
                                return date('d') . " de " . $mes[date('n')] . " de " . date('Y');
                            }
                            ?>
                            <small><b>Milagro - </b> <?php echo fechaC(); ?></small>
                        </div>
                    </li>

                    <li class="dropdown-menu-header" style="background: greenyellow;">
                        <a href="../TIENDA/">
                            <span><i class="fa fa-shopping-cart" style="font-size: 20px;"></i> Tienda</span>
                        </a>
                    </li>

                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link">
                            <img src="../ADMIN/template/dist/assets/img/admin-avatar.png" />
                            <span></span><?php echo $_SESSION["nombre_cli"]; ?>
                        </a>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="../ADMIN/template/dist/assets/img/admin-avatar.png" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong"><?php echo $_SESSION["nombre_cli"] ?></div><small>Cliente</small>
                    </div>
                </div>
                <ul class="side-menu metismenu">

                    <li>
                        <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/datos_personal.php');"><i class="sidebar-item-icon fa fa-user"></i>
                            <span class="nav-label">Datos personales </span>
                        </a>
                    </li>
                    <li>
                        <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/compras_persona.php');"><i class="sidebar-item-icon fa fa-shopping-cart"></i>
                            <span class="nav-label">Compras empresa </span>
                        </a>
                    </li>
                    <li>
                        <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/compras_servicios.php');"><i class="sidebar-item-icon fa fa-shopping-cart"></i>
                            <span class="nav-label">Servicios </span>
                        </a>
                    </li>
                    <li>
                        <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/compras_online.php');"><i class="sidebar-item-icon fa fa-paypal"></i>
                            <span class="nav-label">Compras online </span>
                        </a>
                    </li>
                    <li>
                        <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/transaferencias.php');"><i class="sidebar-item-icon fa fa-bank"></i>
                            <span class="nav-label">Transferencias bancarias </span>
                        </a>
                    </li>
                    <li>
                        <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/efectivo.php');"><i class="sidebar-item-icon fa fa-dollar"></i>
                            <span class="nav-label">Pagos en efectivo </span>
                        </a>
                    </li>

                    <li>
                        <a style="color: white; background: red;" style="color: white;" href="../TIENDA/layout/cerrar.php"><i class="sidebar-item-icon fa fa-circle-o"></i>
                            <span class="nav-label">Salir </span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->
        <div class="content-wrapper" id="contenido_principal">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-body">

                                <img src="../TIENDA/images/123.png" alt="insetech" style="width: 100%; height: 100%;">

                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13">&copy; 2022 Insetech. Todos los derechos reservados - By: ING. JR</div>
                
            </footer>
        </div>
    </div>

    <!-- END THEME CONFIG PANEL-->
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="../ADMIN/template/dist/assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="../ADMIN/template/dist/assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="../ADMIN/template/dist/assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../ADMIN/template/dist/assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="../ADMIN/template/dist/assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="../ADMIN/template/dist/assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="../ADMIN/template/dist/assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="../ADMIN/template/dist/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="../ADMIN/template/dist/assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="../ADMIN/template/dist/assets/js/app.min.js" type="text/javascript"></script>

    <script src="../ADMIN/plugins/js/sweetalert2/sweetalert2.all.min.js" type="text/javascript"></script>
    <script src="../ADMIN/plugins/DATATABLES/datatables.min.js" type="text/javascript"></script>
    <script src="../ADMIN/plugins/SELECT2/js/select2.min.js" type="text/javascript"></script>
</body>

</html>

<script>
    ////// esto es para la vista y validaciones
    function cargar_contenido(contenedor, contenido) {
        $("#" + contenedor).load(contenido);
    }

    ////loader
    function mostar_loader_datos(alerta) {
        var texto = null;
        var mostrar = false;

        switch (alerta[0]) {
            case "datos":
                texto = alerta[1];
                mostrar = true;
                break;
        }
        if (mostrar) {
            Swal.fire({
                title: alerta[2],
                html: texto,
                allowOutsideClick: false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        }
    }

    function cerrar_loader_datos(alerta) {
        var tipo = null;
        var texto = null;
        var mostrar = false;

        switch (alerta[0]) {
            case "exito":
                tipo = alerta[1];
                texto = alerta[2];
                mostrar = true;
                break;

            case "existe":
                tipo = alerta[1];
                texto = alerta[2];
                mostrar = true;
                break;

            case "error":
                tipo = alerta[1];
                texto = alerta[2];
                mostrar = true;
                break;

            default:
                swal.close();
                break;
        }
        if (mostrar) {
            Swal.fire({
                position: "center",
                icon: tipo,
                text: texto,
                showConfirmButton: true,
                allowOutsideClick: false,
            });
        }
    }

    function soloLetras(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = "8-37-39-46";
        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return swal.fire(
                "No se permiten numeros!!",
                "Solo se permiten letras",
                "warning"
            );
        }
    }

    function soloNumeros(e) {
        var key = window.event ? e.which : e.keyCode;
        if (key < 48 || key > 57) {
            return swal.fire(
                "No se permiten letras!!",
                "Solo se permiten numeros",
                "warning"
            );
        }
    }

    ////
    //funcion para validar decimales
    function filterfloat(evt, input) {
        var key = window.Event ? evt.which : evt.keyCode;
        var chark = String.fromCharCode(key);
        var tempvalue = input.value + chark;
        if (key >= 48 && key <= 57) {
            if (filter(tempvalue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            if (key == 8 || key == 13 || key == 0) {
                return false;
            } else if (key === 46) {
                if (filter(tempvalue) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return swal.fire(
                    "No se permiten letras!!",
                    "Solo se permiten numeros decimales",
                    "warning"
                );
            }
        }
    }

    function filter(__val__) {
        var preg = /^([0-9]+\.?[0-9]{0,2})$/;
        if (preg.test(__val__) === true) {
            return true;
        } else {
            return false;
        }
    }
</script>