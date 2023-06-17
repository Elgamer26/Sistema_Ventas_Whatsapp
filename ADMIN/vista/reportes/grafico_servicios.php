<style>
    .contennidor {
        background: gray;
        min-height: 90vh;
    }
</style>
<br>
<section class="content-header">
    <h3>
        <b> Gráficos ventas servicios <i class="fa fa-bar-chart"></i> </b>
    </h3>
</section>
<div class="content">
    <div class="col-md-13">
        <div class="box box-primary box-solid">
            <!-- /.box-header -->
            <div class="box-body">

                <div class="ibox ibox-primary">
                    <div class="ibox-head">
                        <div class="ibox-title">Gráficos ventas servicios</div>
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

                            <div class="col-sm-2 form-group">
                                <label>Tipo de gráfico</label>
                                <select id="tipo" class="form-control">
                                    <option value="bar">Barra</option>
                                    <option value="line">Linea</option>
                                </select>
                            </div>

                            <div class="col-sm-1 form-group">
                                <label>Buscar</label> &nbsp;&nbsp; <label style="color:red;" id="marca_produto_obb"></label>
                                <button onclick="ventas_servicio();" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                            </div>

                            <div class="col-sm-12 form-group">
                                <center>
                                    <div class="chart_v_s">
                                        <canvas id="char_v_servicio" style="height:200px;"></canvas>
                                    </div>
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

    //////////////////////////////// grafico 
    function ventas_servicio() {

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

        var tipo_grafico = $("#tipo").val();
        var nombre_grafico = $("#tipo option:selected").text();
        funcion = "ventas_servicio";
        $.ajax({
            url: "../ADMIN/controlador/system/system.php",
            type: "POST",
            data: {
                funcion: funcion,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
            },
        }).done(function(response) {
            if (response != 0) {
                var fecha = [];
                var cantidad = [];
                var colores = [];
                var data = JSON.parse(response);
                for (var i = 0; i < data.length; i++) {
                    fecha.push(data[i][0]);
                    cantidad.push(data[i][1]);
                    colores.push(colores_rgb());
                }
                mostrar_graficos_ventas_servicio(
                    fecha,
                    cantidad,
                    tipo_grafico,
                    nombre_grafico,
                    colores
                );
            } else {
                $("canvas#char_v_servicio").remove();
                return Swal.fire(
                    "Mensaje de advertencia",
                    "No hay datos disponibles en este rango de fecha",
                    "warning"
                );
            }
        });
    }

    function mostrar_graficos_ventas_servicio(
        fecha,
        cantidad,
        tipo_grafico,
        nombre_grafico,
        colores
    ) {
        //esto es para desctuir el grafico porque sale un error
        $("canvas#char_v_servicio").remove();
        $("div.chart_v_s").append(
            '<canvas id="char_v_servicio" style="height:200px;"></canvas>'
        );
        ///este es el grafico

        var ctx = document.getElementById("char_v_servicio").getContext("2d");
        var myChart = new Chart(ctx, {
            type: tipo_grafico,
            data: {
                labels: fecha,
                datasets: [{
                    label: nombre_grafico,
                    data: cantidad,
                    backgroundColor: colores,
                    borderColor: colores,
                    borderWidth: 1,
                }, ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    /// par los graficos
    function colores_rgb() {
        var coolor =
            "(" +
            generar_numero(255) +
            "," +
            generar_numero(255) +
            "," +
            generar_numero(255) +
            ")";
        return "rgb" + coolor;
    }

    function generar_numero(numero) {
        return (Math.random() * numero).toFixed(0);
    }
</script>