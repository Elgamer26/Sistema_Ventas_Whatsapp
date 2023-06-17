<script type="text/javascript" src="../ADMIN/js/web_sevis.js"></script>

<br>
<section class="content-header">
    <h3>
        <b> Listado de calificaciones <i class="fa fa-star"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de calificaciones</div>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_calificacion_producto" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acción</th>
                                    <th>Producto</th>
                                    <th>Foto</th>
                                    <th>Tipo</th>
                                    <th>Marca</th>
                                    <th>Cantidad calificaciones</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acción</th>
                                    <th>Producto</th>
                                    <th>Foto</th>
                                    <th>Tipo</th>
                                    <th>Marca</th>
                                    <th>Cantidad calificaciones</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detalle_calificaiones" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-star"></i> Detalle de calificación</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 table-responsive">
                        &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                        <table id="detalle_calificaicon" class="table table-striped table-bordered">
                            <thead bgcolor="black" style="color:#fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Clientes</th>
                                    <th>Fecha</th>
                                    <th>Calificación</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Clientes</th>
                                    <th>Fecha</th>
                                    <th>Calificación</th>
                                    <th>Detalle</th>
                                </tr>
                            </tfoot>
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

<script>
    listar_calificacion_producto();
</script>