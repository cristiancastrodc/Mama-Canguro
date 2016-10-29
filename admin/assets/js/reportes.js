$(document).ready(function(){
  // Deslizables
  $("#r1").click(function(){
    $("#report1").slideToggle();
  });
  $("#r2").click(function(){
    $("#report2").slideToggle();
  });
  $("#r3").click(function(){
    $("#report3").slideToggle();
  });
  $("#r4").click(function(){
    $("#report4").slideToggle();
  });
  $("#r5").click(function(){
    $("#report5").slideToggle();
  });
  $("#r7").click(function(){
    $("#report7").slideToggle();
  });
  $("#r8").click(function(){
    $("#report8").slideToggle();
  });
  $("#r9").click(function(){
    $("#report9").slideToggle();
  });

  // Definición para las Fechas y Rangos de Fechas
  $("#r1_fecha").datepicker({ dateFormat: "yy-mm-dd", changeMonth: true });
  $("#r2_fecha").datepicker({ dateFormat: "yy-mm-dd", changeMonth: true });

  $("#r3_fecha_inicio").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r3_fecha_fin").datepicker( "option", "minDate", selectedDate );
    }
  });
  $("#r3_fecha_fin").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r3_fecha_inicio").datepicker( "option", "maxDate", selectedDate );
    }
  });

  $("#r5_fecha_inicio").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r5_fecha_fin").datepicker( "option", "minDate", selectedDate );
    }
  });
  $("#r5_fecha_fin").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r5_fecha_inicio").datepicker( "option", "maxDate", selectedDate );
    }
  });

  $("#r7_fecha_inicio").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r7_fecha_fin").datepicker( "option", "minDate", selectedDate );
    }
  });
  $("#r7_fecha_fin").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r7_fecha_inicio").datepicker( "option", "maxDate", selectedDate );
    }
  });

  $("#r8_fecha_inicio").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r8_fecha_fin").datepicker( "option", "minDate", selectedDate );
    }
  });
  $("#r8_fecha_fin").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r8_fecha_inicio").datepicker( "option", "maxDate", selectedDate );
    }
  });

  $("#r9_fecha_inicio").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r9_fecha_fin").datepicker( "option", "minDate", selectedDate );
    }
  });
  $("#r9_fecha_fin").datepicker({ 
    dateFormat: "yy-mm-dd", 
    changeMonth: true,
    onClose: function( selectedDate ){
      $("#r9_fecha_inicio").datepicker( "option", "maxDate", selectedDate );
    }
  });

  // Eventos
  $("#r1_fecha").change(function(){
    var fecha = $("#r1_fecha").val();
    var referencia = "generacion-reportes.php?reporte=1&fecha=" + fecha;
    $("#a_r1").attr("href", referencia);
  });

  $("#r2_fecha").change(function(){
    var fecha = $("#r2_fecha").val();
    var referencia = "generacion-reportes.php?reporte=2&fecha=" + fecha;
    $("#a_r2").attr("href", referencia);
  });

  $("#r4_mes").change(function(){
    var mes = $("#r4_mes").val();
    var referencia = "generacion-reportes.php?reporte=4&mes=" + mes;
    $("#a_r4").attr("href", referencia);
  });

  $("#r3_fecha_inicio").change(function(){
    var fechaini = $("#r3_fecha_inicio").val();
    var fechafin = $("#r3_fecha_fin").val();
    if (fechafin != "") {
      var referencia = "generacion-reportes.php?reporte=3&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r3").attr("href", referencia);
    }
  });
  $("#r3_fecha_fin").change(function(){
    var fechaini = $("#r3_fecha_inicio").val();
    var fechafin = $("#r3_fecha_fin").val();
    if (fechaini != "") {
      var referencia = "generacion-reportes.php?reporte=3&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r3").attr("href", referencia);
    }
  });

  $("#r5_fecha_inicio").change(function(){
    var fechaini = $("#r5_fecha_inicio").val();
    var fechafin = $("#r5_fecha_fin").val();
    if (fechafin != "") {
      var referencia = "generacion-reportes.php?reporte=5&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r5").attr("href", referencia);
    }
  });
  $("#r5_fecha_fin").change(function(){
    var fechaini = $("#r5_fecha_inicio").val();
    var fechafin = $("#r5_fecha_fin").val();
    if (fechaini != "") {
      var referencia = "generacion-reportes.php?reporte=5&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r5").attr("href", referencia);
    }
  });

  $("#r7_fecha_inicio").change(function(){
    var fechaini = $("#r7_fecha_inicio").val();
    var fechafin = $("#r7_fecha_fin").val();
    if (fechafin != "") {
      var referencia = "generacion-reportes.php?reporte=7&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r7").attr("href", referencia);
    }
  });
  $("#r7_fecha_fin").change(function(){
    var fechaini = $("#r7_fecha_inicio").val();
    var fechafin = $("#r7_fecha_fin").val();
    if (fechaini != "") {
      var referencia = "generacion-reportes.php?reporte=7&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r7").attr("href", referencia);
    }
  });

  $("#r8_fecha_inicio").change(function(){
    var fechaini = $("#r8_fecha_inicio").val();
    var fechafin = $("#r8_fecha_fin").val();
    if (fechafin != "") {
      var referencia = "generacion-reportes.php?reporte=8&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r8").attr("href", referencia);
    }
  });
  $("#r8_fecha_fin").change(function(){
    var fechaini = $("#r8_fecha_inicio").val();
    var fechafin = $("#r8_fecha_fin").val();
    if (fechaini != "") {
      var referencia = "generacion-reportes.php?reporte=8&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r8").attr("href", referencia);
    }
  });

  $("#r9_fecha_inicio").change(function(){
    var fechaini = $("#r9_fecha_inicio").val();
    var fechafin = $("#r9_fecha_fin").val();
    if (fechafin != "") {
      var referencia = "generacion-reportes.php?reporte=9&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r9").attr("href", referencia);
    }
  });
  $("#r9_fecha_fin").change(function(){
    var fechaini = $("#r9_fecha_inicio").val();
    var fechafin = $("#r9_fecha_fin").val();
    if (fechaini != "") {
      var referencia = "generacion-reportes.php?reporte=9&fechaini=" + fechaini + "&fechafin=" + fechafin;
      $("#a_r9").attr("href", referencia);
    }
  });
});