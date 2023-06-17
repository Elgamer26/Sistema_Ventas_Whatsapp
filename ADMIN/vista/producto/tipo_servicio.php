<script type="text/javascript" src="../ADMIN/js/producto.js"></script>

<br>
<section class="content-header">
    <h3>
        <b> Tipo de servicios <i class="fa fa-list"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista tipos de servicios</div> <button class="btn btn-danger" onclick="nuevo_servicio();"><i class="fa fa-plus"></i> Nuevo servicio</button>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_servicioss_" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_servicio" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nuevo servicio</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-6">
                        <label for="nombre_servicio">Nombre</label>
                        <input type="text" class="form-control" id="nombre_servicio" placeholder="Ingrese nombre" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="precio_servicio">Precio</label>
                        <input type="number" class="form-control" id="precio_servicio" placeholder="Ingrese precio"><br>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="registra_servicio()"><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_servicio" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar servicio</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                <input type="hidden" id="id_servicio_edit">

                    <div class="col-lg-6">
                        <label for="nombre_servicio_edit">Nombre</label>
                        <input type="text" class="form-control" id="nombre_servicio_edit" placeholder="Ingrese nombre" onkeypress="return soloLetras(event)"><br>
                    </div>

                    <div class="col-lg-6">
                        <label for="precio_servicio_edit">Precio</label>
                        <input type="number" class="form-control" id="precio_servicio_edit" placeholder="Ingrese precio"><br>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editar_servicio()"><i class="fa fa-edit"></i> Editar</button>
            </div>
        </div>
    </div>
</div>

<script>
    listar_servicios();
</script>