<script type="text/javascript" src="js/producto.js"></script>

<?php
date_default_timezone_set('America/Guayaquil');
$fecha = date("Y-m-d");
?>

<br>
<section class="content-header">
    <h3>
        <b> Nueva promoción <i class="fa fa-cube"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Nueva promoción</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-12 form-group">
                                <label>Producto</label> &nbsp;&nbsp; <label style="color:red;" id="producto_obligg"></label>
                                <select class="producto form-control" style="width: 100%" id="producto"></select><br>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Fecha inicio</label> &nbsp;&nbsp; <label style="color:red;" id="fecha_ini_obligg"></label>
                                <input readonly type="date" value="<?php echo $fecha; ?>" class="form-control" id="fecha_inicio">
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Fecha fin</label> &nbsp;&nbsp; <label style="color:red;" id="fecha_fin_obligg"></label>
                                <input type="date" value="<?php echo $fecha; ?>" class="form-control" id="fecha_fin">
                            </div>

                            <div class="col-sm-3 form-group">
                                <label> Tipo de promoción</label> &nbsp;&nbsp; <label style="color:red;" id="tipo_promo_obligg"></label>
                                <select class="tipo_promo form-control" style="width: 100%" id="tipo_promo">
                                    <option value="2x1">2 X 1</option>
                                    <option value="3x1">3 X 1</option>
                                    <option value="Descuento">Descuento %</option>
                                </select>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Valor de descuento</label> &nbsp;&nbsp; <label style="color:red;" id="valor_obligg"></label>
                                <input type="text" readonly maxlength="2" class="form-control" id="descuento" value="0" placeholder="Ingrese valor" onkeypress="return soloNumeros(event)">
                            </div>

                            <br> <br> <br> <br>

                            <div class="col-sm-12 form-group">
                                <button onclick="guardar_oferta();" class="btn btn-primary" type="button"><i class="fa fa-edit"></i> Guardar</button> -
                                <button onclick="cargar_contenido('contenido_principal','vista/producto/registro_promocion.php');" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $("#producto").select2();
    listar_productos_combo();

    $("#tipo_promo").change(function() {
        var tipo = $("#tipo_promo").val();

        if(tipo == 'Descuento'){
            $("#descuento").attr("readonly", false);
            $("#descuento").val("");  
        }else{
            $("#descuento").attr("readonly", true);
            $("#descuento").val("0");
        }  
    });

    ////////////////////////
    function listar_productos_combo() {
        funcion = "listar_productos_combo";
        $.ajax({
            url: "../ADMIN/controlador/promociones/promociones.php",
            type: "POST",
            data: {
                funcion: funcion
            },
        }).done(function(response) {
            var data = JSON.parse(response);
            var cadena = "";
            if (data.length > 0) {
                //bucle para extraer los datos del rol
                for (var i = 0; i < data.length; i++) {
                    cadena +=
                        "<option value='" + data[i][0] + "'> " + data[i][1] + " </option>";
                }
                //aqui concadenamos al id del select
                $("#producto").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#producto").html(cadena);
            }
        });
    }
</script>