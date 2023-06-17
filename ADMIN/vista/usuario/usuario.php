<script type="text/javascript" src="js/usuario.js"></script>

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
        <b> Nuevo usuario <i class="fa fa-user"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Nuevo usuario</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-6 form-group">
                                <label>Nombres</label> &nbsp;&nbsp; <label style="color:red;" id="nombre_oblig"></label>
                                <input type="text" maxlength="20" class="form-control" id="nombres" placeholder="Ingrese nombres" onkeypress="return soloLetras(event)">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label>Apellidos</label> &nbsp;&nbsp; <label style="color:red;" id="apellido_obliga"></label>
                                <input type="text" maxlength="20" class="form-control" id="apellidos" placeholder="Ingrese apellidos" onkeypress="return soloLetras(event)">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label>Tipo de rol</label> &nbsp;&nbsp; <label style="color:red;" id="rol_obliga"></label>
                                <select class="tipo_rol_usu form-control" id="tipo_rol_usu">
                                </select>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label>Cedula</label> &nbsp;&nbsp; <label style="color:red;" id="dcoumento_obliga"></label>
                                <input type="text" maxlength="10" class="form-control" id="numero_docu" placeholder="Ingrese cedula" onkeypress="return soloNumeros(event)">
                                <label for="" id="cedula_empleado" style="color: red; font-size: 12px;"></label>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label>Foto de usuario</label>&nbsp;&nbsp; <label style="color:orange;">La foto del usuario no es obligatorio</label>
                                <input type="file" class="form-control" id="foto">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label>Usuario</label> &nbsp;&nbsp; <label style="color:red;" id="usuario_obliga"></label>
                                <input type="text" maxlength="20" class="form-control" id="usuario" placeholder="Ingrese usuario" onkeypress="return soloLetras(event)">
                            </div>

                            <div class="col-sm-6 form-group">
                                <label>Password</label> &nbsp;&nbsp; <label style="color:red;" id="pass_obliga"></label>
                                <input type="password" maxlength="15" class="form-control" id="password" placeholder="Ingrese password">
                                <span id="passstrength"></span>
                            </div>

                            <div class="col-sm-5 form-group">
                                <label>Confirmar password</label> &nbsp;&nbsp; <label style="color:red;" id="pass_obliga_con"></label>
                                <input type="password" maxlength="15" class="form-control" id="password_con" placeholder="Confirmar password">
                            </div>


                            <div class="col-sm-1 form-group">
                                <label>..........</label>
                                <button onclick="mostrar_usu();" class="btn btn-danger"> <i class="fa fa-eye"></i></button>
                            </div>

                            <div class="col-sm-12 form-group" style="text-align: center;background: greenyellow;">
                                <h4 style="margin: 0;"><b>Permisos de usuario</b></h4>
                            </div>


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


                            <br>
                            <br>
                            <br>

                            <div class="col-sm-12 form-group">
                                <button onclick="guardar_usuaio();" class="btn btn-primary" type="button"><i class="fa fa-edit"></i> Guardar Usuario</button> -
                                <button onclick="cargar_contenido('contenido_principal','vista/usuario/usuario.php');" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    var pass_usus = false;

    $(".tipo_rol_usu").select2();

    listar_rol_usu();

    function mostrar_usu() {
        var ver = document.getElementById("password");
        var con = document.getElementById("password_con");

        if (ver.type == "password") {
            ver.type = "text";
            con.type = "text";
        } else {
            ver.type = "password";
            con.type = "password";
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

    document.getElementById("foto").addEventListener("change", () => {
        var filename = document.getElementById("foto").value;
        var idxdot = filename.lastIndexOf(".") + 1;
        var extfile = filename.substr(idxdot, filename.length).toLowerCase();
        if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {} else {
            swal.fire(
                "Mensaje de alerta",
                "Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
                "warning"
            );
            document.getElementById("foto").value = "";
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
            var cadena = "<option value=''> --- Ingrese rol de usuario --- </option>";
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

    $("#tipo_rol_usu").change(function() {
        var id = $(this).val();

        if (id == 1) {
            $("#usuario_p")[0].checked = true
            $("#clientes_p")[0].checked = true
            $("#proveedor_p")[0].checked = true
            $("#datos_empresa_p")[0].checked = true;
            $("#banco_p")[0].checked = true;
            $("#tipo_servicio_p")[0].checked = true;
            $("#productos_p")[0].checked = true;
            $("#compras_p")[0].checked = true;
            $("#facturacion_p")[0].checked = true;
            $("#calificacion_p")[0].checked = true;
            $("#ventas_online_p")[0].checked = true;
            $("#tipos_pagos_p")[0].checked = true;
            $("#envios_p")[0].checked = true;
            $("#registro_promo_p")[0].checked = true;
            $("#promo_vigente_p")[0].checked = true;
            $("#reportes_p")[0].checked = true;
        } else {
            $("#usuario_p")[0].checked = false
            $("#clientes_p")[0].checked = false
            $("#proveedor_p")[0].checked = false
            $("#datos_empresa_p")[0].checked = false;
            $("#banco_p")[0].checked = false;
            $("#tipo_servicio_p")[0].checked = false;
            $("#productos_p")[0].checked = false;
            $("#compras_p")[0].checked = false;
            $("#facturacion_p")[0].checked = false;
            $("#calificacion_p")[0].checked = false;
            $("#ventas_online_p")[0].checked = false;
            $("#tipos_pagos_p")[0].checked = false;
            $("#envios_p")[0].checked = false;
            $("#registro_promo_p")[0].checked = false;
            $("#promo_vigente_p")[0].checked = false;
            $("#reportes_p")[0].checked = false;
        }
    });

    $('#password').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false == enoughRegex.test($(this).val())) {
            $('#passstrength').html('Más caracteres.');
            $('#passstrength').css('color', 'red');

            pass_usus = false;
        } else if (strongRegex.test($(this).val())) {
            $('#passstrength').className = 'ok';
            $('#passstrength').html('Fuerte!');
            $('#passstrength').css('color', 'green');

            pass_usus = true;
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength').className = 'alert';
            $('#passstrength').html('Media!');
            $('#passstrength').css('color', 'orange');

            pass_usus = false
        } else {
            $('#passstrength').className = 'error';
            $('#passstrength').html('Débil!');
            $('#passstrength').css('color', 'red');

            pass_usus = false
        }
        return true;
    });
</script>