<script type="text/javascript" src="../ADMIN/js/usuario.js"></script>

<br>

<section class="content-header">
    <h3>
        <b> Listado banco <i class="fa fa-bank"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista banco</div> <button class="btn btn-danger" onclick="nuevo_banco();"><i class="fa fa-plus"></i> Nuevo banco</button>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_banco" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Nombre</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_BANCO" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nuevo banco</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12">
                        <label for="nombre_banco">Nombre</label>
                        <input type="text" class="form-control" id="nombre_banco" placeholder="Ingrese nombre" onkeypress="return soloLetras(event)"><br>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="registra_banco()"><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_baanco" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar tipo</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                <input type="hidden" id="id_banco">

                    <div class="col-lg-12">
                        <label for="nombre_banco_edit">Nombre</label>
                        <input type="text" class="form-control" id="nombre_banco_edit" placeholder="Ingrese nombre" onkeypress="return soloLetras(event)"><br>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editar_banco()"><i class="fa fa-edit"></i> Editar</button>
            </div>
        </div>
    </div>
</div>

<script>
    listar_banco();
</script>