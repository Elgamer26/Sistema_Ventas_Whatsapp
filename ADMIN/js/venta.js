var funcion,
  tabla_venta_servicios,
  tabla_venta_productos,
  tabla_producto_envio,
  tabla_producto_oferta_envio,
  tabla_ventas_online_pro,
  tabla_transferencia,
  tabla_efectivo;

//////////////////////
function guardar_venta_servicios() {
  var cliente = $("#cliente").val();
  var numero_compra = $("#numero_compra").val();
  var comprobante_tipo = $("#comprobante_tipo").val();
  var impuesto = $("#impuesto").val();
  var fecha_compra = $("#fecha_compra").val();

  var txt_totalneto = $("#txt_totalneto").val();
  var txt_impuesto = $("#txt_impuesto").val();
  var txt_a_pagar = $("#txt_a_pagar").val();
  var count = 0;

  if (
    cliente.length == 0 ||
    numero_compra.length == 0 ||
    impuesto.length == 0
  ) {
    validar_venta_servicio(cliente, numero_compra, impuesto);
    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#cliente_obligg").html("");
    $("#numero_obliga").html("");
    $("#Impuesto_obliga").html("");
  }

  $("#detalle_servicio tbody#tbody_detalle_servicio tr").each(function () {
    count++;
  });

  if (count == 0) {
    return Swal.fire(
      "Mensaje de advertencia",
      "El detalle de venta debe tener un servicio por lo menos,(TABLA SERVICIO)",
      "warning"
    );
  }

  funcion = "registrar_servicio_venta";
  alerta = ["datos", "Se esta registrando la venta", "Registrando la venta"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
    type: "POST",
    data: {
      funcion: funcion,
      cliente: cliente,
      numero_compra: numero_compra,
      comprobante_tipo: comprobante_tipo,
      impuesto: impuesto,
      fecha_compra: fecha_compra,
      txt_totalneto: txt_totalneto,
      txt_impuesto: txt_impuesto,
      txt_a_pagar: txt_a_pagar,
      count: count,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp != 2) {
        registrar_detalle_venta_servicio(parseInt(resp));
      } else {
        alerta = [
          "existe",
          "warning",
          "El numero de venta " + numero_compra + ", ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo regitrar la venta"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_venta_servicio(cliente, numero_compra, impuesto) {
  if (cliente.length == 0) {
    $("#cliente_obligg").html("No hay cliente");
  } else {
    $("#cliente_obligg").html("");
  }

  if (numero_compra.length == 0) {
    $("#numero_obliga").html("Ingrese N° compra");
  } else {
    $("#numero_obliga").html("");
  }

  if (impuesto.length == 0) {
    $("#Impuesto_obliga").html("Ingrese dato");
  } else {
    $("#Impuesto_obliga").html("");
  }
}

function registrar_detalle_venta_servicio(id) {
  var count = 0;
  var arrego_insumo = new Array();
  var arreglo_cantidad = new Array();
  var arreglo_precio = new Array();
  var arreglo_descuento_moneda = new Array();
  var arreglo_subtotal = new Array();

  $("#detalle_servicio tbody#tbody_detalle_servicio tr").each(function () {
    arrego_insumo.push($(this).find("td").eq(0).text());
    arreglo_cantidad.push($(this).find("td").eq(2).text());
    arreglo_precio.push($(this).find("td").eq(3).text());
    arreglo_descuento_moneda.push($(this).find("td").eq(4).text());
    arreglo_subtotal.push($(this).find("td").eq(5).text());
    count++;
  });

  //aqui combierto el arreglo a un string
  var idpm = arrego_insumo.toString();
  var cantidad = arreglo_cantidad.toString();
  var precio = arreglo_precio.toString();
  var des = arreglo_descuento_moneda.toString();
  var sutotal = arreglo_subtotal.toString();

  if (count == 0) {
    return;
  }

  funcion = "registrar_detalle_venta_servicio";
  //ajax para guardar detalle registros
  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      idpm: idpm,
      cantidad: cantidad,
      precio: precio,
      des: des,
      sutotal: sutotal,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        alerta = ["", "", ""];
        cerrar_loader_datos(alerta);
        enviar_correo_venta_servicio(parseInt(id));

        Swal.fire({
          title: "Venta realizada con exito",
          text: "Desea imprimir el reporte de venta??",
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
              "../ADMIN/REPORTES/Pdf/reporte_de_veser.php?id=" +
                parseInt(id) +
                "#zoom=100%",
              "Reporte de venta",
              "scrollbards=No"
            );

            cargar_contenido(
              "contenido_principal",
              "vista/venta/venta_servicios.php"
            );
          }
        });

        cargar_contenido(
          "contenido_principal",
          "vista/venta/venta_servicios.php"
        );
      }
    } else {
      alerta = ["error", "error", "No se pudo regitrar el detalle venta"];
      cerrar_loader_datos(alerta);
    }
  });
}

function enviar_correo_venta_servicio(id) {
  $.ajax({
    url: "../ADMIN/modelo/envio_correo/correo_venta_servicio.php",
    type: "POST",
    data: {
      id: id,
    },
  }).done(function (resp) {
    if (resp == 1) {
      alertify.success("Correo enviado");
    } else {
      alertify.error("Error de envio");
    }
  });
}

/////////
function listar_venta_servicios() {
  funcion = "listar_venta_servicios";
  tabla_venta_servicios = $("#tabla_venta_servicio").DataTable({
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
      url: "../ADMIN/controlador/venta/venta.php",
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
            return `<button style='font-size:13px;' type='button' class='inactivar btn btn-danger' title='Inactivar el Oftalmólogo'><i class='fa fa-times'></i></button> - <button style='font-size:13px;' type='button' class='enviar_correo btn btn-success' title='Enviar correo'><i class='fa fa-envelope'></i></button> - <button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-success'>COMPRADO</span>";
          } else {
            return "<span class='label label-danger'>ANULADO</span>";
          }
        },
      },
      { data: "cliente" },
      {
        data: "tipo_doc",
        render: function (data, type, row) {
          if (data == "Boleta") {
            return "<span class='label label-info'>Nota de venta</span>";
          } else {
            return "<span class='label label-success'>" + data + "</span>";
          }
        },
      },
      { data: "numero_compra" },
      {
        data: "iva",
        render: function (data, type, row) {
          if (data == "0") {
            return "0%";
          } else {
            return "12%";
          }
        },
      },

      { data: "fecha" },
      { data: "cantidad" },
      { data: "total" },
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
  tabla_venta_servicios.on("draw.dt", function () {
    var pageinfo = $("#tabla_venta_servicio").DataTable().page.info();
    tabla_venta_servicios
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_venta_servicio").on("click", ".pfd", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_venta_servicios.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_venta_servicios.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_venta_servicios.row(this).data();
  }

  var id = data.id_venta_servico;

  Swal.fire({
    title: "IMPRIMIR VENTA DE SERVICIO",
    text: "Desea imprimir el reporte de venta??",
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
        "../ADMIN/REPORTES/Pdf/reporte_de_veser.php?id=" +
          parseInt(id) +
          "#zoom=100%",
        "Reporte de venta",
        "scrollbards=No"
      );
    }
  });
});

$("#tabla_venta_servicio").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_venta_servicios.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_venta_servicios.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_venta_servicios.row(this).data();
  }

  var id = data.id_venta_servico;

  Swal.fire({
    title: "Anular venta",
    text: "Desea anular la venta??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, anular!!",
  }).then((result) => {
    if (result.value) {
      anular_venta_servicio(parseInt(id));
    }
  });
});

function anular_venta_servicio(id) {
  alerta = ["datos", "Se esta anulando la venta", ".:Anulando venta:."];
  mostar_loader_datos(alerta);

  funcion = "anular_venta_servicio";
  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        alerta = ["exito", "success", "Se anulo la venta con exito"];
        cerrar_loader_datos(alerta);
        tabla_venta_servicios.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo anular la venta"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_venta_servicio").on("click", ".ver", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_venta_servicios.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_venta_servicios.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_venta_servicios.row(this).data();
  }

  var id = data.id_venta_servico;
  var iva = data.iva;

  alerta = [
    "datos",
    "Se esta cargando el detalle venta",
    ".:Cargando la venta:.",
  ];
  mostar_loader_datos(alerta);
  cargar_detalle_venta_servicios(parseInt(id), iva);
});

$("#tabla_venta_servicio").on("click", ".enviar_correo", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_venta_servicios.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_venta_servicios.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_venta_servicios.row(this).data();
  }
  var id = data.id_venta_servico;

  Swal.fire({
    title: "Envio de correo",
    text: "Desea enviar detalle de venta al correo del cliente??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, enviar!!",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "../ADMIN/modelo/envio_correo/correo_venta_servicio.php",
        type: "POST",
        data: {
          id: id,
        },
      }).done(function (resp) {
        if (resp == 1) {
          alertify.success("Correo enviado");
        } else {
          alertify.error("Error de envio");
        }
      });
    }
  });
});

function cargar_detalle_venta_servicios(id, iva) {
  funcion = "cargar_detalle_venta_servicios";
  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
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
    let impuestototal = 0;
    let subtotal = 0;
    let impuesto = iva;
    let count = 0;

    var data = JSON.parse(resp);
    var llenat = "";
    data["data"].forEach((row) => {
      count++;
      llenat += `<tr>
                  <td>${count}</td>
                  <td>${row["servicio"]}</td>
                  <td>${row["cantidad"]}</td>
                  <td>${row["precio"]}</td>
                  <td>${row["descuento"]}</td>
                  <td>${row["total"]}</td>                           
                  </tr>`;

      arreglo_total = row["total"];

      subtotal = (parseFloat(subtotal) + parseFloat(arreglo_total)).toFixed(2);
      impuestototal = parseFloat((subtotal * impuesto) / 100).toFixed(2);
      total = (parseFloat(subtotal) + parseFloat(impuestototal)).toFixed(2);

      $("#lbl_totalneto").html("<b>Total neto: </b> $/." + subtotal);
      $("#lbl_impuesto").html(
        "<b>impuesto " + impuesto + "% : </b> $/." + impuestototal
      );
      $("#lbl_a_pagar").html("<b>Total a pagar: </b> $/." + total);

      $("#tbody_detalle_venta_servicios").html(llenat);
    });

    $("#modal_detalle_venta_servicios").modal({
      backdrop: "static",
      keyboard: false,
    });
    $("#modal_detalle_venta_servicios").modal("show");
  });
}

///////////// venta de productos
function modal_producto_selct() {
  $("#modal_producto_selecionar").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_producto_selecionar").modal("show");
}

function listar_producto_selecionar() {
  funcion = "listar_producto_selecionar";
  tabla_producto_envio = $("#detalle_producto_seleccionar").DataTable({
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
      url: "../ADMIN/controlador/venta/venta.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      {
        render: function (data, type, row) {
          return `<button style='font-size:13px;' type='button' class='enviar btn btn-danger' title='enviar'><i class='fa fa-send'></i></button>`;
        },
      },
      { data: "codigo" },
      { data: "nombre_producto" },
      { data: "tipo_producto" },
      { data: "marca" },
      {
        data: "stock",
        render: function (data, type, row) {
          if (data == null) {
            return "<span class='label label-danger'>No stock</span>";
          } else {
            return "<span class='label label-success'>" + data + "</span>";
          }
        },
      },
      { data: "precio_venta" },
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
    order: [[0, "desc"]],
  });
}

$("#detalle_producto_seleccionar").on("click", ".enviar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_producto_envio.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_producto_envio.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_producto_envio.row(this).data();
  }

  $("#id_productos").val(data.id_producto);
  $("#nombre_prodc").val(data.nombre_producto);
  $("#tipo_producto").val(data.tipo_producto);
  $("#marca_product").val(data.marca);
  $("#stock_product").val(data.stock);

  $("#tipo_pro").val("No promoción");
  $("#descuento_promo").val("0");

  $("#cantidad").val("1");
  $("#precio").val(data.precio_venta);
  $("#descuento").val("0");

  $("#modal_producto_selecionar").modal("hide");
});

function modal_producto_oferta_select() {
  $("#modal_producto_oferta_selecionar").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_producto_oferta_selecionar").modal("show");
}

function listar_producto_oferta_selecionar() {
  funcion = "listar_producto_oferta_selecionar";
  tabla_producto_oferta_envio = $(
    "#detalle_producto_oferta_seleccionar"
  ).DataTable({
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
      url: "../ADMIN/controlador/venta/venta.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      {
        render: function (data, type, row) {
          return `<button style='font-size:13px;' type='button' class='enviar btn btn-danger' title='enviar'><i class='fa fa-send'></i></button>`;
        },
      },
      { data: "codigo" },
      { data: "nombre_producto" },
      { data: "tipo_producto" },
      {
        data: "stock",
        render: function (data, type, row) {
          if (data == null) {
            return "<span class='label label-danger'>No stock</span>";
          } else {
            return "<span class='label label-success'>" + data + "</span>";
          }
        },
      },
      { data: "precio_venta" },
      {
        data: "tipo_oferta",
        render: function (data, type, row) {
          if (data == "Descuento") {
            return "<span class='label label-success'>" + data + "</span>";
          } else if (data == "3x1") {
            return "<span class='label label-warning'>" + data + "</span>";
          } else {
            return "<span class='label label-info'>" + data + "</span>";
          }
        },
      },
      {
        data: "descuento",
        render: function (data, type, row) {
          return "<span>" + data + "%</span>";
        },
      },
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
    order: [[0, "desc"]],
  });
}

$("#detalle_producto_oferta_seleccionar").on("click", ".enviar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_producto_oferta_envio.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_producto_oferta_envio.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_producto_oferta_envio.row(this).data();
  }

  $("#id_productos").val(data.id_producto);
  $("#nombre_prodc").val(data.nombre_producto);
  $("#tipo_producto").val(data.tipo_producto);
  $("#marca_product").val(data.marca);
  $("#stock_product").val(data.stock);

  $("#tipo_pro").val(data.tipo_oferta);
  $("#descuento_promo").val(data.descuento);

  $("#cantidad").val("1");
  $("#precio").val(data.precio_venta);
  $("#descuento").val("0");

  $("#modal_producto_oferta_selecionar").modal("hide");
});

function guardar_venta_productos() {
  var cliente = $("#cliente").val();
  var numero_compra = $("#numero_compra").val();
  var comprobante_tipo = $("#comprobante_tipo").val();
  var impuesto = $("#impuesto").val();
  var fecha_compra = $("#fecha_compra").val();

  var txt_totalneto = $("#txt_totalneto").val();
  var txt_impuesto = $("#txt_impuesto").val();
  var txt_a_pagar = $("#txt_a_pagar").val();
  var count = 0;

  if (
    cliente.length == 0 ||
    numero_compra.length == 0 ||
    impuesto.length == 0
  ) {
    validar_venta_producto(cliente, numero_compra, impuesto);
    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#cliente_obligg").html("");
    $("#numero_obliga").html("");
    $("#Impuesto_obliga").html("");
  }

  $("#detalle_producto_ tbody#tbody_detalle_producto_ tr").each(function () {
    count++;
  });

  if (count == 0) {
    return Swal.fire(
      "Mensaje de advertencia",
      "El detalle de venta debe tener un producto por lo menos, (TABLA PRODUCTO)",
      "warning"
    );
  }

  funcion = "registrar_producto_venta";
  alerta = ["datos", "Se esta registrando la venta", "Registrando la venta"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
    type: "POST",
    data: {
      funcion: funcion,
      cliente: cliente,
      numero_compra: numero_compra,
      comprobante_tipo: comprobante_tipo,
      impuesto: impuesto,
      fecha_compra: fecha_compra,
      txt_totalneto: txt_totalneto,
      txt_impuesto: txt_impuesto,
      txt_a_pagar: txt_a_pagar,
      count: count,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp != 2) {
        registrar_detalle_venta_producto(parseInt(resp));
      } else {
        alerta = [
          "existe",
          "warning",
          "El numero de venta " + numero_compra + ", ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo regitrar la venta"];
      cerrar_loader_datos(alerta);
    }
  });
}

function registrar_detalle_venta_producto(id) {
  var count = 0;
  var arrego_insumo = new Array();
  var arreglo_cantidad = new Array();
  var arreglo_sale = new Array();
  var arreglo_oferta = new Array();
  var arreglo_des_oferta = new Array();
  var arreglo_precio = new Array();
  var arreglo_descuento_moneda = new Array();
  var arreglo_subtotal = new Array();

  $("#detalle_producto_ tbody#tbody_detalle_producto_ tr").each(function () {
    arrego_insumo.push($(this).find("td").eq(0).text());
    arreglo_cantidad.push($(this).find("td").eq(2).text());
    arreglo_sale.push($(this).find("td").eq(3).text());
    arreglo_precio.push($(this).find("td").eq(4).text());
    arreglo_oferta.push($(this).find("td").eq(5).text());
    arreglo_des_oferta.push($(this).find("td").eq(6).text());
    arreglo_descuento_moneda.push($(this).find("td").eq(7).text());
    arreglo_subtotal.push($(this).find("td").eq(8).text());
    count++;
  });

  //aqui combierto el arreglo a un string
  var idpm = arrego_insumo.toString();
  var cantidad = arreglo_cantidad.toString();
  var sale = arreglo_sale.toString();
  var precio = arreglo_precio.toString();
  var oferta = arreglo_oferta.toString();
  var des_oferta = arreglo_des_oferta.toString();
  var descuento = arreglo_descuento_moneda.toString();
  var sutotal = arreglo_subtotal.toString();

  if (count == 0) {
    return;
  }

  funcion = "registrar_detalle_venta_producto_a";
  //ajax para guardar detalle registros
  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      idpm: idpm,
      cantidad: cantidad,
      sale: sale,
      precio: precio,
      oferta: oferta,
      des_oferta: des_oferta,
      descuento: descuento,
      sutotal: sutotal,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        alerta = ["", "", ""];
        cerrar_loader_datos(alerta);
        enviar_correo_producto_venta(parseInt(id));

        Swal.fire({
          title: "Venta realizada con exito",
          text: "Desea imprimir el reporte de venta??",
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
              "../ADMIN/REPORTES/Pdf/reporte_venta_producto.php?id=" +
                parseInt(id) +
                "#zoom=100%",
              "Reporte de venta",
              "scrollbards=No"
            );

            cargar_contenido(
              "contenido_principal",
              "vista/venta/nueva_venta.php"
            );
          }
        });

        cargar_contenido("contenido_principal", "vista/venta/nueva_venta.php");
      }
    } else {
      alerta = ["error", "error", "No se pudo regitrar el detalle venta"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_venta_producto(cliente, numero_compra, impuesto) {
  if (cliente.length == 0) {
    $("#cliente_obligg").html("No hay cliente");
  } else {
    $("#cliente_obligg").html("");
  }

  if (numero_compra.length == 0) {
    $("#numero_obliga").html("Ingrese N° compra");
  } else {
    $("#numero_obliga").html("");
  }

  if (impuesto.length == 0) {
    $("#Impuesto_obliga").html("Ingrese dato");
  } else {
    $("#Impuesto_obliga").html("");
  }
}

function enviar_correo_producto_venta(id) {
  $.ajax({
    url: "../ADMIN/modelo/envio_correo/correo_venta_producto.php",
    type: "POST",
    data: {
      id: id,
    },
  }).done(function (resp) {
    if (resp == 1) {
      alertify.success("Correo enviado");
    } else {
      alertify.error("Error de envio");
    }
  });
}

/////////
function listar_ventas_productos() {
  funcion = "listar_ventas_productos";
  tabla_venta_productos = $("#tabla_ventas_pro").DataTable({
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
      url: "../ADMIN/controlador/venta/venta.php",
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
            return `<button style='font-size:13px;' type='button' class='inactivar btn btn-danger' title='Inactivar el Oftalmólogo'><i class='fa fa-times'></i></button> - <button style='font-size:13px;' type='button' class='enviar_correo btn btn-success' title='Envio de correo'><i class='fa fa-envelope'></i></button> - <button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-success'>VENDIDO</span>";
          } else {
            return "<span class='label label-danger'>ANULADO</span>";
          }
        },
      },
      { data: "cliente" },
      {
        data: "tipo_doc",
        render: function (data, type, row) {
          if (data == "Boleta") {
            return "<span class='label label-info'>Nota de venta</span>";
          } else {
            return "<span class='label label-success'>" + data + "</span>";
          }
        },
      },
      { data: "numero_compra" },
      {
        data: "iva",
        render: function (data, type, row) {
          if (data == "0") {
            return "0%";
          } else {
            return "12%";
          }
        },
      },

      { data: "fecha" },
      { data: "cantidad" },
      { data: "total" },
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
  tabla_venta_productos.on("draw.dt", function () {
    var pageinfo = $("#tabla_ventas_pro").DataTable().page.info();
    tabla_venta_productos
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_ventas_pro").on("click", ".pfd", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_venta_productos.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_venta_productos.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_venta_productos.row(this).data();
  }

  var id = data.id_venta;

  Swal.fire({
    title: "IMPRIMIR VENTA DE PRODUCTO",
    text: "Desea imprimir el reporte de venta??",
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
        "../ADMIN/REPORTES/Pdf/reporte_venta_producto.php?id=" +
          parseInt(id) +
          "#zoom=100%",
        "Reporte de venta",
        "scrollbards=No"
      );
    }
  });
});

$("#tabla_ventas_pro").on("click", ".ver", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_venta_productos.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_venta_productos.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_venta_productos.row(this).data();
  }

  var id = data.id_venta;
  var iva = data.iva;

  alerta = [
    "datos",
    "Se esta cargando el detalle venta",
    ".:Cargando la venta:.",
  ];
  mostar_loader_datos(alerta);
  cargar_detalle_venta_producto(parseInt(id), iva);
});

function cargar_detalle_venta_producto(id, iva) {
  funcion = "cargar_detalle_venta_producto";
  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
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
    let impuestototal = 0;
    let subtotal = 0;
    let impuesto = iva;
    let count = 0;

    var data = JSON.parse(resp);
    var llenat = "";
    data["data"].forEach((row) => {
      count++;
      llenat += `<tr>
                  <td>${count}</td>
                  <td>${row["nombre_producto"]}</td>
                  <td>${row["cantidad"]}</td>
                  <td>${row["sale"]}</td>
                  <td>${row["precio"]}</td>
                  <td>${row["tipo_oferta"]}</td>
                  <td>${row["des_pferta"]}</td>
                  <td>${row["descuento"]}</td>
                  <td>${row["total"]}</td>                           
                  </tr>`;

      arreglo_total = row["total"];

      subtotal = (parseFloat(subtotal) + parseFloat(arreglo_total)).toFixed(2);
      impuestototal = parseFloat((subtotal * impuesto) / 100).toFixed(2);
      total = (parseFloat(subtotal) + parseFloat(impuestototal)).toFixed(2);

      $("#lbl_totalneto").html("<b>Total neto: </b> $/." + subtotal);
      $("#lbl_impuesto").html(
        "<b>impuesto " + impuesto + "% : </b> $/." + impuestototal
      );
      $("#lbl_a_pagar").html("<b>Total a pagar: </b> $/." + total);

      $("#tbody_detalle_venta_produto").html(llenat);
    });

    $("#modal_detalle_venta_prodcutos").modal({
      backdrop: "static",
      keyboard: false,
    });
    $("#modal_detalle_venta_prodcutos").modal("show");
  });
}

$("#tabla_ventas_pro").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_venta_productos.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_venta_productos.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_venta_productos.row(this).data();
  }

  var id = data.id_venta;

  Swal.fire({
    title: "Anular venta",
    text: "Desea anular la venta??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, anular!!",
  }).then((result) => {
    if (result.value) {
      anular_venta_producto(parseInt(id));
    }
  });
});

function anular_venta_producto(id) {
  alerta = ["datos", "Se esta anulando la venta", ".:Anulando venta:."];
  mostar_loader_datos(alerta);

  funcion = "anular_venta_producto";
  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        alerta = ["exito", "success", "Se anulo la venta con exito"];
        cerrar_loader_datos(alerta);
        tabla_venta_productos.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo anular la venta"];
      cerrar_loader_datos(alerta);
    }
  });
}

$("#tabla_ventas_pro").on("click", ".enviar_correo", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_venta_productos.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_venta_productos.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_venta_productos.row(this).data();
  }
  var id = data.id_venta;

  Swal.fire({
    title: "Envio de correo",
    text: "Desea enviar detalle de venta al correo del cliente??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, enviar!!",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "../ADMIN/modelo/envio_correo/correo_venta_producto.php",
        type: "POST",
        data: {
          id: id,
        },
      }).done(function (resp) {
        if (resp == 1) {
          alertify.success("Correo enviado");
        } else {
          alertify.error("Error de envio");
        }
      });
    }
  });
});

///////// ventas productos online
/////////
function listar_ventas_onlinee_productos() {
  funcion = "listar_ventas_onlinee_productos";
  tabla_ventas_online_pro = $("#tabla_ventas_online_pro").DataTable({
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
      url: "../ADMIN/controlador/venta/venta.php",
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
            return `<button style='font-size:13px;' type='button' class='inactivar btn btn-danger' title='Inactivar el Oftalmólogo'><i class='fa fa-times'></i></button> - <button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-success'>Vendido</span>";
          } else {
            return "<span class='label label-danger'>Anulado</span>";
          }
        },
      },
      {
        data: "pago",
        render: function (data, type, row) {
          if (data == 0) {
            return "<span class='label label-danger'>En espera</span>";
          } else if (data == 1) {
            return "<span class='label label-warning'>Pago enviado</span>";
          } else {
            return "<span class='label label-success'>Pagado</span>";
          }
        },
      },

      { data: "cliente" },
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
      { data: "numero_compra" },
      { data: "fecha" },
      { data: "cantidad" },
      { data: "subtotal" },
      { data: "impuesto" },
      { data: "total" },
      {
        data: "cod_envio",
        render: function (data, type, row) {
          if (data != null) {
            return data;
          } else {
            return "<span class='label label-danger'>Sin código</span>";
          }
        },
      },

      {
        data: "estado_envio",
        render: function (data, type, row) {
          if (data != null) {
            return "<span class='label label-warning'>" + data + "</span>";
          } else if (data == "Entregado") {
            return "<span class='label label-success'>" + data + "</span>";
          } else {
            return "<span class='label label-danger'>Sin estado</span>";
          }
        },
      },
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
  tabla_ventas_online_pro.on("draw.dt", function () {
    var pageinfo = $("#tabla_ventas_online_pro").DataTable().page.info();
    tabla_ventas_online_pro
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_ventas_online_pro").on("click", ".pfd", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_ventas_online_pro.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_ventas_online_pro.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_ventas_online_pro.row(this).data();
  }

  var id = data.id_venta_online_trans;

  Swal.fire({
    title: "IMPRIMIR VENTA DE PRODUCTO",
    text: "Desea imprimir el reporte de venta??",
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
        "../ADMIN/REPORTES/Pdf/factura_venta_online.php?id=" +
          parseInt(id) +
          "#zoom=100%",
        "Reporte de venta",
        "scrollbards=No"
      );
    }
  });
});

$("#tabla_ventas_online_pro").on("click", ".ver", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_ventas_online_pro.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_ventas_online_pro.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_ventas_online_pro.row(this).data();
  }

  var id = data.id_venta_online_trans;

  alerta = [
    "datos",
    "Se esta cargando el detalle venta",
    ".:Cargando la venta:.",
  ];
  mostar_loader_datos(alerta);
  cargar_detalle_venta_onlinee_producto(parseInt(id));
});

function cargar_detalle_venta_onlinee_producto(id) {
  funcion = "cargar_detalle_venta_onlinee_producto";
  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
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
    let impuestototal = 0;
    let subtotal = 0;
    let impuesto = 12;
    let count = 0;
    var data = JSON.parse(resp);
    var llenat = "";
    data["data"].forEach((row) => {
      count++;
      llenat += `<tr>
                  <td>${count}</td>
                  <td>${row["nombre_producto"]}</td>
                  <td>${row["cantidad"]}</td>
                  <td>${row["precio"]}</td>
                  <td>${row["tipo_oferta"]}</td>
                  <td>${row["descuento_oferta"]}</td>
                  <td>${row["subtotal"]}</td>                           
                  </tr>`;

      arreglo_total = row["subtotal"];
      subtotal = (parseFloat(subtotal) + parseFloat(arreglo_total)).toFixed(2);
      impuestototal = parseFloat((subtotal * impuesto) / 100).toFixed(2);
      total = (parseFloat(subtotal) + parseFloat(impuestototal)).toFixed(2);

      $("#lbl_totalneto").html("<b>Total neto: </b> $/." + subtotal);
      $("#lbl_impuesto").html(
        "<b>impuesto " + impuesto + "% : </b> $/." + impuestototal
      );
      $("#lbl_a_pagar").html("<b>Total a pagar: </b> $/." + total);
      $("#tbody_detalle_venta_online_produto").html(llenat);
    });

    $("#modal_detalle_venta_onine_prodcutos").modal({
      backdrop: "static",
      keyboard: false,
    });
    $("#modal_detalle_venta_onine_prodcutos").modal("show");
  });
}

$("#tabla_ventas_online_pro").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_ventas_online_pro.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_ventas_online_pro.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_ventas_online_pro.row(this).data();
  }

  var id = data.id_venta_online_trans;

  Swal.fire({
    title: "Anular venta",
    text: "Desea anular la venta??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, anular!!",
  }).then((result) => {
    if (result.value) {
      anular_venta_online_producto(parseInt(id));
    }
  });
});

function anular_venta_online_producto(id) {
  alerta = ["datos", "Se esta anulando la venta", ".:Anulando venta:."];
  mostar_loader_datos(alerta);

  funcion = "anular_venta_online_producto";
  $.ajax({
    url: "../ADMIN/controlador/venta/venta.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        alerta = ["exito", "success", "Se anulo la venta con exito"];
        cerrar_loader_datos(alerta);
        tabla_ventas_online_pro.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo anular la venta"];
      cerrar_loader_datos(alerta);
    }
  });
}

/////////
function lista_transferencia_bancaria() {
  funcion = "lista_transferencia_bancaria";
  tabla_transferencia = $("#tabla_transferencia").DataTable({
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
      url: "../ADMIN/controlador/venta/venta.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },

      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 0) {
            return "<span class='label label-danger'>En espera</span>";
          } else if (data == 1) {
            return "<button class='btn_procesar btn_fotoo btn btn-info'><i class='fa fa-check'></i> Procesar venta</button>";
          } else {
            return "<span class='label label-success'>Venta procesada</span>";
          }
        },
      },
      {
        data: "foto",
        render: function (data, type, row) {
          if (data != null) {
            return (
              "<a class='btn btn-success' href='../ADMIN/" +
              data +
              "' download><i class='fa fa-download'></i> Ver foto</a>"
            );
          } else {
            return "<span class='label label-danger'>Comprobante no enviado</span>";
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 0) {
            return "<span class='label label-danger'>En espera</span>";
          } else if (data == 1) {
            return "<span class='label label-warning'>En proceso...</span>";
          } else {
            return "<span class='label label-success'>Procesado</span>";
          }
        },
      },
      { data: "cliente" },
      { data: "codigo" },
      { data: "numero_compra" },
      { data: "nombre_banco" },
      { data: "fecha" },
      { data: "monto" },
      { data: "monto" },
      {
        data: "fecha_deposito",
        render: function (data, type, row) {
          if (data != null) {
            return data;
          } else {
            return "<span class='label label-danger'>Sin fecha</span>";
          }
        },
      },
      {
        data: "fecha_proceso",
        render: function (data, type, row) {
          if (data != null) {
            return data;
          } else {
            return "<span class='label label-danger'>Sin fecha</span>";
          }
        },
      },
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
  tabla_transferencia.on("draw.dt", function () {
    var pageinfo = $("#tabla_transferencia").DataTable().page.info();
    tabla_transferencia
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_transferencia").on("click", ".btn_procesar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_transferencia.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_transferencia.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_transferencia.row(this).data();
  }

  var id = data.id_venta_online;

  Swal.fire({
    title: "Procesar venta",
    text: "Desea procesar la venta??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, procesar!",
  }).then((result) => {
    if (result.value) {
      alerta = ["datos", "Procesando venta", "Procesando venta..."];
      mostar_loader_datos(alerta);

      funcion = "procesar_venta_clinte";
      $.ajax({
        url: "../ADMIN/controlador/venta/venta.php",
        type: "POST",
        data: {
          funcion: funcion,
          id: id,
        },
      }).done(function (resp) {
        if (resp > 0) {
          if (resp == 1) {
            alerta = ["exito", "success", "La venta se proceso con exito"];
            cerrar_loader_datos(alerta);
            tabla_transferencia.ajax.reload();
          }
        } else {
          alerta = ["error", "error", "No se pudo procesar la venta"];
          cerrar_loader_datos(alerta);
        }
      });
    }
  });
});

//////////////////
/////////
function lista_efetivo_clinte() {
  funcion = "lista_efetivo_clinte";
  tabla_efectivo = $("#tabla_efectivo").DataTable({
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
      url: "../ADMIN/controlador/venta/venta.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
      {
        data: "foto",
        render: function (data, type, row) {
          if (data != null) {
            return (
              "<a class='btn btn-success' href='../ADMIN/" +
              data +
              "' download><i class='fa fa-download'></i> Ver foto</a>"
            );
          } else {
            return "<button class='btn_fotoo btn btn-warning'>Pago en espera..</button>";
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 0) {
            return "<span class='label label-danger'>En espera</span>";
          } else {
            return "<span class='label label-success'>Procesado</span>";
          }
        },
      },
      { data: "clientee" },
      { data: "numero_compra" },
      { data: "fecha" },
      { data: "monto" },
      { data: "monto" },
      {
        data: "fecha_proceso",
        render: function (data, type, row) {
          if (data != null) {
            return data;
          } else {
            return "<span class='label label-danger'>Sin fecha</span>";
          }
        },
      },
      {
        data: "detalle",
        render: function (data, type, row) {
          if (data != null) {
            return data;
          } else {
            return "<span class='label label-danger'>Sin detalle</span>";
          }
        },
      },
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
  tabla_efectivo.on("draw.dt", function () {
    var pageinfo = $("#tabla_efectivo").DataTable().page.info();
    tabla_efectivo
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}
