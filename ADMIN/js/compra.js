var funcion, tabla_producto_envio, tabla_compras_pro;

///////////////
function modal_poductos() {
  $("#modal_producto_select").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_producto_select").modal("show");
}

function listar_producto_seelct() {
  funcion = "listar_producto_seelct";
  tabla_producto_envio = $("#detalle_producto_select").DataTable({
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
      url: "../ADMIN/controlador/compra/compra.php",
      type: "POST",
      data: { funcion: funcion },
    },
    //hay que poner la misma cantidad de columnas y tambien en el html
    columns: [
      { defaultContent: "" },
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

  //esto es para crearn un contador para la tabla este contador es automatico
  tabla_producto_envio.on("draw.dt", function () {
    var pageinfo = $("#detalle_producto_select").DataTable().page.info();
    tabla_producto_envio
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#detalle_producto_select").on("click", ".enviar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_producto_envio.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_producto_envio.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_producto_envio.row(this).data();
  }

  $("#id_marca").val(data.id_producto);
  $("#nombre_ma").val(data.nombre_producto);
  $("#tipo_m").val(data.tipo_producto);
  $("#precio_compra").val("");
  $("#codigi_material").val(data.codigo);
  $("#cantiddad").val("1");

  $("#modal_producto_select").modal("hide");
});

/////////// guardar compra
function gardar_compra_material() {
  var proveedor = $("#proveedor").val();
  var numero_compra = $("#numero_compra").val();
  var comprobante_tipo = $("#comprobante_tipo").val();
  var impuesto = $("#impuesto").val();
  var fecha_compra = $("#fecha_compra").val();

  var txt_totalneto = $("#txt_totalneto").val();
  var txt_impuesto = $("#txt_impuesto").val();
  var txt_a_pagar = $("#txt_a_pagar").val();
  var count = 0;

  if (
    proveedor.length == 0 ||
    numero_compra.length == 0 ||
    impuesto.length == 0
  ) {
    validar_registro_compra(proveedor, numero_compra, impuesto);
    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#razon_oblig").html("");
    $("#numero_obliga").html("");
    $("#Impuesto_obliga").html("");
  }

  $("#detalle_compra_material tbody#tbody_detalle_compra_material tr").each(
    function () {
      count++;
    }
  );

  if (count == 0) {
    return Swal.fire(
      "Mensaje de advertencia",
      "El detalle de compra debe tener un producto por lo menos,(TABLA PRODUCTO)",
      "warning"
    );
  }

  funcion = "registrar_compra_producto";
  alerta = ["datos", "Se esta registrando la compra", "Registrando la compra"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/compra/compra.php",
    type: "POST",
    data: {
      funcion: funcion,
      proveedor: proveedor,
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
        registrar_detalle_compra(parseInt(resp));
      } else {
        alerta = [
          "existe",
          "warning",
          "El numero de compra " + numero_compra + ", ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo regitrar la compra"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_registro_compra(proveedor, numero_compra, impuesto) {
  if (proveedor.length == 0) {
    $("#razon_oblig").html("NO hay proveedor");
  } else {
    $("#razon_oblig").html("");
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

function registrar_detalle_compra(id) {
  var count = 0;
  var arrego_insumo = new Array();
  var arreglo_cantidad = new Array();
  var arreglo_precio = new Array();
  var arreglo_descuento_moneda = new Array();
  var arreglo_subtotal = new Array();

  $("#detalle_compra_material tbody#tbody_detalle_compra_material tr").each(
    function () {
      arrego_insumo.push($(this).find("td").eq(0).text());
      arreglo_cantidad.push($(this).find("td").eq(2).text());
      arreglo_precio.push($(this).find("td").eq(3).text());
      arreglo_descuento_moneda.push($(this).find("td").eq(4).text());
      arreglo_subtotal.push($(this).find("td").eq(5).text());
      count++;
    }
  );

  //aqui combierto el arreglo a un string
  var idpm = arrego_insumo.toString();
  var cantidad = arreglo_cantidad.toString();
  var precio = arreglo_precio.toString();
  var des = arreglo_descuento_moneda.toString();
  var sutotal = arreglo_subtotal.toString();

  if (count == 0) {
    return;
  }

  funcion = "registrar_detalle_compra";
  //ajax para guardar detalle registros
  $.ajax({
    url: "../ADMIN/controlador/compra/compra.php",
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

        Swal.fire({
          title: "Campra realizada con exito",
          text: "Desea imprimir el reporte de compra??",
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
              "../ADMIN/REPORTES/Pdf/reporte_de_ingreso.php?id=" +
                parseInt(id) +
                "#zoom=100%",
              "Reporte de compra",
              "scrollbards=No"
            );

            cargar_contenido(
              "contenido_principal",
              "vista/compra/nueva_compra_insumo.php"
            );
          }
        });

        cargar_contenido(
          "contenido_principal",
          "vista/compra/nueva_compra.php"
        );
      }
    } else {
      alerta = ["error", "error", "No se pudo regitrar el detalle compra"];
      cerrar_loader_datos(alerta);
    }
  });
}

/////////
function listar_compras() {
  funcion = "listar_compras";
  tabla_compras_pro = $("#tabla_compras_").DataTable({
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
      url: "../ADMIN/controlador/compra/compra.php",
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
            return "<span class='label label-success'>COMPRADO</span>";
          } else {
            return "<span class='label label-danger'>ANULADO</span>";
          }
        },
      },
      { data: "razon_social" },

      {
        data: "tipo_doc",
        render: function (data, type, row) {
          if (data == "Factura") {
            return data;
          } else {
            return "Nota de compra";
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
  tabla_compras_pro.on("draw.dt", function () {
    var pageinfo = $("#tabla_compras_").DataTable().page.info();
    tabla_compras_pro
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + pageinfo.start;
      });
  });
}

$("#tabla_compras_").on("click", ".ver", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_compras_pro.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_compras_pro.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_compras_pro.row(this).data();
  }

  var id = data.id_compra;
  var iva = data.iva;

  alerta = [
    "datos",
    "Se esta cargando el detalle compra",
    ".:Cargando la compra:.",
  ];
  mostar_loader_datos(alerta);
  cargar_detalle_compra(parseInt(id), iva);
});

function cargar_detalle_compra(id, iva) {
  funcion = "cargar_detalle_compra";
  $.ajax({
    url: "../ADMIN/controlador/compra/compra.php",
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
                <td>${row["nombre_producto"]} - ${row["tipo_producto"]}</td>
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

      $("#tbody_detalle_compr_insumo").html(llenat);
    });

    $("#modal_detalle_comppra_insumos").modal({
      backdrop: "static",
      keyboard: false,
    });
    $("#modal_detalle_comppra_insumos").modal("show");
  });
}

$("#tabla_compras_").on("click", ".pfd", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_compras_pro.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_compras_pro.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_compras_pro.row(this).data();
  }

  var id = data.id_compra;

  Swal.fire({
    title: "IMPRIMIR COMPRA",
    text: "Desea imprimir el reporte de compra??",
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
        "../ADMIN/REPORTES/Pdf/reporte_de_ingreso.php?id=" +
          parseInt(id) +
          "#zoom=100%",
        "Reporte de compra",
        "scrollbards=No"
      );
    }
  });
});

$("#tabla_compras_").on("click", ".inactivar", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_compras_pro.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_compras_pro.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_compras_pro.row(this).data();
  }

  var id = data.id_compra;

  Swal.fire({
    title: "Anular compra",
    text: "Desea anular la compra??",
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    allowOutsideClick: false,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, anular!!",
  }).then((result) => {
    if (result.value) {
      anular_compra_(parseInt(id));
    }
  });
});

function anular_compra_(id) {
  alerta = ["datos", "Se esta anulando la compra", ".:Anulando compra:."];
  mostar_loader_datos(alerta);

  funcion = "anular_compra";
  $.ajax({
    url: "../ADMIN/controlador/compra/compra.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        alerta = ["exito", "success", "Se anulo la compra con exito"];
        cerrar_loader_datos(alerta);
        tabla_compras_pro.ajax.reload();
      }
    } else {
      alerta = ["error", "error", "No se pudo anular la compra"];
      cerrar_loader_datos(alerta);
    }
  });
}
