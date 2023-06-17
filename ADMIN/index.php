<?php
//esto es en caso de que no exista la session me llevara al login index
session_start();
if (!isset($_SESSION["id_usu"])) {
    header("location: ../");
}
?>

<!DOCTYPE html>
<html lang="es">

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

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />

    <link rel="icon" href="../ADMIN/img/russ.png">

    
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
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img id="imagen_usu_dos" />
                            <span id="usuario_usu_usu"></span><i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="modal_password();"><i class="fa fa-key"></i> <b>Password</b></a>
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" style="background: red; color:white;" href="controlador/usuario/cerrar.php"><i class="fa fa-power-off"></i><b>Cerrar</b></a>
                        </ul>
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
                        <img id="imagen_usu_uno" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong" id="nombres_usu_uno">James Brown</div><small id="rol_usu">Administrator</small>
                    </div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a style="color: white;" class="active" href="index.php"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Inicio</span>
                        </a>
                    </li>
                    <!-- <li class="heading">Mantenimiento y Seguridad</li> -->
                    <li>
                        <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-wrench"></i>
                            <span class="nav-label">Mant. y Seguridad</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li id="usuario_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-user"></i>
                                    <span class="nav-label">Usuarios</span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/usuario/tipo_usuario.php');">Tipo de usuario</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/usuario/usuario.php');">Registro usuario</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/usuario/listado_usuario.php');">Listado de usuario</a>
                                    </li>

                                </ul>
                            </li>
                            <li id="cliente_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-users"></i>
                                    <span class="nav-label">Clientes </span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/cliente/nuevo_cliente.php');">Registro de cliente</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/cliente/listado_clientes.php');">Listado de cientes</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/cliente/listado_clientes_web.php');">Listado de cientes web</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="proveedor_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-truck"></i>
                                    <span class="nav-label">Proveedores</span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/proveedor/nuevo_proveedor.php');">Registro de proveedor</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/proveedor/litar_proveedor.php');">Listado de proveedores</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="empresa_modulo">
                                <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/usuario/empresa.php');"><i class="sidebar-item-icon fa fa-home"></i>
                                    <span class="nav-label">Datos de empresa </span>
                                </a>
                            </li>
                            <li id="banco_modulo">
                                <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/usuario/banco.php');"><i class="sidebar-item-icon fa fa-bank"></i>
                                    <span class="nav-label">Banco </span>
                                </a>
                            </li>
                            <li id="banco_modulo">
                                <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/usuario/pagina_web.php');"><i class="sidebar-item-icon fa fa-windows"></i>
                                    <span class="nav-label">Página web </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="heading">Compras y ventas </li> -->
                    <li>
                        <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-shopping-cart"></i>
                            <span class="nav-label">Compras y ventas</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">

                            <li id="tipo_servicio_modulo">
                                <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/producto/tipo_servicio.php');"><i class="sidebar-item-icon fa fa-fax"></i>
                                    <span class="nav-label">Tipo de servicio </span>
                                </a>
                            </li>
                            <li id="productos_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-cubes"></i>
                                    <span class="nav-label">Productos</span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">

                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/producto/marca.php');">Marca de productos</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/producto/tipo.php');">Tipos de productos</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/producto/nuevo_producto.php');">Registro de producto</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/producto/listar_producto.php');">Listado de productos</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="compras_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-shopping-cart"></i>
                                    <span class="nav-label">Compras</span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/compra/nueva_compra.php');">Nueva compra</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/compra/listado_compras.php');">Listado de compras</a>
                                    </li>

                                </ul>
                            </li>
                            <li id="facturacion_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-dollar"></i>
                                    <span class="nav-label">Facturación </span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">
                                    <li>
                                        <a style="color: white;" href="javascript:;">
                                            <span class="nav-label">Productos</span><i class="fa fa-angle-left arrow"></i></a>
                                        <ul class="nav-3-level collapse">
                                            <li>
                                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/venta/nueva_venta.php');">Nueva venta</a>
                                            </li>
                                            <li>
                                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/venta/listar_venta.php');">Listado de ventas</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a style="color: white;" href="javascript:;">
                                            <span class="nav-label">Servicios</span><i class="fa fa-angle-left arrow"></i></a>
                                        <ul class="nav-3-level collapse">
                                            <li>
                                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/venta/venta_servicios.php');">Nuevo servicio</a>
                                            </li>
                                            <li>
                                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/venta/listado_servicios.php');">Listado de servicio</a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>
                    <!-- <li class="heading">Servicios web </li> -->
                    <li>
                        <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-desktop"></i>
                            <span class="nav-label">Servicios web</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">

                            <li id="califcaion_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-star"></i>
                                    <span class="nav-label">Calificación </span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/servicio_web/calificacion.php');">Sistema</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/servicio_web/calificacion_producto.php');">Producto</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="venta_online_modulo">
                                <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/servicio_web/listado_compras_online.php');"><i class="sidebar-item-icon fa fa-paypal"></i>
                                    <span class="nav-label">Ventas online </span>
                                </a>
                            </li>
                            <li id="tipo_pago_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-dollar"></i>
                                    <span class="nav-label">Tipos de pagos </span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/servicio_web/listado_transferencia.php');">Transferencia</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/servicio_web/listado_deposito.php');">Efectivo</a>
                                    </li>
                                </ul>
                            </li>
                            <li id="envios_modulo">
                                <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-truck"></i>
                                    <span class="nav-label">Envios </span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-2-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/servicio_web/envios.php');">Envios</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/servicio_web/vehiulos.php');">Vehiculos</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/servicio_web/repartidor.php');">Repartidor</a>
                                    </li>
                                </ul>
                            </li>


                        </ul>
                    </li>
                    <!-- <li class="heading">Ofertas </li> -->
                    <li>
                        <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-gift"></i>
                            <span class="nav-label">Ofertas</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">


                            <li id="registro_promo_modulo">
                                <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/producto/registro_promocion.php');"><i class="sidebar-item-icon fa fa-gift"></i>
                                    <span class="nav-label">Registro de ofertas </span>
                                </a>
                            </li>
                            <li id="promocion_vigentes_modulo">
                                <a style="color: white;" style="color: white;" onclick="cargar_contenido('contenido_principal','vista/producto/promo_vigentes.php');"><i class="sidebar-item-icon fa fa-list"></i>
                                    <span class="nav-label">Ofertas vigentes </span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- <li class="heading">Reportes </li> -->
                    <li id="reportes_modulo">
                        <a style="color: white;" href="javascript:;"><i class="sidebar-item-icon fa fa-file"></i>
                            <span class="nav-label">Reportes </span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/productos.php');">Productos </a>
                            </li>
                            <li>
                                <a style="color: white;" href="javascript:;">
                                    <span class="nav-label">Facturación</span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-3-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/factura_productos.php');">Productos</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/factura_servicios.php');">Servicios</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/compras.php');">Compras</a>
                            </li>
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/usuarios.php');">Usuarios</a>
                            </li>
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/clientes.php');">Clientes</a>
                            </li>
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/clientes_web.php');">Clientes web</a>
                            </li>
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/ingreso.php');">Ingreso</a>
                            </li>
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/egresos.php');">Egresos</a>
                            </li>
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/promociones.php');">Promociones</a>
                            </li>
                            <li>
                                <a style="color: white;" href="javascript:;">
                                    <span class="nav-label">Gráficos estadísticos</span><i class="fa fa-angle-left arrow"></i></a>
                                <ul class="nav-3-level collapse">
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/graficos_producto.php');">Ventas productos</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/graficos_ventas_onvlne.php');">Ventas online</a>
                                    </li>
                                    <li>
                                        <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/grafico_servicios.php');">Ventas servicios</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a style="color: white;" onclick="cargar_contenido('contenido_principal','vista/reportes/pedidos.php');">Pedidos pendientes</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->
        <div class="content-wrapper" id="contenido_principal">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="count_p">201</h2>
                                <div class="m-b-5">PRODUCTOS</div><i class="fa fa-cubes widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-info color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="count_s">1250</h2>
                                <div class="m-b-5">SERVICIOS</div><i class="fa fa-fax widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="count_c">$1570</h2>
                                <div class="m-b-5">CLIENTES</div><i class="fa fa-users widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-danger color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong" id="count_o">108</h2>
                                <div class="m-b-5">OFERTAS</div><i class="fa fa-gift widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="flexbox mb-4">
                                    <div>
                                        <h4 style="text-align: center;">5 productos mas vendidos</h4>
                                    </div>
                                </div>
                                <div>
                                    <div class="chart_p">
                                        <canvas id="char_producto" style="height:260px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="ibox">
                            <div class="ibox-body">
                                <div class="flexbox mb-4">
                                    <div>
                                        <h4 style="text-align: center;">5 servicios mas vendidos</h4>
                                    </div>
                                </div>
                                <div>
                                    <div class="chart_s">
                                        <canvas id="char_servicios" style="height:260px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                </div>

            </div>
            <!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13"> &copy; 2022 Insetech. Todos los derechos reservados - By: ING. JR</div>  

                
            </footer>
        </div>
    </div>

    <!-- END THEME CONFIG PANEL-->
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Cargando...</div>
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
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="../ADMIN/plugins/js/sweetalert2/sweetalert2.all.min.js" type="text/javascript"></script>
    <script src="../ADMIN/plugins/DATATABLES/datatables.min.js" type="text/javascript"></script>
    <script src="../ADMIN/plugins/SELECT2/js/select2.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="plugins/Chart/chart.min.js"></script>

    <script src="../ADMIN/js/system.js" type="text/javascript"></script>
</body>

</html>

<div class="modal fade" id="modal_edit__pasword_usu" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar password</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <input type="hidden" id="pass_oculto">
                    <input type="hidden" id="id_usu_usu">

                    <div class="col-sm-12 form-group">
                        <label>Password actual</label> &nbsp;&nbsp; <label style="color:red;" id="password_actual_oblig"></label>
                        <input type="password" maxlength="15" class="form-control" id="password_actual" placeholder="Ingrese password actual">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Password nuevo</label> &nbsp;&nbsp; <label style="color:red;" id="password_nuevo_oblig"></label>
                        <input type="password" maxlength="15" class="form-control" id="password_nuevo" placeholder="Ingrese password nuevo">
                        <span id="passstrength_n"></span>
                    </div>

                    <div class="col-sm-5 form-group">
                        <label>Repetir password</label> &nbsp;&nbsp; <label style="color:red;" id="password_repetir_oblig"></label>
                        <input type="password" maxlength="15" class="form-control" id="password_repetir" placeholder="Repetir password">
                    </div>

                    <div class="col-sm-1 form-group">
                        <label>Ver</label>
                        <button onclick="mostrar_usu_usu();" class="btn btn-danger"> <i class="fa fa-eye"></i></button>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editar_password_usu()"><i class="fa fa-edit"></i> Editar</button>
            </div>
        </div>
    </div>
</div>

<script>
    traer_datos_usuario_perfil();
    permisos_modulos_usuario();
    productos_mas_comprados();
    servicios_mas_comprados();
    traer_datos_dasboard_admin();
    verificar_ofertas();

    function mostrar_usu_usu() {
        var ver = document.getElementById("password_actual");
        var nuevo = document.getElementById("password_nuevo");
        var repetri = document.getElementById("password_repetir");

        if (ver.type == "password") {
            ver.type = "text";
            nuevo.type = "text";
            repetri.type = "text";
        } else {
            ver.type = "password";
            nuevo.type = "password";
            repetri.type = "password";
        }
    }

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

    $('#password_nuevo').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false == enoughRegex.test($(this).val())) {
            $('#passstrength_n').html('Más caracteres.');
            $('#passstrength_n').css('color', 'red');
        } else if (strongRegex.test($(this).val())) {
            $('#passstrength_n').className = 'ok';
            $('#passstrength_n').html('Fuerte!');
            $('#passstrength_n').css('color', 'green');
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength_n').className = 'alert';
            $('#passstrength_n').html('Media!');
            $('#passstrength_n').css('color', 'orange');
        } else {
            $('#passstrength_n').className = 'error';
            $('#passstrength_n').html('Débil!');
            $('#passstrength_n').css('color', 'red');
        }
        return true;
    });
</script>