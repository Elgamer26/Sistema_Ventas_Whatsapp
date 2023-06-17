<script type="text/javascript" src="js/venta.js"></script>

<?php
date_default_timezone_set('America/Guayaquil');
$fecha = date("Y-m-d");
$codigo = date("YmdHms");
?>

<br>
<section class="content-header">
    <h3>
        <b> Nueva venta <i class="fa fa-dollar"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Nueva venta</div>
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

                            <div class="col-sm-2 form-group">
                                <label>Productos</label>
                                <button class="btn btn-info" onclick="modal_producto_selct();"><i class="fa fa-cubes"></i> .:Buscar productos:. </button>
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Ofertas</label>
                                <button class="btn btn-success" onclick="modal_producto_oferta_select();"><i class="fa fa-gift"></i> .:Buscar Ofertas:. </button>
                            </div>

                            <div class="col-sm-12 form-group">
                            </div>

                            <input type="hidden" id="id_productos">

                            <div class="col-lg-4">
                                <label for="nombre_prodc">Producto</label> &nbsp;&nbsp; <label style="color:red;" id="producto_obligg_a"></label>
                                <input readonly type="text" class="form-control" id="nombre_prodc" placeholder="Producto"><br>
                            </div>

                            <div class="col-lg-3">
                                <label for="tipo_producto">Tipo producto</label>
                                <input readonly type="text" class="form-control" id="tipo_producto" placeholder="Tipo producto"><br>
                            </div>

                            <div class="col-lg-3">
                                <label for="marca_product">Marca producto</label>
                                <input readonly type="text" class="form-control" id="marca_product" placeholder="Marca producto"><br>
                            </div>

                            <div class="col-lg-2">
                                <label for="stock_product">Stock</label> &nbsp;&nbsp; <label style="color:red;" id="stock_obligg_a"></label>
                                <input readonly type="text" class="form-control" id="stock_product" placeholder="Stock"><br>
                            </div>

                            <div class="col-lg-2">
                                <label for="">Tipo promocion</label>
                                <input readonly class="form-control" id="tipo_pro" type="text"><br>
                            </div>

                            <div class="col-lg-2">
                                <label for="">Desc. promoción</label>
                                <input readonly class="form-control" id="descuento_promo" value="0" type="number"><br>
                            </div>

                            <div class="col-lg-12">
                            </div>

                            <div class="col-lg-2">
                                <label for="">Cantidad</label> &nbsp;&nbsp; <label style="color:red;" id="cantidada_obligg_a"></label>
                                <input min="1" class="form-control" id="cantidad" type="number" min="1" value="0" onkeypress="return soloNumeros(event)"><br>
                            </div>

                            <div class=" col-lg-2">
                                <label for="">Precio $/</label> &nbsp;&nbsp; <label style="color:red;" id="precio_obligg_a"></label>
                                <input readonly type="text" value="0" class="form-control" id="precio" style="background: #dd4b39; color: white;"><br>
                            </div>

                            <div class="col-lg-2">
                                <label for="">Desc. $/ en moneda</label> &nbsp;&nbsp; <label style="color:red;" id="descuenot_obligg_a"></label>
                                <input onkeypress="return filterfloat(event, this);" min="0" type="text" value="0" class="form-control" id="descuento"><br>
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Ingresar</label>
                                <button onclick="ingresar_detalle_producto();" class="btn btn-primary"><i class="fa fa-check"></i> Ingresar al detalle</button>
                            </div>

                            <br>

                            <div class="col-lg-12 table-responsive">
                                &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                                <table id="detalle_producto_" class="table table-striped table-bordered">
                                    <thead bgcolor="black" style="color:#fff;">
                                        <tr>
                                            <th>Id</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Sale</th>
                                            <th>Precio</th>
                                            <th>Tipo oferta</th>
                                            <th>Desc. oferta</th>
                                            <th>Desc. moneda</th>
                                            <th>Subtotal</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbody_detalle_producto_">

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
                                <button onclick="guardar_venta_productos();" class="btn btn-primary" type="button"><i class="fa fa-check"></i> Guardar venta</button> -
                                <button onclick="cargar_contenido('contenido_principal','vista/venta/nueva_venta.php');" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    listar_producto_oferta_selecionar();
    listar_producto_selecionar();
    traer_datos_de_empresa();

    $(".cliente").select2();
    listar_cliente_combo();

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

    ////////////// agregra detalle
    function ingresar_detalle_producto() {
        var id = $("#id_productos").val();
        var producto = $("#nombre_prodc").val();
        var tipo = $("#tipo_producto").val();

        var stock = $("#stock_product").val();
        var tipo_pro = $("#tipo_pro").val();
        var descuento_promo = $("#descuento_promo").val();

        var precio = $("#precio").val();
        var descuento = $("#descuento").val();
        var cantiddad = $("#cantidad").val();

        var impuesto = $("#impuesto").val();
        var comprobante_tipo = $("#comprobante_tipo").val();
        var sale = 0;
        var des_ofer = 0;

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

        if (id.length == 0 || producto.length == 0 || tipo.length == 0) {
            $("#producto_obligg_a").html("No hay producto");

            return swal.fire(
                "Campo vacios",
                "Debe ingrear un producto",
                "warning"
            );
        } else {
            $("#producto_obligg_a").html("");
        }

        if (precio < 0 || precio.length == 0) {
            $("#precio_obligg_a").html("Ingrese precio");
            return swal.fire(
                "Campo vacios",
                "Debe ingresar el precio, no debe quedar en 0, ni vacio",
                "warning"
            );
        } else {
            $("#precio_obligg_a").html("");
        }

        if (descuento < 0 || descuento.length == 0) {
            $("#descuenot_obligg_a").html("Ingrese valor");

            return swal.fire(
                "Campo vacios",
                "Debe ingresar el descuento, o deje en valor 0",
                "warning"
            );
        } else {
            $("#descuenot_obligg_a").html("");
        }

        if (cantiddad <= 0 || cantiddad.length == 0) {
            $("#cantidada_obligg_a").html("Ingrese cantidad");

            return swal.fire(
                "Campo vacios",
                "Debe ingresar la cantidad, no deje el valor 0",
                "warning"
            );
        } else {
            $("#cantidada_obligg_a").html("");
        }

        if (tipo_pro == '2x1') {
            sale = 2 * cantiddad;
        } else if (tipo_pro == '3x1') {
            sale = 3 * cantiddad;
        } else {
            sale = cantiddad;
        }

        if (tipo_pro == 'Descuento') {
            des_ofer = parseFloat(precio * descuento_promo / 100).toFixed(2);
        } else {
            des_ofer = 0;
        }

        if (parseInt(sale) > parseInt(stock)) {
            $("#stock_obligg_a").html("XX");
            $("#cantidada_obligg_a").html("XXX");
            return Swal.fire(
                "Mensaje de advertencia",
                "La cantidad " + sale + " ingresa supera el stock " + stock + " actual del producto",
                "warning"
            );
        } else {
            $("#stock_obligg_a").html("");
            $("#cantidada_obligg_a").html("");
        }

        if (verificar_venta_producto(id)) {
            return Swal.fire(
                "Mensaje de advertencia",
                "El producto '" +
                producto +
                "' , ya fue agregado al detalle",
                "warning"
            );
        }

        var total = 0, agg = 0;
        total = cantiddad * parseFloat(precio).toFixed(2);
        agg = parseFloat(total - descuento - des_ofer).toFixed(2);

        //aqui agrego los labores para unir a la tabla
        var datos_agg = "<tr>";
        datos_agg += "<td for='id'>" + id + "</td>";
        datos_agg += "<td>" + producto + " " + tipo + "</td>";
        datos_agg += "<td>" + cantiddad + "</td>";
        datos_agg += "<td>" + sale + "</td>";
        datos_agg += "<td>" + precio + "</td>";

        datos_agg += "<td>" + tipo_pro + "</td>";
        datos_agg += "<td>" + des_ofer + "</td>";
        datos_agg += "<td>" + descuento + "</td>";

        datos_agg += "<td>" + parseFloat(agg).toFixed(2); +
        "</td>";
        datos_agg +=
            "<td><button onclick='remove_venta_producto(this)' class='btn btn-danger'><i class='fa fa-trash'></i></button></td>";
        datos_agg += "</tr>";

        $("#tbody_detalle_producto_").append(datos_agg);

        sumartotalneto_venta();
        $("#id_productos").val("");
        $("#nombre_prodc").val("");
        $("#tipo_producto").val("");

        $("#stock_product").val("");
        $("#tipo_pro").val("");
        $("#descuento_promo").val("");

        $("#precio").val("0");
        $("#descuento").val("0");
        $("#cantidad").val("0");
    }

    function remove_venta_producto(t) {
        var td = t.parentNode;
        var tr = td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr);
        sumartotalneto_venta();
    }

    function sumartotalneto_venta() {
        let arreglo_total = new Array();
        let count = 0;
        let total = 0;
        let impuestototal = 0;
        let subtotal = 0;
        let impuesto = document.getElementById("impuesto").value;
        let tipo_comprobante = document.getElementById("comprobante_tipo").value;

        $("#detalle_producto_ tbody#tbody_detalle_producto_ tr").each(
            function() {
                arreglo_total.push($(this).find("td").eq(8).text());
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

    function verificar_venta_producto(id) {
        let idverificar = document.querySelectorAll(
            "#tbody_detalle_producto_ td[for='id']"
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

<div class="modal fade" id="modal_producto_selecionar" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-cubes"></i> Listado de productos</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 table-responsive">
                        &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                        <table id="detalle_producto_seleccionar" class="table table-striped table-bordered">
                            <thead bgcolor="black" style="color:#fff;">
                                <tr>

                                    <th>Enviar</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Marca</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>

                            <tbody id="tbody_detalle_producto_seleccionar">

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

<div class="modal fade" id="modal_producto_oferta_selecionar" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-cubes"></i> Listado de ofertas</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 table-responsive">
                        &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                        <table id="detalle_producto_oferta_seleccionar" class="table table-striped table-bordered">
                            <thead bgcolor="black" style="color:#fff;">
                                <tr>

                                    <th>Enviar</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Tipo</th>
                                    <th>Desc.</th>
                                </tr>
                            </thead>

                            <tbody id="tbody_detalle_producto_oferta_seleccionar">

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