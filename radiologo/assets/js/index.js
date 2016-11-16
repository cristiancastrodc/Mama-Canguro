$(document).ready(function() {
  // Recuperar Pacientes no Atendidos y Resultados Pendientes
  $.get('contenido-principal.php', function(data) {
    $('#principal').html(data);
  });
  // Resaltar enlace activo del menú
  $('#btn-pagina-principal').addClass('banner-grid-active')
});

$('#principal').on('click', '.btn-atender-paciente', function(event) {
  event.preventDefault();
  var nro_atencion = $(this).data('nro-atencion');
  var ruta = 'atender-paciente.php?nro_atencion=' + nro_atencion;
  $.get(ruta, function() {
    window.location.reload();
  });
});
