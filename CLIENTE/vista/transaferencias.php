<script type="text/javascript" src="../ADMIN/js/carrito.js"></script>

<br>

<section class="content-header">
    <h3>
        <b> Listado transferencias <i class="fa fa-bank"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista transferencias</div>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_transferencia" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Comprobante</th>
                                    <th>Estado</th>
                                    <th>Cliente</th>
                                    <th>Cod. transferencia</th>
                                    <th>N° venta</th>
                                    <th>banco</th>
                                    <th>Fecha petición</th>
                                    <th>Monto</th>
                                    <th>Valor transferencia</th>
                                    <th>Fecha deposito</th>
                                    <th>Fecha proceso</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Comprobante</th>
                                    <th>Estado</th>
                                    <th>Cliente</th>
                                    <th>Cod. transferencia</th>
                                    <th>N° venta</th>
                                    <th>banco</th>
                                    <th>Fecha petición</th>
                                    <th>Monto</th>
                                    <th>Valor transferencia</th>
                                    <th>Fecha deposito</th>
                                    <th>Fecha proceso</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_photo_comprobante" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #f39c12; color:white;">
                <h4 class="modal-title"><i class="fa fa-image"></i> Subir foto de la transaferencia</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <input type="number" hidden id="id_transferencia">
                    <input type="number" hidden id="id_venta_onlinee">
                    <div class="col-sm-12 form-group">
                        <div class="ibox-body text-center">
                            <h5 class="font-strong m-b-10 m-t-10"><span>Foto transferencia</span></h5>
                            <div>                               
                                <input type="file" id="foto_trans" class="form-control">
                                <br>
                                <button class="btn btn-info btn-rounded m-b-5" onclick="cargar_foto_transferencia();"><i class="fa fa-upload"></i> Cargar foto</button>
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
    lista_transferencia_bancaria_cliente();

    document.getElementById("foto_trans").addEventListener("change", () => {
        var filename = document.getElementById("foto_trans").value;
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