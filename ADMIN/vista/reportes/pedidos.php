<style>
    .contennidor {
        background: gray;
        min-height: 90vh;
    }
</style>

<br>
<section class="content-header">
    <h3>
        <b> Reporte pedidos pendientes <i class="fa fa-clock-o"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Reporte pedidos pendientes</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-12 form-group">
                                <center>
                                    <iframe width="100%" height="100%" class="contennidor" id="iframe_pedidos"></iframe>
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
        traer_reprote();
    });

    function traer_reprote() {
        var ifrm = document.getElementById("iframe_pedidos");
        ifrm.setAttribute("src", "../ADMIN/REPORTES/Pdf/Reportes/reporte_pedidos.php");
    }
</script>