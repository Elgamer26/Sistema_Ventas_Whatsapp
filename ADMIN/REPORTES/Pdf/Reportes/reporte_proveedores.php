<?php

session_start();
$id_usu = $_SESSION["id_usu"];
$f_i = $_GET["f_i"];
$f_f = $_GET["f_f"];

//llamos al autoload.php del mpdf
require_once __DIR__ . '/../../vendor/autoload.php';
//aqui llamo la nueva conexion
require_once "../../../modelo/conect/conect_r.php";

$sql = 'SELECT
usuario.usuario_id,
empleado.nombres,
empleado.app_pate,
empleado.apellidos,
tipo_usuario.tipo_usuario 
FROM
usuario
INNER JOIN empleado ON usuario.empleado_id = empleado.empleado_id
INNER JOIN tipo_usuario ON usuario.tipo_usuario_id = tipo_usuario.tipo_usuario_id
WHERE
usuario.usuario_id = "' . $id_usu . '"';

$consulta_empresa = 'SELECT * FROM empresa';
$resulta_empresa = $mysqli->query($consulta_empresa);
$data_empresa = mysqli_fetch_assoc($resulta_empresa);

date_default_timezone_set('America/Guayaquil');
$fecha = date("d-m-Y");

$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

    $html = '<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>Reporte de proveedores</title>
        <link rel="stylesheet" href="../../css/style.css" media="all" />
      </head>
      <body>  
        <header class="clearfix">
      <table style="border-collapse;" border="1">
      <thead>
      <tr>
        <th width="20%" style="border-top:0px; border-left:0px; border-bottom:0px; border-right:0px;"><img src="../../../' . $data_empresa['logo'] . '" width="99" height="99"></th>
        <th width="50%" style="border-top:0px; border-left:0px; border-bottom:0px; border-right:0px; text-align:left;">
        <b style="color: black;">Datos de le empresa:</b><br>
        <b style="color: black;">Dirección: </b> <span style="color: black;"> ' . $data_empresa['direccion'] . ' </span><br>
        <b style="color: black;">Telefono: </b> <span style="color: black;"> ' . $data_empresa['telefono'] . ' </span><br>
        <b style="color: black;">Correo: </b> <span style="color: black;"> ' . $data_empresa['email'] . '</span><br>
        </th>

        <th width="30%" style="text-align: center">
        <h3 style="color: black;"> Fecha emisio:  <span style="color: black;"> ' . $fecha . '  </span> </3><br>
        <h1  style="color: black;"> Reporte de proveedores</h1>
        <h3 style="color: black;">Tipo de usuario°: <span style="color: black;"></span>' . $row['tipo_usuario'] . '  </span> 
         </th>
      </tr>
    </thead>
      </table>

       <h1></h1>         
       <div id="project">
        <div><span style="color: black; font-size: 15px"><b> Usuario encargado : </b>  ' . $row['nombres'] . '  ' . $row['app_pate'] . '  ' . $row['apellidos'] . ' </div>
       </div>
        </header>
        <main>
          <table>
            <thead>
              <tr>
                <th style="color: black;" class="service"><b>ITEM</b></th>
                <th style="color: black;" class="desc"><b>RAZON SOCIAL</b></th>
                <th style="color: black;" class="desc"><b>RUC</b></th> 
                <th style="color: black;" class="desc"><b>DIRECCION</b></th>
                <th style="color: black;" class="desc"><b>PROVINCIA</b></th>  
                 <th style="color: black;" class="desc"><b>CIUDAD</b></th>
                <th style="color: black;" class="desc"><b>TELEFONO</b></th> 
                <th style="color: black;" class="desc"><b>CORREO</b></th> 

                <th style="color: black;" class="desc"><b>ENCARGADO</b></th> 
                <th style="color: black;" class="desc"><b>SEXO</b></th> 
                <th style="color: black;" class="desc"><b>ESTADO</b></th> 
              </tr>
            </thead>
            <tbody>';

    $sqldetalle = 'SELECT
	proveedor.proveedor_id,
	proveedor.razon_social,
	proveedor.ruc,
	proveedor.proveedor_direccion,
	provinciaa.provincia,
	ciudad.ciudad_nombre,
	proveedor.proveedor_telefono,
	proveedor.proveedor_correo,
	proveedor.encargado,
	proveedor.encargado_sexo,
	proveedor.encargado_telefono,
	proveedor.proveedor_estado 
    FROM
        provinciaa
        INNER JOIN proveedor ON provinciaa.provincia_id = proveedor.provincia_id
        INNER JOIN ciudad ON proveedor.ciudad_id = ciudad.ciudad_id 
    WHERE
        proveedor.proveedor_fecha BETWEEN ' . $f_i . ' 
        AND ' . $f_f . ' 
    ORDER BY
	proveedor.proveedor_fecha DESC';

    $contador = 0;
    $estado = "";
    $bg = "";
    $bg_s = "";
    // aqui estoy pidiendo la conexion y la consulta envio
    $resultmedi = $mysqli->query($sqldetalle);

    while ($rowmedi = $resultmedi->fetch_assoc()) {

        $contador++;

        if ($rowmedi['proveedor_estado'] == 1) {
            $estado = "ACTIVO";
            $bg = 'style="background:green; color:white; !important"';
        } else {
            $estado = "INACTIVO";
            $bg = 'style="background:red; color:white; !important"';
        }

        if ($rowmedi['encargado_sexo'] == "Masculino") {
            $bg_s = 'style="background:#3c8dbc; color:white; !important"';
        } else {
            $bg_s = 'style="background:pink; color:black; !important"';
        }

        $html .= '<tr>
                    <td class="service">' . $contador . '</td>
                    <td class="desc"> ' . $rowmedi['razon_social'] . ' </td>
                    <td class="desc"> ' . $rowmedi['ruc'] . ' </td>                     
                    <td class="desc">' . $rowmedi['proveedor_direccion'] . '</td>
                    <td class="desc"> ' . $rowmedi['provincia'] . ' </td>
                    <td class="desc">  ' . $rowmedi['ciudad_nombre'] . ' </td> 
                    <td class="desc"> ' . $rowmedi['proveedor_telefono'] . ' </td>  
                    <td class="desc"> ' . $rowmedi['proveedor_correo'] . ' </td>  
                    <td class="desc"> ' . $rowmedi['encargado'] . ' </td>  
                    <td class="desc" ' . $bg_s . '> <b>' . $rowmedi['encargado_sexo'] . '</b> </td>  
                    <td class="desc" ' . $bg . '> <b>' . $estado . '</b> </td>  
                  </tr>';
    }

    $html .= '</tbody>
              </table>   
            </main>        
          </body>
        </html>';
}

//esto es para cambiar el tamaño de la hoja
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output();
