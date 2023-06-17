<script type="text/javascript" src="../ADMIN/js/web_sevis.js"></script>
<br>
<section class="content-header">
    <h3>
        <b> Vehículos <i class="fa fa-truck"></i> </b> <button class="btn btn-danger" onclick="nuevo_vehiculo();"><i class="fa fa-plus"></i> Nuevo vehículos</button>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de Vehículos</div>
                    </div>
                    <div class="ibox-body">

                        <table id="tabla_vehiculos" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Tipo vehículos</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Placa</th>
                                    <th>Color</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Estado</th>
                                    <th>Tipo vehículos</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Placa</th>
                                    <th>Color</th>
                                    <th>Detalle</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_nuevo_veiculo" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-plus"></i> Nuevo vehículo</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-6 form-group">
                        <label>Tipo vehículo</label>
                        <select class="form-control" style="width: 100%;" id="tipo_vehiculo">
                            <option value="Moto">Moto</option>
                            <option value="Auto">Auto</option>
                            <option value="Camión">Camión</option>
                            <option value="Bicicleta">Bicicleta</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Marca</label> &nbsp;&nbsp; <label style="color:red;" id="marca_obligg"></label>
                        <input type="text" maxlength="50" class="form-control" id="marca_vehi" placeholder="Ingrese marca">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Modelo</label> &nbsp;&nbsp; <label style="color:red;" id="modelo_obligg"></label>
                        <input type="text" maxlength="50" class="form-control" id="modelo_vehi" placeholder="Ingrese modelo">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Placa</label> &nbsp;&nbsp; <label style="color:red;" id="matricula_obliga"></label>
                        <input type="text" maxlength="10" class="form-control" onkeyup="llemar_placa();" id="matricula" placeholder="Ingrese placa">
                        <label style="color:red;" id="validacion_placa"></label>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Color</label> &nbsp;&nbsp; <label style="color:red;" id="numerose_obliga"></label>
                        <input type="text" maxlength="10" class="form-control" id="numero_serie" placeholder="Ingrese color" onkeypress="return soloLetras(event)">
                    </div>

                    <div class="col-sm-12 form-group">
                        <label>Detalle</label> &nbsp;&nbsp; <label style="color:red;" id="detalle_obliga"></label>
                        <textarea class="form-control" id="detalle_p"></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-success" id="btn_acpetaraa" onclick="registra_vehiculo();"><i class="fa fa-save"></i> Guardar</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_veiculo" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar vehículo</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <input type="number" id="idvehicuslos" hidden>

                    <div class="col-sm-6 form-group">
                        <label>Tipo vehículo</label>
                        <select class="form-control" style="width: 100%;" id="tipo_vehiculo_edit">
                            <option value="Moto">Moto</option>
                            <option value="Auto">Auto</option>
                            <option value="Camión">Camión</option>
                            <option value="Bicicleta">Bicicleta</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Marca</label> &nbsp;&nbsp; <label style="color:red;" id="edit_marca_obligg"></label>
                        <input type="text" maxlength="50" class="form-control" id="marca_vehi_edit" placeholder="Ingrese marca">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Modelo</label> &nbsp;&nbsp; <label style="color:red;" id="modelo_obligg_edit"></label>
                        <input type="text" maxlength="50" class="form-control" id="modelo_vehi_edit" placeholder="Ingrese modelo">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Placa</label> &nbsp;&nbsp; <label style="color:red;" id="edit_matricula_obliga"></label>
                        <input type="text" maxlength="10" class="form-control" onkeyup="llemar_placa_edit();" id="matricula_edit" placeholder="Ingrese placa">
                        <label style="color:red;" id="validacion_placa_edit"></label>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Color</label> &nbsp;&nbsp; <label style="color:red;" id="edit_numerose_obliga"></label>
                        <input type="text" maxlength="10" class="form-control" id="numero_serie_edit" placeholder="Ingrese color" onkeypress="return soloNumeros(event)">
                    </div>

                    <div class="col-sm-12 form-group">
                        <label>Detalle</label> &nbsp;&nbsp; <label style="color:red;" id="edit_detalle_obliga"></label>
                        <textarea class="form-control" id="detalle_p_edit"></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" id="editar_btnt" onclick="editar_vehiculo();"><i class="fa fa-edit"></i> Editar</button>
            </div>

        </div>
    </div>
</div>

<script>
    var expresion = /^([A-Z]{3}-\d{3,4})$/;

    function llemar_placa() {
        var placa = $("#matricula").val();
        if (placa != "") {
            if (!expresion.test(placa)) {
                $("#validacion_placa").html('FORMATO PLACA INCORRECTO');
                $("#btn_acpetaraa").hide();
            } else {
                $("#validacion_placa").html('');
                $("#btn_acpetaraa").show();
            }
        } else {
            $("#validacion_placa").html('');
        }
    }

    function llemar_placa_edit() {
        var placa = $("#matricula_edit").val();
        if (placa != "") {
            if (!expresion.test(placa)) {
                $("#validacion_placa_edit").html('FORMATO PLACA INCORRECTO');
                $("#editar_btnt").hide();
            } else {
                $("#validacion_placa_edit").html('');
                $("#editar_btnt").show();
            }
        } else {
            $("#validacion_placa_edit").html('');
        }
    }


    // var matricula = /[A-Z]{3}[-]\d{3}/;
    // var c5 = document.getElementById('matricula');

    // c5.addEventListener('onkeyup', function() {
    //     let valormatricula = c5.value;
    //     if (matricula.test(valormatricula)) {
    //         console.log('Exito!');
    //     } else {
    //         console.log('Erro en la matricula el formato debe ser ‘MU-XXXX-YYY’ donde XXXX son 4 dígitos numéricos y YYY son letras de la A a la Z en mayúsculas')
    //     }
    // });


    listar_vwhiculos();
</script>