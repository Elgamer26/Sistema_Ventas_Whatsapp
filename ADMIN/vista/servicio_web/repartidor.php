<script type="text/javascript" src="../ADMIN/js/web_sevis.js"></script>
<br>
<section class="content-header">
    <h3>
        <b> Repartidores <i class="fa fa-users"></i> </b> <button class="btn btn-danger" onclick="nuevo_repartidor();"><i class="fa fa-plus"></i> Nuevo repartidor</button>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de repartidores</div>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_repartidor" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Foto</th>
                                    <th>Tipo de licencia</th>
                                    <th>Sexo</th>
                                    <th>Cedula</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Direccion</th>
                                    <th>Usuario</th>
                                    <th>Password</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Foto</th>
                                    <th>Tipo de licencia</th>
                                    <th>Sexo</th>
                                    <th>Cedula</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Direccion</th>
                                    <th>Usuario</th>
                                    <th>Password</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_repartidor" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nuevo repartidor</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-6 form-group">
                        <label>Nombres</label> &nbsp;&nbsp; <label style="color:red;" id="edit_nombres_oblig"></label>
                        <input type="text" maxlength="100" class="form-control" id="nombress" placeholder="Ingrese Nombres" onkeypress="return soloLetras(event)">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Apellidos</label> &nbsp;&nbsp; <label style="color:red;" id="apellidos_oblig"></label>
                        <input type="text" maxlength="100" class="form-control" id="apellidoss" placeholder="Ingrese apellidos" onkeypress="return soloLetras(event)">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Cedula</label> &nbsp;&nbsp; <label style="color:red;" id="cedula_obliga"></label>
                        <input type="text" maxlength="10" class="form-control" id="numero_docu" placeholder="Ingrese cedula" onkeypress="return soloNumeros(event)">
                        <label for="" id="cedula_empleado" style="color: red; font-size: 12px;"></label>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Telefono</label> &nbsp;&nbsp; <label style="color:red;" id="telefono_obliga"></label>
                        <input type="text" maxlength="10" class="form-control" id="telefono_p" placeholder="Ingrese telefono" onkeypress="return soloNumeros(event)">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Correo</label> &nbsp;&nbsp; <label style="color:red;" id="correo_obliga"></label>
                        <input type="text" maxlength="30" class="form-control" id="correo_p" placeholder="Ingrese correo">
                        <label for="" id="email_correcto" style="color: red;"></label>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Domicilio</label> &nbsp;&nbsp; <label style="color:red;" id="direccion_obliga"></label>
                        <input type="text" maxlength="40" class="form-control" id="direccions" placeholder="Ingrese direccions">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Sexo</label>
                        <select class="form-control" id="sexo">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Tipo de licencia</label> &nbsp;&nbsp; <label style="color:red;" id="tipo_lice_obliga"></label>
                        <input type="text" maxlength="40" class="form-control" id="tipo_licencia" placeholder="Ingrese tipo de licencia">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Usuario</label> &nbsp;&nbsp; <label style="color:red;" id="usuario_obliga"></label>
                        <input type="text" maxlength="20" class="form-control" id="usuario" placeholder="Ingrese usuario" onkeypress="return soloLetras(event)">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Foto</label> &nbsp;&nbsp; <label style="color: orange;">La foto no es obligatoria</label>
                        <input type="file" maxlength="20" class="form-control" id="foto_repa">
                    </div>

                    <div class="col-sm-12 form-group">

                        <div class="row">

                            <div class="col-sm-6 form-group">
                                <label>Password</label> &nbsp;&nbsp; <label style="color:red;" id="pass_obliga"></label>
                                <input type="password" maxlength="15" class="form-control" id="password" placeholder="Ingrese password">
                                <span id="passstrength"></span>
                            </div>

                            <div class="col-sm-5 form-group">
                                <label>Confirmar password</label> &nbsp;&nbsp; <label style="color:red;" id="pass_obliga_conf"></label>
                                <input type="password" maxlength="15" class="form-control" id="password_conf" placeholder="Confirmar password">
                            </div>

                            <div class="col-sm-1 form-group">
                                <label>..........</label>
                                <button onclick="mostrar_usu();" class="btn btn-danger"> <i class="fa fa-eye"></i></button>
                            </div>
                        </div>

                    </div>



                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-success" onclick="registro_repartidor();"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_repartidor_editar" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar repartidor</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <input type="number" id="id_repartidor" hidden>

                    <div class="col-sm-6 form-group">
                        <label>Nombres</label> &nbsp;&nbsp; <label style="color:red;" id="edit_nombres_oblig"></label>
                        <input type="text" maxlength="100" class="form-control" id="nombress_edit" placeholder="Ingrese Nombres" onkeypress="return soloLetras(event)">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Apellidos</label> &nbsp;&nbsp; <label style="color:red;" id="edit_apellidos_oblig"></label>
                        <input type="text" maxlength="100" class="form-control" id="apellidoss_edit" placeholder="Ingrese apellidos" onkeypress="return soloLetras(event)">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Cedula</label> &nbsp;&nbsp; <label style="color:red;" id="edit_cedula_obliga"></label>
                        <input type="text" maxlength="10" class="form-control" id="numero_docu_edit" placeholder="Ingrese cedula" onkeypress="return soloNumeros(event)">
                        <label for="" id="cedula_empleado" style="color: red; font-size: 12px;"></label>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Telefono</label> &nbsp;&nbsp; <label style="color:red;" id="edit_telefono_obliga"></label>
                        <input type="text" maxlength="10" class="form-control" id="telefono_p_edit" placeholder="Ingrese telefono" onkeypress="return soloNumeros(event)">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Correo</label> &nbsp;&nbsp; <label style="color:red;" id="edit_correo_obliga"></label>
                        <input type="text" maxlength="30" class="form-control" id="correo_p_edit" placeholder="Ingrese correo">
                        <label for="" id="email_correcto" style="color: red;"></label>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Domicilio</label> &nbsp;&nbsp; <label style="color:red;" id="edit_direccion_obliga"></label>
                        <input type="text" maxlength="40" class="form-control" id="direccions_edit" placeholder="Ingrese direccions">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Sexo</label>
                        <select class="form-control" id="sexo_edit">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Tipo de licencia</label> &nbsp;&nbsp; <label style="color:red;" id="edit_tipo_lice_obliga"></label>
                        <input type="text" maxlength="40" class="form-control" id="tipo_licencia_edit" placeholder="Ingrese tipo de licencia">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Usuario</label> &nbsp;&nbsp; <label style="color:red;" id="usuario_obliga_e"></label>
                        <input type="text" maxlength="15" class="form-control" id="usuario_e" placeholder="Ingrese usuario" onkeypress="return soloLetras(event)">
                    </div>

                    <div class="col-sm-5 form-group">
                        <label>Password</label> &nbsp;&nbsp; <label style="color:red;" id="pass_obliga_e"></label>
                        <input type="password" maxlength="15" class="form-control" id="password_e" placeholder="Ingrese password">
                        <span id="passstrength_e"></span>
                    </div>

                    <div class="col-sm-1 form-group">
                        <label>..........</label>
                        <button onclick="mostrar_usu_e();" class="btn btn-danger"> <i class="fa fa-eye"></i></button>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="ediatr_repartidor();"><i class="fa fa-edit"></i> Editar</button>
            </div>
        </div>
    </div>
</div>


<!-- ////// -->
<div class="modal fade" id="modal_editar_photo" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #f39c12; color:white;">
                <h4 class="modal-title"><i class="fa fa-image"></i> Editar foto de repartidor</h4>
            </div>

            <div class="modal-body">

                <div class="row">

                    <input type="number" id="id_foto_producto" hidden>

                    <div class="col-sm-12 form-group">
                        <div class="ibox-body text-center">

                            <img class="img-circle" id="foto_producto" white="100px" height="100px">
                            <h5 class="font-strong m-b-10 m-t-10"><span>Foto de repartidor</span></h5>
                            <div>
                                <button class="btn btn-info btn-rounded m-b-5" onclick="editar_foto_repartidor();"><i class="fa fa-plus"></i> Cambiar foto</button>
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
    var pass_deli_e = false;
    $('#password').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false == enoughRegex.test($(this).val())) {
            $('#passstrength').html('Más caracteres.');
            $('#passstrength').css('color', 'red');
            pass_deli_e = false;
        } else if (strongRegex.test($(this).val())) {
            $('#passstrength').className = 'ok';
            $('#passstrength').html('Fuerte!');
            $('#passstrength').css('color', 'green');
            pass_deli_e = true;
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength').className = 'alert';
            $('#passstrength').html('Media!');
            $('#passstrength').css('color', 'orange');
            pass_deli_e = false;
        } else {
            $('#passstrength').className = 'error';
            $('#passstrength').html('Débil!');
            $('#passstrength').css('color', 'red');
            pass_deli_e = false;
        }
        return true;
    });


    //////
    function mostrar_usu() {
        var ver = document.getElementById("password");
        var conf = document.getElementById("password_conf");

        if (ver.type == "password") {
            ver.type = "text";
            conf.type = "text";
        } else {
            ver.type = "password";
            conf.type = "password";
        }
    }

    function mostrar_usu_e() {
        var ver = document.getElementById("password_e");

        if (ver.type == "password") {
            ver.type = "text";
        } else {
            ver.type = "password";
        }
    }

    listar_repartidor();

    $('#password_e').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false == enoughRegex.test($(this).val())) {
            $('#passstrength_e').html('Más caracteres.');
            $('#passstrength_e').css('color', 'red');
        } else if (strongRegex.test($(this).val())) {
            $('#passstrength_e').className = 'ok';
            $('#passstrength_e').html('Fuerte!');
            $('#passstrength_e').css('color', 'green');
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength_e').className = 'alert';
            $('#passstrength_e').html('Media!');
            $('#passstrength_e').css('color', 'orange');
        } else {
            $('#passstrength_e').className = 'error';
            $('#passstrength_e').html('Débil!');
            $('#passstrength_e').css('color', 'red');
        }
        return true;
    });

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

    $("#correo_p").keyup(function() {
        if (this.value != "") {
            document.getElementById('correo_p').addEventListener('input', function() {
                campo = event.target;
                //este codigo me da formato email
                email = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                //esto es para validar si es un email valida
                if (email.test(campo.value)) {
                    //estilos para cambiar de color y ocultar el boton
                    $(this).css("border", "1px solid green");
                    $("#email_correcto").html("");
                } else {
                    $(this).css("border", "1px solid red");
                    $("#email_correcto").html("Email incorrecto");
                }
            });
        } else {
            $(this).css("border", "1px solid green");
            $("#email_correcto").html("");
        }
    });

    document.getElementById("foto_repa").addEventListener("change", () => {
        var filename = document.getElementById("foto_repa").value;
        var idxdot = filename.lastIndexOf(".") + 1;
        var extfile = filename.substr(idxdot, filename.length).toLowerCase();
        if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {} else {
            swal.fire(
                "Mensaje de alerta",
                "Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
                "warning"
            );
            document.getElementById("foto_repa").value = "";
        }
    });

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
</script>