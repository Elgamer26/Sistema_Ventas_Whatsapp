var funcion, tabla_transferencia, tabla_efectivo;

$(document).on("click", "#ingresar_cliente", function (e) {
  e.preventDefault();
  var usuario = $("#user_email").val();
  var password = $("#user_pass").val();

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
      url: "../ADMIN/controlador/carrito/carrito.php",
      type: "POST",
      data: { usuario: usuario, password: password, funcion: funcion },
    }).done(function (responce) {
      if (responce == 0) {
        $("#none_usu").hide();
        $("#none_pass").hide();
        $("#error_logeo").hide();
        $("#error_logeo").show(2000);
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
            url: "../ADMIN/controlador/carrito/carrito.php",
            type: "POST",
            data: {
              id_cli: data[0][0],
              nombre: data[0][1],
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

/////////////
function enviar_correo() {
  var correo = $("#correo_envio").val();
  alerta = ["datos", "Enviando correo...", "Enviando correo..."];
  mostar_loader_datos(alerta);
  funcion = "Enviando_correo";
  $("#envio_cliente_exito").hide();
  $("#envio_cliente_error").hide();
  $("#envio_cliente_no_envio").hide();

  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      correo: correo,
    },
  }).done(function (response) {
    if (response != 0) {
      $.ajax({
        url: "../ADMIN/modelo/envio_correo/password_new.php",
        type: "POST",
        data: {
          response: response,
          correo: correo,
        },
      }).done(function (resp) {
        if (resp == 1) {
          $("#envio_cliente_exito").show(2000);
        } else {
          $("#envio_cliente_no_envio").show(2000);
        }
        alerta = ["", "", ""];
        cerrar_loader_datos(alerta);
      });
    } else {
      alerta = ["", "", ""];
      cerrar_loader_datos(alerta);
      $("#envio_cliente_error").show(2000);
    }
  });
}

$(document).on("keyup", "#buscar_prod", function () {
  let valor = $(this).val();
  if (valor != "") {
    pagination_carrito(1, valor);
  } else {
    pagination_carrito(1);
  }
});

function pagination_carrito(partida, valor) {
  funcion = "pagination_carrito";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      partida: partida,
      funcion: funcion,
      valor: valor,
    },
  }).done(function (response) {
    var array = eval(response);
    if (array[0]) {
      $("#unir_carrito").html(array[0]);
      $("#pagination_pro").html(array[1]);
    } else {
      $("#unir_carrito")
        .html(`<div class="col-lg-12" style="text-align: center; justify-content: center; align-items: center"><br>
              <label style="font-size: 20px;"></i>.:No se encontro producto:.<label>
           </div>`);
      $("#pagination_pro").html("");
    }
  });
}

function agregar_producto(id, precio) {
  Swal.fire({
    title: "<strong>Ingrese cantidad de producto</strong>",
    html: `
    <div class="col-sm-12">
    <input type="number" value="1" class="form-control" id="cantidad_proddd" placeholder="Ingrese cantidad">
    </div>`,
    showConfirmButton: true,
    showCloseButton: false,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText:
      '<a onclick="ingresar_agregar_producto(' +
      id +
      "," +
      precio +
      ');"><i class="fa fa-download"></i> Ingresar!</a>',
  });
}

function ingresar_agregar_producto(id, precio) {
  var cantidad = $("#cantidad_proddd").val();

  if (cantidad.length == 0 || cantidad == "" || cantidad <= 0) {
    return alert("Ingrese cantidad de producto!");
  }

  funcion = "agregar_producto";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      precio: precio,
      cantidad: cantidad,
    },
  }).done(function (response) {
    if (response == "100") {
      alerta = [
        "existe",
        "error",
        "Para poder agregar el producto al carrito debe inicar sesion :(",
      ];
      cerrar_loader_datos(alerta);
    } else if (response == "1") {
      count_carrito();
      alerta = [
        "exito",
        "success",
        "El producto se agrego al carrito con exito",
      ];
      cerrar_loader_datos(alerta);
    } else if (response == "2") {
      alerta = [
        "exito",
        "success",
        "El producto ya esta registrado en el carrito, SE AUMENTO LA CANTIDAD",
      ];
      cerrar_loader_datos(alerta);
    } else if (response == "3" || response == "0") {
      alerta = [
        "error",
        "error",
        "No se pudo agregar el producto al carrito, FALLO EN LA MATRIX :(",
      ];
      cerrar_loader_datos(alerta);
    } else {
      alerta = [
        "existe",
        "warning",
        "No hay stock suficiente para la cantidad ingresada, " +
          response +
          "  :(",
      ];
      cerrar_loader_datos(alerta);
    }
  });
}

$(document).on("keyup", "#buscar_prod_oferta", function () {
  let valor = $(this).val();
  if (valor != "") {
    pagination_carrito_oferta(1, valor);
  } else {
    pagination_carrito_oferta(1);
  }
});

function pagination_carrito_oferta(partida, valor) {
  funcion = "pagination_carrito_oferta";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      partida: partida,
      funcion: funcion,
      valor: valor,
    },
  }).done(function (response) {
    var array = eval(response);
    if (array[0]) {
      $("#unir_carrito_oferta").html(array[0]);
      $("#pagination_oferta").html(array[1]);
    } else {
      $("#unir_carrito_oferta")
        .html(`<div class="col-lg-12" style="text-align: center; justify-content: center; align-items: center"><br>
                <label style="font-size: 20px;"></i>.:No se encontro producto:.<label>
             </div>`);
      $("#pagination_oferta").html("");
    }
  });
}

function agregar_producoferta(id) {
  Swal.fire({
    title: "<strong>Ingrese cantidad de producto oferta</strong>",
    html: `
    <div class="col-sm-12">
    <input type="number" value="1" class="form-control" id="cantidad_proddd_oferta" placeholder="Ingrese cantidad">
    </div>`,
    showConfirmButton: true,
    showCloseButton: false,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText:
      '<button class="btn btn-danger" onclick="ingresar_agregar_producoferta(' +
      id +
      ');"><i class="fa fa-download"></i> Ingresar!</button>',
  });
}

function ingresar_agregar_producoferta(id) {
  var cantidad = $("#cantidad_proddd_oferta").val();

  if (cantidad.length == 0 || cantidad == "" || cantidad <= 0) {
    return alert("Ingrese cantidad de producto!");
  }

  funcion = "agregar_producoferta";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
      cantidad: cantidad,
    },
  }).done(function (response) {
    if (response == "100") {
      alerta = [
        "existe",
        "error",
        "Para poder agregar el producto al carrito debe inicar sesion :(",
      ];
      cerrar_loader_datos(alerta);
    } else if (response == "1") {
      count_carrito();
      alerta = [
        "exito",
        "success",
        "El producto se agrego al carrito con exito",
      ];
      cerrar_loader_datos(alerta);
    } else if (response == "2") {
      alerta = [
        "exito",
        "success",
        "El producto ya esta registrado en el carrito, SE AUMENTO LA CANTIDAD",
      ];
      cerrar_loader_datos(alerta);
    } else if (response == "3" || response == "0") {
      alerta = [
        "error",
        "error",
        "No se pudo agregar el producto al carrito, FALLO EN LA MATRIX :(",
      ];
      cerrar_loader_datos(alerta);
    } else {
      alerta = [
        "existe",
        "warning",
        "No hay stock suficiente para la cantidad ingresada, " +
          response +
          "  :(",
      ];
      cerrar_loader_datos(alerta);
    }
  });
}

function nuevo_cliente_carrito() {

  var nombress = document.getElementById("nombress").value;
  var apellidoss = document.getElementById("apellidoss").value;
  var numero_docu = document.getElementById("numero_docu").value;
  var telefono_p = document.getElementById("telefono_p").value;
  var correo_p = document.getElementById("correo_p").value;
  var direccions = document.getElementById("direccions").value;
  var sexo = document.getElementById("sexo").value;
  var password = document.getElementById("password_clie").value;
  var confir = document.getElementById("password_clie_onfirm").value;

  if (
    nombress.length == 0 ||
    apellidoss.length == 0 ||
    numero_docu.length == 0 ||
    telefono_p.length == 0 ||
    correo_p.length == 0 ||
    direccions.length == 0 ||
    password.length == 0 ||
    confir.length == 0
  ) {
    validar_registro_carrito(
      nombress,
      apellidoss,
      numero_docu,
      telefono_p,
      correo_p,
      direccions,
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
    $("#password_obliga").html("");
    $("#password_obliga_confirm").html("");
  }

  if (password != confir) {
    $("#password_obliga").html("xxx");
    $("#password_obliga_confirm").html("xxx");

    return swal.fire(
      "Password no coinciden",
      "Ingrese el password correctamente",
      "warning"
    );
  }

  if(!global_pass){
    return swal.fire(
      "",
      "Ingresé un Password más seguro para su cuenta de usuario",
      "warning"
    );
  }

  funcion = "registrar_clientes_carrito";
  alerta = ["datos", "Se esta creando el cliente", "creando cliente"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/cliente/cliente.php",
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
      password: password,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        
        enviar_correo_registrar(correo_p, password, nombress);

        Swal.fire({
          title: 'Cliente registrado',
          text: "Datos registrados con exito",
          icon: 'success',
          showCancelButton: false,
          showConfirmButton: true,
          allowOutsideClick: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: ' OK '
        }).then((result) => {
          if (result.isConfirmed) {       
            location.href = "index.php";
          }
        })

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
  });
}

async function enviar_correo_registrar(correo, password, nombress) {
  let result = await $.ajax({
    url: "../ADMIN/modelo/envio_correo/correo_registrar.php",
    type: "POST",
    data: {
      correo: correo,
      password: password,
      nombress: nombress
    },
  });
    console.log(result);
}

// function enviar_correo_registrar(correo, password, nombress) {
//   $.ajax({
//     url: "../ADMIN/modelo/envio_correo/correo_registrar.php",
//     type: "POST",
//     data: {
//       correo: correo,
//       password: password,
//       nombress: nombress
//     },
//   }).done(function (resp) {
//     console.log(resp);
//   });
// }

function validar_registro_carrito(
  nombress,
  apellidoss,
  numero_docu,
  telefono_p,
  correo_p,
  direccions,
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

  if (password.length == 0) {
    $("#password_obliga").html("Ingrese password");
  } else {
    $("#password_obliga").html("");
  }

  if (confir.length == 0) {
    $("#password_obliga_confirm").html("Confirmar password");
  } else {
    $("#password_obliga_confirm").html("");
  }
}

function calificar_sistema() {
  var estrella = "";
  var nesecita_calif = document.getElementById("nesecita_calif").checked;
  var regular_cali = document.getElementById("regular_cali").checked;
  var bueno_calif = document.getElementById("bueno_calif").checked;
  var muy_bueno_calif = document.getElementById("muy_bueno_calif").checked;
  var excelente_calif = document.getElementById("excelente_calif").checked;
  var comentario = document.getElementById("comentario").value;

  if (nesecita_calif == true) {
    estrella = "Necesita Mejorar";
  } else if (regular_cali == true) {
    estrella = "Regular";
  } else if (bueno_calif == true) {
    estrella = "Bueno";
  } else if (muy_bueno_calif == true) {
    estrella = "Muy Bueno";
  } else if (excelente_calif == true) {
    estrella = "Excelente";
  } else {
    estrella = "";
  }

  if (estrella == "") {
    return swal.fire(
      "No hay calificación",
      "Debe ingresar una calificación para continuar.",
      "warning"
    );
  }

  if (comentario.length == 0 || comentario.text == "" || comentario == "") {
    $("#comentario_olbigg").html("Ingresar un comentario para continuar");
    return swal.fire(
      "No hay comentario",
      "Debe ingresar una comentario para continuar.",
      "warning"
    );
  } else {
    $("#comentario_olbigg").html("");
  }

  funcion = "calificar_sistema";
  alerta = [
    "datos",
    "Se esta enviando su calificación",
    "Enviando calificación",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      estrella: estrella,
      comentario: comentario,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        document.getElementById("nesecita_calif").checked = false;
        document.getElementById("regular_cali").checked = false;
        document.getElementById("bueno_calif").checked = false;
        document.getElementById("muy_bueno_calif").checked = false;
        document.getElementById("excelente_calif").checked = false;
        document.getElementById("comentario").value = "";

        $("#calificacion_cliente_exito").show(2000);
        alerta = ["exito", "success", "La calificación se envio con exito"];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "Error al enviar calificación"];
      cerrar_loader_datos(alerta);
    }
  });
}

//////////////////////////
function mostrar_carrito_compra_detalle() {
  funcion = "mostrar_carrito_compra_detalle";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (response) {
    if (response != 100) {
      count_carrito();
      var array = eval(response);
      var sub = parseFloat(array[1]).toFixed(2);
      var iva = parseFloat(array[2]).toFixed(2);
      var grantotal = parseFloat(array[3]).toFixed(2);

      if (array[0]) {
        $("#unnir_tabla_detalle").html(array[0]);
        $("#subtotal").html("$. " + sub);
        $("#iva_total").html("$. " + iva);
        $("#grntotal").html("$. " + grantotal);

        $("#txt_subtotal").val(sub);
        $("#txt_iva_total").val(iva);
        $("#txt_grntotal").val(grantotal);

        $("#boton_pocesar_pagos").css("display", "block");
      } else {
        $("#unnir_tabla_detalle").html("");
        $("#subtotal").html("0.00");
        $("#iva_total").html("0.00");
        $("#grntotal").html("0.00");

        $("#txt_subtotal").val("");
        $("#txt_iva_total").val("");
        $("#txt_grntotal").val("");

        $("#boton_pocesar_pagos").css("display", "none");
      }
    } else {
      $("#unnir_tabla_detalle").html("");
      $("#subtotal").html("0.00");
      $("#iva_total").html("0.00");
      $("#grntotal").html("0.00");

      $("#txt_subtotal").val("");
      $("#txt_iva_total").val("");
      $("#txt_grntotal").val("");

      $("#boton_pocesar_pagos").css("display", "none");
    }
  });
}

function quitar_producto(id_cli, id_pro) {
  Swal.fire({
    title: "Quitar producto?",
    text: "El producto se quitara del detalle!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, quitar!",
  }).then((result) => {
    if (result.isConfirmed) {
      funcion = "quitar_producto_detalle";

      $.ajax({
        url: "../ADMIN/controlador/carrito/carrito.php",
        type: "POST",
        data: {
          funcion: funcion,
          id_cli: id_cli,
          id_pro: id_pro,
        },
      }).done(function (response) {
        if (response == 1) {
          mostrar_carrito_compra_detalle();
        } else {
          alerta = [
            "error",
            "error",
            "No se puedo quitar el producto, error en la matrix",
          ];
          cerrar_loader_datos(alerta);
        }
      });
    }
  });
}

function aumen_cantidad_prod(id_cli, id_pro, cantidad) {
  idcli = id_cli;
  idpro = id_pro;
  cant = parseInt(cantidad + 1);
  cantidad_producto(idcli, idpro, cant);
}

function dismi_cantidad_prod(id_cli, id_pro, cantidad) {
  idcli = id_cli;
  idpro = id_pro;
  cant = parseInt(cantidad - 1);
  cantidad_producto(idcli, idpro, cant);
}

function cantidad_producto(idcli, idpro, cant) {
  funcion = "cantidad_producto_carrito";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      idcli: idcli,
      idpro: idpro,
      cant: cant,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        mostrar_carrito_compra_detalle();
      }
    } else if (response == 0) {
      alert("No se pudo aumentar el producto - ERROR MATRIX :(");
    } else {
      alerta = [
        "datos",
        "warning",
        "La cantidad ingresada, supera el stock '" +
          response +
          "', del producto :(",
      ];
      cerrar_loader_datos(alerta);
      Swal.fire(
        "Stock no disponible",
        "La cantidad ingresada esta al limite del '" +
          response +
          "', del producto :(",
        "warning"
      );
    }
  });
}

//////////////////////////
function count_carrito() {
  funcion = "count_carrito";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (response) {
    if (response != 100) {
      var data = JSON.parse(response);
      $("#count_cartt").html(data[0]);
      if (data[0] == 0) {
        $("#btn_vaciar_").css("display", "none");
      } else {
        $("#btn_vaciar_").show();
      }
    } else {
      $("#count_cartt").html("0");
      $("#btn_vaciar_").css("display", "none");
    }
  });
}

function vaciar_carrito() {
  Swal.fire({
    title: "Vaciar carrito de compras",
    text: "Desea vaciar todo el carrito de compras?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, vaciar!",
  }).then((result) => {
    if (result.isConfirmed) {
      funcion = "vaciar_carrito";

      $.ajax({
        url: "../ADMIN/controlador/carrito/carrito.php",
        type: "POST",
        data: {
          funcion: funcion,
        },
      }).done(function (response) {
        if (response == 1) {
          mostrar_carrito_compra_detalle();
          alerta = [
            "exito",
            "success",
            "El carrito de compras se vacio con exito",
          ];
          cerrar_loader_datos(alerta);
        } else {
          alerta = [
            "error",
            "error",
            "No se puedo vaciar el carrito, error en la matrix",
          ];
          cerrar_loader_datos(alerta);
        }
      });
    }
  });
}

//// procesar pago del cliente
function procesar_pago() {
  var tipo_pago = $("#tipo_pagoos").val();
  var total = $("#txt_grntotal").val();

  if (tipo_pago == "Transferencia") {
    $("#valor_tranferencia").val(total);
    $("#modal_tranferencia").modal({ backdrop: "static", keyboard: false });
    $("#modal_tranferencia").modal("show");
  } else {
    $("#valor_efectivo").val(total);
    $("#modal_efectivo").modal({ backdrop: "static", keyboard: false });
    $("#modal_efectivo").modal("show");
  }
}

////////////////////////
function listar_banco_combo() {
  funcion = "listar_banco_combo";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
    },
  }).done(function (response) {
    var data = JSON.parse(response);
    var cadena = "";
    if (data.length > 0) {
      //bucle para extraer los datos del rol
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" + data[i][0] + "'> " + data[i][1] + " </option>";
      }
      //aqui concadenamos al id del select
      $("#tipo_banco").html(cadena);
    } else {
      cadena += "<option value=''>No hay datos</option>";
      $("#tipo_banco").html(cadena);
    }
  });
}

function procesar_transferencia() {
  let timerInterval;
  Swal.fire({
    title: "Procesando información, transferencia!",
    html: "Procesando información, transferencia <b></b>",
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
      procesar_pago_producto();
    }
  });
}

function procesar_efectivo() {
  let timerInterval;
  Swal.fire({
    title: "Procesando información, pago en efectivo!",
    html: "Procesando información, pago en efectivo <b></b>",
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
      procesar_pago_producto_efectivo();
    }
  });
}

function procesar_pago_producto() {
  var direccion = $("#direccion_envio").val();
  var referencia = $("#refrencia_envio").val();
  var codigo = $("#codi_tranf").val();
  var foto = $("#comprobante_file").val();

  if (direccion.length == 0 || referencia.length == 0) {
    verificacion_direccion(direccion, referencia);
    $("#modal_tranferencia").modal("hide");
    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos, no debe quedar vacios",
      "warning"
    );
  } else {
    $("#direccion_envio_obligg").html("");
    $("#refrencia_envio_obligg").html("");
  }

  if (codigo.length == 0) {
    $("#codigo_tranferess_olgig").html("Ingrese codigo de transferencia");
    return swal.fire(
      "Campo vacios",
      "Debe ingresar el codigo de transferencia, no debe quedar vacios",
      "warning"
    );
  } else {
    $("#codigo_tranferess_olgig").html("");
  }

  if (foto.length == 0) {
    $("#comprobante_obligg").html("Ingrese la foto del comprobante");
    return swal.fire(
      "No hay foto",
      "Debe ingresar la foto del comprobante, no debe quedar vacios",
      "warning"
    );
  } else {
    $("#comprobante_obligg").html("");
  }

  var banco = $("#tipo_banco").val();

  if (banco.length == 0 || banco == "") {
    return swal.fire("Campo vacios", "No hay banco disponibles", "warning");
  }

  var fecha_transf = $("#fecha_tranferencia").val();
  var sub = $("#txt_subtotal").val();
  var impuesto = $("#txt_iva_total").val();
  var total = $("#txt_grntotal").val();
  var tipo_pago = $("#tipo_pagoos").val();
  var count = 0;

  $("#tabla_detalle_producto tbody#unnir_tabla_detalle tr").each(function () {
    count++;
  });

  alerta = ["datos", "Enviando información de compra", "Envindo información"];
  mostar_loader_datos(alerta);
  funcion = "registra_compra_tranferencia";

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
  var foto = $("#comprobante_file")[0].files[0];
  //est valores son como los que van en la data del ajax

  formdata.append("funcion", funcion);
  formdata.append("banco", banco);
  formdata.append("direccion", direccion);
  formdata.append("referencia", referencia);
  formdata.append("fecha_transf", fecha_transf);
  formdata.append("sub", sub);
  formdata.append("impuesto", impuesto);
  formdata.append("total", total);
  formdata.append("tipo_pago", tipo_pago);
  formdata.append("count", count);
  formdata.append("codigo", codigo);

  formdata.append("foto", foto);
  formdata.append("nombrearchivo", nombrearchivo);

  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      console.log(resp);

      if (resp == "no_clientes") {
        alerta = ["datos", "warning", "Debe iniciar sesión para comprar"];
        cerrar_loader_datos(alerta);
      } else if (resp == "no_foto") {
        alerta = ["datos", "warning", "Debe ingresar la foto del comprobante"];
        cerrar_loader_datos(alerta);
      } else {
        if (resp > 0) {
          registra_detalle_compra_trasnferenia(parseInt(resp));
        } else {
          alerta = ["error", "error", "Error de registro"];
          cerrar_loader_datos(alerta);
        }
      }
    },
  });
  return false;

  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      banco: banco,
      direccion: direccion,
      referencia: referencia,
      fecha_transf: fecha_transf,
      sub: sub,
      impuesto: impuesto,
      total: total,
      tipo_pago: tipo_pago,
      count: count,
      codigo: codigo,
    },
  }).done(function (response) {
    if (response != "no_clientes") {
      registra_detalle_compra_trasnferenia(parseInt(response));
    } else {
      alerta = ["datos", "warning", "Debe iniciar sesión para comprar"];
      cerrar_loader_datos(alerta);
    }
  });
}

function procesar_pago_producto_efectivo() {
  var direccion = $("#direccion_envio").val();
  var referencia = $("#refrencia_envio").val();

  if (direccion.length == 0 || referencia.length == 0) {
    verificacion_direccion(direccion, referencia);
    $("#modal_efectivo").modal("hide");
    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos, no debe quedar vacios",
      "warning"
    );
  } else {
    $("#direccion_envio_obligg").html("");
    $("#refrencia_envio_obligg").html("");
  }

  var fecha_efectivo = $("#fecha_efectivo").val();
  var sub = $("#txt_subtotal").val();
  var impuesto = $("#txt_iva_total").val();
  var total = $("#txt_grntotal").val();
  var tipo_pago = $("#tipo_pagoos").val();
  var count = 0;

  $("#tabla_detalle_producto tbody#unnir_tabla_detalle tr").each(function () {
    count++;
  });

  alerta = ["datos", "Enviando información de compra", "Envindo información"];
  mostar_loader_datos(alerta);
  funcion = "registra_compra_efectivo";

  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      direccion: direccion,
      referencia: referencia,
      fecha_efectivo: fecha_efectivo,
      sub: sub,
      impuesto: impuesto,
      total: total,
      tipo_pago: tipo_pago,
      count: count,
    },
  }).done(function (response) {
    if (response != "no_clientes") {
      registra_detalle_compra_trasnferenia(parseInt(response));
    } else {
      alerta = ["datos", "warning", "Debe iniciar sesión para comprar"];
      cerrar_loader_datos(alerta);
    }
  });
}

function verificacion_direccion(direccion, referencia) {
  if (direccion.length == 0) {
    $("#direccion_envio_obligg").html("Ingrese dirección envio");
  } else {
    $("#nombres_oblig").html("");
  }

  if (referencia.length == 0) {
    $("#refrencia_envio_obligg").html("Ingrese referencia envio");
  } else {
    $("#refrencia_envio_obligg").html("");
  }
}

function registra_detalle_compra_trasnferenia(id) {
  funcion = "registra_detalle_compra_trasnferenia";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
    },
  }).done(function (resp) {
    if (resp == 1) {
      Swal.fire({
        title: "Compra realizada con exito!!",
        text: "Desea imprimir la factura de venta??",
        icon: "warning",
        html:
          "Ingrese a su</b> " +
          '<a target="_blank" href="../CLIENTE/">CUENTA</a> ' +
          "de cliente, podrá visualizar las compras del carrito",
        showCancelButton: true,
        showConfirmButton: true,
        allowOutsideClick: false,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, ver!!",
      }).then((result) => {
        if (result.value) {
          // location.reload();
          window.open(
            "../ADMIN/REPORTES/Pdf/factura_venta_online.php?id=" +
              parseInt(id) +
              "#zoom=100%",
            "Factura venta",
            "scrollbards=No"
          );
        }
        location.href = "index.php";
      });
    } else {
      alerta = [
        "error",
        "error",
        "La compra mo se realizo con exito - FALLA EN LA MATRIX :(;",
      ];
      cerrar_loader_datos(alerta);
    }
  });
}

//////////////
/////////
function listar_ventas_productos_cliente() {
  funcion = "listar_ventas_productos_cliente";
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
      url: "../ADMIN/controlador/carrito/carrito.php",
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
            return `<button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
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
      { data: "tipo_doc" },
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

/////////
function listar_venta_servicios_cliente() {
  funcion = "listar_venta_servicios_cliente";
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
      url: "../ADMIN/controlador/carrito/carrito.php",
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
            return `<button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
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
      { data: "tipo_doc" },
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

/////////
function listar_ventas_onlinee_productos_cliente() {
  funcion = "listar_ventas_onlinee_productos_cliente";
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
      url: "../ADMIN/controlador/carrito/carrito.php",
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
            return `<button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
          } else {
            return `<button style='font-size:13px;' type='button' class='ver btn btn-warning' title='ver detalle'><i class='fa fa-eye'></i></button> - <button style='font-size:13px;' type='button' class='pfd btn btn-primary' title='ver reporte'><i class='fa fa-file'></i></button>`;
          }
        },
      },
      {
        data: "estado",
        render: function (data, type, row) {
          if (data == 1) {
            return "<span class='label label-success'>Comprado</span>";
          } else {
            return "<span class='label label-danger'>Anulado</span>";
          }
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

/////////
function lista_transferencia_bancaria_cliente() {
  funcion = "lista_transferencia_bancaria_cliente";
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
      url: "../ADMIN/controlador/carrito/carrito.php",
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
              "' download><i class='fa fa-download'></i> Foto subida</a>"
            );
          } else {
            return "<button class='btn_fotoo btn btn-info'><i class='fa fa-upload'></i> Subir foto</button>";
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

$("#tabla_transferencia").on("click", ".btn_fotoo", function () {
  //esto esta extrayendo los datos de la tabla el (data)
  var data = tabla_transferencia.row($(this).parents("tr")).data(); //a que fila deteta que doy click
  //esta condicion es importante para el responsibe porque salda un error si no lo pongo
  if (tabla_transferencia.row(this).child.isShown()) {
    //esto es cuando esta en tamaño responsibo
    var data = tabla_transferencia.row(this).data();
  }

  var id = data.transferencia_id;
  var id_venta = data.id_venta_online;

  $("#id_transferencia").val(id);
  $("#id_venta_onlinee").val(id_venta);

  $("#modal_photo_comprobante").modal({ backdrop: "static", keyboard: false });
  $("#modal_photo_comprobante").modal("show");
});

function cargar_foto_transferencia() {
  var id = document.getElementById("id_transferencia").value;
  var id_venta = document.getElementById("id_venta_onlinee").value;
  var foto = document.getElementById("foto_trans").value;

  if (foto == "" || foto.length == 0 || foto == "") {
    return swal.fire(
      "Mensaje de advertencia",
      "Ingrese la imagen de la transferencia",
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
  var foto = $("#foto_trans")[0].files[0];

  //est valores son como los que van en la data del ajax
  funcion = "subir_phto_transa";
  formdata.append("funcion", funcion);
  formdata.append("id", id);
  formdata.append("id_venta", id_venta);
  formdata.append("foto", foto);
  formdata.append("nombrearchivo", nombrearchivo);

  alerta = [
    "datos",
    "Subiendo foto de transferencia bancaria",
    "Cargando foto",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      console.log(resp);
      if (resp > 0) {
        if (resp == 1) {
          document.getElementById("foto_trans").value = "";
          tabla_transferencia.ajax.reload();
          alerta = ["exito", "success", "La foto se subio con exi"];
          cerrar_loader_datos(alerta);
          $("#modal_photo_comprobante").modal("hide");
        }
      } else {
        alerta = ["error", "error", "No se pudo editar la foto de producto"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

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
      url: "../ADMIN/controlador/carrito/carrito.php",
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
              "' download><i class='fa fa-download'></i> Foto subida</a>"
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

//////////// calificar
function calificar_producto(id) {
  $("#calificacion_cliente_exito_p").hide();
  document.getElementById("nesecita_calif_p").checked = false;
  document.getElementById("regular_cali_p").checked = false;
  document.getElementById("bueno_calif_p").checked = false;
  document.getElementById("muy_bueno_calif_p").checked = false;
  document.getElementById("excelente_calif_p").checked = false;
  document.getElementById("comentario_p").value = "";

  funcion = "traer_foto_producto";
  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      id: id,
    },
  }).done(function (response) {
    var data = JSON.parse(response);
    $("#id_producto_p").val(id);
    $("#foto_producto_p").attr("src", "../ADMIN/" + data[0]);
    $("#modal_calificar_producto_normal").modal({
      backdrop: "static",
      keyboard: false,
    });
    $("#modal_calificar_producto_normal").modal("show");
  });
}

function calificar_producto_p() {
  var estrella = "";
  var nesecita_calif = document.getElementById("nesecita_calif_p").checked;
  var regular_cali = document.getElementById("regular_cali_p").checked;
  var bueno_calif = document.getElementById("bueno_calif_p").checked;
  var muy_bueno_calif = document.getElementById("muy_bueno_calif_p").checked;
  var excelente_calif = document.getElementById("excelente_calif_p").checked;
  var comentario = document.getElementById("comentario_p").value;
  var id = document.getElementById("id_producto_p").value;

  if (nesecita_calif == true) {
    estrella = "Necesita Mejorar";
  } else if (regular_cali == true) {
    estrella = "Regular";
  } else if (bueno_calif == true) {
    estrella = "Bueno";
  } else if (muy_bueno_calif == true) {
    estrella = "Muy Bueno";
  } else if (excelente_calif == true) {
    estrella = "Excelente";
  } else {
    estrella = "";
  }

  if (estrella == "") {
    return swal.fire(
      "No hay calificación",
      "Debe ingresar una calificación para continuar.",
      "warning"
    );
  }

  if (comentario.length == 0 || comentario.text == "" || comentario == "") {
    $("#comentario_olbigg_p").html("Ingresar un comentario para continuar");
    return swal.fire(
      "No hay comentario",
      "Debe ingresar una comentario para continuar.",
      "warning"
    );
  } else {
    $("#comentario_olbigg_p").html("");
  }

  funcion = "calificar_poducto_pp";
  alerta = [
    "datos",
    "Se esta enviando su calificación",
    "Enviando calificación",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/carrito/carrito.php",
    type: "POST",
    data: {
      funcion: funcion,
      estrella: estrella,
      comentario: comentario,
      id: id,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        document.getElementById("nesecita_calif_p").checked = false;
        document.getElementById("regular_cali_p").checked = false;
        document.getElementById("bueno_calif_p").checked = false;
        document.getElementById("muy_bueno_calif_p").checked = false;
        document.getElementById("excelente_calif_p").checked = false;
        document.getElementById("comentario_p").value = "";

        $("#calificacion_cliente_exito_p").show(2000);
        alerta = ["exito", "success", "La calificación se envio con exito"];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "Error al enviar calificación"];
      cerrar_loader_datos(alerta);
    }
  });
}
