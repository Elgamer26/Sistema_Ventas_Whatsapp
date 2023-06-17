var funcion, tabla_envios_repartidor, efec_espera, tabla_efectivo_procesado;

$(document).on("click", "#entrar", function (e) {
  e.preventDefault();

  var usuario = $("#usuario_d").val();
  var password = $("#password_d").val();

  if (parseInt(usuario.length) <= 0 || usuario == "") {
    $("#p_none_pass").hide();
    $("#p_none_usu").hide();
    $("#p_error_logeo").hide();
    $("#p_none_usu").show(2000);
  } else if (parseInt(password.length) <= 0 || password == "") {
    $("#p_none_usu").hide();
    $("#p_none_pass").hide();
    $("#p_error_logeo").hide();
    $("#p_none_pass").show(2000);
  } else {
    $("#p_none_usu").hide();
    $("#p_none_pass").hide();
    $("#p_error_logeo").hide();

    funcion = "logeo";
    $.ajax({
      url: "../ADMIN/controlador/repartidor/repartidor.php",
      type: "POST",
      data: { usuario: usuario, password: password, funcion: funcion },
    }).done(function (responce) {
      if (responce == 0) {
        $("#p_none_usu").hide();
        $("#p_none_pass").hide();
        $("#p_error_logeo").hide();
        $("#p_error_logeo").show(2000);
        return false;
      } else {
        var data = JSON.parse(responce);
        if (data[0][3] == 0) {
          Swal.fire({
            icon: "error",
            title: "Usuario inactivo",
            text: "El usuario se encuentra inactivo!",
          });
        } else {
          funcion = "session";
          $.ajax({
            url: "../ADMIN/controlador/repartidor/repartidor.php",
            type: "POST",
            data: {
              id_repa: data[0][0],
              nombre_re: data[0][1],
              funcion: funcion,
            },
          }).done(function (res) {
            if (res == 1) {
              let timerInterval;
              Swal.fire({
                title: "Bienvenido al sistema del repartidor!",
                html: "Usted sera redireccionado en <b></b> mi.",
                allowOutsideClick: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading();
                  const b = Swal.getHtmlContainer().querySelector("b");
                  timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft();
                  }, 100);
                },
                willClose: () => {
                  clearInterval(timerInterval);
                },
              }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                  location.reload();
                }
              });
            }
          });
        }
      }
    });
  }
});

function trear_datos() {
  funcion = "trear_datos";
  $.ajax({
    url: "../../ADMIN/controlador/repartidor/repartidor.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (responce) {
    if (responce != 0) {
      var data = JSON.parse(responce);
      document.getElementById("nombress").value = data[0][1];
      document.getElementById("apellidoss").value = data[0][2];
      document.getElementById("numero_docu").value = data[0][3];
      document.getElementById("telefono_p").value = data[0][4];
      document.getElementById("correo_p").value = data[0][5];
      document.getElementById("direccions").value = data[0][6];
      document.getElementById("sexo").value = data[0][7];
      document.getElementById("tipo_licencia").value = data[0][8];
      document.getElementById("usuario").value = data[0][9];
      document.getElementById("password").value = data[0][10];
    }
  });
}

function editar_datos() {
  var nombress = document.getElementById("nombress").value;
  var apellidoss = document.getElementById("apellidoss").value;
  var numero_docu = document.getElementById("numero_docu").value;
  var telefono_p = document.getElementById("telefono_p").value;
  var correo_p = document.getElementById("correo_p").value;
  var direccions = document.getElementById("direccions").value;
  var sexo = document.getElementById("sexo").value;
  var tipo_licencia = document.getElementById("tipo_licencia").value;
  var usuario = document.getElementById("usuario").value;
  var password = document.getElementById("password").value;
  var password_confir = document.getElementById("password_confir").value;

  if (
    nombress.length == 0 ||
    apellidoss.length == 0 ||
    numero_docu.length == 0 ||
    telefono_p.length == 0 ||
    correo_p.length == 0 ||
    direccions.length == 0 ||
    tipo_licencia.length == 0 ||
    usuario.length == 0 ||
    password.length == 0 ||
    password_confir.length == 0
  ) {
    validar_registro_repartidor(
      nombress,
      apellidoss,
      numero_docu,
      telefono_p,
      correo_p,
      direccions,
      tipo_licencia,
      usuario,
      password,
      password_confir
    );

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#nombres_oblig").html("");
    $("#apellidos_oblig").html("");
    $("#cedula_obliga").html("");
    $("#telefono_obliga").html("");
    $("#correo_obliga").html("");
    $("#direccion_obliga").html("");
    $("#tipo_lice_obliga").html("");
    $("#usuario_obliga").html("");
    $("#pass_obliga").html("");
    $("#confir_pass_obliga").html("");
  }

  if (password != password_confir) {
    $("#confir_pass_obliga").html("Confirmar password");
    $("#pass_obliga").html("Confirmar password");

    return swal.fire(
      "Password no coinciden",
      "Los 2 password deben ser iguales",
      "warning"
    );
  } else {
    $("#confir_pass_obliga").html("");
    $("#pass_obliga").html("");
  }

  funcion = "editar_datos";
  alerta = ["datos", "Se esta editando el repartidor", "Editando repartidor"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../../ADMIN/controlador/repartidor/repartidor.php",
    type: "POST",
    data: {
      funcion: funcion,
      nombress: nombress,
      apellidoss: apellidoss,
      numero_docu: numero_docu,
      telefono_p: telefono_p,
      correo_p: correo_p,
      direccions: direccions,
      sexo: sexo,
      tipo_licencia: tipo_licencia,
      usuario: usuario,
      password: password,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        cargar_contenido("contenido_principal", "datos_personal.php");
        alerta = ["exito", "success", "Datos editados con exito"];
        cerrar_loader_datos(alerta);
        $("#modal_repartidor").modal("hide");
      } else if (resp == 2) {
        alerta = [
          "existe",
          "warning",
          "La cedula '" + numero_docu + "', ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      } else if (resp == 3) {
        alerta = [
          "existe",
          "warning",
          "El correo '" + correo_p + "', ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "Error al editar el repartidor"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_registro_repartidor(
  nombress,
  apellidoss,
  numero_docu,
  telefono_p,
  correo_p,
  direccions,
  tipo_licencia,
  usuario,
  password,
  password_confir
) {
  if (nombress.length == 0) {
    $("#nombres_oblig").html("Ingrese nombres");
  } else {
    $("#nombres_oblig").html("");
  }

  if (apellidoss.length == 0) {
    $("#apellidos_oblig").html("Ingrese apellidos");
  } else {
    $("#apellidos_oblig").html("");
  }

  if (numero_docu.length == 0) {
    $("#cedula_obliga").html("Ingrese cedula");
  } else {
    $("#cedula_obliga").html("");
  }

  if (telefono_p.length == 0) {
    $("#telefono_obliga").html("Ingrese telefono");
  } else {
    $("#telefono_obliga").html("");
  }

  if (correo_p.length == 0) {
    $("#correo_obliga").html("Ingrese correo");
  } else {
    $("#correo_obliga").html("");
  }

  if (direccions.length == 0) {
    $("#direccion_obliga").html("Ingrese direccion");
  } else {
    $("#direccion_obliga").html("");
  }

  if (tipo_licencia.length == 0) {
    $("#tipo_lice_obliga").html("Ingrese tipo licencia");
  } else {
    $("#tipo_lice_obliga").html("");
  }

  if (usuario.length == 0) {
    $("#usuario_obliga").html("Ingrese usuario");
  } else {
    $("#usuario_obliga").html("");
  }

  if (password.length == 0) {
    $("#pass_obliga").html("Ingrese password");
  } else {
    $("#pass_obliga").html("");
  }

  if (password_confir.length == 0) {
    $("#confir_pass_obliga").html("Confirmar password");
  } else {
    $("#confir_pass_obliga").html("");
  }
}

//////////////////////////
/////////////////////////////
function listar_envios_repartidor() {
  funcion = "listar_envios_repartidor";
  tabla_envios_repartidor = $("#tabla_envios_repartidor").DataTable({
    ordering: true,
    paging: true,
    aProcessing: true,
    aServerSide: true,
    searching: { regex: true },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    pageLength: 10,
    destroy: true,
    async: false,
    processing: true,

    ajax: {
      url: "../../ADMIN/controlador/repartidor/repartidor.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return `<button style='font-size:13px;' type='button' class='aceptar btn btn-success' title='ver envios'><i class='fa fa-check'></i></button> - <button style='font-size:13px;' type='button' class='ver_envios btn btn-warning' title='ver envios'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pdf btn btn-danger' title='ver envios'><i class='fa fa-file'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='ver_envios btn btn-warning' title='ver envios'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pdf btn btn-danger' title='ver envios'><i class='fa fa-file'></i></button>`;
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-warning'>EN ESPERA</span>";
          } else {
            return "<span class='label label-success'>ENTREGADO</span>";
          }
        },
      },
      { data: "repartidor" },
      { data: "vehiculos" },
      { data: "num_envio" },
      { data: "fecha_envio" },
      { data: "total" },
      { data: "countt" },
    ],

    language: {
      rows: "%d fila seleccionada",
      processing: "Tratamiento en curso...",
      search: "Buscar&nbsp;:",
      lengthMenu: "Agrupar en _MENU_ items",
      info: "Mostrando los item (_START_ al _END_) de un total _TOTAL_ items",
      infoEmpty: "No existe datos.",
      infoFiltered: "(filtrado de _MAX_ elementos en total)",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No se encontro resultados en tu busqueda",
      emptyTable: "No hay datos disponibles en la tabla",
      paginate: {
        first: "Primero",
        previous: "Anterior",
        next: "Siguiente",
        last: "Ultimo",
      },
      select: {
        rows: "%d fila seleccionada",
      },
      aria: {
        sortAscending: ": active para ordenar la columa en orden ascendente",
        sortDescending: ": active para ordenar la columna en orden descendente",
      },
    },
    select: true,
    responsive: "true",
    dom: "Bfrtilp",
    buttons: [
      {
        extend: "excelHtml5",
        text: "Excel",
        titleAttr: "Exportar a Excel",
        className: "btn btn-success greenlover",
      },
      {
        extend: "pdfHtml5",
        text: "PDF",
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger redfule",
      },
      {
        extend: "print",
        text: "Imprimir",
        titleAttr: "Imprimir",
        className: "btn btn-primary azuldete",
      },
    ],
    order: [[0, "ASC"]],
  });

  //esto es para crearn un contador para la tabla este contador es automatico
  tabla_envios_repartidor.on("draw.dt", function () {
    var pageinfo = $("#tabla_envios_repartidor").DataTable().page.info();
    tabla_envios_repartidor
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_envios_repartidor").on("click", ".ver_envios", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_envios_repartidor.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_envios_repartidor.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_envios_repartidor.row(this).data();
  }

  var id = data.envio_id;

  alerta = ["datos", "Se esta cargando el detalle de envio", ".:Cargando...:."];
  mostar_loader_datos(alerta);
  cargar_detalle_envio(parseInt(id));
});

function cargar_detalle_envio(id) {
  funcion = "cargar_detalle_envio";
  $.ajax({
    url: "../../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
    },
  }).done(function (resp) {
    alerta = ["", "", ""];
    cerrar_loader_datos(alerta);
    let arreglo_total = new Array();
    let total = 0;
    var data = JSON.parse(resp);
    var llenat = "";
    data["data"].forEach((row) => {
      llenat += `<tr>
                  <td>${row["cliente"]}</td>
                  <td>${row["tipo_pago"]}</td>
                  <td>${row["num_venta"]}</td>
                  <td>${row["direccion"]}</td>
                  <td>${row["refrencia"]}</td>
                  <td>${row["cantidad"]}</td>
                  <td>${row["valor"]}</td>                           
                  </tr>`;

      arreglo_total = row["valor"];
      total = (parseFloat(total) + parseFloat(arreglo_total)).toFixed(2);

      $("#lbl_totalneto").html("<b>Total: </b> $ " + total);

      $("#tbody_detalle_ventas_seleccionar_A").html(llenat);
    });

    $("#modal_detalle_envios").modal({
      backdrop: "static",
      keyboard: false,
    });
    $("#modal_detalle_envios").modal("show");
  });
}

$("#tabla_envios_repartidor").on("click", ".pdf", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_envios_repartidor.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_envios_repartidor.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_envios_repartidor.row(this).data();
  }

  var id = data.envio_id;

  Swal.fire({
    title: "IMPRIMIR ENVIO",
    text: "Desea imprimir el reporte de envio??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Imprimir!!",
  }).then((result) => {
    if (result.value) {
      window.open(
        "../../ADMIN/REPORTES/Pdf/reporte_envio.php?id=" +
          parseInt(id) +
          "#zoom=100%",
        "Reporte de venta",
        "scrollbards=No"
      );
    }
  });
});

$("#tabla_envios_repartidor").on("click", ".aceptar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_envios_repartidor.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_envios_repartidor.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_envios_repartidor.row(this).data();
  }

  var id = data.envio_id;

  Swal.fire({
    title: "Finalizar entregas",
    text: "Desea finalizar las entregas??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, finalizar!!",
  }).then((result) => {
    if (result.value) {
      funcion = "finalizar_entregas";
      $.ajax({
        url: "../../ADMIN/controlador/repartidor/repartidor.php",
        type: "POST",
        data: {
          funcion: funcion,
          id: id,
        },
      }).done(function (resp) {
        console.log(resp);

        if (resp > 0) {
          alerta = ["exito", "success", "Envio de ventas finalizado"];
          cerrar_loader_datos(alerta);
          tabla_envios_repartidor.ajax.reload();
        } else {
          alerta = [
            "error",
            "error",
            "No se guardar el registro, error en la matrix",
          ];
          cerrar_loader_datos(alerta);
        }
      });
    }
  });
});

//////////////////////
function listar_efectivo_espera() {
  funcion = "listar_efectivo_espera";
  efec_espera = $("#tabla_efectivo_espera").DataTable({
    ordering: true,
    paging: true,
    aProcessing: true,
    aServerSide: true,
    searching: { regex: true },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    pageLength: 10,
    destroy: true,
    async: false,
    processing: true,

    ajax: {
      url: "../../ADMIN/controlador/repartidor/repartidor.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      {
        render: function (data, type, row) {
          return `<button style='font-size:13px;' type='button' class='photo btn btn-warning' title='Subir foto'><i class='fa fa-photo'></i> Subir</button>`;
        },
      },
      {
        render: function (data, type, row) {
          return "<span class='label label-warning'>En espera</span>";
        },
      },
      { data: "numero_compra" },
      { data: "clientee" },
      { data: "direccion" },
      { data: "referencia" },
      { data: "fecha" },
      { data: "monto" },
    ],

    language: {
      rows: "%d fila seleccionada",
      processing: "Tratamiento en curso...",
      search: "Buscar&nbsp;:",
      lengthMenu: "Agrupar en _MENU_ items",
      info: "Mostrando los item (_START_ al _END_) de un total _TOTAL_ items",
      infoEmpty: "No existe datos.",
      infoFiltered: "(filtrado de _MAX_ elementos en total)",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No se encontro resultados en tu busqueda",
      emptyTable: "No hay datos disponibles en la tabla",
      paginate: {
        first: "Primero",
        previous: "Anterior",
        next: "Siguiente",
        last: "Ultimo",
      },
      select: {
        rows: "%d fila seleccionada",
      },
      aria: {
        sortAscending: ": active para ordenar la columa en orden ascendente",
        sortDescending: ": active para ordenar la columna en orden descendente",
      },
    },
    select: true,
    responsive: "true",
    dom: "Bfrtilp",
    buttons: [
      {
        extend: "excelHtml5",
        text: "Excel",
        titleAttr: "Exportar a Excel",
        className: "btn btn-success greenlover",
      },
      {
        extend: "pdfHtml5",
        text: "PDF",
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger redfule",
      },
      {
        extend: "print",
        text: "Imprimir",
        titleAttr: "Imprimir",
        className: "btn btn-primary azuldete",
      },
    ],
    order: [[0, "ASC"]],
  });

  //esto es para crearn un contador para la tabla este contador es automatico
  efec_espera.on("draw.dt", function () {
    var pageinfo = $("#tabla_efectivo_espera").DataTable().page.info();
    efec_espera
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_efectivo_espera").on("click", ".photo", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = efec_espera.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (efec_espera.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = efec_espera.row(this).data();
  }

  var id = data.efectivo_id;
  var id_clie = data.id_venta_online_trans;

  $("#id_efectivoo").val(id);
  $("#id_clentee").val(id_clie);

  $("#modal_editar_photo").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar_photo").modal("show");
});

function subir_photo() {
  var id = document.getElementById("id_efectivoo").value;
  var id_clie = document.getElementById("id_clentee").value;
  var foto = document.getElementById("foto_new").value;
  var detalle = document.getElementById("txt_detalle").value;

  if (foto == "" || foto.length == 0) {
    return swal.fire(
      "Mensaje de advertencia",
      "Ingrese la imagen del efectivo",
      "warning"
    );
  }

  if (detalle == "" || detalle.length == 0 || detalle.trim() == "") {

    $("#lbl_detalle_").html("- Ingrese detalle efectivo");

    return swal.fire(
      "Mensaje de advertencia",
      "Ingrese el detalle de efectivo",
      "warning"
    );

  }else{
    $("#lbl_detalle_").html("");
  }

  var f = new Date();
  //este codigo me captura la extenion del archivo
  var extecion = foto.split(".").pop();
  //renombramoso el archivo con las hora minutos y segundos
  var nombrearchivo =
    "IMG" +
    f.getDate() +
    "" +
    (f.getMonth() + 1) +
    "" +
    f.getFullYear() +
    "" +
    f.getHours() +
    "" +
    f.getMinutes() +
    "" +
    f.getSeconds() +
    "." +
    extecion;

  var formdata = new FormData();
  var foto = $("#foto_new")[0].files[0];

  //est valores son como los que van en la data del ajax
  funcion = "subir_foto_efectivo";
  formdata.append("funcion", funcion);
  formdata.append("id", id);
  formdata.append("id_clie", id_clie);
  formdata.append("foto", foto);
  formdata.append("detalle", detalle);
  formdata.append("nombrearchivo", nombrearchivo);

  alerta = [
    "datos",
    "Se esta enviando la imagen del efectivo",
    "Enviando imagen...",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../../ADMIN/controlador/repartidor/repartidor.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          document.getElementById("foto_new").value = "";
          document.getElementById("txt_detalle").value = "";
          efec_espera.ajax.reload();
          alerta = [
            "exito",
            "success",
            "La foto se envio con exito",
          ];
          cerrar_loader_datos(alerta);
          $("#modal_editar_photo").modal("hide");
        }
      } else {
        alerta = ["error", "error", "No se pudo enviar la foto del efectivo"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

//////////////////////
function ver_efectivo_procesado() {
  funcion = "ver_efectivo_procesado";
  tabla_efectivo_procesado = $("#tabla_efectivo_procesado").DataTable({
    ordering: true,
    paging: true,
    aProcessing: true,
    aServerSide: true,
    searching: { regex: true },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    pageLength: 10,
    destroy: true,
    async: false,
    processing: true,

    ajax: {
      url: "../../ADMIN/controlador/repartidor/repartidor.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      {
        data: "foto",
        render: function (data, type, row) {
            return (
              "<a class='btn btn-success' href='../../ADMIN/" +
              data +
              "' download><i class='fa fa-download'></i> Ver</a>"
            );          
        },
      },
      {
        render: function (data, type, row) {
          return "<span class='label label-success'>Procesado</span>";
        },
      },
      { data: "numero_compra" },
      { data: "clientee" },
      { data: "direccion" },
      { data: "referencia" },
      { data: "fecha" },
      { data: "monto" },
    ],

    language: {
      rows: "%d fila seleccionada",
      processing: "Tratamiento en curso...",
      search: "Buscar&nbsp;:",
      lengthMenu: "Agrupar en _MENU_ items",
      info: "Mostrando los item (_START_ al _END_) de un total _TOTAL_ items",
      infoEmpty: "No existe datos.",
      infoFiltered: "(filtrado de _MAX_ elementos en total)",
      infoPostFix: "",
      loadingRecords: "Cargando...",
      zeroRecords: "No se encontro resultados en tu busqueda",
      emptyTable: "No hay datos disponibles en la tabla",
      paginate: {
        first: "Primero",
        previous: "Anterior",
        next: "Siguiente",
        last: "Ultimo",
      },
      select: {
        rows: "%d fila seleccionada",
      },
      aria: {
        sortAscending: ": active para ordenar la columa en orden ascendente",
        sortDescending: ": active para ordenar la columna en orden descendente",
      },
    },
    select: true,
    responsive: "true",
    dom: "Bfrtilp",
    buttons: [
      {
        extend: "excelHtml5",
        text: "Excel",
        titleAttr: "Exportar a Excel",
        className: "btn btn-success greenlover",
      },
      {
        extend: "pdfHtml5",
        text: "PDF",
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger redfule",
      },
      {
        extend: "print",
        text: "Imprimir",
        titleAttr: "Imprimir",
        className: "btn btn-primary azuldete",
      },
    ],
    order: [[0, "ASC"]],
  });

  //esto es para crearn un contador para la tabla este contador es automatico
  tabla_efectivo_procesado.on("draw.dt", function () {
    var pageinfo = $("#tabla_efectivo_procesado").DataTable().page.info();
    tabla_efectivo_procesado
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}