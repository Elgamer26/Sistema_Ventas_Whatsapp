<script type="text/javascript" src="js/producto.js"></script>

<br>
<section class="content-header">
    <h3>
        <b> Nuevo producto <i class="fa fa-cube"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Nuevo producto</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-3 form-group">
                                <label>Código</label> &nbsp;&nbsp; <label style="color:red;" id="codigo_oblig"></label>
                                <input type="text" maxlength="20" value="<?php echo rand(0, 9999999); ?>" class="form-control" id="codigos" placeholder="Ingrese codigo (20)" onkeypress="return soloNumeros(event)">
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Nombre producto</label> &nbsp;&nbsp; <label style="color:red;" id="nombre_obliga"></label>
                                <input type="text" maxlength="50" class="form-control" id="nombre_producto" placeholder="Ingrese nombre del producto">
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Tipo produco</label> &nbsp;&nbsp; <label style="color:red;" id="tipo_pro_obligg"></label>
                                <select class="tipo_producto form-control" style="width: 100%" id="tipo_producto"></select>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Marca de producto</label> &nbsp;&nbsp; <label style="color:red;" id="marca_produto_obb"></label>
                                <select class="marca_produto form-control" style="width: 100%" id="marca_produto"></select>
                            </div>

                            <div class="col-sm-12 form-group">
                                <label>Descripción</label> &nbsp;&nbsp; <label style="color:red;" id="descripc_obliga"></label>
                                <textarea class="form-control" rows="3" id="decripcion"></textarea>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Precio venta</label> &nbsp;&nbsp; <label style="color:red;" id="precio_venta_oblig"></label>
                                <input type="text" maxlength="12" class="form-control" id="precio_venta" placeholder="Ingrese precio venta" onkeypress="return filterfloat(event, this);">
                            </div>

                            <div class="col-sm-12 form-group">
                                <label>Foto</label> &nbsp;&nbsp; <label style="color:orange;" id="descripc_obliga">La foto del producto no es obligatorio</label>
                                <input type="file" class="form-control" id="foto">
                            </div>

                            <br>

                            <div class="col-sm-12 form-group">
                                <button onclick="guardar_producto();" class="btn btn-primary" type="button"><i class="fa fa-edit"></i> Guardar</button> -
                                <button onclick="cargar_contenido('contenido_principal','vista/producto/nuevo_producto.php');" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(".tipo_producto").select2();
    $(".marca_produto").select2();

    listar_marca_combo();
    listar_tipo();

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
    function listar_marca_combo() {
        funcion = "listar_marca_combo";
        $.ajax({
            url: "../ADMIN/controlador/producto/producto.php",
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
                $("#marca_produto").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#marca_produto").html(cadena);
            }
        });
    }

    function listar_tipo() {
        funcion = "listar_tipo_comobo";
        $.ajax({
            url: "../ADMIN/controlador/producto/producto.php",
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
                $("#tipo_producto").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#tipo_producto").html(cadena);
            }
        });
    }
</script>