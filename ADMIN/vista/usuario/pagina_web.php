<script type="text/javascript" src="js/system.js"></script>
<br>
<section class="content-header">
    <h3>
        <b> Página web <i class="fa fa-windows"></i> </b>
    </h3>
</section>

<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Página web</div>
                    </div>
                    <div class="ibox-body">

                        <div class="row">

                            <div class="col-sm-4 form-group">
                                <div class="ibox">
                                    <div class="ibox-body text-center">
                                        <h4> <b>Foto 1 página web</b></h4> 
                                        <div class="m-t-20">
                                            <img id="foto_view_1" width="250px" height="250px">
                                        </div>
                                        <br>
                                        <input type="file" class="form-control" id="foto1">
                                        <input type="hidden" class="form-control" id="foto1_ruta">
                                        <br>
                                        <div>
                                            <button class="btn btn-info btn-rounded m-b-5" onclick="subir_foto_1();"><i class="fa fa-photo"></i> Subir</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <div class="ibox">
                                    <div class="ibox-body text-center">
                                        <h4> <b>Foto 2 página web</b></h4>
                                        <div class="m-t-20">
                                            <img id="foto_view_2" width="250px" height="250px">
                                        </div>
                                        <br>
                                        <input type="file" class="form-control" id="foto2">
                                        <input type="hidden" class="form-control" id="foto2_ruta">
                                        <br>
                                        <div>
                                            <button class="btn btn-info btn-rounded m-b-5" onclick="subir_foto_2();"><i class="fa fa-photo"></i> Subir</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <div class="ibox">
                                    <div class="ibox-body text-center">
                                        <h4> <b>Foto 3 página web</b></h4>
                                        <div class="m-t-20">
                                            <img id="foto_view_3" width="250px" height="250px">
                                        </div>
                                        <br>
                                        <input type="file" class="form-control" id="foto3">
                                        <input type="hidden" class="form-control" id="foto3_ruta">
                                        <br>
                                        <div>
                                            <button class="btn btn-info btn-rounded m-b-5" onclick="subir_foto_3();"><i class="fa fa-photo"></i> Subir</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-4 form-group">
                                <div class="ibox">
                                    <div class="ibox-body text-center">
                                        <h4> <b>Detalle foto 1</b> <label style="color:red;" id="lbldetalle_1"></label> </h4> 
                                        <div class="m-t-20">
                                            <textarea class="form-control" id="detalle_1" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <div class="ibox">
                                    <div class="ibox-body text-center">
                                        <h4> <b>Detalle foto 2</b>  <label style="color:red;" id="lbldetalle_2"></label> </h4>
                                        <div class="m-t-20">
                                            <textarea class="form-control" id="detalle_2" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <div class="ibox">
                                    <div class="ibox-body text-center">
                                        <h4> <b>Detalle foto 3</b>  <label style="color:red;" id="lbldetalle_3"></label> </h4>
                                        <div class="m-t-20">
                                            <textarea class="form-control" id="detalle_3" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 form-group">
                            <button onclick="editar_detalle_foto();" class="btn btn-info btn-rounded m-b-5" type="button"><i class="fa fa-edit"></i> Cambiar detalle</button>
                            <button onclick="cargar_contenido('contenido_principal','vista/usuario/pagina_web.php');" class="btn btn-danger btn-rounded m-b-5" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</div>

<script>
    traer_datos_web();

    document.getElementById("foto1").addEventListener("change", () => {
        var filename = document.getElementById("foto1").value;
        var idxdot = filename.lastIndexOf(".") + 1;
        var extfile = filename.substr(idxdot, filename.length).toLowerCase();
        if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {} else {
            swal.fire(
                "Mensaje de alerta",
                "Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
                "warning"
            );
            document.getElementById("foto1").value = "";
        }
    });

    document.getElementById("foto1").addEventListener("change", () => {
        var filename = document.getElementById("foto1").value;
        var idxdot = filename.lastIndexOf(".") + 1;
        var extfile = filename.substr(idxdot, filename.length).toLowerCase();
        if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {} else {
            swal.fire(
                "Mensaje de alerta",
                "Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
                "warning"
            );
            document.getElementById("foto1").value = "";
        }
    });

    document.getElementById("foto3").addEventListener("change", () => {
        var filename = document.getElementById("foto3").value;
        var idxdot = filename.lastIndexOf(".") + 1;
        var extfile = filename.substr(idxdot, filename.length).toLowerCase();
        if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {} else {
            swal.fire(
                "Mensaje de alerta",
                "Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
                "warning"
            );
            document.getElementById("foto3").value = "";
        }
    });
</script>