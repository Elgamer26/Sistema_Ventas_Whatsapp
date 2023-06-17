<script type="text/javascript" src="js/compra.js"></script>

<?php
date_default_timezone_set('America/Guayaquil');
$fecha = date("Y-m-d");
?>

<br>
<section class="content-header">
    <h3>
        <b> Nuevo compra <i class="fa fa-shopping-cart"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Nuevo compra</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-4 form-group">
                                <label>Proveedor</label> &nbsp;&nbsp; <label style="color:red;" id="razon_oblig"></label>
                                <select class="proveedor form-control" id="proveedor" style="width:100%;">
                                </select>
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>N° compra</label> &nbsp;&nbsp; <label style="color:red;" id="numero_obliga"></label>
                                <input type="text" maxlength="20" class="form-control" id="numero_compra" placeholder="Ingrese numero" onkeypress="return soloNumeros(event)">
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Tipo comprobante</label>
                                <select class="form-control" id="comprobante_tipo">
                                    <option value="Factura">Factura</option>
                                    <option value="Boleta">Nota de compra</option>
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

                            <div class="col-sm-1 form-group">
                                <label>Buscar</label>
                                <button class="btn btn-warning" onclick="modal_poductos();"><i class="fa fa-search"></i></button>
                            </div>

                            <input type="hidden" id="id_marca">

                            <div class="col-sm-3 form-group">
                                <label>Codigo producto</label> &nbsp;&nbsp; <label style="color:red;" id="codigo_mate_obliga"></label>
                                <input readonly type="text" maxlength="10" class="form-control" id="codigi_material" placeholder="Ingrese codigo" onkeypress="return soloNumeros(event)">
                            </div>

                            <div class="col-sm-4 form-group">
                                <label>Nombre</label> &nbsp;&nbsp; <label style="color:red;" id="nombre_ma_obliga"></label>
                                <input readonly type="text" class="form-control" id="nombre_ma">
                            </div>

                            <div class="col-sm-4 form-group">
                                <label>Tipo producto</label>
                                <input readonly type="text" class="form-control" id="tipo_m">
                            </div>


                            <div class="col-sm-2 form-group">
                                <label>Precio compra</label> &nbsp;&nbsp; <label style="color:red;" id="precio_compra_obliga"></label>
                                <input type="text" maxlength="10" class="form-control" id="precio_compra" placeholder="Ingrese precio" onkeypress="return filterfloat(event, this);">
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
                                <button onclick="ingresar_detalle();" class="btn btn-primary"><i class="fa fa-check"></i> Ingresar al detalle</button>
                            </div>

                            <br>

                            <div class="col-lg-12 table-responsive">
                                &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                                <table id="detalle_compra_material" class="table table-striped table-bordered">
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

                                    <tbody id="tbody_detalle_compra_material">

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
                                <button onclick="gardar_compra_material();" class="btn btn-primary" type="button"><i class="fa fa-check"></i> Guardar compra</button> -
                                <button onclick="cargar_contenido('contenido_principal','vista/compra/nueva_compra.php');" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    listar_producto_seelct();
    $(".proveedor").select2();
    listar_proveedor_combo();

    $("#comprobante_tipo").on("change", function() {
        var valor = $(this).val();

        if (valor == "Boleta") {
            $("#impuesto").attr("disabled", true);
            $("#impuesto").val("0");
        } else {
            $("#impuesto").removeAttr("disabled");
            $("#impuesto").val("12");
        }
    });

    ////////////////////////
    function listar_proveedor_combo() {
        funcion = "listar_proveedor_combo";
        $.ajax({
            url: "../ADMIN/controlador/compra/compra.php",
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
                $("#proveedor").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#proveedor").html(cadena);
            }
        });
    }

    ////////////////7 agregra detalle
    function ingresar_detalle() {
        var codigo = $("#codigi_material").val();
        var id_ma = $("#id_marca").val();
        var nombre = $("#nombre_ma").val();
        var tipo = $("#tipo_m").val();
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

        if (id_ma.length == 0 || nombre.length == 0 || codigo.length == 0) {
            $("#codigo_mate_obliga").html("Ingrese dato");
            $("#nombre_ma_obliga").html("Ingrese dato");

            return swal.fire(
                "Campo vacios",
                "Debe ingresar todo del material",
                "warning"
            );
        } else {
            $("#codigo_mate_obliga").html("");
            $("#nombre_ma_obliga").html("");
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

        if (verificar_compra_id(id_ma)) {
            return Swal.fire(
                "Mensaje de advertencia",
                "El producto '" +
                nombre +
                " - " +
                tipo +
                "' , ya fue agregado al detalle",
                "warning"
            );
        }

        var total = 0, agg = 0;
        total = cantiddad * parseFloat(precio).toFixed(2);
        agg = total - parseFloat(descuento).toFixed(2);

        //aqui agrego los labores para unir a la tabla
        var datos_agg = "<tr>";
        datos_agg += "<td for='id'>" + id_ma + "</td>";
        datos_agg += "<td>" + nombre + " - " + tipo + "</td>";
        datos_agg += "<td>" + cantiddad + "</td>";
        datos_agg += "<td>" + precio + "</td>";
        datos_agg += "<td>" + descuento + "</td>";
        datos_agg += "<td>" + parseFloat(agg).toFixed(2); +
        "</td>";
        datos_agg +=
            "<td><button onclick='remove_compra_pro(this)' class='btn btn-danger'><i class='fa fa-trash'></i></button></td>";
        datos_agg += "</tr>";

        //esto me ayuda a enviar los datos a la tabla
        $("#tbody_detalle_compra_material").append(datos_agg);

        sumartotalneto();

        $("#codigi_material").val("");
        $("#id_marca").val("");
        $("#nombre_ma").val("");
        $("#tipo_m").val("");
        $("#precio_compra").val("");
        $("#descuento").val("0.00");
        $("#cantiddad").val("0");
    }

    function remove_compra_pro(t) {
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

        $("#detalle_compra_material tbody#tbody_detalle_compra_material tr").each(
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

    function verificar_compra_id(id) {
        let idverificar = document.querySelectorAll(
            "#tbody_detalle_compra_material td[for='id']"
        );
        return [].filter.call(idverificar, (td) => td.textContent == id).length == 1;
    }
</script>


<div class="modal fade" id="modal_producto_select" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-cubes"></i> Listado de productos</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 table-responsive">
                        &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                        <table id="detalle_producto_select" class="table table-striped table-bordered">
                            <thead bgcolor="black" style="color:#fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Enviar</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Marca</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>

                            <tbody id="tbody_detalle_producto_select">

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