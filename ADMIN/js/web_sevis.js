var funcion,
  tabla_calificacion,
  tabla_vehiculos,
  tabla_repartidor,
  detalle_ventas_seleccionar,
  tabla_envioss,
  tabla_calificacion_p,
  tabla_calificacion_producto;

function listar_calificacion() {
  funcion = "listar_calificacion";
  tabla_calificacion = $("#tabla_calificacion").DataTable({
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
      url: "../ADMIN/controlador/web_servis/web_servis.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      { data: "ciente" },
      { data: "fecha" },
      {
        data: "calificar",
        render: function (data, type, row) {
          if (data == "Excelente") {
            return "<span class='label label-success'>" + data + "</span>";
          } else if (data == "Muy Bueno") {
            return "<span class='label label-info'>" + data + "</span>";
          } else if (data == "Bueno") {
            return "<span class='label label-primary'>" + data + "</span>";
          } else if (data == "Regular") {
            return "<span class='label label-warning'>" + data + "</span>";
          } else {
            return "<span class='label label-danger'>" + data + "</span>";
          }
        },
      },

      { data: "detalle" },
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
    order: [[3, "ASC"]],
  });

  //esto es para crearn un contador para la tabla este contador es automatico
  tabla_calificacion.on("draw.dt", function () {
    var pageinfo = $("#tabla_calificacion").DataTable().page.info();
    tabla_calificacion
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

function listar_calificacion_producto() {
  funcion = "listar_calificacion_producto";
  tabla_calificacion_p = $("#tabla_calificacion_producto").DataTable({
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
      url: "../ADMIN/controlador/web_servis/web_servis.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      {
        render: function () {
          return "<button style='font-size:13px;' type='button' class='ver_calif btn btn-warning' title='enviar'><i class='fa fa-eye'></i></button>";
        },
      },
      { data: "nombre_producto" },
      {
        data: "foto",
        render: function (data, type, row) {
          return "<img class='img-circle' src='" + data + "' width='45px' />";
        },
      },
      { data: "tipo_producto" },
      { data: "marca" },
      { data: "cantidad" },
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
  tabla_calificacion_p.on("draw.dt", function () {
    var pageinfo = $("#tabla_calificacion_producto").DataTable().page.info();
    tabla_calificacion_p
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_calificacion_producto").on("click", ".ver_calif", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_calificacion_p.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_calificacion_p.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_calificacion_p.row(this).data();
  }

  var id = data.id_producto;
  traer_calidifcacion(parseInt(id));
});

function traer_calidifcacion(id) {
  $("#modal_detalle_calificaiones").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_detalle_calificaiones").modal("show");

  funcion = "traer_calidifcacion";
  tabla_calificacion_producto = $("#detalle_calificaicon").DataTable({
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
      url: "../ADMIN/controlador/web_servis/web_servis.php",
      type: "POST",
      data: { funcion: funcion, id: id },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      { data: "cliente" },
      { data: "fecha" },
      {
        data: "calificar",
        render: function (data, type, row) {
          if (data == "Excelente") {
            return "<span class='label label-success'>" + data + "</span>";
          } else if (data == "Muy Bueno") {
            return "<span class='label label-info'>" + data + "</span>";
          } else if (data == "Bueno") {
            return "<span class='label label-primary'>" + data + "</span>";
          } else if (data == "Regular") {
            return "<span class='label label-warning'>" + data + "</span>";
          } else {
            return "<span class='label label-danger'>" + data + "</span>";
          }
        },
      },
      { data: "detalle" },
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
    order: [[0, "ASC"]],
  });

  //esto es para crearn un contador para la tabla este contador es automatico
  tabla_calificacion_producto.on("draw.dt", function () {
    var pageinfo = $("#detalle_calificaicon").DataTable().page.info();
    tabla_calificacion_producto
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

function nuevo_vehiculo() {
  $("#marca_vehi").val("");
  $("#matricula").val("");
  $("#numero_serie").val("");
  $("#detalle_p").val("");

  $("#marca_obligg").html("");
  $("#matricula_obliga").html("");
  $("#numerose_obliga").html("");
  $("#detalle_obliga").html("");
  $("#validacion_placa").html("");
  $("#modelo_obligg").html("");

  $("#modal_nuevo_veiculo").modal({ backdrop: "static", keyboard: false });
  $("#modal_nuevo_veiculo").modal("show");
}

function listar_vwhiculos() {
  funcion = "listar_vwhiculos";
  tabla_vehiculos = $("#tabla_vehiculos").DataTable({
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
      url: "../ADMIN/controlador/web_servis/web_servis.php",
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
      { data: "tipo" },
      { data: "marca" },
      { data: "modelo" },
      { data: "matricula" },
      { data: "numero_serie" },
      { data: "detalle_p" },
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
    order: [[3, "ASC"]],
  });

  //esto es para crearn un contador para la tabla este contador es automatico
  tabla_vehiculos.on("draw.dt", function () {
    var pageinfo = $("#tabla_vehiculos").DataTable().page.info();
    tabla_vehiculos
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

function registra_vehiculo() {
  var tipo = $("#tipo_vehiculo").val();
  var marca = $("#marca_vehi").val();
  var matricula = $("#matricula").val();
  var numero_serie = $("#numero_serie").val();
  var detalle_p = $("#detalle_p").val();
  var modelo = $("#modelo_vehi").val();

  if (
    marca.length == 0 ||
    matricula.length == 0 ||
    numero_serie.length == 0 ||
    detalle_p.length == 0 ||
    modelo.length == 0
  ) {
    validar_registro(marca, matricula, numero_serie, detalle_p, modelo);

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#marca_obligg").html("");
    $("#matricula_obliga").html("");
    $("#numerose_obliga").html("");
    $("#detalle_obliga").html("");
    $("#modelo_obligg").html("");
  }

  funcion = "registrar_vehiculo";
  alerta = ["datos", "Se esta creando el vehículo", "creando vehículo"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    data: {
      funcion: funcion,
      tipo: tipo,
      marca: marca,
      matricula: matricula,
      numero_serie: numero_serie,
      detalle_p: detalle_p,
      modelo: modelo,
    },
  }).done(function (resp) {
    if (resp == 1) {
      $("#modal_nuevo_veiculo").modal("hide");
      tabla_vehiculos.ajax.reload();
      alerta = ["exito", "success", "El vehículo se registró con exito"];
      cerrar_loader_datos(alerta);
    } else {
      alerta = ["error", "error", "Error al registrar el vehículo"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_registro(marca, matricula, numero_serie, detalle_p, modelo) {
  if (marca.length == 0) {
    $("#marca_obligg").html("Ingrese marca");
  } else {
    $("#marca_obligg").html("");
  }

  if (matricula.length == 0) {
    $("#matricula_obliga").html("Ingrese placa");
  } else {
    $("#matricula_obliga").html("");
  }

  if (numero_serie.length == 0) {
    $("#numerose_obliga").html("Ingrese color");
  } else {
    $("#numerose_obliga").html("");
  }

  if (detalle_p.length == 0) {
    $("#detalle_obliga").html("Ingrese detalle");
  } else {
    $("#detalle_obliga").html("");
  }

  if (modelo.length == 0) {
    $("#modelo_obligg").html("Ingrese modelo");
  } else {
    $("#modelo_obligg").html("");
  }
}

$("#tabla_vehiculos").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_vehiculos.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_vehiculos.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_vehiculos.row(this).data();
  }
  var dato = 0;
  var id = data.id_vehiculo;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del vehículo cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_vehculo(id, dato);
    }
  });
});

$("#tabla_vehiculos").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_vehiculos.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_vehiculos.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_vehiculos.row(this).data();
  }
  var dato = 1;
  var id = data.id_vehiculo;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del vehículo cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_vehculo(id, dato);
    }
  });
});

function cambiar_estado_vehculo(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "cambiar_estado_vehculo";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_vehiculos.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_vehiculos").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_vehiculos.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_vehiculos.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_vehiculos.row(this).data();
  }

  $("#idvehicuslos").val(data.id_vehiculo);
  $("#tipo_vehiculo_edit").val(data.tipo);
  $("#marca_vehi_edit").val(data.marca);
  $("#matricula_edit").val(data.matricula);
  $("#numero_serie_edit").val(data.numero_serie);
  $("#detalle_p_edit").val(data.detalle_p);
  $("#modelo_vehi_edit").val(data.modelo);

  $("edit_#marca_obligg").html("");
  $("edit_#matricula_obliga").html("");
  $("edit_#numerose_obliga").html("");
  $("edit_#detalle_obliga").html("");
  $("#validacion_placa_edit").html("");
  $("#modelo_obligg_edit").html("");

  $("#modal_editar_veiculo").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_editar_veiculo").modal("show");
});

function editar_vehiculo() {
  var id = $("#idvehicuslos").val();
  var tipo = $("#tipo_vehiculo_edit").val();
  var marca = $("#marca_vehi_edit").val();
  var matricula = $("#matricula_edit").val();
  var numero_serie = $("#numero_serie_edit").val();
  var detalle_p = $("#detalle_p_edit").val();
  var modelo = $("#modelo_vehi_edit").val();

  if (
    marca.length == 0 ||
    matricula.length == 0 ||
    numero_serie.length == 0 ||
    detalle_p.length == 0 ||
    modelo.length == 0
  ) {
    validar_editar(marca, matricula, numero_serie, detalle_p, modelo);

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#edit_marca_obligg").html("");
    $("#edit_matricula_obliga").html("");
    $("#edit_numerose_obliga").html("");
    $("#edit_detalle_obliga").html("");
    $("#modelo_obligg_edit").html("");
  }

  funcion = "editar_vehiculo";
  alerta = ["datos", "Se esta editando el vehículo", "Editando vehículo"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      tipo: tipo,
      marca: marca,
      matricula: matricula,
      numero_serie: numero_serie,
      detalle_p: detalle_p,
      modelo: modelo,
    },
  }).done(function (resp) {
    if (resp == 1) {
      $("#modal_editar_veiculo").modal("hide");
      tabla_vehiculos.ajax.reload();
      alerta = ["exito", "success", "El vehículo se registró con exito"];
      cerrar_loader_datos(alerta);
    } else {
      alerta = ["error", "error", "Error al registrar el vehículo"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_editar(marca, matricula, numero_serie, detalle_p, modelo) {
  if (marca.length == 0) {
    $("#edit_marca_obligg").html("Ingrese marca");
  } else {
    $("#edit_marca_obligg").html("");
  }

  if (matricula.length == 0) {
    $("#edit_matricula_obliga").html("Ingrese matricula");
  } else {
    $("#edit_matricula_obliga").html("");
  }

  if (numero_serie.length == 0) {
    $("#edit_numerose_obliga").html("Ingrese color");
  } else {
    $("#edit_numerose_obliga").html("");
  }

  if (detalle_p.length == 0) {
    $("#edit_detalle_obliga").html("Ingrese detalle");
  } else {
    $("#edit_detalle_obliga").html("");
  }

  if (modelo.length == 0) {
    $("#modelo_obligg_edit").html("Ingrese modelo");
  } else {
    $("#modelo_obligg_edit").html("");
  }
}

///////////////////
//////////////
////////
function listar_repartidor() {
  funcion = "listar_repartidor";
  tabla_repartidor = $("#tabla_repartidor").DataTable({
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
      url: "../ADMIN/controlador/web_servis/web_servis.php",
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
            return `<button style='font-size:13px;' type='button' class='inactivar btn btn-danger' title='Inactivar el usuario'><i class='fa fa-times'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el usuario'><i class='fa fa-edit'></i></button> - <button style='font-size:13px;' type='button' class='htiti btn btn-warning' title='Editra foto'><i class='fa fa-photo'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='activar btn btn-success' title='Activar el usuario'><i class='fa fa-check'></i></button> - <button style='font-size:13px;' type='button' class='htiti btn btn-warning' title='Editra foto'><i class='fa fa-photo'></i></button>`;
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
      {
        data: "imagen",
        render: function (data, type, row) {
          return "<img class='img-circle' src='" + data + "' width='45px' />";
        },
      },
      { data: "tipo_licencia" },
      { data: "sexo" },
      { data: "cedula" },
      { data: "telefono" },
      { data: "correo" },
      { data: "direcion" },
      { data: "usuario" },
      { data: "passwordd" },
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
  tabla_repartidor.on("draw.dt", function () {
    var pageinfo = $("#tabla_repartidor").DataTable().page.info();
    tabla_repartidor
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_repartidor").on("click", ".htiti", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_repartidor.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_repartidor.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_repartidor.row(this).data();
  }

  var id = data.repartidor_id;
  var foto = data.imagen;

  $("#id_foto_producto").val(id);
  $("#foto_actu").val(foto);
  $("#foto_producto").attr("src", foto);

  $("#modal_editar_photo").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar_photo").modal("show");
});

function editar_foto_repartidor() {
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
  funcion = "editar_foto_repartidor";
  formdata.append("funcion", funcion);
  formdata.append("id", id);
  formdata.append("foto", foto);
  formdata.append("ruta_actual", ruta_actual);
  formdata.append("nombrearchivo", nombrearchivo);

  alerta = [
    "datos",
    "Se esta editando la imagen del repartidor",
    "Editando imagen repartidor",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          document.getElementById("foto_new").value = "";
          tabla_repartidor.ajax.reload();
          alerta = [
            "exito",
            "success",
            "La foto de repartidor se edito con exito",
          ];
          cerrar_loader_datos(alerta);
          $("#modal_editar_photo").modal("hide");
        }
      } else {
        alerta = ["error", "error", "No se pudo editar la foto de repartidor"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

function nuevo_repartidor() {
  $("#passstrength_e").html("");

  $("#numero_docu").css("border", "1px solid green");
  $("#cedula_empleado").html("");

  $("#correo_p").css("border", "1px solid green");
  $("#email_correcto").html("");

  $("#nombres_oblig").html("");
  $("#apellidos_oblig").html("");
  $("#cedula_obliga").html("");
  $("#telefono_obliga").html("");
  $("#correo_obliga").html("");
  $("#direccion_obliga").html("");
  $("#tipo_lice_obliga").html("");

  document.getElementById("nombress").value = "";
  document.getElementById("apellidoss").value = "";
  document.getElementById("numero_docu").value = "";
  document.getElementById("telefono_p").value = "";
  document.getElementById("correo_p").value = "";
  document.getElementById("direccions").value = "";
  document.getElementById("tipo_licencia").value = "";
  document.getElementById("usuario").value = "";
  document.getElementById("password").value = "";

  $("#modal_repartidor").modal({ backdrop: "static", keyboard: false });
  $("#modal_repartidor").modal("show");
}

function registro_repartidor() {
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
  var confir = document.getElementById("password_conf").value;

  var foto = document.getElementById("foto_repa").value;

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
    confir.length == 0
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
      confir
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
    $("#pass_obliga_conf").html("");
  }

  if (password != confir) {
    $("#pass_obliga").html("XXX");
    $("#pass_obliga_conf").html("XXX");

    return swal.fire(
      "Password no coinciden",
      "Ingrese los password correctamente",
      "warning"
    );
  }

  if (!pass_deli_e) {
    return swal.fire(
      "",
      "Ingrese un password mas fuerte para su cuenta de usuario",
      "warning"
    );
  }

  ////////////////////
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
  var foto = $("#foto_repa")[0].files[0];
  //est valores son como los que van en la data del ajax

  funcion = "registrar_repartidors";
  alerta = ["datos", "Se esta creando el repartidor", "creando repartidor"];
  mostar_loader_datos(alerta);

  formdata.append("funcion", funcion);

  formdata.append("nombress", nombress);
  formdata.append("apellidoss", apellidoss);
  formdata.append("numero_docu", numero_docu);
  formdata.append("telefono_p", telefono_p);

  formdata.append("correo_p", correo_p);
  formdata.append("direccions", direccions);

  formdata.append("sexo", sexo);
  formdata.append("tipo_licencia", tipo_licencia);
  formdata.append("usuario", usuario);
  formdata.append("password", password);

  formdata.append("foto", foto);
  formdata.append("nombrearchivo", nombrearchivo);

  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          tabla_repartidor.ajax.reload();
          alerta = ["exito", "success", "El cliente se registro con exito"];
          cerrar_loader_datos(alerta);
          $("#passstrength_e").html("");
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
        alerta = ["error", "error", "Error al registrar el cliente"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
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
  confir
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

  if (confir.length == 0) {
    $("#pass_obliga_conf").html("Confirmar password");
  } else {
    $("#pass_obliga_conf").html("");
  }
}

$("#tabla_repartidor").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_repartidor.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_repartidor.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_repartidor.row(this).data();
  }
  var dato = 0;
  var id = data.repartidor_id;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del repartidor cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_repartidor(id, dato);
    }
  });
});

$("#tabla_repartidor").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_repartidor.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_repartidor.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_repartidor.row(this).data();
  }
  var dato = 1;
  var id = data.repartidor_id;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del repartidor cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_repartidor(id, dato);
    }
  });
});

function cambiar_estado_repartidor(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "cambiar_estado_repatrdiro";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_repartidor.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_repartidor").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_repartidor.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_repartidor.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_repartidor.row(this).data();
  }

  document.getElementById("id_repartidor").value = data.repartidor_id;
  document.getElementById("nombress_edit").value = data.nombres;
  document.getElementById("apellidoss_edit").value = data.apellidos;
  document.getElementById("numero_docu_edit").value = data.cedula;
  document.getElementById("telefono_p_edit").value = data.telefono;
  document.getElementById("correo_p_edit").value = data.correo;
  document.getElementById("direccions_edit").value = data.direcion;
  document.getElementById("sexo_edit").value = data.sexo;
  document.getElementById("tipo_licencia_edit").value = data.tipo_licencia;

  document.getElementById("usuario_e").value = data.usuario;
  document.getElementById("password_e").value = data.passwordd;

  $("#edit_nombres_oblig").html("");
  $("#edit_apellidos_oblig").html("");
  $("#edit_cedula_obliga").html("");
  $("#edit_telefono_obliga").html("");
  $("#edit_correo_obliga").html("");
  $("#edit_direccion_obliga").html("");
  $("#edit_tipo_lice_obliga").html("");

  $("#usuario_obliga_e").html("");
  $("#pass_obliga_e").html("");

  $("#modal_repartidor_editar").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_repartidor_editar").modal("show");
});

function ediatr_repartidor() {
  var id = document.getElementById("id_repartidor").value;
  var nombress = document.getElementById("nombress_edit").value;
  var apellidoss = document.getElementById("apellidoss_edit").value;
  var numero_docu = document.getElementById("numero_docu_edit").value;
  var telefono_p = document.getElementById("telefono_p_edit").value;
  var correo_p = document.getElementById("correo_p_edit").value;
  var direccions = document.getElementById("direccions_edit").value;
  var sexo = document.getElementById("sexo_edit").value;
  var tipo_licencia = document.getElementById("tipo_licencia_edit").value;
  var usuario_e = document.getElementById("usuario_e").value;
  var password_e = document.getElementById("password_e").value;

  if (
    nombress.length == 0 ||
    apellidoss.length == 0 ||
    numero_docu.length == 0 ||
    telefono_p.length == 0 ||
    correo_p.length == 0 ||
    direccions.length == 0 ||
    tipo_licencia.length == 0 ||
    usuario_e.length == 0 ||
    password_e.length == 0
  ) {
    validar_editar_repartidor(
      nombress,
      apellidoss,
      numero_docu,
      telefono_p,
      correo_p,
      direccions,
      tipo_licencia,
      usuario_e,
      password_e
    );

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#edit_nombres_oblig").html("");
    $("#edit_apellidos_oblig").html("");
    $("#edit_cedula_obliga").html("");
    $("#edit_telefono_obliga").html("");
    $("#edit_correo_obliga").html("");
    $("#edit_direccion_obliga").html("");
    $("#edit_tipo_lice_obliga").html("");
    $("#usuario_obliga_e").html("");
    $("#pass_obliga_e").html("");
  }

  funcion = "editarr_repartidors";
  alerta = ["datos", "Se esta editando el repartidor", "editando repartidor"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      nombress: nombress,
      apellidoss: apellidoss,
      numero_docu: numero_docu,
      telefono_p: telefono_p,
      correo_p: correo_p,
      direccions: direccions,
      sexo: sexo,
      tipo_licencia: tipo_licencia,
      usuario_e: usuario_e,
      password_e: password_e,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        $("#modal_repartidor_editar").modal("hide");
        tabla_repartidor.ajax.reload();
        alerta = ["exito", "success", "El repartidor se registro con exito"];
        cerrar_loader_datos(alerta);
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
      alerta = ["error", "error", "Error al registrar el repartidor"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_editar_repartidor(
  nombress,
  apellidoss,
  numero_docu,
  telefono_p,
  correo_p,
  direccions,
  tipo_licencia,
  usuario_e,
  password_e
) {
  if (nombress.length == 0) {
    $("#edit_nombres_oblig").html("Ingrese nombres");
  } else {
    $("#edit_nombres_oblig").html("");
  }

  if (apellidoss.length == 0) {
    $("#edit_apellidos_oblig").html("Ingrese apellidos");
  } else {
    $("#edit_apellidos_oblig").html("");
  }

  if (numero_docu.length == 0) {
    $("#edit_cedula_obliga").html("Ingrese cedula");
  } else {
    $("#edit_cedula_obliga").html("");
  }

  if (telefono_p.length == 0) {
    $("#edit_telefono_obliga").html("Ingrese telefono");
  } else {
    $("#edit_telefono_obliga").html("");
  }

  if (correo_p.length == 0) {
    $("#edit_correo_obliga").html("Ingrese correo");
  } else {
    $("#edit_correo_obliga").html("");
  }

  if (direccions.length == 0) {
    $("#edit_direccion_obliga").html("Ingrese direccion");
  } else {
    $("#edit_direccion_obliga").html("");
  }

  if (tipo_licencia.length == 0) {
    $("#edit_tipo_lice_obliga").html("Ingrese tipo licencia");
  } else {
    $("#edit_tipo_lice_obliga").html("");
  }

  if (usuario_e.length == 0) {
    $("#usuario_obliga_e").html("Ingrese usuario");
  } else {
    $("#usuario_obliga_e").html("");
  }

  if (password_e.length == 0) {
    $("#pass_obliga_e").html("Ingrese password");
  } else {
    $("#pass_obliga_e").html("");
  }
}

///////////////////
function modal_ventass_selct() {
  $("#modal_ventas_selecionar").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_ventas_selecionar").modal("show");
}

function listar_ventass_selecionar() {
  funcion = "listar_ventass_selecionar";
  detalle_ventas_seleccionar = $("#detalle_ventas_seleccionar").DataTable({
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
      url: "../ADMIN/controlador/web_servis/web_servis.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      {
        render: function (data, type, row) {
          return `<button style='font-size:13px;' type='button' class='enviar btn btn-warning' title='enviar'><i class='fa fa-send'></i></button>`;
        },
      },
      {
        data: "pago",
        render: function (data, type, row) {
          if (data == 0) {
            return "<span class='label label-danger'>Pago en espera</span>";
          } else if (data == 1) {
            return "<span class='label label-warning'>Pago enviado</span>";
          } else {
            return "<span class='label label-success'>Pagado</span>";
          }
        },
      },
      {
        data: "tipo_pago",
        render: function (data, type, row) {
          if (data == "Transferencia") {
            return (
              "<span class='label label-primary'><i class='fa fa-paypal'></i> " +
              data +
              "</span>"
            );
          } else {
            return (
              "<span class='label label-success'><i class='fa fa-dollar'></i> " +
              data +
              "</span>"
            );
          }
        },
      },
      { data: "cliente" },
      { data: "direccion" },
      { data: "referencia" },
      { data: "cantidad" },
      { data: "numero_compra" },
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
    order: [[3, "ASC"]],
  });
}

$("#detalle_ventas_seleccionar").on("click", ".enviar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = detalle_ventas_seleccionar.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (detalle_ventas_seleccionar.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = detalle_ventas_seleccionar.row(this).data();
  }

  $("#id_venta").val(data.id_venta_online_trans);
  $("#cliente_").val(data.cliente);
  $("#tipo_transfereica").val(data.tipo_pago);
  $("#numero_venta").val(data.numero_compra);

  $("#direccion_envio").val(data.direccion);
  $("#referencia").val(data.referencia);
  $("#cantidad_pro").val(data.cantidad);

  $("#modal_ventas_selecionar").modal("hide");
});

//////////////////////////
/////////////////////////////
function listar_envioss() {
  funcion = "listar_envioss";
  tabla_envioss = $("#tabla_envioss").DataTable({
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
      url: "../ADMIN/controlador/web_servis/web_servis.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      {
        render: function () {
          return `<button style='font-size:13px;' type='button' class='ver_envios btn btn-warning' title='ver envios'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pdf btn btn-danger' title='ver envios'><i class='fa fa-file'></i></button>`;
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-warning'>ENVIADO</span>";
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
  tabla_envioss.on("draw.dt", function () {
    var pageinfo = $("#tabla_envioss").DataTable().page.info();
    tabla_envioss
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

function guardar_envio_venta() {
  var repartidor = document.getElementById("repartidor").value;
  var vehículo = document.getElementById("vehículo").value;
  var numero_compra = document.getElementById("numero_compra").value;
  var fecha_envio = document.getElementById("fecha_envio").value;
  var count = 0;
  if (
    repartidor.length == 0 ||
    vehículo.length == 0 ||
    numero_compra.length == 0 ||
    fecha_envio.length == 0
  ) {
    validar_envio_guardar(repartidor, vehículo, numero_compra, fecha_envio);

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#repartidor_obligg").html("");
    $("#vehículo_obligg").html("");
    $("#numero_obliga").html("");
    $("#fecha_obliga").html("");
  }

  $("#detalle_envio tbody#tbody_detalle_envio tr").each(function () {
    count++;
  });

  if (count == 0) {
    return swal.fire(
      "Detalle de envio vacío",
      "Debe ingresar datos al detalle de envío",
      "warning"
    );
  }
  var total = document.getElementById("txt_totalneto").value;
  funcion = "registra_envio_venta";
  alerta = ["datos", "Se esta registrando en envío", "Registrando envio"];
  mostar_loader_datos(alerta);
  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    data: {
      funcion: funcion,
      repartidor: repartidor,
      vehículo: vehículo,
      numero_compra: numero_compra,
      fecha_envio: fecha_envio,
      total: total,
      count: count,
    },
  }).done(function (resp) {
    if (resp > 0) {
      detalle_envio_ventas(parseInt(resp));
    } else {
      alerta = ["error", "error", "Error al registrar el envio"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_envio_guardar(
  repartidor,
  vehículo,
  numero_compra,
  fecha_envio
) {
  if (repartidor.length == 0) {
    $("#repartidor_obligg").html("No hay repartidor");
  } else {
    $("#repartidor_obligg").html("");
  }

  if (vehículo.length == 0) {
    $("#vehículo_obligg").html("No hay vehículo");
  } else {
    $("#vehículo_obligg").html("");
  }

  if (numero_compra.length == 0) {
    $("#numero_obliga").html("Ingrese dato");
  } else {
    $("#numero_obliga").html("");
  }

  if (fecha_envio.length == 0) {
    $("#fecha_obliga").html("Ingrese dato");
  } else {
    $("#fecha_obliga").html("");
  }
}

function detalle_envio_ventas(id) {
  var count = 0;
  var arrego_id = new Array();
  var arreglo_direccion = new Array();
  var arreglo_referencia = new Array();
  var arreglo_num_venta = new Array();
  var arreglo_cant = new Array();
  var arreglo_valor = new Array();
  var codigo = $("#numero_compra").val();

  $("#detalle_envio tbody#tbody_detalle_envio tr").each(function () {
    arrego_id.push($(this).find("td").eq(0).text());
    arreglo_direccion.push($(this).find("td").eq(4).text());
    arreglo_referencia.push($(this).find("td").eq(5).text());
    arreglo_num_venta.push($(this).find("td").eq(3).text());
    arreglo_cant.push($(this).find("td").eq(6).text());
    arreglo_valor.push($(this).find("td").eq(7).text());
    count++;
  });

  //aqui combierto el arreglo a un string
  var id_venta = arrego_id.toString();
  var direccion = arreglo_direccion.toString();
  var referencia = arreglo_referencia.toString();
  var nu_venta = arreglo_num_venta.toString();
  var cantidad = arreglo_cant.toString();
  var valor = arreglo_valor.toString();

  if (count == 0) {
    return;
  }

  funcion = "detalle_envio_ventas";
  //ajax para guardar detalle registros
  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      id_venta: id_venta,
      direccion: direccion,
      referencia: referencia,
      nu_venta: nu_venta,
      cantidad: cantidad,
      valor: valor,
      codigo: codigo,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire({
          title: "El envio se realizó con exito",
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
              "../ADMIN/REPORTES/Pdf/reporte_envio.php?id=" +
                parseInt(id) +
                "#zoom=100%",
              "Reporte de venta",
              "scrollbards=No"
            );
          }
          cargar_contenido(
            "contenido_principal",
            "vista/servicio_web/nuevo_envios.php"
          );
        });
      }
    } else {
      alerta = ["error", "error", "No se pudo regitrar el detalle de envio"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_envioss").on("click", ".ver_envios", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_envioss.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_envioss.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_envioss.row(this).data();
  }

  var id = data.envio_id;

  alerta = ["datos", "Se esta cargando el detalle de envio", ".:Cargando...:."];
  mostar_loader_datos(alerta);
  cargar_detalle_envio(parseInt(id));
});

function cargar_detalle_envio(id) {
  funcion = "cargar_detalle_envio";
  $.ajax({
    url: "../ADMIN/controlador/web_servis/web_servis.php",
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

$("#tabla_envioss").on("click", ".pdf", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_envioss.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_envioss.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_envioss.row(this).data();
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
        "../ADMIN/REPORTES/Pdf/reporte_envio.php?id=" +
          parseInt(id) +
          "#zoom=100%",
        "Reporte de venta",
        "scrollbards=No"
      );
    }
  });
});
