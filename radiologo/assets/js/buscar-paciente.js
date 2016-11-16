$(document).ready(function() {
  // Resaltar enlace activo del menú
  $('#btn-buscar-paciente').addClass('banner-grid-active')
  $('#tabla-pacientes').dataTable();
  $('#tabla-atenciones').dataTable();
});

$('#tabla-pacientes').on('click', '.btn-buscar-paciente', function(event) {
  event.preventDefault();
  console.log('clock');
});
