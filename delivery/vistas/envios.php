<script type="text/javascript" src="../../ADMIN/js/repartidor.js"></script>
<br>
<section class="content-header">
    <h3>
        <b> Listado de envios <i class="fa fa-send"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de envios</div>  
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_envios_repartidor" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Repartidor</th>
                                    <th>Vehículo</th>
                                    <th>N° envío</th>
                                    <th>Fecha envío</th>
                                    <th>Total</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Repartidor</th>
                                    <th>Vehículo</th>
                                    <th>N° envío</th>
                                    <th>Fecha envío</th>
                                    <th>Total</th>
                                    <th>Cantidad</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detalle_envios" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-truck"></i> Detalle de envios</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 table-responsive">
                        &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                        <table id="detalle_envios" class="table table-striped table-bordered">
                            <thead bgcolor="black" style="color:#fff;">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Tipo transf.</th>
                                    <th>N. venta</th>
                                    <th>Dirección</th>
                                    <th>Referencia</th>
                                    <th>Cant. producto</th>
                                    <th>Valor envio</th>
                                </tr>
                            </thead>

                            <tbody id="tbody_detalle_ventas_seleccionar_A">

                            </tbody>

                        </table>

                    </div>

                    <div class="col-lg-12" style="text-align: right;">
                        <label for="" id="lbl_totalneto"></label>
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
    listar_envios_repartidor();
</script>