var funcion, tabla_marca, tabla_tipo, tabla_producto, tabla_servicio;

function nueva_marca() {
  $("#modal_marca").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_marca").modal("show");
}

function registra_marcas() {
  var nombre = $("#marca").val();

  if (nombre.length == 0 || nombre.length < 0 || nombre == "") {
    return Swal.fire({
      icon: "warning",
      title: "No hay marca",
      text: "Ingrese una marca!!",
    });
  }

  funcion = "registrar_marca";
  alerta = ["datos", "Se esta creando la marca", "Creando marca."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: {
      funcion: funcion,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#marca").val("");
        $("#modal_marca").modal("hide");
        tabla_marca.ajax.reload();
        alerta = ["exito", "success", "La marca se creó con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "La marca '" + nombre + "', ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo crear la marca"];
      cerrar_loader_datos(alerta);
    }
  });
}

function listar_marca() {
  funcion = "listar_marca";
  tabla_marca = $("#tabla_marcas_").DataTable({
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
      url: "../ADMIN/controlador/producto/producto.php",
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
      { data: "marca" },
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
  tabla_marca.on("draw.dt", function () {
    var pageinfo = $("#tabla_marcas_").DataTable().page.info();
    tabla_marca
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_marcas_").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_marca.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_marca.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_marca.row(this).data();
  }
  var dato = 0;
  var id = data.id_marca;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado de la marca se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_marca(id, dato);
    }
  });
});

$("#tabla_marcas_").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_marca.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_marca.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_marca.row(this).data();
  }
  var dato = 1;
  var id = data.id_marca;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado de la marca se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_marca(id, dato);
    }
  });
});

$("#tabla_marcas_").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_marca.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_marca.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_marca.row(this).data();
  }

  $("#id_marca").val(data.id_marca);
  $("#marca_edit").val(data.marca);

  $("#modal_tpo_marca").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_tpo_marca").modal("show");
});

function cambiar_marca(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "estado_marca";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_marca.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

function editar_marca() {
  var id = $("#id_marca").val();
  var nombre = $("#marca_edit").val();

  if (nombre.length == 0 || nombre.length < 0 || nombre == "") {
    return Swal.fire({
      icon: "warning",
      title: "No hay marca",
      text: "Ingrese un marca!!",
    });
  }

  funcion = "editar_marca";
  alerta = ["datos", "Se esta editando la marca", "Editando marca."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#modal_tpo_marca").modal("hide");
        tabla_marca.ajax.reload();
        alerta = ["exito", "success", "La marca se edito con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "La marca '" + nombre + "', ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo editar la marca"];
      cerrar_loader_datos(alerta);
    }
  });
}

///////////
////////////
function nueva_tipo() {
  $("#modal_tipo").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_tipo").modal("show");
}

function registra_tipo() {
  var nombre = $("#tipo").val();

  if (nombre.length == 0 || nombre.length < 0 || nombre == "") {
    return Swal.fire({
      icon: "warning",
      title: "No hay tipo",
      text: "Ingrese un tipo!!",
    });
  }

  funcion = "registrar_tipo";
  alerta = ["datos", "Se esta creando el tipo", "Creando tipo."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: {
      funcion: funcion,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#tipo").val("");
        $("#modal_tipo").modal("hide");
        tabla_tipo.ajax.reload();
        alerta = ["exito", "success", "El tipo se creó con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "El tipo '" + nombre + "', ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo crear el tipo"];
      cerrar_loader_datos(alerta);
    }
  });
}

function listar_tipo() {
  funcion = "listar_tipo";
  tabla_tipo = $("#tabla_tipo_").DataTable({
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
      url: "../ADMIN/controlador/producto/producto.php",
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
      { data: "tipo_producto" },
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
  tabla_tipo.on("draw.dt", function () {
    var pageinfo = $("#tabla_tipo_").DataTable().page.info();
    tabla_tipo
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_tipo_").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_tipo.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_tipo.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_tipo.row(this).data();
  }
  var dato = 0;
  var id = data.id_tipo_produto;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del tipo se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_tipo(id, dato);
    }
  });
});

$("#tabla_tipo_").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_tipo.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_tipo.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_tipo.row(this).data();
  }
  var dato = 1;
  var id = data.id_tipo_produto;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del tipo se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_tipo(id, dato);
    }
  });
});

$("#tabla_tipo_").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_tipo.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_tipo.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_tipo.row(this).data();
  }

  $("#id_tipo").val(data.id_tipo_produto);
  $("#tipo_edit").val(data.tipo_producto);

  $("#modal_edit_tipo").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_edit_tipo").modal("show");
});

function cambiar_tipo(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "estado_tipo";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_tipo.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

function editar_tipo() {
  var id = $("#id_tipo").val();
  var nombre = $("#tipo_edit").val();

  if (nombre.length == 0 || nombre.length < 0 || nombre == "") {
    return Swal.fire({
      icon: "warning",
      title: "No hay tipo",
      text: "Ingrese un tipo!!",
    });
  }

  funcion = "editar_tipo";
  alerta = ["datos", "Se esta editando el tipo", "Editando tipo."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      nombre: nombre,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#modal_edit_tipo").modal("hide");
        tabla_tipo.ajax.reload();
        alerta = ["exito", "success", "EL tipo se edito con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "EL tipo '" + nombre + "', ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo editar eL tipo"];
      cerrar_loader_datos(alerta);
    }
  });
}

//////////////
//////////////producto
function guardar_producto() {
  var codigos = document.getElementById("codigos").value;
  var nombres = document.getElementById("nombre_producto").value;
  var marca = document.getElementById("marca_produto").value;
  var tipo = document.getElementById("tipo_producto").value;
  var precio_venta = document.getElementById("precio_venta").value;
  var decripcion = document.getElementById("decripcion").value;

  var foto = document.getElementById("foto").value;

  if (
    codigos.length == 0 ||
    nombres.length == 0 ||
    marca.length == 0 ||
    tipo.length == 0 ||
    precio_venta.length == 0 ||
    decripcion.length == 0
  ) {
    validar_registro_pro(
      codigos,
      nombres,
      marca,
      tipo,
      precio_venta,
      decripcion
    );

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#codigo_oblig").html("");
    $("#nombre_obliga").html("");
    $("#marca_produto_obb").html("");
    $("#tipo_pro_obligg").html("");
    $("#precio_venta_oblig").html("");
    $("#descripc_obliga").html("");
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

  alerta = ["datos", "Se esta creando el produto", "Creando produto"];
  mostar_loader_datos(alerta);

  funcion = "registra_producto";

  formdata.append("funcion", funcion);
  formdata.append("codigos", codigos);
  formdata.append("nombres", nombres);
  formdata.append("marca", marca);
  formdata.append("tipo", tipo);
  formdata.append("precio_venta", precio_venta);
  formdata.append("decripcion", decripcion);

  formdata.append("foto", foto);
  formdata.append("nombrearchivo", nombrearchivo);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          alerta = ["exito", "success", "El producto se registro con exito"];
          cerrar_loader_datos(alerta);
          cargar_contenido(
            "contenido_principal",
            "vista/producto/nuevo_producto.php"
          );
        } else if (resp == 2) {
          alerta = [
            "existe",
            "warning",
            "El codigo " + codigos + ", ya esta registrado",
          ];
          cerrar_loader_datos(alerta);
        } else {
          alerta = [
            "existe",
            "warning",
            "La nombre '" + nombres + "' de producto, ya esta registrado",
          ];
          cerrar_loader_datos(alerta);
        }
      } else {
        alerta = ["error", "error", "Error al registrar el producto"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

/////////////////////
function validar_registro_pro(
  codigos,
  nombres,
  marca,
  tipo,
  precio_venta,
  decripcion
) {
  if (codigos.length == 0) {
    $("#codigo_oblig").html("Ingrese codigo");
  } else {
    $("#codigo_oblig").html("");
  }

  if (nombres.length == 0) {
    $("#nombre_obliga").html("Ingrese nombre");
  } else {
    $("#nombre_obliga").html("");
  }

  if (marca.length == 0) {
    $("#marca_produto_obb").html("Ingrese marca");
  } else {
    $("#marca_produto_obb").html("");
  }

  if (tipo.length == 0) {
    $("#tipo_pro_obligg").html("Ingrese tipo");
  } else {
    $("#tipo_pro_obligg").html("");
  }

  if (precio_venta.length == 0) {
    $("#precio_venta_oblig").html("Ingrese precio venta");
  } else {
    $("#precio_venta_oblig").html("");
  }

  if (decripcion.length == 0) {
    $("#descripc_obliga").html("Ingrese descripcion");
  } else {
    $("#descripc_obliga").html("");
  }
}

////////////////////////
function listar_prodcuto() {
  funcion = "listar_prodcuto";
  tabla_producto = $("#tabla_productos_").DataTable({
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
      url: "../ADMIN/controlador/producto/producto.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      {
        data: "eliminado",
        render: function (data, type, row) {
          if (data == 1) {
            return `<button style='font-size:13px;' type='button' class='inactivar btn btn-danger' title='Inactivar el Oftalmólogo'><i class='fa fa-times'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el Oftalmólogo'><i class='fa fa-edit'></i></button> - <button style='font-size:13px;' type='button' class='photo btn btn-warning' title='Editar el Oftalmólogo'><i class='fa fa-photo'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='activar btn btn-success' title='Activar el Oftalmólogo'><i class='fa fa-check'></i></button> - <button style='font-size:13px;' type='button' class='editar btn btn-primary' title='Editar el Oftalmólogo'><i class='fa fa-edit'></i></button> - <button style='font-size:13px;' type='button' class='photo btn btn-warning' title='Editar el Oftalmólogo'><i class='fa fa-photo'></i></button>`;
          }
        },
      },
      {
        data: "eliminado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-success'>Si</span>";
          } else {
            return "<span class='label label-danger'>No</span>";
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == "Activo") {
            return "<span class='label label-success'>Activo</span>";
          } else if (data == "Agotado") {
            return "<span class='label label-warning'>Agotado</span>";
          } else {
            return "<span class='label label-warning'>No disponible</span>";
          }
        },
      },
      { data: "codigo" },
      { data: "nombre_producto" },
      {
        data: "stock",
        render: function (data, type, row) {
          if (data == null) {
            return "<span class='label label-danger'>No stock</span>";
          } else {
            return data;
          }
        },
      },
      {
        data: "foto",
        render: function (data, type, row) {
          return "<img class='img-circle' src='" + data + "' width='45px' />";
        },
      },
      { data: "marca" },
      { data: "tipo_producto" },
      { data: "precio_venta" },
      { data: "descripcion" },
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
  tabla_producto.on("draw.dt", function () {
    var pageinfo = $("#tabla_productos_").DataTable().page.info();
    tabla_producto
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_productos_").on("click", ".photo", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_producto.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_producto.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_producto.row(this).data();
  }

  var id = data.id_producto;
  var foto = data.foto;

  $("#id_foto_producto").val(id);
  $("#foto_actu").val(foto);
  $("#foto_producto").attr("src", foto);

  $("#modal_editar_photo").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar_photo").modal("show");
});

function editar_foto_producto() {
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
  funcion = "editar_foto_producto";
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
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          document.getElementById("foto_new").value = "";
          tabla_producto.ajax.reload();
          alerta = [
            "exito",
            "success",
            "La foto de producto se edito con exito",
          ];
          cerrar_loader_datos(alerta);
          $("#modal_editar_photo").modal("hide");
        }
      } else {
        alerta = ["error", "error", "No se pudo editar la foto de producto"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

$("#tabla_productos_").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_producto.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_producto.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_producto.row(this).data();
  }
  var dato = 0;
  var id = data.id_producto;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del producto se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_producto(id, dato);
    }
  });
});

$("#tabla_productos_").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_producto.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_producto.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_producto.row(this).data();
  }
  var dato = 1;
  var id = data.id_producto;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del producto se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_producto(id, dato);
    }
  });
});

function cambiar_estado_producto(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "estado_producto";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_producto.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_productos_").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_producto.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_producto.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_producto.row(this).data();
  }

  document.getElementById("id_producto_edit").value = data.id_producto;
  document.getElementById("codigos").value = data.codigo;
  document.getElementById("nombre_producto").value = data.nombre_producto;
  $("#marca_produto").val(data.id_marca).trigger("change");
  $("#tipo_producto").val(data.id_tipo_producto).trigger("change");
  document.getElementById("decripcion").value = data.descripcion;
  document.getElementById("precio_venta").value = data.precio_venta;

  $("#codigo_oblig").html("");
  $("#nombre_obliga").html("");
  $("#marca_produto_obb").html("");
  $("#tipo_pro_obligg").html("");
  $("#precio_venta_oblig").html("");
  $("#descripc_obliga").html("");

  $("#modal_editar_producto").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar_producto").modal("show");
});

function ediar_productoo() {
  var id = document.getElementById("id_producto_edit").value;
  var codigos = document.getElementById("codigos").value;
  var nombres = document.getElementById("nombre_producto").value;
  var marca = document.getElementById("marca_produto").value;
  var tipo = document.getElementById("tipo_producto").value;
  var precio_venta = document.getElementById("precio_venta").value;
  var decripcion = document.getElementById("decripcion").value;

  if (
    codigos.length == 0 ||
    nombres.length == 0 ||
    marca.length == 0 ||
    tipo.length == 0 ||
    precio_venta.length == 0 ||
    decripcion.length == 0
  ) {
    validar_editae_pro(codigos, nombres, marca, tipo, precio_venta, decripcion);

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#codigo_oblig").html("");
    $("#nombre_obliga").html("");
    $("#marca_produto_obb").html("");
    $("#tipo_pro_obligg").html("");
    $("#precio_venta_oblig").html("");
    $("#descripc_obliga").html("");
  }

  funcion = "editar_producto";
  alerta = ["datos", "Se esta editando el producto", "Editando producto"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      codigos: codigos,
      nombres: nombres,
      marca: marca,
      tipo: tipo,
      precio_venta: precio_venta,
      decripcion: decripcion,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        tabla_producto.ajax.reload();
        $("#modal_editar_producto").modal("hide");
        alerta = ["exito", "success", "El producto se edito con exito"];
        cerrar_loader_datos(alerta);
      } else if (resp == 2) {
        alerta = [
          "existe",
          "warning",
          "El codigo " + codigos + ", ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "La nombre '" + nombres + "' de producto, ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "Error al registrar el producto"];
      cerrar_loader_datos(alerta);
    }
  });
}

/////////////////////
function validar_editae_pro(
  codigos,
  nombres,
  marca,
  tipo,
  precio_venta,
  decripcion
) {
  if (codigos.length == 0) {
    $("#codigo_oblig").html("Ingrese codigo");
  } else {
    $("#codigo_oblig").html("");
  }

  if (nombres.length == 0) {
    $("#nombre_obliga").html("Ingrese nombre");
  } else {
    $("#nombre_obliga").html("");
  }

  if (marca.length == 0) {
    $("#marca_produto_obb").html("Ingrese marca");
  } else {
    $("#marca_produto_obb").html("");
  }

  if (tipo.length == 0) {
    $("#tipo_pro_obligg").html("Ingrese tipo");
  } else {
    $("#tipo_pro_obligg").html("");
  }

  if (precio_venta.length == 0) {
    $("#precio_venta_oblig").html("Ingrese precio venta");
  } else {
    $("#precio_venta_oblig").html("");
  }

  if (decripcion.length == 0) {
    $("#descripc_obliga").html("Ingrese descripcion");
  } else {
    $("#descripc_obliga").html("");
  }
}

///////////////
///////////// tipo de servicios
function nuevo_servicio() {
  $("#modal_servicio").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_servicio").modal("show");
}

function registra_servicio() {
  var nombre = $("#nombre_servicio").val();
  var precio = $("#precio_servicio").val();

  if (
    nombre.length == 0 ||
    nombre.length < 0 ||
    nombre == "" ||
    precio.length == 0 ||
    precio.length < 0 ||
    precio == ""
  ) {
    return Swal.fire({
      icon: "warning",
      title: "No hay datos",
      text: "Ingrese datos completos!!",
    });
  }

  funcion = "registrar_servicio";
  alerta = ["datos", "Se esta creando el servicio", "Creando servicio."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: {
      funcion: funcion,
      nombre: nombre,
      precio: precio,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#nombre_servicio").val("");
        $("#precio_servicio").val("");
        $("#modal_servicio").modal("hide");

        tabla_servicio.ajax.reload();
        alerta = ["exito", "success", "El servicio se creó con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "El servicio '" + nombre + "', ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo crear el servicio"];
      cerrar_loader_datos(alerta);
    }
  });
}

function listar_servicios() {
  funcion = "listar_servicios";
  tabla_servicio = $("#tabla_servicioss_").DataTable({
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
      url: "../ADMIN/controlador/producto/producto.php",
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
      { data: "servicio" },
      { data: "precio" },
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
  tabla_servicio.on("draw.dt", function () {
    var pageinfo = $("#tabla_servicioss_").DataTable().page.info();
    tabla_servicio
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_servicioss_").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_servicio.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_servicio.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_servicio.row(this).data();
  }
  var dato = 0;
  var id = data.id_servicio;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del servicio se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_servicio(id, dato);
    }
  });
});

$("#tabla_servicioss_").on("click", ".activar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_servicio.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_servicio.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_servicio.row(this).data();
  }
  var dato = 1;
  var id = data.id_servicio;

  Swal.fire({
    title: "Cambiar estado?",
    text: "El estado del servicio se cambiara!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cambiar!",
  }).then((result) => {
    if (result.isConfirmed) {
      cambiar_estado_servicio(id, dato);
    }
  });
});

function cambiar_estado_servicio(id, dato) {
  var res = "";
  if (dato == 1) {
    res = "activo";
  } else {
    res = "inactivo";
  }

  funcion = "estado_servicio";
  alerta = [
    "datos",
    "Se esta cambiando el estado a " + res + "",
    "Cambiando estado",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: { id: id, dato: dato, funcion: funcion },
  }).done(function (response) {
    console.log(response);
    if (response > 0) {
      if (response == 1) {
        alerta = ["exito", "success", "EL estado se " + res + " con extio"];
        cerrar_loader_datos(alerta);
        tabla_servicio.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo cambiar el estado"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_servicioss_").on("click", ".editar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_servicio.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_servicio.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_servicio.row(this).data();
  }

  document.getElementById("id_servicio_edit").value = data.id_servicio;
  document.getElementById("nombre_servicio_edit").value = data.servicio;
  document.getElementById("precio_servicio_edit").value = data.precio;

  $("#modal_editar_servicio").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar_servicio").modal("show");
});

function editar_servicio() {
  var id = $("#id_servicio_edit").val();
  var nombre = $("#nombre_servicio_edit").val();
  var precio = $("#precio_servicio_edit").val();

  if (
    nombre.length == 0 ||
    nombre.length < 0 ||
    nombre == "" ||
    precio.length == 0 ||
    precio.length < 0 ||
    precio == ""
  ) {
    return Swal.fire({
      icon: "warning",
      title: "No hay datos",
      text: "Ingrese datos completos!!",
    });
  }

  funcion = "editarr_servicio";
  alerta = ["datos", "Se esta editando el servicio", "Editando servicio."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/producto/producto.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      nombre: nombre,
      precio: precio,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#modal_editar_servicio").modal("hide");

        tabla_servicio.ajax.reload();
        alerta = ["exito", "success", "El servicio se edito con exito"];
        cerrar_loader_datos(alerta);
      } else {
        alerta = [
          "existe",
          "warning",
          "El servicio '" + nombre + "', ingresado ya existe",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo crear el servicio"];
      cerrar_loader_datos(alerta);
    }
  });
}

//////////////ofertas
function guardar_oferta() {
  var id = document.getElementById("producto").value;
  var fecha_inicio = document.getElementById("fecha_inicio").value;
  var fecha_fin = document.getElementById("fecha_fin").value;
  var tipo_promo = document.getElementById("tipo_promo").value;
  var descuento = document.getElementById("descuento").value;

  if (
    id.length == 0 ||
    fecha_inicio.length == 0 ||
    fecha_fin.length == 0 ||
    tipo_promo.length == 0 ||
    descuento.length == 0
  ) {
    validar_oferta_regi(id, fecha_inicio, fecha_fin, tipo_promo, descuento);

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#producto_obligg").html("");
    $("#fecha_ini_obligg").html("");
    $("#fecha_fin_obligg").html("");
    $("#tipo_promo_obligg").html("");
    $("#valor_obligg").html("");
  }

  if (fecha_inicio >= fecha_fin) {
    $("#fecha_ini_obligg").html("XXX");
    $("#fecha_fin_obligg").html("XXX");
    return Swal.fire(
      "Mensaje de advertencia",
      "La fecha inicio '" +
        fecha_inicio +
        "' es mayor o igual a la fecha final '" +
        fecha_fin +
        "'",
      "warning"
    );
  } else {
    $("#fecha_ini_obligg").html("");
    $("#fecha_fin_obligg").html("");
  }

  if (tipo_promo == "Descuento") {
    if (descuento.length == 0 || descuento == "0" || descuento == "") {
      $("#valor_obligg").html("No hay valor");
      return swal.fire(
        "Campo vacio",
        "Ingrese un valor de descuento",
        "warning"
      );
    }
  } else {
    $("#valor_obligg").html("");
  }

  funcion = "registra_oofertaa";
  alerta = ["datos", "Se esta registrando la oferta", "Registrando oferta"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/promociones/promociones.php",
    type: "POST",
    data: {
      funcion,
      id,
      fecha_inicio,
      fecha_fin,
      tipo_promo,
      descuento,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp != 0) {
        envio_oferta_id(resp);
        alerta = ["exito", "success", "La oferta se registro con exito"];
        cerrar_loader_datos(alerta);
        cargar_contenido(
          "contenido_principal",
          "vista/producto/registro_promocion.php"
        );
      }
    } else {
      alerta = ["error", "error", "Error al registrar la oferta"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_oferta_regi(
  id,
  fecha_inicio,
  fecha_fin,
  tipo_promo,
  descuento
) {
  if (id.length == 0) {
    $("#producto_obligg").html("No hay producto");
  } else {
    $("#producto_obligg").html("");
  }

  if (fecha_inicio.length == 0) {
    $("#fecha_ini_obligg").html("Ingrese fecha inicio");
  } else {
    $("#fecha_ini_obligg").html("");
  }

  if (fecha_fin.length == 0) {
    $("#fecha_fin_obligg").html("Ingrese fecha fin");
  } else {
    $("#fecha_fin_obligg").html("");
  }

  if (tipo_promo.length == 0) {
    $("#tipo_promo_obligg").html("Ingrese oferta");
  } else {
    $("#tipo_promo_obligg").html("");
  }

  if (descuento.length == 0) {
    $("#valor_obligg").html("Ingrese valor");
  } else {
    $("#valor_obligg").html("");
  }
}

$(document).on("keyup", "#buscar_prod", function () {
  let valor = $(this).val();
  if (valor != "") {
    pagination(1, valor);
  } else {
    pagination(1);
  }
});

function pagination(partida, valor) {
  funcion = "paguinar_ofertas";
  $.ajax({
    url: "../ADMIN/controlador/promociones/promociones.php",
    type: "POST",
    data: {
      partida: partida,
      funcion: funcion,
      valor: valor,
    },
  }).done(function (response) {
    var array = eval(response);
    if (array[0]) {
      $("#unir_listado_ofertas").html(array[0]);
      $("#unir_paguinador").html(array[1]);
    } else {
      $("#unir_listado_ofertas")
        .html(`<div class="col-lg-12" style="text-align: center; justify-content: center; align-items: center"><br>
            <label style="font-size: 20px;"></i>.:No se encontro producto:.<label>
         </div>`);
      $("#unir_paguinador").html("");
    }
  });
}

function eliminar_ofert(id) {
  Swal.fire({
    title: "Eliminar oferta",
    text: "Desea eliminar la oferta?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      funcion = "eliminar_oferta";
      alerta = ["datos", "Se esta eliminando la oferta", "Eliminando oferta."];
      mostar_loader_datos(alerta);

      $.ajax({
        url: "../ADMIN/controlador/promociones/promociones.php",
        type: "POST",
        data: {
          funcion: funcion,
          id: id,
        },
      }).done(function (response) {
        if (response > 0) {
          if (response == 1) {
            alerta = ["exito", "success", "La oferta se elimino con exito"];
            cerrar_loader_datos(alerta);
            pagination(1);
          }
        } else {
          alerta = ["error", "error", "No se pudo eliminar la oferta"];
          cerrar_loader_datos(alerta);
        }
      });
    }
  });
}

function editar_ofert(id) {
  funcion = "editar_ofertss";
  alerta = ["datos", "Cargando datos de oferta", "Cargando oferta."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/promociones/promociones.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
    },
  }).done(function (response) {
    alerta = ["", "", ""];
    cerrar_loader_datos(alerta);
    var data = JSON.parse(response);

    document.getElementById("id_ofertass").value = id;
    document.getElementById("fecha_inicio").value = data[2];
    document.getElementById("fecha_fin").value = data[5];
    document.getElementById("tipo_promo").value = data[6];
    document.getElementById("descuento").value = data[8];
    document.getElementById("descuento_bandera").value = data[8];

    if (data[6] == "Descuento") {
      $("#descuento").attr("readonly", false);
    } else {
      $("#descuento").attr("readonly", true);
    }

    $("#modal_editra_pferta").modal({ backdrop: "static", keyboard: false });
    $("#modal_editra_pferta").modal("show");
  });
}

function editaar_oferta() {
  var id = document.getElementById("id_ofertass").value;
  var fecha_inicio = document.getElementById("fecha_inicio").value;
  var fecha_fin = document.getElementById("fecha_fin").value;
  var tipo_promo = document.getElementById("tipo_promo").value;
  var descuento = document.getElementById("descuento").value;

  if (
    fecha_inicio.length == 0 ||
    fecha_fin.length == 0 ||
    tipo_promo.length == 0 ||
    descuento.length == 0
  ) {
    validar_oferta_editar(fecha_inicio, fecha_fin, tipo_promo, descuento);

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#fecha_ini_obligg").html("");
    $("#fecha_fin_obligg").html("");
    $("#tipo_promo_obligg").html("");
    $("#valor_obligg").html("");
  }

  if (fecha_inicio >= fecha_fin) {
    $("#fecha_ini_obligg").html("XXX");
    $("#fecha_fin_obligg").html("XXX");
    return Swal.fire(
      "Mensaje de advertencia",
      "La fecha inicio '" +
        fecha_inicio +
        "' es mayor o igual a la fecha final '" +
        fecha_fin +
        "'",
      "warning"
    );
  } else {
    $("#fecha_ini_obligg").html("");
    $("#fecha_fin_obligg").html("");
  }

  if (tipo_promo == "Descuento") {
    if (descuento.length == 0 || descuento == "0" || descuento == "") {
      $("#valor_obligg").html("No hay valor");
      return swal.fire(
        "Campo vacio",
        "Ingrese un valor de descuento",
        "warning"
      );
    }
  } else {
    $("#valor_obligg").html("");
  }

  funcion = "editar_ofertaaaaa";
  alerta = ["datos", "Se esta editando la oferta", "Editando oferta"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/promociones/promociones.php",
    type: "POST",
    data: {
      funcion,
      id,
      fecha_inicio,
      fecha_fin,
      tipo_promo,
      descuento,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        $("#modal_editra_pferta").modal("hide");
        alerta = ["exito", "success", "La oferta se edito con exito"];
        cerrar_loader_datos(alerta);
        pagination(1);
      }
    } else {
      alerta = ["error", "error", "Error al editar la oferta"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_oferta_editar(fecha_inicio, fecha_fin, tipo_promo, descuento) {
  if (fecha_inicio.length == 0) {
    $("#fecha_ini_obligg").html("Ingrese fecha inicio");
  } else {
    $("#fecha_ini_obligg").html("");
  }

  if (fecha_fin.length == 0) {
    $("#fecha_fin_obligg").html("Ingrese fecha fin");
  } else {
    $("#fecha_fin_obligg").html("");
  }

  if (tipo_promo.length == 0) {
    $("#tipo_promo_obligg").html("Ingrese oferta");
  } else {
    $("#tipo_promo_obligg").html("");
  }

  if (descuento.length == 0) {
    $("#valor_obligg").html("Ingrese valor");
  } else {
    $("#valor_obligg").html("");
  }
}

function enviar_oferta(id) {
  Swal.fire({
    title: "Envío de oferta por correo",
    text: "Desea enviar la oferta por correo?",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, enviar!",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "../ADMIN/modelo/envio_correo/envio_oferta.php",
        type: "POST",
        data: {
          id: id,
        },
      }).done(function (resp) {});
      alertify.success("Ofertas enviadas");
    }
  });
}

function envio_oferta_id(id) {
  $.ajax({
    url: "../ADMIN/modelo/envio_correo/envio_oferta.php",
    type: "POST",
    data: {
      id: id,
    },
  }).done(function (resp) {});
  alertify.success("Ofertas enviadas");
}

function enviar_whatsapp(id) {
  Swal.fire({
    title: "Envío de oferta por WhatsApp",
    text: "Desea enviar la oferta por WhatsApp?",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, enviar!",
  }).then((result) => {
    if (result.value) {
      envio_whatsapp_send(id);
    }
  });
}

async function envio_whatsapp_send(id) {
  alertify.warning("Enviando ofertas...");
  let result;
  try {
    result = await $.ajax({
      url: "../ADMIN/modelo/envio_whatsapp/envio_ver.php",
      type: "POST",
      data: { id: id },
    });
    console.log(result);
  } catch (error) {
    console.error(error)
  }
}
