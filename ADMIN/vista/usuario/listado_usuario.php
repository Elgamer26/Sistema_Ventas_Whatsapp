<script type="text/javascript" src="../ADMIN/js/usuario.js"></script>

<style>
    input[type="checkbox"] {
        position: relative;
        width: 60px;
        height: 30px;
        -webkit-appearance: none;
        background: rgb(168, 168, 168);
        outline: none;
        border-radius: 15px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, .5);
    }

    input:checked[type="checkbox"] {
        background: rgb(51 255 0);
    }

    input[type="checkbox"]:before {
        content: "";
        position: absolute;
        width: 30px;
        height: 30px;
        border-radius: 20px;
        top: 0;
        left: 0;
        background: white;
        transition: 0.5s;

    }

    input:checked[type="checkbox"]:before {
        left: 30px;
    }
</style>

<br>
<section class="content-header">
    <h3>
        <b> Listado de usuarios <i class="fa fa-list"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de usuarios</div>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_usuarios_" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Usuario</th>
                                    <th>Foto</th>
                                    <th>Rol</th>
                                    <th>N° documento</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Usuario</th>
                                    <th>Foto</th>
                                    <th>Rol</th>
                                    <th>N° documento</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<form autocomplete="false" onsubmit="return false" id="frm_edit_usuario">
    <div class="modal fade" id="modal_edit_usuario" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #3c8dbc; color:white;">
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Editar usuario</h4>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <input hidden type="text" id="id_usuario_edit">

                        <div class="col-sm-6 form-group">
                            <label>Nombres</label> &nbsp;&nbsp; <label style="color:red;" id="nombre_oblig"></label>
                            <input type="text" maxlength="20" class="form-control" id="nombres" placeholder="Ingrese nombres" onkeypress="return soloLetras(event)">
                        </div>

                        <div class="col-sm-6 form-group">
                            <label>Apellidos</label> &nbsp;&nbsp; <label style="color:red;" id="apellido_obliga"></label>
                            <input type="text" maxlength="20" class="form-control" id="apellidos" placeholder="Ingrese apellidos" onkeypress="return soloLetras(event)">
                        </div>

                        <div class="col-sm-6 form-group">
                            <label>Usuario</label> &nbsp;&nbsp; <label style="color:red;" id="usuario_obliga"></label>
                            <input type="text" maxlength="20" class="form-control" id="usuario" placeholder="Ingrese usuario" onkeypress="return soloLetras(event)">
                        </div>

                        <div class="col-sm-6 form-group">
                            <label>Tipo de rol</label> &nbsp;&nbsp; <label style="color:red;" id="rol_obliga"></label>
                            <select class="tipo_rol_usu form-control" style="width: 100%" id="tipo_rol_usu">
                            </select>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label>Cedula</label> &nbsp;&nbsp; <label style="color:red;" id="dcoumento_obliga"></label>
                            <input type="text" maxlength="10" class="form-control" id="numero_docu" placeholder="Ingrese cedula" onkeypress="return soloNumeros(event)">
                            <label for="" id="cedula_empleado" style="color: red; font-size: 12px;"></label>
                        </div>

                    </div>
                </div>

                <div class="modal-footer" style="background: silver;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="editar_usuario()"><i class="fa fa-edit"></i> Editar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form autocomplete="false" onsubmit="return false" id="frm_edit_permiso">
    <div class="modal fade" id="modal_edit__pasword" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: #3c8dbc; color:white;">
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Editar password</h4>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <input hidden type="text" id="id_usuario_edit_c">

                        <div class="col-sm-12 form-group">
                            <label>Password</label> &nbsp;&nbsp; <label style="color:red;" id="pass_obliga"></label>
                            <input type="password" maxlength="15" class="form-control" id="password_edit_usu" placeholder="Ingrese password">
                            <span id="passstrength"></span>
                        </div>

                        <div class="col-sm-10 form-group">
                            <label>Confirmar password</label> &nbsp;&nbsp; <label style="color:red;" id="pass_obliga_c"></label>
                            <input type="password" maxlength="15" class="form-control" id="password_edit_usu_c" placeholder="Confirmar password">
                        </div>

                        <div class="col-sm-1 form-group">
                            <label>..........</label>
                            <button onclick="mostrar_usu();" class="btn btn-danger"> <i class="fa fa-eye"></i></button>
                        </div>

                    </div>
                </div>

                <div class="modal-footer" style="background: silver;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="editar_password()"><i class="fa fa-edit"></i> Editar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- ///////////////////este formulario es para editar los permiso -->
<div class="modal fade" id="modal_editar_permisos" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar permisos</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <input hidden type="text" id="id_permiso">
                    <input hidden type="text" id="id_usu">


                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='usuario_p'>Usuario</label><br>
                        <input type='checkbox' id='usuario_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='clientes_p'>Clientes</label><br>
                        <input type='checkbox' id='clientes_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='proveedor_p'>Proveedores</label><br>
                        <input type='checkbox' id='proveedor_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='datos_empresa_p'>Datos empresa</label><br>
                        <input type='checkbox' id='datos_empresa_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='banco_p'>Banco</label><br>
                        <input type='checkbox' id='banco_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='tipo_servicio_p'>Tipo servicio</label><br>
                        <input type='checkbox' id='tipo_servicio_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='productos_p'>Productos</label><br>
                        <input type='checkbox' id='productos_p'><br>
                    </div>

                    <br>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='compras_p'>Compras</label><br>
                        <input type='checkbox' id='compras_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='facturacion_p'>Facturación</label><br>
                        <input type='checkbox' id='facturacion_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='calificacion_p'>Calificación</label><br>
                        <input type='checkbox' id='calificacion_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='ventas_online_p'>Ventas online</label><br>
                        <input type='checkbox' id='ventas_online_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='tipos_pagos_p'>Tipos de pagos</label><br>
                        <input type='checkbox' id='tipos_pagos_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='envios_p'>Envios</label><br>
                        <input type='checkbox' id='envios_p'><br>
                    </div>

                    <br>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='registro_promo_p'>Registro de promociones</label><br>
                        <input type='checkbox' id='registro_promo_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='promo_vigente_p'>Promociones vigentes</label><br>
                        <input type='checkbox' id='promo_vigente_p'><br>
                    </div>

                    <div class='col-sm-2 form-group' style="text-align:center">
                        <label for='reportes_p'>Reportes</label><br>
                        <input type='checkbox' id='reportes_p'><br>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editar_permisos_usuario()"><i class="fa fa-edit"></i> Editar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_photo" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #f39c12; color:white;">
                <h4 class="modal-title"><i class="fa fa-image"></i> Editar foto de usuario</h4>
            </div>

            <div class="modal-body">

                <div class="row">

                    <input type="number" id="id_foto_producto" hidden>

                    <div class="col-sm-12 form-group">
                        <div class="ibox-body text-center">

                            <img class="img-circle" id="foto_producto" white="100px" height="100px">
                            <h5 class="font-strong m-b-10 m-t-10"><span>Foto de usuario</span></h5>
                            <div>
                                <button class="btn btn-info btn-rounded m-b-5" onclick="editar_foto_usuarioo();"><i class="fa fa-plus"></i> Cambiar foto</button>
                                <input type="file" id="foto_new" class="form-control">
                                <input type="text" id="foto_actu" hidden>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(".tipo_rol_usu").select2();
    listar_usuarios();
    listar_rol_usu();

    function mostrar_usu() {
        var ver = document.getElementById("password_edit_usu");
        var ver_c = document.getElementById("password_edit_usu_c");

        if (ver.type == "password") {
            ver.type = "text";
            ver_c.type = "text";
        } else {
            ver.type = "password";
            ver_c.type = "password";
        }
    }

    $("#numero_docu").keyup(function() {
        if (this.value != "") {
            var cad = document.getElementById("numero_docu").value.trim();
            var total = 0;
            var longitud = cad.length;
            var longcheck = longitud - 1;

            if (cad != "") {
                if (cad !== "" && longitud === 10) {
                    for (i = 0; i < longcheck; i++) {
                        if (i % 2 === 0) {
                            var aux = cad.charAt(i) * 2;
                            if (aux > 9) aux -= 9;
                            total += aux;
                        } else {
                            total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar           
                        }
                    }
                    total = total % 10 ? 10 - total % 10 : 0;
                    if (cad.charAt(longitud - 1) == total) {

                        var digitos = String(cad).split('').map(d => parseInt(d));
                        var digito = digitos[0];
                        var veri = digitos.every((d) => d == digito);

                        if (!veri) {
                            $(this).css("border", "1px solid green");
                            $("#cedula_empleado").html("");
                        } else {
                            document.getElementById("cedula_empleado").innerHTML = ("cedula Inválida");
                            $(this).css("border", "1px solid red");
                        }

                    } else {
                        document.getElementById("cedula_empleado").innerHTML = ("cedula Inválida");
                        $(this).css("border", "1px solid red");
                        // $("#ocutar_p").hide();
                    }
                } else {
                    document.getElementById("cedula_empleado").innerHTML = ("La cedula no tiene 10 digitos");
                    $(this).css("border", "1px solid red");
                    // $("#ocutar_p").hide();
                }
            } else {
                document.getElementById("cedula_empleado").innerHTML = ("Debe ingresra una cedula");
                $(this).css("border", "1px solid red");
            }
        } else {
            $(this).css("border", "1px solid green");
            $("#cedula_empleado").html("");
        }
    });

    ////////////////////////
    function listar_rol_usu() {
        funcion = "listar_rl_usu";
        $.ajax({
            url: "../ADMIN/controlador/usuario/usuario.php",
            type: "POST",
            data: {
                funcion: funcion
            },
        }).done(function(response) {
            var data = JSON.parse(response);
            var cadena = "";
            if (data.length > 0) {
                //bucle para extraer los datos del rol
                for (var i = 0; i < data.length; i++) {
                    cadena +=
                        "<option value='" + data[i][0] + "'> " + data[i][1] + " </option>";
                }
                //aqui concadenamos al id del select
                $("#tipo_rol_usu").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos de rol</option>";
                $("#tipo_rol_usu").html(cadena);
            }
        });
    }

    document.getElementById("foto_new").addEventListener("change", () => {
        var filename = document.getElementById("foto_new").value;
        var idxdot = filename.lastIndexOf(".") + 1;
        var extfile = filename.substr(idxdot, filename.length).toLowerCase();
        if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {} else {
            swal.fire(
                "Mensaje de alerta",
                "Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
                "warning"
            );
            document.getElementById("foto_new").value = "";
        }
    });

    $('#password_edit_usu').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false == enoughRegex.test($(this).val())) {
            $('#passstrength').html('Más caracteres.');
            $('#passstrength').css('color', 'red');
        } else if (strongRegex.test($(this).val())) {
            $('#passstrength').className = 'ok';
            $('#passstrength').html('Fuerte!');
            $('#passstrength').css('color', 'green');
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength').className = 'alert';
            $('#passstrength').html('Media!');
            $('#passstrength').css('color', 'orange');
        } else {
            $('#passstrength').className = 'error';
            $('#passstrength').html('Débil!');
            $('#passstrength').css('color', 'red');
        }
        return true;
    });
</script>