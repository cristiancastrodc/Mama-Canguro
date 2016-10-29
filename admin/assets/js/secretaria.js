$(document).ready(function () {

  $("#toggleNuevoPaciente").click(function () {
    $("#divTogglePaciente").slideToggle();
  });

  $("#toggleListaPacientes").click(function () {
    $("#divToggleListaPacientes").slideToggle();
  });

  $("#toggleServicios").click(function () {
    $("#no-more-tables").slideToggle();
  });

  $("#generarNuevoPaciente").click(function () {
    $.ajax({
      method: "GET",
      url: "form-nuevo-paciente.php"
    })
    .done(function ( data ) {
      $("#nuevoPaciente").html ( data );
    });
  });

  $("#txtDNI").keyup(function () {
    var dni_paciente = $("#txtDNI").val();
    if (dni_paciente.length == 8) {
      $("#paciente").css("display", "block");
      $.ajax({
        method: "GET",
        url: "form-atender-paciente.php",
        dataType: "json",
        data: {
          dni : dni_paciente
        }
      })
      .done (function ( data ) {
        var existe = data.existePaciente;
        var contenido = data.divPaciente;
        if (existe == 1) {
          $("#paciente").html ( contenido );
          $("#lista-servicios").css("display", "block");
        } else {
          $("#paciente").html ( contenido );
          $("#lista-servicios").css("display", "none");
          $("#contenidoServicio").css("display", "none");
          $("#contenidoServicio").html( "" );
        }
      }); 
    } else {
      $("#paciente").css("display", "none");
      $("#paciente").html( "" );
      $("#lista-servicios").css("display", "none");
      $("#contenidoServicio").css("display", "none");
      $("#contenidoServicio").html( "" );
    }
  });
});

function recuperarServicio ( idServicio ){
  var id_paciente = $("#txtIdentificador").val();
  $("#no-more-tables").slideToggle();
  $("#contenidoServicio").css("display", "block");
  $.ajax({
    method: "GET",
    url: "form-mostrar-servicio.php",
    data: {
      servicio : idServicio,
      idpaciente : id_paciente
    }
  })
  .done (function ( data ) {
    $("#contenidoServicio").html ( data );
    var precio = $("#txtPrecio").val();
    $("#txtTotal").val( precio );
    $("#txtDescuento").keyup(function () {
      var precio = $("#txtPrecio").val();
      precio = Number(precio.substring(3));
      var descuento = $("#txtDescuento").val();
      descuento = Number(descuento);
      if (descuento <= precio) {
        var total = precio - descuento;
        total = "S/. " + total;
        $("#txtTotal").val( total );
      } else {
        precio = "S/. " + precio;
        $("#txtTotal").val( precio );
      }
    });
    $("#txtPrecio").keyup(function () {
      var precio = $("#txtPrecio").val();
      precio = Number(precio.substring(3));
      var descuento = $("#txtDescuento").val();
      descuento = Number(descuento);
      if (descuento <= precio) {
        var total = precio - descuento;
        total = "S/. " + total;
        $("#txtTotal").val( total );
      } else {
        precio = "S/. " + precio;
        $("#txtTotal").val( precio );
      }
    });
  });
}