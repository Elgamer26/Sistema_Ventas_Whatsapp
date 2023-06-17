<script type="text/javascript" src="../ADMIN/js/producto.js"></script>

<br>
<section class="content-header">
    <h3>
        <b> Listado de productos <i class="fa fa-list"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de productos</div>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_productos_" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Disponible</th>
                                    <th>Estado</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                    <th>Foto</th>
                                    <th>Marca producto</th>
                                    <th>Tipo producto</th>
                                    <th>Precio venta</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Disponible</th>
                                    <th>Estado</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                    <th>Foto</th>
                                    <th>Marca producto</th>
                                    <th>Tipo producto</th>
                                    <th>Precio venta</th>
                                    <th>Descripción</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_editar_producto" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar producto</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <input type="hidden" id="id_producto_edit">

                    <div class="col-sm-6 form-group">
                        <label>Código</label> &nbsp;&nbsp; <label style="color:red;" id="codigo_oblig"></label>
                        <input type="text" maxlength="20" value="<?php echo rand(0, 9999999); ?>" class="form-control" id="codigos" placeholder="Ingrese codigo (20)" onkeypress="return soloNumeros(event)">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Nombre producto</label> &nbsp;&nbsp; <label style="color:red;" id="nombre_obliga"></label>
                        <input type="text" maxlength="50" class="form-control" id="nombre_producto" placeholder="Ingrese nombre del producto">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Tipo produco</label> &nbsp;&nbsp; <label style="color:red;" id="tipo_pro_obligg"></label>
                        <select class="tipo_producto form-control" style="width: 100%" id="tipo_producto"></select>
                    </div>

                    <div class="col-sm-6 form-group">
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

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="ediar_productoo()"><i class="fa fa-edit"></i> Editar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_photo" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #f39c12; color:white;">
                <h4 class="modal-title"><i class="fa fa-image"></i> Editar foto de producto</h4>
            </div>

            <div class="modal-body">

                <div class="row">

                    <input type="number" id="id_foto_producto" hidden>

                    <div class="col-sm-12 form-group">
                        <div class="ibox-body text-center">

                            <img class="img-circle" id="foto_producto" white="100px" height="100px">
                            <h5 class="font-strong m-b-10 m-t-10"><span>Foto de producto</span></h5>
                            <div>
                                <button class="btn btn-info btn-rounded m-b-5" onclick="editar_foto_producto();"><i class="fa fa-plus"></i> Cambiar foto</button>
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
    $(".tipo_producto").select2();
    $(".marca_produto").select2();

    listar_marca_combo();
    listar_tipo();
    listar_prodcuto();

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