<script type="text/javascript" src="../ADMIN/js/venta.js"></script>
<script type="text/javascript" src="../ADMIN/js/carrito.js"></script>

<br>

<section class="content-header">
    <h3>
        <b> Listado de compras online <i class="fa fa-paypal"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de compras online</div>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_ventas_online_pro" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Pago</th>
                                    <th>Cliente</th>
                                    <th>Tipo pago</th>
                                    <th>N° compra</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Impuesto</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Pago</th>
                                    <th>Cliente</th>
                                    <th>Tipo pago</th>
                                    <th>N° compra</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Impuesto</th>
                                    <th>Total</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detalle_venta_onine_prodcutos" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-cubes"></i> Detalle venta</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 table-responsive">
                        &nbsp;&nbsp; <label style="color:red; text-align: center;" id="detalle_obligg"></label>
                        <table id="detalle_venta_online_produto" class="table table-striped table-bordered">
                            <thead bgcolor="black" style="color:#fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Tipo oferta</th>
                                    <th>Desc. oferta</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody id="tbody_detalle_venta_online_produto">

                            </tbody>
                        </table>

                    </div>
                    <div class="col-lg-12" style="text-align: right;">
                        <label for="" id="lbl_totalneto"></label>
                    </div>
                    <div class="col-lg-12" style="text-align: right;">
                        <label for="" id="lbl_impuesto"></label>
                    </div>
                    <div class="col-lg-12" style="text-align: right;">
                        <label for="" id="lbl_a_pagar"></label>
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
    listar_ventas_onlinee_productos_cliente();
</script>