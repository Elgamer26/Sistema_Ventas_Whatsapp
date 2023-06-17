var funcion, tabña_respaldoo;

function traer_datos_de_empresa() {
  funcion = "traer_datos_de_empresa";
  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (resp) {
    var data = JSON.parse(resp);
    if (data.length > 0) {
      document.getElementById("nombres_empresa").value = data[0][1];
      document.getElementById("ruc_empresa").value = data[0][2];
      document.getElementById("direccion_empresa").value = data[0][3];
      document.getElementById("telefono_empresa").value = data[0][4];
      document.getElementById("correo_empresa").value = data[0][5];
      document.getElementById("propietario_empresa").value = data[0][6];
      document.getElementById("descripcion_empresa").innerHTML = data[0][7];
      document.getElementById("IVA").value = data[0][9];

      document.getElementById("foto_empresa").src = data[0][8];
      document.getElementById("foto_actual").value = data[0][8];
    }
  });
}

function cambiar_foto_perfil_empresa() {
  var foto = document.getElementById("foto_nueva").value;
  var ruta_actual = document.getElementById("foto_actual").value;

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
  var foto = $("#foto_nueva")[0].files[0];

  //est valores son como los que van en la data del ajax
  funcion = "cambiar_foto_perfilempresa";
  formdata.append("funcion", funcion);
  formdata.append("foto", foto);
  formdata.append("ruta_actual", ruta_actual);
  formdata.append("nombrearchivo", nombrearchivo);

  alerta = [
    "datos",
    "Se esta editando la imagen de empresa",
    "Editando imagen empresa",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          document.getElementById("foto_nueva").value = "";
          traer_datos_de_empresa();
          alerta = [
            "exito",
            "success",
            "La foto de empresa se edito con exito",
          ];
          cerrar_loader_datos(alerta);
        }
      } else {
        alerta = ["error", "error", "No se pudo editar la foto de empresa"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

function editra_datos_empresa() {
  var nomber = document.getElementById("nombres_empresa").value;
  var ruc = document.getElementById("ruc_empresa").value;
  var direcc = document.getElementById("direccion_empresa").value;
  var telefono = document.getElementById("telefono_empresa").value;
  var correo = document.getElementById("correo_empresa").value;
  var dueño = document.getElementById("propietario_empresa").value;
  var descrp = document.getElementById("descripcion_empresa").value;
  var IVA = document.getElementById("IVA").value;

  if (
    nomber.length == 0 ||
    ruc.length == 0 ||
    direcc.length == 0 ||
    telefono.length == 0 ||
    correo.length == 0 ||
    dueño.length == 0 ||
    descrp.length == 0 ||
    IVA.length == 0
  ) {
    validar_registro(nomber, ruc, direcc, telefono, correo, dueño, descrp, IVA);

    return swal.fire(
      "Mensaje de alerta",
      "Ingrese todo los datos, no debe quedar ningun dato vacio",
      "warning"
    );
  } else {
    $("#nombre_empresa_oblig").html("");
    $("#ruc_obliga").html("");
    $("#dirccion_obliga").html("");
    $("#telefono_empresa").html("");
    $("#correo_empresa").html("");
    $("#propietraio_obliga").html("");
    $("#descripcion_obliga").html("");
    $("#Iva_obliga").html("");
  }

  funcion = "cambiar_datos_empresa";
  alerta = [
    "datos",
    "Se esta modificando los datos de perfil",
    "Cambiando datos del usuario",
  ];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: {
      funcion: funcion,
      nomber: nomber,
      ruc: ruc,
      direcc: direcc,
      telefono: telefono,
      correo: correo,
      dueño: dueño,
      descrp: descrp,
      iva: IVA
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        traer_datos_de_empresa();
        alerta = [
          "exito",
          "success",
          "Los datos de empresa se actualizo con exito",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "No se pudo actualizar el registro"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_registro(
  nomber,
  ruc,
  direcc,
  telefono,
  correo,
  dueño,
  descrp,
  IVA
) {
  if (nomber.length == 0) {
    $("#nombre_empresa_oblig").html("Ingrese nombre de empresa");
  } else {
    $("#nombre_empresa_oblig").html("");
  }

  if (ruc.length == 0) {
    $("#ruc_obliga").html("Ingrese ruc empresa");
  } else {
    $("#ruc_obliga").html("");
  }

  if (direcc.length == 0) {
    $("#dirccion_obliga").html("Ingrese direccion");
  } else {
    $("#dirccion_obliga").html("");
  }

  if (telefono.length == 0) {
    $("#telefono_empresa").html("Ingrese telefono empresa");
  } else {
    $("#telefono_empresa").html("");
  }

  if (correo.length == 0) {
    $("#correo_empresa").html("Ingrese correo empresa");
  } else {
    $("#correo_empresa").html("");
  }

  if (dueño.length == 0) {
    $("#propietraio_obliga").html("Ingrese propietario de la empresa");
  } else {
    $("#propietraio_obliga").html("");
  }

  if (descrp.length == 0) {
    $("#descripcion_obliga").html("Ingrese descripcion de la empresa");
  } else {
    $("#descripcion_obliga").html("");
  }

  if (IVA.length == 0) {
    $("#Iva_obliga").html("Ingrese IVA");
  } else {
    $("#Iva_obliga").html("");
  }
}

/////////cliente usuario
function traer_datos_cliente() {
  funcion = "traer_datos_cliente";
  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (responce) {
    if (responce != 0) {
      var data = JSON.parse(responce);
      $("#nombress").val(data[0][1]);
      $("#apellidoss").val(data[0][2]);
      $("#direccions").val(data[0][5]);
      $("#telefono_p").val(data[0][8]);
      $("#correo_p").val(data[0][4]);
      $("#sexo").val(data[0][6]);
      $("#numero_docu").val(data[0][3]);
      $("#password_cl").val(data[0][9]);
    }
  });
}

function actualizar_datos() {
  var nombress = document.getElementById("nombress").value;
  var apellidoss = document.getElementById("apellidoss").value;
  var numero_docu = document.getElementById("numero_docu").value;
  var telefono_p = document.getElementById("telefono_p").value;
  var correo_p = document.getElementById("correo_p").value;
  var direccions = document.getElementById("direccions").value;
  var sexo = document.getElementById("sexo").value;
  var password = document.getElementById("password_cl").value;
  var password_cl_c = document.getElementById("password_cl_c").value;

  if (
    nombress.length == 0 ||
    apellidoss.length == 0 ||
    numero_docu.length == 0 ||
    telefono_p.length == 0 ||
    correo_p.length == 0 ||
    direccions.length == 0 ||
    password.length == 0
  ) {
    validar_editar_actalizar(
      nombress,
      apellidoss,
      numero_docu,
      telefono_p,
      correo_p,
      direccions,
      password
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
    $("#passwordd_obliga").html("");
  }

  if (password != password_cl_c) {
    $("#passwordd_obliga_c").html("Confirmar password");
    $("#passwordd_obliga").html("Confirmar password");
    return swal.fire(
      "Password no coinciden",
      "Ingrese el password correctamente",
      "warning"
    );
  } else {
    $("#passwordd_obliga_c").html("");
    $("#passwordd_obliga").html("");
  }

  if(!pass_usus_cli){
    return swal.fire(
      "",
      "Ingrese un password mas fuerte para su cuenta de usuario",
      "warning"
    );
  }

  funcion = "actuaizar_datos_ciente";
  alerta = ["datos", "Se esta editando los datos", "Editando datos"];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
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
        document.getElementById("password_cl_c").value = "";
        $("#modal_editar_cliente").modal("hide");
        alerta = ["exito", "success", "Los datos se actualizaron con exito"];
        cerrar_loader_datos(alerta);
        traer_datos_cliente();
      } else if (resp == 2) {
        alerta = [
          "existe",
          "warning",
          "La cedula " + numero_docu + ", ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      } else if (resp == 3) {
        alerta = [
          "existe",
          "warning",
          "El correo " + correo_p + ", ya esta registrado",
        ];
        cerrar_loader_datos(alerta);
      }
    } else {
      alerta = ["error", "error", "Error al editar el cliente"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_editar_actalizar(
  nombress,
  apellidoss,
  numero_docu,
  telefono_p,
  correo_p,
  direccions,
  password
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
    $("#passwordd_obliga").html("Ingrese password");
  } else {
    $("#passwordd_obliga").html("");
  }
}

//////////////
/////////// traer datos de accesos de usuario
function permisos_modulos_usuario() {
  funcion = "obtener_permisos_usuario_logeado";
  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (response) {
    var data = JSON.parse(response);

    data[0]["usuario"].toString() == "true"
      ? $("#usuario_modulo").css("display", "block")
      : $("#usuario_modulo").css("display", "none");

    data[0]["cliente"].toString() == "true"
      ? $("#cliente_modulo").css("display", "block")
      : $("#cliente_modulo").css("display", "none");

    data[0]["proveedor"].toString() == "true"
      ? $("#proveedor_modulo").css("display", "block")
      : $("#proveedor_modulo").css("display", "none");

    data[0]["datos_empresa"].toString() == "true"
      ? $("#empresa_modulo").css("display", "block")
      : $("#empresa_modulo").css("display", "none");

    data[0]["banco"].toString() == "true"
      ? $("#banco_modulo").css("display", "block")
      : $("#banco_modulo").css("display", "none");

    data[0]["tipo_servicio"].toString() == "true"
      ? $("#tipo_servicio_modulo").css("display", "block")
      : $("#tipo_servicio_modulo").css("display", "none");

    data[0]["producto"].toString() == "true"
      ? $("#productos_modulo").css("display", "block")
      : $("#productos_modulo").css("display", "none");

    data[0]["compras"].toString() == "true"
      ? $("#compras_modulo").css("display", "block")
      : $("#compras_modulo").css("display", "none");

    data[0]["facturacion"].toString() == "true"
      ? $("#facturacion_modulo").css("display", "block")
      : $("#facturacion_modulo").css("display", "none");

    data[0]["calificacion"].toString() == "true"
      ? $("#califcaion_modulo").css("display", "block")
      : $("#califcaion_modulo").css("display", "none");

    data[0]["ventas_online"].toString() == "true"
      ? $("#venta_online_modulo").css("display", "block")
      : $("#venta_online_modulo").css("display", "none");

    data[0]["tipos_pagos"].toString() == "true"
      ? $("#tipo_pago_modulo").css("display", "block")
      : $("#tipo_pago_modulo").css("display", "none");

    data[0]["envios"].toString() == "true"
      ? $("#envios_modulo").css("display", "block")
      : $("#envios_modulo").css("display", "none");

    data[0]["registro_promo"].toString() == "true"
      ? $("#registro_promo_modulo").css("display", "block")
      : $("#registro_promo_modulo").css("display", "none");

    data[0]["promo_vigentes"].toString() == "true"
      ? $("#promocion_vigentes_modulo").css("display", "block")
      : $("#promocion_vigentes_modulo").css("display", "none");

    data[0]["reportes"].toString() == "true"
      ? $("#reportes_modulo").css("display", "block")
      : $("#reportes_modulo").css("display", "none");
  });
}

/////////////////
//////////////////////////////// grafico de productos mas comprados top 5
function productos_mas_comprados() {
  var tipo_grafico = "doughnut";
  var nombre_grafico = "Dona";
  funcion = "productos_mas_comprados";
  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: {
      funcion: funcion,
    },
  }).done(function (response) {
    if (response != 0) {
      var nombre_pr = [];
      var cantidad = [];
      var colores = [];
      var data = JSON.parse(response);
      for (var i = 0; i < data.length; i++) {
        nombre_pr.push(data[i][0]);
        cantidad.push(data[i][1]);
        colores.push(colores_rgb());
      }
      mostrar_graficos_cinco_productos(
        nombre_pr,
        cantidad,
        tipo_grafico,
        nombre_grafico,
        colores
      );
    } else {
      $("canvas#char_producto").remove();
    }
  });
}

function mostrar_graficos_cinco_productos(
  nombre_pr,
  cantidad,
  tipo_grafico,
  nombre_grafico,
  colores
) {
  //esto es para desctuir el grafico porque sale un error
  $("canvas#char_producto").remove();
  $("div.chart_p").append(
    '<canvas id="char_producto" style="height:260px;"></canvas>'
  );
  ///este es el grafico

  var ctx = document.getElementById("char_producto").getContext("2d");
  var myChart = new Chart(ctx, {
    type: tipo_grafico,
    data: {
      labels: nombre_pr,
      datasets: [
        {
          label: nombre_grafico,
          data: cantidad,
          backgroundColor: colores,
          borderColor: colores,
          borderWidth: 1,
        },
      ],
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

//////////////////////////////// grafico de servicios mas comprados top 5
function servicios_mas_comprados() {
  var tipo_grafico = "pie";
  var nombre_grafico = "Pastel";
  funcion = "servicios_mas_comprados";
  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: {
      funcion: funcion,
    },
  }).done(function (response) {
    if (response != 0) {
      var nombre_pr = [];
      var cantidad = [];
      var colores = [];
      var data = JSON.parse(response);
      for (var i = 0; i < data.length; i++) {
        nombre_pr.push(data[i][0]);
        cantidad.push(data[i][1]);
        colores.push(colores_rgb());
      }
      mostrar_graficos_cinco_servicios(
        nombre_pr,
        cantidad,
        tipo_grafico,
        nombre_grafico,
        colores
      );
    } else {
      $("canvas#char_servicios").remove();
    }
  });
}

function mostrar_graficos_cinco_servicios(
  nombre_pr,
  cantidad,
  tipo_grafico,
  nombre_grafico,
  colores
) {
  //esto es para desctuir el grafico porque sale un error
  $("canvas#char_servicios").remove();
  $("div.chart_s").append(
    '<canvas id="char_servicios" style="height:260px;"></canvas>'
  );
  ///este es el grafico

  var ctx = document.getElementById("char_servicios").getContext("2d");
  var myChart = new Chart(ctx, {
    type: tipo_grafico,
    data: {
      labels: nombre_pr,
      datasets: [
        {
          label: nombre_grafico,
          data: cantidad,
          backgroundColor: colores,
          borderColor: colores,
          borderWidth: 1,
        },
      ],
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

////////////////////////////para el dashboard
function traer_datos_dasboard_admin() {
  funcion = "traer_datos_dasboard_admin";
  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (response) {
    var data = JSON.parse(response);
    $("#count_p").html(data[0]["productos"]);
    $("#count_s").html(data[0]["servicios"]);
    $("#count_c").html(data[0]["clientes"]);
    $("#count_o").html(data[0]["ofertas"]);
  });
}

////////////////////////////para el usuario logeado
function traer_datos_usuario_perfil() {
  funcion = "traer_usuario_perfil";
  $.ajax({
    url: "../ADMIN/controlador/usuario/usuario.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (responce) {
    if (responce != 0) {
      var data = JSON.parse(responce);
      $("#nombres_usu_uno").html(data[0]["nombres"]);
      $("#rol_usu").html(data[0]["tipo_usuario"]);
      $("#imagen_usu_uno").attr("src", "../ADMIN/" + data[0]["foto"]);
      $("#imagen_usu_dos").attr("src", "../ADMIN/" + data[0]["foto"]);
      $("#usuario_usu_usu").html(data[0]["usuario"]);
      $("#pass_oculto").val(data[0]["password"]);
      $("#id_usu_usu").val(data[0]["id_usuario"]);
    }
  });
}

function modal_password() {
  $("#password_actual_oblig").html("");
  $("#password_nuevo_oblig").html("");
  $("#password_repetir_oblig").html("");

  $("#modal_edit__pasword_usu").modal({
    backdrop: "static",
    keyboard: false,
  });
  $("#modal_edit__pasword_usu").modal("show");
}

function editar_password_usu() {
  var id = $("#id_usu_usu").val();
  var oculto = $("#pass_oculto").val();
  var actual = $("#password_actual").val();
  var nuevo = $("#password_nuevo").val();
  var repetir = $("#password_repetir").val();

  if (actual.length == 0 || nuevo.length == 0 || repetir.length == 0) {
    validar_password_usuario(actual, nuevo, repetir);

    return swal.fire(
      "Campo vacios",
      "Debe ingresar todos los datos en los campos",
      "warning"
    );
  } else {
    $("#password_actual_oblig").html("");
    $("#password_nuevo_oblig").html("");
    $("#password_repetir_oblig").html("");
  }

  if (oculto != actual) {
    $("#password_actual_oblig").html("Password incorrecto");
    return swal.fire(
      "Password incorrecto!",
      "El password ingresado es incorrecto",
      "warning"
    );
  } else {
    $("#password_actual_oblig").html("");
  }

  if (nuevo != repetir) {
    $("#password_nuevo_oblig").html("Password no coinciden");
    $("#password_repetir_oblig").html("Password no coinciden");
    return swal.fire(
      "Password no coinciden!",
      "Ingrese los password correctamente",
      "warning"
    );
  } else {
    $("#password_nuevo_oblig").html("");
    $("#password_repetir_oblig").html("");
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
      nombre: nuevo,
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        $("#password_actual").val("");
        $("#password_nuevo").val("");
        $("#password_repetir").val("");

        alerta = ["exito", "success", "El password se edito con exito"];
        cerrar_loader_datos(alerta);
        traer_datos_usuario_perfil();
        $("#modal_edit__pasword_usu").modal("hide");
      }
    } else {
      alerta = ["error", "error", "Error al editar el password"];
      cerrar_loader_datos(alerta);
    }
  });
}

function validar_password_usuario(actual, nuevo, repetir) {
  if (actual.length == 0) {
    $("#password_actual_oblig").html("Ingrese password actual");
  } else {
    $("#password_actual_oblig").html("");
  }

  if (nuevo.length == 0) {
    $("#password_nuevo_oblig").html("Ingrese password nuevo");
  } else {
    $("#password_nuevo_oblig").html("");
  }

  if (repetir.length == 0) {
    $("#password_repetir_oblig").html("Repetir password");
  } else {
    $("#password_repetir_oblig").html("");
  }
}

function verificar_ofertas() {
  funcion = "verificar_ofertas";
  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: {
      funcion: funcion,
    },
  }).done(function (resp) {
    console.log(resp);
  });
}

/////////////// subiir fotos de la página web
function subir_foto_1() {
  var foto1 = document.getElementById("foto1").value;
  var foto1_ruta = document.getElementById("foto1_ruta").value;

  if (foto1.length == 0) {
    return swal.fire("No hay foto", "Debe ingresar la foto", "warning");
  }

  //para scar la fecha para la foto
  var f = new Date();
  //este codigo me captura la extenion del archivo
  var extecion = foto1.split(".").pop();
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
  var foto = $("#foto1")[0].files[0];
  //est valores son como los que van en la data del ajax

  alerta = ["datos", "Se esta cambiando la foto", "Cambiando foto"];
  mostar_loader_datos(alerta);

  funcion = "cambiat_foto_1";

  formdata.append("funcion", funcion);
  formdata.append("foto", foto);
  formdata.append("ruta_actual", foto1_ruta);
  formdata.append("nombrearchivo", nombrearchivo);

  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          traer_datos_web();
          alerta = ["exito", "success", "La foto se cambio con exito"];
          cerrar_loader_datos(alerta);
          cargar_contenido(
            "contenido_principal",
            "vista/usuario/pagina_web.php"
          );
        }
      } else {
        alerta = ["error", "error", "Error al cambiar la foto"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

function subir_foto_2() {
  var foto2 = document.getElementById("foto2").value;
  var foto2_ruta = document.getElementById("foto2_ruta").value;

  if (foto2.length == 0) {
    return swal.fire("No hay foto", "Debe ingresar la foto", "warning");
  }

  //para scar la fecha para la foto
  var f = new Date();
  //este codigo me captura la extenion del archivo
  var extecion = foto2.split(".").pop();
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
  var foto = $("#foto2")[0].files[0];
  //est valores son como los que van en la data del ajax

  alerta = ["datos", "Se esta cambiando la foto", "Cambiando foto"];
  mostar_loader_datos(alerta);

  funcion = "cambiat_foto_2";

  formdata.append("funcion", funcion);
  formdata.append("foto", foto);
  formdata.append("ruta_actual", foto2_ruta);
  formdata.append("nombrearchivo", nombrearchivo);

  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          traer_datos_web();
          alerta = ["exito", "success", "La foto se cambio con exito"];
          cerrar_loader_datos(alerta);
          cargar_contenido(
            "contenido_principal",
            "vista/usuario/pagina_web.php"
          );
        }
      } else {
        alerta = ["error", "error", "Error al cambiar la foto"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

function subir_foto_3() {
  var foto3 = document.getElementById("foto3").value;
  var foto3_ruta = document.getElementById("foto3_ruta").value;

  if (foto3.length == 0) {
    return swal.fire("No hay foto", "Debe ingresar la foto", "warning");
  }

  //para scar la fecha para la foto
  var f = new Date();
  //este codigo me captura la extenion del archivo
  var extecion = foto3.split(".").pop();
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
  var foto = $("#foto3")[0].files[0];
  //est valores son como los que van en la data del ajax

  alerta = ["datos", "Se esta cambiando la foto", "Cambiando foto"];
  mostar_loader_datos(alerta);

  funcion = "cambiat_foto_3";

  formdata.append("funcion", funcion);
  formdata.append("foto", foto);
  formdata.append("ruta_actual", foto3_ruta);
  formdata.append("nombrearchivo", nombrearchivo);

  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    //aqui envio toda la formdata
    data: formdata,
    contentType: false,
    processData: false,
    success: function (resp) {
      if (resp > 0) {
        if (resp == 1) {
          traer_datos_web();
          alerta = ["exito", "success", "La foto se cambio con exito"];
          cerrar_loader_datos(alerta);
          cargar_contenido(
            "contenido_principal",
            "vista/usuario/pagina_web.php"
          );
        }
      } else {
        alerta = ["error", "error", "Error al cambiar la foto"];
        cerrar_loader_datos(alerta);
      }
    },
  });
  return false;
}

function editar_detalle_foto() {
  var detalle1 = $("#detalle_1").val();
  var detalle2 = $("#detalle_2").val();
  var detalle3 = $("#detalle_3").val();

  if (detalle1.length == 0 || detalle2.length == 0 || detalle3.length == 0) {
    if (detalle1.length == 0) {
      $("#lbldetalle_1").html("Ingrese detalle");
    } else {
      $("#lbldetalle_1").html("");
    }

    if (detalle2.length == 0) {
      $("#lbldetalle_2").html("Ingrese detalle");
    } else {
      $("#lbldetalle_2").html("");
    }

    if (detalle3.length == 0) {
      $("#lbldetalle_3").html("Ingrese detalle");
    } else {
      $("#lbldetalle_3").html("");
    }

    return Swal.fire({
      icon: "warning",
      title: "Campos vacios",
      text: "Ingrese datos en los campos vacios",
    });
  }else{
    $("#lbldetalle_1").html("");
    $("#lbldetalle_2").html("");
    $("#lbldetalle_3").html("");
  }

  funcion = "editar_detalle_foto";
  alerta = ["datos", "Se esta cambiando el detalle de las fotos", "Creando detalle..."];
  mostar_loader_datos(alerta);

  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: {
      funcion: funcion,
      detalle1: detalle1,
      detalle2: detalle2,
      detalle3: detalle3
    },
  }).done(function (response) {
    if (response > 0) {
      if (response == 1) {
        traer_datos_web
        alerta = ["exito", "success", "El detalle de las fotos se cambio con exito"];
        cerrar_loader_datos(alerta);
      } 
    } else {
      alerta = ["error", "error", "No se pudo cambiar el detalle de las fotos"];
      cerrar_loader_datos(alerta);
    }
  });
}

function traer_datos_web() {
  funcion = "traer_datos_web";
  $.ajax({
    url: "../ADMIN/controlador/system/system.php",
    type: "POST",
    data: { funcion: funcion },
  }).done(function (resp) {
    var data = JSON.parse(resp);
    if (data.length > 0) {
      document.getElementById("foto1_ruta").value = data[0]["foto1"];
      document.getElementById("foto2_ruta").value = data[0]["foto2"];
      document.getElementById("foto3_ruta").value = data[0]["foto3"];

      document.getElementById("foto_view_1").src = data[0]["foto1"];
      document.getElementById("foto_view_2").src = data[0]["foto2"];
      document.getElementById("foto_view_3").src = data[0]["foto3"];

      document.getElementById("detalle_1").value = data[0]["detalle1"];
      document.getElementById("detalle_2").value = data[0]["detalle2"];
      document.getElementById("detalle_3").value = data[0]["detalle3"];
    }
  });
}
