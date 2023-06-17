<script type="text/javascript" src="js/web_sevis.js"></script>
<?php
date_default_timezone_set('America/Guayaquil');
$fecha = date("Y-m-d");
$codigo = date("YmdHms");
?>
<br>

<section class="content-header">
    <h3>
        <b> Nuevo envío <i class="fa fa-send"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Nuevo envío</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-6 form-group">
                                <label>Repartidor</label> &nbsp;&nbsp; <label style="color:red;" id="repartidor_obligg"></label>
                                <select class="repartidor form-control" id="repartidor" style="width:100%;">
                                </select>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Vehículo</label> &nbsp;&nbsp; <label style="color:red;" id="vehículo_obligg"></label>
                                <select class="vehículo form-control" id="vehículo" style="width:100%;">
                                </select>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Marca</label>
                                <input type="text" class="form-control" id="marca_v" readonly>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Matricula</label>
                                <input type="text" class="form-control" id="Matricula_v" readonly>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Color</label>
                                <input type="text" class="form-control" id="Serie_v" readonly>
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>N° envío</label> &nbsp;&nbsp; <label style="color:red;" id="numero_obliga"></label>
                                <input type="text" maxlength="20" class="form-control" id="numero_compra" placeholder="Ingrese numero" value="<?php echo $codigo; ?>" onkeypress="return soloNumeros(event)">
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Fecha</label> &nbsp;&nbsp; <label style="color:red;" id="fecha_obliga"></label>
                                <input type="date" class="form-control" id="fecha_envio" value="<?php echo $fecha; ?>">
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Ventas Online</label>
                                <button class="btn btn-info" onclick="modal_ventass_selct();"><i class="fa fa-search"></i> .: Buscar :. </button>
                            </div>

                            <div class="col-sm-12 form-group">
                            </div>

                            <input type="hidden" id="id_venta">

                            <div class="col-lg-4">
                                <label for="cliente_">Cliente</label> &nbsp;&nbsp; <label style="color:red;" id="cliente__obligg"></label>
                                <input readonly type="text" class="form-control" id="cliente_"><br>
                            </div>

                            <div class="col-lg-2">
                                <label for="tipo_transfereica">Tipo transferencia</label>
                                <input readonly type="text" class="form-control" id="tipo_transfereica"><br>
                            </div>

                            <div class="col-lg-2">
                                <label for="numero_venta">N° venta</label>
                                <input readonly type="text" class="form-control" id="numero_venta"><br>
                            </div>

                            <div class="col-lg-4">
                                <label for="direccion_envio">Dirección</label>
                                <input readonly type="text" class="form-control" id="direccion_envio"><br>
                            </div>

                            <div class="col-lg-4">
                                <label for="referencia">Referencia</label>
                                <input readonly type="text" class="form-control" id="referencia"><br>
                            </div>

                            <div class="col-lg-2">
                                <label for="cantidad_pro">Cant. productos</label>
                                <input readonly type="text" class="form-control" id="cantidad_pro"><br>
                            </div>

                            <div class="col-lg-2">
                                <label for="vlor_envio">Valor del envio</label> &nbsp;&nbsp; <label style="color:red;" id="valorr__obligg"></label>
                                <input class="form-control" id="vlor_envio" value="0" type="number"><br>
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Ingresar</label>
                                <button onclick="ingresar_detalle_envio();" class="btn btn-primary"><i class="fa fa-download"></i> Ingresar al detalle</button>
                            </div>

                            <br>

                            <div class="col-lg-12 table-responsive">
                                &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                                <table id="detalle_envio" class="table table-striped table-bordered">
                                    <thead bgcolor="black" style="color:#fff;">
                                        <tr>
                                            <th style="display: none;">Id</th>
                                            <th>Cliente</th>
                                            <th>Tipo transf.</th>
                                            <th>Num. venta</th>
                                            <th>Dirección</th>
                                            <th>Referencia</th>
                                            <th>Cant. producto</th>
                                            <th>Valor envio</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbody_detalle_envio">

                                    </tbody>

                                </table>

                            </div>

                            <div class="col-lg-12" style="text-align: right;">
                                <label for="" id="lbl_totalneto"></label>
                                <input hidden type="text" id="txt_totalneto">
                            </div>

                            <div class="col-sm-12 form-group">
                                <button onclick="guardar_envio_venta();" class="btn btn-primary" type="button"><i class="fa fa-check"></i> Guardar envío</button> -
                                <button onclick="cargar_contenido('contenido_principal','vista/servicio_web/nuevo_envios.php');" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    listar_ventass_selecionar();

    $(".repartidor").select2();
    $(".vehículo").select2();
    listar_repartiro_combo();
    listar_vehiculo_combo();

    ////////////////////////
    function listar_repartiro_combo() {
        funcion = "listar_repartiro_combo";
        $.ajax({
            url: "../ADMIN/controlador/web_servis/web_servis.php",
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
                        "<option value='" + data[i][0] + "'> " + data[i][1] + " " + data[i][2] + " - " + data[i][3] + " - Licencia: " + data[i][8] + "</option>";
                }
                //aqui concadenamos al id del select
                $("#repartidor").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#repartidor").html(cadena);
            }
        });
    }

    function listar_vehiculo_combo() {
        funcion = "listar_vehiculo_combo";
        $.ajax({
            url: "../ADMIN/controlador/web_servis/web_servis.php",
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
                $("#vehículo").html(cadena);
                var id = $("#vehículo").val();
                traer_datos_vehculos(parseInt(id));
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#vehículo").html(cadena);
            }
        });
    }

    $("#vehículo").change(function() {
        var id = $(this).val();
        traer_datos_vehculos(parseInt(id));
    });

    function traer_datos_vehculos(id) {
        funcion = "traer_datos_vehculos";
        $.ajax({
            url: "../ADMIN/controlador/web_servis/web_servis.php",
            type: "POST",
            data: {
                funcion: funcion,
                id: id,
            },
        }).done(function(response) {
            var data = JSON.parse(response);
            $("#marca_v").val(data[0][2]);
            $("#Matricula_v").val(data[0][3]);
            $("#Serie_v").val(data[0][4]);
        });
    }

    //////////////////////////
    ////////////// agregra detalle
    function ingresar_detalle_envio() {
        var id = $("#id_venta").val();
        var cliente = $("#cliente_").val();
        var tipo = $("#tipo_transfereica").val();
        var numero_venta = $("#numero_venta").val();
        var direccion_envio = $("#direccion_envio").val();
        var referencia = $("#referencia").val();
        var cantidad_pro = $("#cantidad_pro").val();
        var vlor_envio = $("#vlor_envio").val();


        if (id.length == 0 || cliente.length == 0) {
            $("#cliente__obligg").html("No hay venta seleccionada");
            return swal.fire(
                "Campo vacios",
                "Debe ingrear un producto",
                "warning"
            );
        } else {
            $("#cliente__obligg").html("");
        }

        if (vlor_envio <= 0 || vlor_envio.length == 0 || vlor_envio == "") {
            $("#valorr__obligg").html("XXX");
            return swal.fire(
                "Campo vacio",
                "Ingrese el valor de envío",
                "warning"
            );
        } else {
            $("#valorr__obligg").html("");
        }

        if (verificar_envio(id)) {
            return Swal.fire(
                "Mensaje de advertencia",
                "La venta '" +
                numero_venta +
                "' , ya fue agregado al detalle",
                "warning"
            );
        }

        //aqui agrego los labores para unir a la tabla
        var datos_agg = "<tr>";
        datos_agg += "<td for='id'  style='display: none;'>" + id + "</td>";
        datos_agg += "<td>" + cliente + "</td>";
        datos_agg += "<td>" + tipo + "</td>";
        datos_agg += "<td>" + numero_venta + "</td>";
        datos_agg += "<td>" + direccion_envio + "</td>";
        datos_agg += "<td>" + referencia + "</td>";
        datos_agg += "<td>" + cantidad_pro + "</td>";
        datos_agg += "<td>" + vlor_envio + "</td>";
        datos_agg +=
            "<td><button onclick='remove_envio(this)' class='btn btn-danger'><i class='fa fa-trash'></i></button></td>";
        datos_agg += "</tr>";
        $("#tbody_detalle_envio").append(datos_agg);

        sumartotalneto_envio();
        $("#id_venta").val("");
        $("#cliente_").val("");
        $("#tipo_transfereica").val("");
        $("#numero_venta").val("");
        $("#direccion_envio").val("");
        $("#referencia").val("");
        $("#cantidad_pro").val("");
        $("#vlor_envio").val("0");
    }

    function remove_envio(t) {
        var td = t.parentNode;
        var tr = td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr);
        sumartotalneto_envio();
    }

    function sumartotalneto_envio() {
        let arreglo_total = new Array();
        let count = 0;
        let total = 0;
        let subtotal = 0;
        $("#detalle_envio tbody#tbody_detalle_envio tr").each(
            function() {
                arreglo_total.push($(this).find("td").eq(7).text());
                count++;
            }
        );
        for (var i = 0; i < count; i++) {
            var suma = arreglo_total[i];
            subtotal = (parseFloat(subtotal) + parseFloat(suma)).toFixed(2);
        }
        total = parseFloat(subtotal).toFixed(2);
        $("#lbl_totalneto").html("<b>Total: </b> $/." + total);
        $("#txt_totalneto").val(total);
    }

    function verificar_envio(id) {
        let idverificar = document.querySelectorAll(
            "#tbody_detalle_envio td[for='id']"
        );
        return [].filter.call(idverificar, (td) => td.textContent == id).length == 1;
    }
</script>

<div class="modal fade" id="modal_ventas_selecionar" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 95% !important;">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-cubes"></i> Listado de ventas no enviadas</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 table-responsive">
                        &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                        <table id="detalle_ventas_seleccionar" class="table-responsive table table-striped table-bordered">
                            <thead bgcolor="black" style="color:#fff;">
                                <tr>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Tipo</th>
                                    <th>Cliente</th>
                                    <th>Dirección</th>
                                    <th>Referencia</th>
                                    <th>Cantidad</th>
                                    <th>Cod. venta</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>