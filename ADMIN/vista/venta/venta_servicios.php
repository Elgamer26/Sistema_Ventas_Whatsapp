<script type="text/javascript" src="js/venta.js"></script>

<?php
date_default_timezone_set('America/Guayaquil');
$fecha = date("Y-m-d");
$codigo = date("YmdHms");
?>

<br>
<section class="content-header">
    <h3>
        <b> Venta servicios <i class="fa fa-dollar"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Venta servicios</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-9 form-group">
                                <label>Cliente</label> &nbsp;&nbsp; <label style="color:red;" id="cliente_obligg"></label>
                                <select class="cliente form-control" id="cliente" style="width:100%;">
                                </select>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>N° venta</label> &nbsp;&nbsp; <label style="color:red;" id="numero_obliga"></label>
                                <input type="text" maxlength="20" class="form-control" id="numero_compra" placeholder="Ingrese numero" value="<?php echo $codigo; ?>" onkeypress="return soloNumeros(event)">
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Tipo comprobante</label>
                                <select class="form-control" id="comprobante_tipo">
                                    <option value="Factura">Factura</option>
                                    <option value="Boleta">Nota de venta</option>
                                </select>
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Impuesto %</label> &nbsp;&nbsp; <label style="color:red;" id="Impuesto_obliga"></label>
                                <input type="text" maxlength="4" class="form-control" id="impuesto" placeholder="0" value="12" onkeypress="return filterfloat(event, this);">
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Fecha</label> &nbsp;&nbsp; <label style="color:red;" id="fecha_obliga"></label>
                                <input type="date" readonly class="form-control" id="fecha_compra" value="<?php echo $fecha; ?>">
                            </div>

                            <div class="col-sm-12 form-group">
                            </div>

                            <div class="col-sm-4 form-group">
                                <label>Servicio</label> &nbsp;&nbsp; <label style="color:red;" id="servicio_obligg"></label>
                                <select class="servicio form-control" id="servicio" style="width:100%;">
                                </select>
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Precio</label> &nbsp;&nbsp; <label style="color:red;" id="precio_compra_obliga"></label>
                                <input readonly type="text" maxlength="10" class="form-control" id="precio_compra">
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Descuento</label> &nbsp;&nbsp; <label style="color:red;" id="descuento_obliga"></label>
                                <input type="text" maxlength="10" value="0.00" class="form-control" id="descuento" placeholder="Ingrese desuento" onkeypress="return filterfloat(event, this);">
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Cantidad</label> &nbsp;&nbsp; <label style="color:red;" id="cantiddad_obliga"></label>
                                <input type="text" maxlength="10" class="form-control" id="cantiddad" value="0" onkeypress="return soloNumeros(event)">
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Ingresar</label>
                                <button onclick="ingresar_detalle_servicio();" class="btn btn-primary"><i class="fa fa-check"></i> Ingresar al detalle</button>
                            </div>

                            <br>

                            <div class="col-lg-12 table-responsive">
                                &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                                <table id="detalle_servicio" class="table table-striped table-bordered">
                                    <thead bgcolor="black" style="color:#fff;">
                                        <tr>
                                            <th>Id</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Desc. moneda - dolar</th>
                                            <th>Subtotal</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbody_detalle_servicio">

                                    </tbody>

                                </table>

                            </div>

                            <div class="col-lg-12" style="text-align: right;">
                                <label for="" id="lbl_totalneto"></label>
                                <input hidden type="text" id=txt_totalneto>
                            </div>


                            <div class="col-lg-12" style="text-align: right;">
                                <label for="" id="lbl_impuesto"></label>
                                <input hidden type="text" id=txt_impuesto>
                            </div>

                            <div class="col-lg-12" style="text-align: right;">
                                <label for="" id="lbl_a_pagar"></label>
                                <input hidden type="text" id=txt_a_pagar>
                            </div>

                            <div class="col-sm-12 form-group">
                                <button onclick="guardar_venta_servicios();" class="btn btn-primary" type="button"><i class="fa fa-check"></i> Guardar venta</button> -
                                <button onclick="cargar_contenido('contenido_principal','vista/venta/venta_servicios.php');" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(".cliente").select2();
    listar_cliente_combo();
    $(".servicio").select2();
    listar_servicio_combo();
    traer_datos_de_empresa();

    $("#servicio").change(function() {
        var id = $("#servicio").val();
        traer_precio_servicio(parseInt(id));
    });

    $("#comprobante_tipo").on("change", function() {
        var valor = $(this).val();

        if (valor == "Boleta") {
            $("#impuesto").attr("disabled", true);
            $("#impuesto").val("0");
        } else {
            $("#impuesto").removeAttr("disabled");
            $("#impuesto").val("12");
            traer_datos_de_empresa();
        }
    });

    ////////////////////////
    function listar_cliente_combo() {
        funcion = "listar_cliente_combo";
        $.ajax({
            url: "../ADMIN/controlador/venta/venta.php",
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
                $("#cliente").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#cliente").html(cadena);
            }
        });
    }

    function listar_servicio_combo() {
        funcion = "listar_servicio_combo";
        $.ajax({
            url: "../ADMIN/controlador/venta/venta.php",
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
                $("#servicio").html(cadena);
                var id = $("#servicio").val();
                traer_precio_servicio(parseInt(id));
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#servicio").html(cadena);
            }
        });
    }

    function traer_precio_servicio(id) {
        funcion = "traer_precio_servicio";
        $.ajax({
            url: "../ADMIN/controlador/venta/venta.php",
            type: "POST",
            data: {
                funcion: funcion,
                id: id,
            },
        }).done(function(response) {
            var data = JSON.parse(response);
            $("#precio_compra").val(data[0][0]);
        });
    }

    ////////////// agregra detalle
    function ingresar_detalle_servicio() {
        var id = $("#servicio").val();
        var servicio = $("#servicio option:selected").text();
        var precio = $("#precio_compra").val();
        var descuento = $("#descuento").val();
        var cantiddad = $("#cantiddad").val();

        var impuesto = $("#impuesto").val();
        var comprobante_tipo = $("#comprobante_tipo").val();

        if (comprobante_tipo == "Factura") {
            if (impuesto.length == 0 || impuesto == "") {
                $("#Impuesto_obliga").html("Ingrese valor");
                return swal.fire("Campo vacios", "Debe ingresar el impuesto", "warning");
            } else {
                $("#Impuesto_obliga").html("");
            }
        } else {
            $("#Impuesto_obliga").html("");
        }

        if (id.length == 0) {
            $("#servicio_obligg").html("No hay servicio");

            return swal.fire(
                "Campo vacios",
                "Debe ingrear un servicio",
                "warning"
            );
        } else {
            $("#servicio_obligg").html("");
        }

        if (precio < 0 || precio.length == 0) {
            $("#precio_compra_obliga").html("Ingrese dato");
            return swal.fire(
                "Campo vacios",
                "Debe ingresar el precio, no debe quedar en 0, ni vacio",
                "warning"
            );
        } else {
            $("#precio_compra_obliga").html("");
        }

        if (descuento < 0 || descuento.length == 0) {
            $("#descuento_obliga").html("Ingrese dato");

            return swal.fire(
                "Campo vacios",
                "Debe ingresar el descuento, o deje en valor 0",
                "warning"
            );
        } else {
            $("#descuento_obliga").html("");
        }

        if (cantiddad <= 0 || cantiddad.length == 0) {
            $("#cantiddad_obliga").html("Ingrese cantidad");

            return swal.fire(
                "Campo vacios",
                "Debe ingresar la cantidad, no deje el valor 0",
                "warning"
            );
        } else {
            $("#cantiddad_obliga").html("");
        }

        if (verificar_venta_servicio(id)) {
            return Swal.fire(
                "Mensaje de advertencia",
                "El servicio '" +
                servicio +
                "' , ya fue agregado al detalle",
                "warning"
            );
        }

        var total = 0,
            agg = 0;
        total = cantiddad * parseFloat(precio).toFixed(2);
        agg = total - parseFloat(descuento).toFixed(2);

        //aqui agrego los labores para unir a la tabla
        var datos_agg = "<tr>";
        datos_agg += "<td for='id'>" + id + "</td>";
        datos_agg += "<td>" + servicio + "</td>";
        datos_agg += "<td>" + cantiddad + "</td>";
        datos_agg += "<td>" + precio + "</td>";
        datos_agg += "<td>" + descuento + "</td>";
        datos_agg += "<td>" + parseFloat(agg).toFixed(2); +
        "</td>";
        datos_agg +=
            "<td><button onclick='remove_venta_servicio(this)' class='btn btn-danger'><i class='fa fa-trash'></i></button></td>";
        datos_agg += "</tr>";

        //esto me ayuda a enviar los datos a la tabla
        $("#tbody_detalle_servicio").append(datos_agg);

        sumartotalneto();

        $("#descuento").val("0.00");
        $("#cantiddad").val("0");
    }

    function remove_venta_servicio(t) {
        var td = t.parentNode;
        var tr = td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr);
        sumartotalneto();
    }

    function sumartotalneto() {
        let arreglo_total = new Array();
        let count = 0;
        let total = 0;
        let impuestototal = 0;
        let subtotal = 0;
        let impuesto = document.getElementById("impuesto").value;

        let tipo_comprobante = document.getElementById("comprobante_tipo").value;

        $("#detalle_servicio tbody#tbody_detalle_servicio tr").each(
            function() {
                arreglo_total.push($(this).find("td").eq(5).text());
                count++;
            }
        );

        for (var i = 0; i < count; i++) {
            var suma = arreglo_total[i];
            subtotal = (parseFloat(subtotal) + parseFloat(suma)).toFixed(2);
            impuestototal = parseFloat(subtotal * impuesto / 100).toFixed(2);
        }
        total = (parseFloat(subtotal) + parseFloat(impuestototal)).toFixed(2);

        if (tipo_comprobante == "Factura") {
            $("#lbl_totalneto").html("<b>Total neto: </b> $/." + subtotal);
            $("#lbl_impuesto").html(
                "<b>impuesto: % " + impuesto + " </b> $/." + impuestototal
            );
            $("#lbl_a_pagar").html("<b>Total a pagar: </b> $/." + total);

            $("#txt_totalneto").val(subtotal);
            $("#txt_impuesto").val(impuestototal);
            $("#txt_a_pagar").val(total);
        } else {
            $("#lbl_totalneto").html("<b>Total neto: </b> $/." + subtotal);
            $("#txt_totalneto").val(subtotal);
            $("#txt_impuesto").val("0.00");
            $("#txt_a_pagar").val("0.00");
        }
    }

    function verificar_venta_servicio(id) {
        let idverificar = document.querySelectorAll(
            "#tbody_detalle_servicio td[for='id']"
        );
        return [].filter.call(idverificar, (td) => td.textContent == id).length == 1;
    }

    
    function traer_datos_de_empresa() {
        funcion = "traer_datos_de_empresa";
        $.ajax({
            url: "../ADMIN/controlador/system/system.php",
            type: "POST",
            data: { funcion: funcion },
        }).done(function (resp) {
            var data = JSON.parse(resp);
            if (data.length > 0) { 
            document.getElementById("impuesto").value = data[0][9]; 
            }
        });
    }
</script>