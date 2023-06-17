<script type="text/javascript" src="../ADMIN/js/producto.js"></script>
<br>
<section class="content-header">
    <h3>
        <b> Promociones vigentes <i class="fa fa-cubes"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-success box-solid">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Lista de promociones vigentes</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12"> <label for="codigo_prod">Buscar producto...</label>
            <div class="input-group input-group-sm">
                <input type="text" id="buscar_prod" class="form-control" placeholder="Ingrese el código o nombre del producto">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>

    </div>
</div>

<div class="page-content fade-in-up">
    <div class="row" id="unir_listado_ofertas">


    </div>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center" id="unir_paguinador">

    </ul>
</nav>

<div class="modal fade" id="modal_editra_pferta" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #3c8dbc; color:white;">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar oferta</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <input type="hidden" id="id_ofertass">

                    <div class="col-sm-6 form-group">
                        <label>Fecha inicio</label> &nbsp;&nbsp; <label style="color:red;" id="fecha_ini_obligg"></label>
                        <input readonly type="date" value="<?php echo $fecha; ?>" class="form-control" id="fecha_inicio">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label>Fecha fin</label> &nbsp;&nbsp; <label style="color:red;" id="fecha_fin_obligg"></label>
                        <input type="date" value="<?php echo $fecha; ?>" class="form-control" id="fecha_fin">
                    </div>

                    <div class="col-sm-6 form-group">
                        <label> Tipo de promoción</label> &nbsp;&nbsp; <label style="color:red;" id="tipo_promo_obligg"></label>
                        <select class="tipo_promo form-control" style="width: 100%" id="tipo_promo">
                            <option value="2x1">2 X 1</option>
                            <option value="3x1">3 X 1</option>
                            <option value="Descuento">Descuento %</option>
                        </select>
                    </div>

                    <input type="hidden" id="descuento_bandera">

                    <div class="col-sm-6 form-group">
                        <label>Valor de descuento</label> &nbsp;&nbsp; <label style="color:red;" id="valor_obligg"></label>
                        <input type="text" readonly maxlength="2" class="form-control" id="descuento" value="0" placeholder="Ingrese valor" onkeypress="return soloNumeros(event)">
                    </div>

                </div>
            </div>

            <div class="modal-footer" style="background: silver;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editaar_oferta()"><i class="fa fa-edit"></i> Editar</button>
            </div>
        </div>
    </div>
</div>

<script>
    pagination(1);

    $("#tipo_promo").change(function() {
        var tipo = $("#tipo_promo").val();
        var bandera = $("#descuento_bandera").val();

        if (tipo == 'Descuento') {
            $("#descuento").attr("readonly", false);
            $("#descuento").val(bandera);
        } else {
            $("#descuento").attr("readonly", true);
            $("#descuento").val("0");
        }
    });
</script>