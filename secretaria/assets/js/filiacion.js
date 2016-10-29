$(document).ready(function () {
  $("#txtdni").keyup(function () {
    var dni_texto = $("#txtdni").val();
    if (dni_texto.length > 0) {
      $("#namesearch").slideUp();
      if (dni_texto.length == 8) {
        $.ajax({
          method: "GET",
          url: "recuperar-paciente-dni.php",
          data: {
            dni : dni_texto
          }
        }).done(function ( data ) {
          $("#contenido").html(data);
        });
      } else {
        $("#contenido").html("");
      }
    } else {
      $("#contenido").html("");
      $("#namesearch").slideDown();
    }
  });

  $("#txtnombres").keyup(function () {
    var nombres_texto = $("#txtnombres").val();
    var apellidos_texto = $("#txtapellidos").val();
    long_nombres = nombres_texto.length;
    long_apellidos = apellidos_texto.length;
    if (long_nombres > 0 || long_apellidos > 0) {
      $("#dnisearch").slideUp();
      $.ajax({
        method: "GET",
        url: "recuperar-paciente-nombres.php",
        data: {
          nombres : nombres_texto,
          apellidos : apellidos_texto
        }
      }).done(function ( data ) {
        $("#contenido").html(data);
        $("#buagregar").click(function () {
          $.ajax({
            method: "GET",
            url: "form-nuevo-paciente.php"
          }).done(function ( data ) {
            $("#nuevopaciente").html(data);
          });
        });
      });
    } else {
      $("#contenido").html("");
      $("#dnisearch").slideDown();
    }
  });

  $("#txtapellidos").keyup(function () {
    var nombres_texto = $("#txtnombres").val();
    var apellidos_texto = $("#txtapellidos").val();
    long_nombres = nombres_texto.length;
    long_apellidos = apellidos_texto.length;
    if (long_nombres > 0 || long_apellidos > 0) {
      $("#dnisearch").slideUp();
      $.ajax({
        method: "GET",
        url: "recuperar-paciente-nombres.php",
        data: {
          nombres : nombres_texto,
          apellidos : apellidos_texto
        }
      }).done(function ( data ) {
        $("#contenido").html(data);
        $("#buagregar").click(function () {
          $.ajax({
            method: "GET",
            url: "form-nuevo-paciente.php"
          }).done(function ( data ) {
            $("#nuevopaciente").html(data);
          });
        });
      });
    } else {
      $("#contenido").html("");
      $("#dnisearch").slideDown();
    }
  });


});

function formpacientenombres (id_paciente) {
  $.ajax({
    method: "GET",
    url: "recuperar-paciente-id.php",
    data: {
      id : id_paciente
    }
  }).done(function (data) {
    $("#pacienteenviado").html(data);
    $("#namesearch").slideToggle();
    $("#tabla-pacientes").slideToggle();
  });
}