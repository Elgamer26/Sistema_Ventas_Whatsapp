<style>
    .contennidor {
        background: gray;
        min-height: 90vh;
    }
</style>

<br>
<section class="content-header">
    <h3>
        <b> Reporte productos <i class="fa fa-cube"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Reporte productos</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-3 form-group">
                                <label>Tipo produco</label> &nbsp;&nbsp; <label style="color:red;" id="tipo_pro_obligg"></label>
                                <select class="tipo_producto form-control" style="width: 100%" id="tipo_producto"></select>
                            </div>

                            <div class="col-sm-3 form-group">
                                <label>Marca de producto</label> &nbsp;&nbsp; <label style="color:red;" id="marca_produto_obb"></label>
                                <select class="marca_produto form-control" style="width: 100%" id="marca_produto"></select>
                            </div>

                            <div class="col-sm-2 form-group">
                                <label>Ver todos</label> &nbsp;&nbsp; <label style="color:red;" id="marca_produto_obb"></label>
                                <button onclick="traer_reprote();" class="btn btn-danger"><i class="fa fa-eye"></i> Todos</button>
                            </div>

                            <div class="col-sm-12 form-group">
                                <center>
                                    <iframe width="100%" height="100%" class="contennidor" id="iframe_producto"></iframe>
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
    $(".tipo_producto").select2();
    $(".marca_produto").select2();

    listar_marca_combo();
    listar_tipo();

    ////////////////////////
    function listar_marca_combo() {
        funcion = "listar_marca_combo";
        $.ajax({
            url: "../ADMIN/controlador/producto/producto.php",
            type: "POST",
            data: {
                funcion: funcion
            },
        }).done(function(response) {
            var data = JSON.parse(response);
            var cadena = "<option value='0'> --- Seleccione marca --- </option>";
            if (data.length > 0) {
                //bucle para extraer los datos del rol
                for (var i = 0; i < data.length; i++) {
                    cadena +=
                        "<option value='" + data[i][0] + "'> " + data[i][1] + " </option>";
                }
                //aqui concadenamos al id del select
                $("#marca_produto").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#marca_produto").html(cadena);
            }
        });
    }

    function listar_tipo() {
        funcion = "listar_tipo_comobo";
        $.ajax({
            url: "../ADMIN/controlador/producto/producto.php",
            type: "POST",
            data: {
                funcion: funcion
            },
        }).done(function(response) {
            var data = JSON.parse(response);
            var cadena = "<option value='0'> --- Seleccione tipo --- </option>";
            if (data.length > 0) {
                //bucle para extraer los datos del rol
                for (var i = 0; i < data.length; i++) {
                    cadena +=
                        "<option value='" + data[i][0] + "'> " + data[i][1] + " </option>";
                }
                //aqui concadenamos al id del select
                $("#tipo_producto").html(cadena);
            } else {
                cadena += "<option value=''>No hay datos</option>";
                $("#tipo_producto").html(cadena);
            }
        });
    }

    $(document).ready(function() {
        traer_reprote();
    });

    function traer_reprote() {
        var ifrm = document.getElementById("iframe_producto");
        ifrm.setAttribute("src", "../ADMIN/REPORTES/Pdf/Reportes/reporte_productos.php");
    }

    $("#marca_produto").change(function() {
        var id = $(this).val();
        if (id != 0) {
            var ifrm = document.getElementById("iframe_producto");
            ifrm.setAttribute("src", "../ADMIN/REPORTES/Pdf/Reportes/reporte_productos_marca.php?id=" + id);
        }
    });

    $("#tipo_producto").change(function() {
        var id = $(this).val();
        if (id != 0) {
            var ifrm = document.getElementById("iframe_producto");
            ifrm.setAttribute("src", "../ADMIN/REPORTES/Pdf/Reportes/reporte_productos_tipo.php?id=" + id);
        }
    });
</script>