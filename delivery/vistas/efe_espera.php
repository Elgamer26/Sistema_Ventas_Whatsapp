<script type="text/javascript" src="../../ADMIN/js/repartidor.js"></script>

<br>

<section class="content-header">
    <h3>
        <b> Efectivo en espera <i class="sidebar-item-icon fa fa-minus-circle"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Efectivo en espera</div>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_efectivo_espera" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Subir foto</th>
                                    <th>Estado</th>
                                    <th>N° compra</th>
                                    <th>Cliente</th>
                                    <th>Dirección</th>
                                    <th>Referencia</th>
                                    <th>Fecha compra</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Subir foto</th>
                                    <th>Estado</th>
                                    <th>N° compra</th>
                                    <th>Cliente</th>
                                    <th>Dirección</th>
                                    <th>Referencia</th>
                                    <th>Fecha compra</th>
                                    <th>Monto</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_photo" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #f39c12; color:white;">
                <h4 class="modal-title"><i class="fa fa-image"></i> Subir foto del efectivo</h4>
            </div>

            <div class="modal-body">

                <div class="row">

                    <input type="number" id="id_efectivoo" hidden>
                    <input type="number" id="id_clentee" hidden>

                    <div class="col-sm-12 form-group">
                        <div class="ibox-body text-center">
                            <h5 class="font-strong m-b-10 m-t-10"><span>Foto de efectivo</span></h5>
                            <div>
                                <input type="file" id="foto_new" class="form-control">
                                <br>
                                <h5 class="font-strong m-b-10 m-t-10"><span>Detalle del efectivo</span> <label style="color: red;" id="lbl_detalle_"></label>  </h5> 
                                <textarea class="form-control" id="txt_detalle" cols="30" rows="4"></textarea>

                                <br>
                                <button class="btn btn-info btn-rounded m-b-5" onclick="subir_photo();"><i class="fa fa-plus"></i> Subir foto</button>
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
    listar_efectivo_espera();

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