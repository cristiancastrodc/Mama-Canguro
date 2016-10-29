$(document).ready(function () {
  $("#txtdni").keyup(function () {
    var dni_paciente = $("#txtdni").val();
    if (dni_paciente.length == 8) {
      $.ajax({
        method: "GET",
        url: "recuperar-paciente-atencion-otros.php",
        dataType: "json",
        data: {
          dni : dni_paciente
        }
      })
      .done (function (data) {
        var existe = data.existePaciente;
        var contenido = data.divPaciente;
        if (existe == 1) {
          $("#paciente").html ( contenido );
          $("#paciente").css("display", "block");
          $("#contenido").css("display", "block");
          $("#txtServicio").val( "" );
          $("#tabla_servicios").css("display", "none");
          $("#tabla_servicios").html( "" );
        } else {
          $("#paciente").html ( contenido );
          $("#paciente").css("display", "block");
          $("#contenido").css("display", "none");
          $("#txtServicio").val( "" );
          $("#tabla_servicios").css("display", "none");
          $("#tabla_servicios").html( "" );
        }
      });
    } else {
      $("#paciente").css("display", "none");
      $("#paciente").html( "" );
      $("#contenido").css("display", "none");
      $("#txtServicio").val( "" );
      $("#tabla_servicios").css("display", "none");
      $("#tabla_servicios").html( "" );
    }
  });

  $("#txtServicio").keyup(function () {
    var servicio_texto = $("#txtServicio").val();
    var examen_text = document.getElementById("cbExamenes").checked;
    var procedimiento_text = document.getElementById("cbProcedimientos").checked;
    var consulta_text = document.getElementById("cbConsultas").checked;        

    if (servicio_texto.length > 0) {
      $.ajax({
        method: "GET",
        url: "tabla-servicio.php",
        data: {
          servicio : servicio_texto,
          consulta : consulta_text,
          procedimiento : procedimiento_text,
          examen : examen_text
        }
      })
      .done (function (tabla) {              
        $("#tabla_servicios").css("display", "block");
        $("#tabla_servicios").html( tabla );
        $("#toggleTablaServicios").click(function () {
          $("#no-more-tables").slideToggle();
        });
      });
    } else {
      $("#tabla_servicios").css("display", "none");
      $("#tabla_servicios").html( "" );
    }
  });

});

function recuperarServicio ( idServicio ) {
  var id_paciente = $("#txtdni").val();
  $("#no-more-tables").slideToggle();
  $("#contenidoServicio").css("display", "block");
  $.ajax({
    method: "GET",
    url: "form-mostrar-servicio-secretaria.php",
    data: {
      servicio : idServicio,
      idpaciente : id_paciente
    }
  })
  .done (function ( data ) {
    $("#contenidoServicio").html ( data );
    var precio = $("#txtprecio").val();
    $("#txtpago").val( precio );
    $("#txtdescuento").keyup(function () {
      var precio = $("#txtprecio").val();
      precio = Number(precio.substring(3));
      var descuento = $("#txtdescuento").val();
      descuento = Number(descuento);
      if (descuento <= precio) {
        var total = precio - descuento;
        total = "S/. " + total ;
        $("#txtpago").val( total );
      } else {
        precio = "S/. " + precio ;
        $("#txtpago").val( precio );
      }
    });
    $("#txtprecio").keyup(function () {
      var precio = $("#txtprecio").val();
      precio = Number(precio);
      var descuento = $("#txtdescuento").val();
      descuento = Number(descuento);
      if (descuento <= precio) {
        var total = precio - descuento;
        total = "S/. " + total ;
        $("#txtpago").val( total );
      } else {
        precio = "S/. " + precio ;
        $("#txtpago").val( precio );
      }
    });
  });
}