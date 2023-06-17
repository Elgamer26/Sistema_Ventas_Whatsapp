<style>
    .contennidor {
        background: gray;
        min-height: 90vh;
    }
</style>

<br>
<section class="content-header">
    <h3>
        <b> Reporte egresos <i class="fa fa-dollar"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Reporte egresos</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-3 form-group">
                                <label>Fecha inicio</label>
                                <input type="date" class="form-control" id="fecha_inicio">
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Fecha fin</label>
                                <input type="date" class="form-control" id="fecha_fin">
                            </div>

                            <div class="col-sm-1 form-group">
                                <label>Buscar</label> &nbsp;&nbsp; <label style="color:red;" id="marca_produto_obb"></label>
                                <button onclick="bucar_fechas_egreso();" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                            </div>

                            <div class="col-sm-12 form-group">
                                <center>
                                    <iframe width="100%" height="100%" class="contennidor" id="iframe_egreso"></iframe>
                                </center>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var n = new Date();
        var y = n.getFullYear();
        var m = n.getMonth() + 1;
        var d = n.getDate();
        if (d < 10) {
            d = '0' + d;
        }
        if (m < 10) {
            m = '0' + m;
        }

        document.getElementById("fecha_inicio").value = y + "-" + m + "-" + d;
        document.getElementById("fecha_fin").value = y + "-" + m + "-" + d;
    });

    function bucar_fechas_egreso() {

        var fecha_inicio = document.getElementById("fecha_inicio").value;
        var fecha_fin = document.getElementById("fecha_fin").value;

        if (fecha_inicio > fecha_fin) {
            return Swal.fire(
                "Mensaje de advertencia",
                "La fecha inicio '" +
                fecha_inicio +
                "' es mayor a la fecha final '" +
                fecha_fin +
                "'",
                "warning"
            );
        }

        var ifrm = document.getElementById("iframe_egreso");
        ifrm.setAttribute("src", "../ADMIN/REPORTES/Pdf/Reportes/reporte_egreso.php?f_i=" + fecha_inicio + "&f_f=" + fecha_fin + "");
    }
</script>