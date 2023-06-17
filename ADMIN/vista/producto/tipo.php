<script type="text/javascript" src="../ADMIN/js/producto.js"></script>

<br>
<section class="content-header">
    <h3>
        <b> Tipo de productos <i class="fa fa-list"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista tipos de producto</div> <button class="btn btn-danger" onclick="nueva_tipo();"><i class="fa fa-plus"></i> Nuevo tipo</button>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_tipo_" class="display responsive nowrap" style="width:100%">
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

<div class="modal fade" id="modal_tipo" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nuevo tipo</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12">
                        <label for="tipo">Nombre tipo</label>
                        <input type="text" class="form-control" id="tipo" placeholder="Ingrese tipo"><br>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="registra_tipo()"><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_tipo" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar tipo</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <input type="hidden" id="id_tipo">

                    <div class="col-lg-12">
                        <label for="tipo_edit">Nombre</label>
                        <input type="text" class="form-control" id="tipo_edit" placeholder="Ingrese tipo"><br>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editar_tipo()"><i class="fa fa-edit"></i> Editar</button>
            </div>
        </div>
    </div>
</div>

<script>
   listar_tipo();
</script>