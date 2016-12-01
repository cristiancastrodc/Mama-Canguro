$(document).ready(function() {
  // Resaltar enlace activo del menú
  $('#btn-buscar-paciente').addClass('banner-grid-active')
  $('#tabla-pacientes').dataTable();
});

$('#tabla-pacientes').on('click', '.btn-buscar-paciente', function(event) {
  event.preventDefault();
  var btn = $(this);
  var dni = btn.data('dni')
  $.ajax({
    method: "GET",
    url: "examenes-paciente.php",
    data: {
      dni : dni
    }
  }).done(function ( data ) {
    $("#tabla-atenciones").html(data);
    $('#tabla-atenciones > table').dataTable();
  });
});
