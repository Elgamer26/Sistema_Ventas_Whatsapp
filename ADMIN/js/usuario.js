var funcion, tabla_rol, tabla_usuario, tabla_banco;

$(document).on("click", "#ingresar", function (e) {
  e.preventDefault();
  var usuario = $("#usuario").val();
  var password = $("#password").val();

  if (parseInt(usuario.length) <= 0 || usuario == "") {
    $("#none_pass").hide();
    $("#none_usu").hide();
    $("#error_logeo").hide();
    $("#none_usu").show(2000);
  } else if (parseInt(password.length) <= 0 || password == "") {
    $("#none_usu").hide();
    $("#none_pass").hide();
    $("#error_logeo").hide();
    $("#none_pass").show(2000);
  } else {
    $("#none_usu").hide();
    $("#none_pass").hide();
    $("#error_logeo").hide();

    funcion = "logeo";
    $.ajax({
      url: "../ADMIN/controlador/usuario/usuario.php",
      type: "POST",
      data: { usuario: usuario, password: password, funcion: funcion },
    }).done(function (responce) {
      if (responce == 0) {

        // funcion = "logeo";
        // $.ajax({
        //   url: "../ADMIN/controlador/repartidor/repartidor.php",
        //   type: "POST",
        //   data: { usuario: usuario, password: password, funcion: funcion },
        // }).done(function (responce) {
        //   if (responce == 0) {
        //     $("#none_usu").hide();
        //     $("#none_pass").hide();
        //     $("#error_logeo").hide();
        //     $("#error_logeo").show(2000);
        //     return false;
        //   } else {
        //     var data = JSON.parse(responce);
        //     if (data[0][3] == 0) {
        //       Swal.fire({
        //         icon: "error",
        //         title: "Usuario inactivo",
        //         text: "El usuario se encuentra inactivo!",
        //       });
        //     } else {
        //       funcion = "session";
        //       $.ajax({
        //         url: "../ADMIN/controlador/repartidor/repartidor.php",
        //         type: "POST",
        //         data: {
        //           id_repa: data[0][0],
        //           nombre_re: data[0][1],
        //           funcion: funcion,
        //         },
        //       }).done(function (res) {
        //         if (res == 1) {
        //           let timerInterval;
        //           Swal.fire({
        //             title: "Bienvenido al sistema!",
        //             html: "Usted sera redireccionado en <b></b> mi.",
        //             allowOutsideClick: false,
        //             timer: 2000,
        //             timerProgressBar: true,
        //             didOpen: () => {
        //               Swal.showLoading();
        //               const b = Swal.getHtmlContainer().querySelector("b");
        //               timerInterval = setInterval(() => {
        //                 b.textContent = Swal.getTimerLeft();
        //               }, 100);
        //             },
        //             willClose: () => {
        //               clearInterval(timerInterval);
        //             },
        //           }).then((result) => {
        //             /* Read more about handling dismissals below */
        //             if (result.dismiss === Swal.DismissReason.timer) {
        //               location.reload();
        //             }
        //           });
        //         }
        //       });
        //     }
        //   }
        // });

        $("#none_usu").hide();
        $("#none_pass").hide();
        $("#error_logeo").hide();
        $("#error_logeo").show(2000);
        return false;

      } else {
        var data = JSON.parse(responce);
        if (data[0][7] == 0) {
          Swal.fire({
            icon: "error",
            title: "Usuario inactivo",
            text: "El usuario se encuentra inactivo!",
          });
        } else {
          funcion = "session";
          $.ajax({
            url: "../ADMIN/controlador/usuario/usuario.php",
            type: "POST",
            data: {
              id_usu: data[0][0],
              rol: data[0][6],
              funcion: funcion,
            },
          }).done(function (res) {
            if (res == 1) {
              let timerInterval;
              Swal.fire({
                title: "Bienvenido al sistema!",
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

function listar_roles() {
  funcion = "listar_roles";
  tabla_rol = $("#tabla_roles_").DataTable({
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
      url: "../ADMIN/controlador/usuario/usuario.php",
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
            return `<button style='font-size:13px;' type='button' class='inactivar btn btn-danger' title='Inactivar el Oftalmólogo'><i class='fa fa-times'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el Oftalmólogo'><i class='fa fa-edit'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='activar btn btn-success' title='Activar el Oftalmólogo'><i class='fa fa-check'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el Oftalmólogo'><i class='fa fa-edit'></i></button>`;
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-success'>ACTIVO</span>";
          } else {
            return "<span class='label label-danger'>INACTIVO</span>";
          }
        },
      },
      { data: "tipo_usuario" },
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
    order: [[0, "desc"]],
  });

  //esto es para crearn un contador para la tabla este contador es automatico
  tabla_rol.on("draw.dt", function () {
    var pageinfo = $("#tabla_roles_").DataTable().page.info();
    tabla_rol
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_roles_").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_rol.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_rol.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_rol.row(this).data();
  }
  var dato = 0;
  var id = data.id_tipo_usuario;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del tipo de usuario cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_rol(id, dato);
    }
  });
});

$("#tabla_roles_").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_rol.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_rol.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_rol.row(this).data();
  }
  var dato = 1;
  var id = data.id_tipo_usuario;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del tipo de usuario cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_rol(id, dato);
    }
  });
});

$("#tabla_roles_").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_rol.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_rol.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_rol.row(this).data();
  }

  $("#id_rol_usuario").val(data.id_tipo_usuario);
  $("#nombre_rol_edit").val(data.tipo_usuario);

  $("#modal_tpo_edit").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_tpo_edit").modal("show");
});

function cambiar_estado_rol(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "estado_rol";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_rol.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

function nuevo_usuario() {
  $("#modal_tpo").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_tpo").modal("show");
}

function registra_rol() {
  var nombre = $("#nombre_rol").val();

  if (nombre.length == 0 || nombre.length < 0 || nombre == "") {
    return Swal.fire({
      icon: "warning",
      title: "No hay nombre",
      text: "Ingrese un nombre!!",
    });
  }

  funcion = "registrar_rol";
  alerta = ["datos", "Se esta creando el rol", "Creando rol."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: {
      funcion: funcion,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#nombre_rol").val("");
        $("#modal_tpo").modal("hide");
        tabla_rol.ajax.reload();
        alerta = ["exito", "success", "El tipo de usuario se creó con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "El tipo de usuario " + nombre + ", ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo crear el tipo de usuario"];
      cerrar_loader_datos(alerta);
    }
  });
}

function editar_rol() {
  var id = $("#id_rol_usuario").val();
  var nombre = $("#nombre_rol_edit").val();

  if (nombre.length == 0 || nombre.length < 0 || nombre == "") {
    return Swal.fire({
      icon: "warning",
      title: "No hay nombre",
      text: "Ingrese un nombre!!",
    });
  }

  funcion = "editar_rol";
  alerta = ["datos", "Se esta editando el rol", "Editando rol."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#modal_tpo_edit").modal("hide");
        tabla_rol.ajax.reload();
        alerta = ["exito", "success", "El tipo de usuario se edito con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "El tipo de usuario " + nombre + ", ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo editar el tipo de usuario"];
      cerrar_loader_datos(alerta);
    }
  });
}

/////////////////
//////////////usuario
function guardar_usuaio() {
  var nombre = document.getElementById("nombres").value;
  var apellidos = document.getElementById("apellidos").value;
  var usuario = document.getElementById("usuario").value;
  var password = document.getElementById("password").value;
  var tipo_rol_usu = document.getElementById("tipo_rol_usu").value;
  var numero_docu = document.getElementById("numero_docu").value;
  var confirm = document.getElementById("password_con").value;

  var foto = document.getElementById("foto").value;

  if (
    nombre.length == 0 ||
    apellidos.length == 0 ||
    usuario.length == 0 ||
    password.length == 0 ||
    tipo_rol_usu.length == 0 ||
    numero_docu.length == 0 ||
    confirm.length == 0
  ) {
    validar_registro_usuario(
      nombre,
      apellidos,
      usuario,
      password,
      tipo_rol_usu,
      numero_docu,
      confirm
    );

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#nombre_oblig").html("");
    $("#apellido_obliga").html("");
    $("#usuario_obliga").html("");
    $("#pass_obliga").html("");
    $("#dcoumento_obliga").html("");
    $("#rol_obliga").html("");
    $("#pass_obliga_con").html("");
  }

  if(password != confirm){
    $("#pass_obliga").html("XXX");
    $("#pass_obliga_con").html("XXX");
    return swal.fire(
      "Password no coinciden",
      "Ingrese el password correctamente",
      "warning"
    );
  }

  if(!pass_usus){
    return swal.fire(
      "",
      "Ingrese un password mas fuerte para su cuenta de usuario",
      "warning"
    );
  }

  //para scar la fecha para la foto
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
  var foto = $("#foto")[0].files[0];
  //est valores son como los que van en la data del ajax

  alerta = ["datos", "Se esta creando el usuario", "Creando usuario"];
  mostar_loader_datos(alerta);

  funcion = "registra_usuario";
  formdata.append("funcion", funcion);

  formdata.append("nombre", nombre);
  formdata.append("usuario", usuario);
  formdata.append("password", password);
  formdata.append("apellidos", apellidos);
  formdata.append("tipo_rol_usu", tipo_rol_usu);
  formdata.append("numero_docu", numero_docu);

  formdata.append("foto", foto);
  formdata.append("nombrearchivo", nombrearchivo);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        registrar_permisos_save(parseInt(resp));
      } else if (resp == "b") {
        alerta = [
          "existe",
          "warning",
          "El usuario '" + usuario + "' ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      } else if (resp == "c") {
        alerta = [
          "existe",
          "warning",
          "El nombre '" +
            nombre +
            "' y el apellido '" +
            apellidos +
            "', ya estan registrados",
        ];
        cerrar_loader_datos(alerta);
      } else if (resp == "a") {
        alerta = ["error", "error", "Error al registrar el usuario"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

function validar_registro_usuario(
  nombre,
  apellidos,
  usuario,
  password,
  tipo_rol_usu,
  numero_docu,
  confirm
) {
  if (nombre.length == 0) {
    $("#nombre_oblig").html("Ingrese nombres");
  } else {
    $("#nombre_oblig").html("");
  }

  if (apellidos.length == 0) {
    $("#apellido_obliga").html("Ingrese apellidos");
  } else {
    $("#apellido_obliga").html("");
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

  if (numero_docu.length == 0) {
    $("#dcoumento_obliga").html("Ingrese cedula");
  } else {
    $("#dcoumento_obliga").html("");
  }

  if (tipo_rol_usu.length == 0) {
    $("#rol_obliga").html("No hay tipo de rol");
  } else {
    $("#rol_obliga").html("");
  }

  if (confirm.length == 0) {
    $("#pass_obliga_con").html("Confirmar password");
  } else {
    $("#pass_obliga_con").html("");
  }
}

// permisos de usuario
function registrar_permisos_save(id) {
  var usuario = document.getElementById("usuario_p").checked;
  var clientes = document.getElementById("clientes_p").checked;
  var proveedor = document.getElementById("proveedor_p").checked;
  var datos_empresa = document.getElementById("datos_empresa_p").checked;
  var banco = document.getElementById("banco_p").checked;
  var tipo_servicio = document.getElementById("tipo_servicio_p").checked;
  var productos = document.getElementById("productos_p").checked;
  var compras = document.getElementById("compras_p").checked;
  var facturacion = document.getElementById("facturacion_p").checked;
  var calificacion = document.getElementById("calificacion_p").checked;
  var ventas_online = document.getElementById("ventas_online_p").checked;
  var tipos_pagos = document.getElementById("tipos_pagos_p").checked;
  var envios = document.getElementById("envios_p").checked;
  var registro_promo = document.getElementById("registro_promo_p").checked;
  var promo_vigente = document.getElementById("promo_vigente_p").checked;
  var reportes = document.getElementById("reportes_p").checked;

  funcion = "crear_permisos_usuario";
  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      usuario: usuario,
      clientes: clientes,
      proveedor: proveedor,
      datos_empresa: datos_empresa,
      banco: banco,
      tipo_servicio: tipo_servicio,
      productos: productos,
      compras: compras,
      facturacion: facturacion,
      calificacion: calificacion,
      ventas_online: ventas_online,
      tipos_pagos: tipos_pagos,
      envios: envios,
      registro_promo: registro_promo,
      promo_vigente: promo_vigente,
      reportes: reportes,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "El usuario se registro con exito"];
        cerrar_loader_datos(alerta);
        cargar_contenido("contenido_principal", "vista/usuario/usuario.php");
      }
    } else {
      alerta = [
        "error",
        "error",
        "No se pudo crear los permisos del usuario - FALLO EN LA MATRIX:(",
      ];
      cerrar_loader_datos(alerta);
    }
  });
}

function listar_usuarios() {
  funcion = "listar_usuarios";
  tabla_usuario = $("#tabla_usuarios_").DataTable({
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
      url: "../ADMIN/controlador/usuario/usuario.php",
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
            return `<button style='font-size:13px;' type='button' class='inactivar btn btn-danger' title='Inactivar el usuario'><i class='fa fa-times'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el usuario'><i class='fa fa-edit'></i></button> - <button style='font-size:13px;' type='button' class='key btn btn-warning' title='Editar password'><i class='fa fa-key'></i></button>
            - <button style='font-size:13px;' type='button' class='permisos btn btn-info' title='ver los permisos'><i class='fa fa-lock'></i></button> - <button style='font-size:13px;' type='button' class='photoo btn btn-default' title='Editar imagen'><i class='fa fa-photo'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='activar btn btn-success' title='Activar el usuario'><i class='fa fa-check'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el usuario'><i class='fa fa-edit'></i></button> - <button style='font-size:13px;' type='button' class='key btn btn-warning' title='Editar password'><i class='fa fa-key'></i></button>
            - <button style='font-size:13px;' type='button' class='permisos btn btn-info' title='ver los permisos'><i class='fa fa-lock'></i></button> - <button style='font-size:13px;' type='button' class='photoo btn btn-default' title='Editar imagen'><i class='fa fa-photo'></i></button>`;
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-success'>ACTIVO</span>";
          } else {
            return "<span class='label label-danger'>INACTIVO</span>";
          }
        },
      },
      { data: "nombres" },
      { data: "apellidos" },
      { data: "usuario" },
      {
        data: "foto",
        render: function (data, type, row) {
          return "<img class='img-circle' src='" + data + "' width='45px' />";
        },
      },
      { data: "tipo_usuario" },
      { data: "documento" },
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
  tabla_usuario.on("draw.dt", function () {
    var pageinfo = $("#tabla_usuarios_").DataTable().page.info();
    tabla_usuario
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_usuarios_").on("click", ".photoo", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_usuario.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_usuario.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_usuario.row(this).data();
  }

  var id = data.id_usuario;
  var foto = data.foto;

  $("#id_foto_producto").val(id);
  $("#foto_actu").val(foto);
  $("#foto_producto").attr("src", foto);

  $("#modal_editar_photo").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar_photo").modal("show");
});

function editar_foto_usuarioo() {
  var id = document.getElementById("id_foto_producto").value;
  var foto = document.getElementById("foto_new").value;
  var ruta_actual = document.getElementById("foto_actu").value;

  if (foto == "" || ruta_actual.length == 0 || ruta_actual == "") {
    return swal.fire(
      "Mensaje de advertencia",
      "Ingrese una imagen para actualizar",
      "warning"
    );
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
  funcion = "editar_foto_usuarioo";
  formdata.append("funcion", funcion);
  formdata.append("id", id);
  formdata.append("foto", foto);
  formdata.append("ruta_actual", ruta_actual);
  formdata.append("nombrearchivo", nombrearchivo);

  alerta = [
    "datos",
    "Se esta editando la imagen del producto",
    "Editando imagen producto",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          document.getElementById("foto_new").value = "";
          tabla_usuario.ajax.reload();
          alerta = [
            "exito",
            "success",
            "La foto de usuario se edito con exito",
          ];
          cerrar_loader_datos(alerta);
          $("#modal_editar_photo").modal("hide");
        }
      } else {
        alerta = ["error", "error", "No se pudo editar la foto de usuario"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

$("#tabla_usuarios_").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_usuario.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_usuario.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_usuario.row(this).data();
  }
  var dato = 0;
  var id = data.id_usuario;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del usuario se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_usuario(id, dato);
    }
  });
});

$("#tabla_usuarios_").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_usuario.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_usuario.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_usuario.row(this).data();
  }
  var dato = 1;
  var id = data.id_usuario;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del usuario se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_usuario(id, dato);
    }
  });
});

function cambiar_estado_usuario(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "estado_usuario";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_usuario.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_usuarios_").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_usuario.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_usuario.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_usuario.row(this).data();
  }

  $("#id_usuario_edit").val(data.id_usuario);
  $("#nombres").val(data.nombres);
  $("#apellidos").val(data.apellidos);
  $("#usuario").val(data.usuario);
  $("#tipo_rol_usu").val(data.id_tipo_usuario).trigger("change");
  $("#numero_docu").val(data.documento);

  $("#password").val("");

  $("#nombre_oblig").html("");
  $("#apellido_obliga").html("");
  $("#usuario_obliga").html("");
  $("#pass_obliga").html("");
  $("#dcoumento_obliga").html("");
  $("#rol_obliga").html("");

  $("#numero_docu").css("border", "1px solid green");
  $("#cedula_empleado").html("");

  $("#modal_edit_usuario").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_edit_usuario").modal("show");
});

function editar_usuario() {
  var id = document.getElementById("id_usuario_edit").value;
  var nombre = document.getElementById("nombres").value;
  var apellidos = document.getElementById("apellidos").value;
  var usuario = document.getElementById("usuario").value;
  var tipo_rol_usu = document.getElementById("tipo_rol_usu").value;
  var numero_docu = document.getElementById("numero_docu").value;

  if (
    nombre.length == 0 ||
    apellidos.length == 0 ||
    usuario.length == 0 ||
    numero_docu.length == 0 ||
    tipo_rol_usu.length == 0
  ) {
    validar_registro_usuario_edit(
      nombre,
      apellidos,
      usuario,
      numero_docu,
      tipo_rol_usu
    );

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#nombre_oblig").html("");
    $("#apellido_obliga").html("");
    $("#usuario_obliga").html("");
    $("#dcoumento_obliga").html("");
    $("#rol_obliga").html("");
  }

  funcion = "editar_usuario";
  alerta = ["datos", "Se esta editando el usuario", "Creando usuario"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      nombre: nombre,
      usuario: usuario,
      apellidos: apellidos,
      tipo_rol_usu: tipo_rol_usu,
      numero_docu: numero_docu,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "El usuario se edito con exito"];
        cerrar_loader_datos(alerta);
        tabla_usuario.ajax.reload();
        $("#modal_edit_usuario").modal("hide");
      } else if (response == 2) {
        alerta = [
          "existe",
          "warning",
          "El usuario " + usuario + " ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "El nombre " +
            nombre +
            " y el apellido " +
            apellidos +
            ", ya estan registrados",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "Error al editar el usuario"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_registro_usuario_edit(
  nombre,
  apellidos,
  usuario,
  numero_docu,
  tipo_rol_usu
) {
  if (nombre.length == 0) {
    $("#nombre_oblig").html("Ingrese nombres");
  } else {
    $("#nombre_oblig").html("");
  }

  if (apellidos.length == 0) {
    $("#apellido_obliga").html("Ingrese apellidos");
  } else {
    $("#apellido_obliga").html("");
  }

  if (usuario.length == 0) {
    $("#usuario_obliga").html("Ingrese usuario");
  } else {
    $("#usuario_obliga").html("");
  }

  if (numero_docu.length == 0) {
    $("#dcoumento_obliga").html("Ingrese numero documento");
  } else {
    $("#dcoumento_obliga").html("");
  }

  if (tipo_rol_usu.length == 0) {
    $("#rol_obliga").html("No hay tipo de rol");
  } else {
    $("#rol_obliga").html("");
  }
}

$("#tabla_usuarios_").on("click", ".key", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_usuario.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_usuario.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_usuario.row(this).data();
  }

  document.getElementById("password_edit_usu_c").value = "";
  $('#passstrength').html("");
  $("#id_usuario_edit_c").val(data.id_usuario);
  $("#password_edit_usu").val(data.password);

  $("#modal_edit__pasword").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_edit__pasword").modal("show");
});

$("#tabla_usuarios_").on("click", ".permisos", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_usuario.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_usuario.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_usuario.row(this).data();
  }

  var id = data.id_usuario;

  alerta = [
    "cambio_datos",
    "Se estan obteniendo los permisos actuales del usuario, por favor espere....",
    ".:Obteniendo permisos de usuario:.",
  ];
  mostar_loader_datos(alerta);
  obtener_permisos(parseInt(id));
});

function obtener_permisos(id) {
  funcion = "obtener_permisos";
  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: { funcion: funcion, id: id },
  }).done(function (response) {
    var data = JSON.parse(response);

    $("#id_usu").val(id);
    $("#id_permiso").val(data[0]["permisos_id"]);

    data[0]["usuario"].toString() == "true"
      ? ($("#usuario_p")[0].checked = true)
      : ($("#usuario_p")[0].checked = false);

    data[0]["cliente"].toString() == "true"
      ? ($("#clientes_p")[0].checked = true)
      : ($("#clientes_p")[0].checked = false);

    data[0]["proveedor"].toString() == "true"
      ? ($("#proveedor_p")[0].checked = true)
      : ($("#proveedor_p")[0].checked = false);

    data[0]["datos_empresa"].toString() == "true"
      ? ($("#datos_empresa_p")[0].checked = true)
      : ($("#datos_empresa_p")[0].checked = false);

    data[0]["banco"].toString() == "true"
      ? ($("#banco_p")[0].checked = true)
      : ($("#banco_p")[0].checked = false);

    data[0]["tipo_servicio"].toString() == "true"
      ? ($("#tipo_servicio_p")[0].checked = true)
      : ($("#tipo_servicio_p")[0].checked = false);

    data[0]["producto"].toString() == "true"
      ? ($("#productos_p")[0].checked = true)
      : ($("#productos_p")[0].checked = false);

    data[0]["compras"].toString() == "true"
      ? ($("#compras_p")[0].checked = true)
      : ($("#compras_p")[0].checked = false);

    data[0]["facturacion"].toString() == "true"
      ? ($("#facturacion_p")[0].checked = true)
      : ($("#facturacion_p")[0].checked = false);

    data[0]["calificacion"].toString() == "true"
      ? ($("#calificacion_p")[0].checked = true)
      : ($("#calificacion_p")[0].checked = false);

    data[0]["ventas_online"].toString() == "true"
      ? ($("#ventas_online_p")[0].checked = true)
      : ($("#ventas_online_p")[0].checked = false);

    data[0]["tipos_pagos"].toString() == "true"
      ? ($("#tipos_pagos_p")[0].checked = true)
      : ($("#tipos_pagos_p")[0].checked = false);

    data[0]["envios"].toString() == "true"
      ? ($("#envios_p")[0].checked = true)
      : ($("#envios_p")[0].checked = false);

    data[0]["registro_promo"].toString() == "true"
      ? ($("#registro_promo_p")[0].checked = true)
      : ($("#registro_promo_p")[0].checked = false);

    data[0]["promo_vigentes"].toString() == "true"
      ? ($("#promo_vigente_p")[0].checked = true)
      : ($("#promo_vigente_p")[0].checked = false);

    data[0]["reportes"].toString() == "true"
      ? ($("#reportes_p")[0].checked = true)
      : ($("#reportes_p")[0].checked = false);

    alerta = ["none", "", ""];
    cerrar_loader_datos(alerta);
    $("#modal_editar_permisos").modal({
      backdrop: "static",
      keyboard: false,
    });
    $("#modal_editar_permisos").modal("show");
  });
}

function editar_permisos_usuario() {
  var id_permiso = document.getElementById("id_permiso").value;
  var id_usu = document.getElementById("id_usu").value;

  var usuario = document.getElementById("usuario_p").checked;
  var clientes = document.getElementById("clientes_p").checked;
  var proveedor = document.getElementById("proveedor_p").checked;
  var datos_empresa = document.getElementById("datos_empresa_p").checked;
  var banco = document.getElementById("banco_p").checked;
  var tipo_servicio = document.getElementById("tipo_servicio_p").checked;
  var productos = document.getElementById("productos_p").checked;
  var compras = document.getElementById("compras_p").checked;
  var facturacion = document.getElementById("facturacion_p").checked;
  var calificacion = document.getElementById("calificacion_p").checked;
  var ventas_online = document.getElementById("ventas_online_p").checked;
  var tipos_pagos = document.getElementById("tipos_pagos_p").checked;
  var envios = document.getElementById("envios_p").checked;
  var registro_promo = document.getElementById("registro_promo_p").checked;
  var promo_vigente = document.getElementById("promo_vigente_p").checked;
  var reportes = document.getElementById("reportes_p").checked;

  funcion = "editar_permisos_usuario";
  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: {
      funcion: funcion,
      id_permiso: id_permiso,
      id_usu: id_usu,
      usuario: usuario,
      clientes: clientes,
      proveedor: proveedor,
      datos_empresa: datos_empresa,
      banco: banco,
      tipo_servicio: tipo_servicio,
      productos: productos,
      compras: compras,
      facturacion: facturacion,
      calificacion: calificacion,
      ventas_online: ventas_online,
      tipos_pagos: tipos_pagos,
      envios: envios,
      registro_promo: registro_promo,
      promo_vigente: promo_vigente,
      reportes: reportes,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "Permisos editados con exito"];
        cerrar_loader_datos(alerta);
        tabla_usuario.ajax.reload();
        $("#modal_editar_permisos").modal("hide");
      }
    } else {
      alerta = [
        "error",
        "error",
        "No se pudo editar los permisos - FALLO EN LA MATRIX:(",
      ];
      cerrar_loader_datos(alerta);
    }
  });
}

function editar_password() {
  var id = document.getElementById("id_usuario_edit_c").value;
  var nombre = document.getElementById("password_edit_usu").value;
  var nombre_c = document.getElementById("password_edit_usu_c").value;

  if (nombre.length == 0 || nombre_c.length == 0) {
    return swal.fire("Campo vacios", "Debe ingresar y confirmar el password", "warning");
  }

  if (nombre != nombre_c) {
    $("#pass_obliga").html("Confirmar password");
    $("#pass_obliga_c").html("Confirmar password");

    return swal.fire(
      "Password no coinciden",
      "Los 2 password deben ser iguales",
      "warning"
    );
  } else {
    $("#pass_obliga").html("");
    $("#pass_obliga_c").html("");
  }

  funcion = "editar_password_usuario";
  alerta = ["datos", "Se esta editando el password", "Editando password"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "El password se edito con exito"];
        cerrar_loader_datos(alerta);

        tabla_usuario.ajax.reload();
        $("#modal_edit__pasword").modal("hide");
      }
    } else {
      alerta = ["error", "error", "Error al editar el password"];
      cerrar_loader_datos(alerta);
    }
  });
}

////////////////// banco
function nuevo_banco() {
  $("#nombre_banco").val("");
  $("#modal_BANCO").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_BANCO").modal("show");
}

function registra_banco() {
  var nombre = $("#nombre_banco").val();

  if (nombre.length == 0 || nombre.length < 0 || nombre == "") {
    return Swal.fire({
      icon: "warning",
      title: "No hay nombre",
      text: "Ingrese un nombre!!",
    });
  }

  funcion = "registrar_banco";
  alerta = ["datos", "Se esta creando el banco", "Creando banco."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: {
      funcion: funcion,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#nombre_banco").val("");
        $("#modal_BANCO").modal("hide");
        tabla_banco.ajax.reload();
        alerta = ["exito", "success", "El banco se creó con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "El nombre de banco " + nombre + ", ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo crear el banco"];
      cerrar_loader_datos(alerta);
    }
  });
}

function listar_banco() {
  funcion = "listar_banco";
  tabla_banco = $("#tabla_banco").DataTable({
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
      url: "../ADMIN/controlador/usuario/usuario.php",
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
            return `<button style='font-size:13px;' type='button' class='inactivar btn btn-danger' title='Inactivar el usuario'><i class='fa fa-times'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el usuario'><i class='fa fa-edit'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='activar btn btn-success' title='Activar el usuario'><i class='fa fa-check'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el usuario'><i class='fa fa-edit'></i></button>`;
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-success'>ACTIVO</span>";
          } else {
            return "<span class='label label-danger'>INACTIVO</span>";
          }
        },
      },
      { data: "nombre_banco" },
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
  tabla_banco.on("draw.dt", function () {
    var pageinfo = $("#tabla_banco").DataTable().page.info();
    tabla_banco
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_banco").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_banco.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_banco.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_banco.row(this).data();
  }
  var dato = 0;
  var id = data.id_banco;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del banco se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_banco(id, dato);
    }
  });
});

$("#tabla_banco").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_banco.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_banco.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_banco.row(this).data();
  }
  var dato = 1;
  var id = data.id_banco;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del banco se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_banco(id, dato);
    }
  });
});

function cambiar_estado_banco(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "estado_banco";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_banco.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_banco").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_banco.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_banco.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_banco.row(this).data();
  }

  $("#id_banco").val(data.id_banco);
  $("#nombre_banco_edit").val(data.nombre_banco);

  $("#modal_editar_baanco").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_editar_baanco").modal("show");
});

function editar_banco() {
  var id = $("#id_banco").val();
  var nombre = $("#nombre_banco_edit").val();

  if (nombre.length == 0 || nombre.length < 0 || nombre == "") {
    return Swal.fire({
      icon: "warning",
      title: "No hay nombre",
      text: "Ingrese un nombre!!",
    });
  }

  funcion = "editar_banco";
  alerta = ["datos", "Se esta editando el banco", "Editando banco."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#modal_editar_baanco").modal("hide");
        tabla_banco.ajax.reload();
        alerta = ["exito", "success", "El banco se edito con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "El banco " + nombre + ", ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo editar el banco"];
      cerrar_loader_datos(alerta);
    }
  });
}
