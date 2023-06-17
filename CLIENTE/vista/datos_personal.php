<script type="text/javascript" src="../ADMIN/js/system.js"></script>

<br>
<section class="content-header">
    <h3>
        <b> Datos cliente <i class="fa fa-user"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Datos cliente</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-6 form-group">
                                <label>Nombres</label> &nbsp;&nbsp; <label style="color:red;" id="nombres_oblig"></label>
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
                                <label>Dirección</label> &nbsp;&nbsp; <label style="color:red;" id="direccion_obliga"></label>
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
                                <label>Password</label> &nbsp;&nbsp; <label style="color:red;" id="passwordd_obliga"></label>
                                <input type="password" maxlength="15" class="form-control" id="password_cl" placeholder="Ingrese password">
                                <span id="passstrength"></span>
                            </div>

                            <div class="col-sm-5 form-group">
                                <label>Confirmar password</label> &nbsp;&nbsp; <label style="color:red;" id="passwordd_obliga_c"></label>
                                <input type="password" maxlength="15" class="form-control" id="password_cl_c" placeholder="Confirmar password">
                            </div>

                            <div class="col-sm-1 form-group">
                                <label>Ver</label>
                                <button onclick="mostrar_usu_clie();" class="btn btn-info"><i class="fa fa-eye"></i> </button>
                            </div>

                            <br> <br>
                            <br> <br>

                            <div class="col-sm-12 form-group">
                                <button onclick="actualizar_datos();" class="btn btn-primary" type="button"><i class="fa fa-save"></i> Actualizar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
 var pass_usus_cli = false;

    function mostrar_usu_clie() {
        var ver = document.getElementById("password_cl");
        var cer = document.getElementById("password_cl_c");

        if (ver.type == "password") {
            ver.type = "text";
            cer.type = "text";
        } else {
            ver.type = "password";
            cer.type = "password";
        }
    }

    traer_datos_cliente();

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

    $('#password_cl').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false == enoughRegex.test($(this).val())) {
            $('#passstrength').html('Más caracteres.');
            $('#passstrength').css('color', 'red');

            pass_usus_cli = false;
        } else if (strongRegex.test($(this).val())) {
            $('#passstrength').className = 'ok';
            $('#passstrength').html('Fuerte!');
            $('#passstrength').css('color', 'green');

            pass_usus_cli = true;
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength').className = 'alert';
            $('#passstrength').html('Media!');
            $('#passstrength').css('color', 'orange');

            pass_usus_cli = false;
        } else {
            $('#passstrength').className = 'error';
            $('#passstrength').html('Débil!');
            $('#passstrength').css('color', 'red');

            pass_usus_cli = false;
        }
        return true;
    });
</script>