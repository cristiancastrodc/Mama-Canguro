$(document).ready(function () {
  $("#toggleAntecedentes").click(function (){
    $("#antecedentes").slideToggle();
  });
  $("#toggleHistorial").click(function (){
    $("#historial").slideToggle();
  });
  $("#guardarAntecedentes").click(function () {
    var consultorio = $("#consultorio").val();
    var id_paciente = $("#DNI").val();
    if (consultorio == 1) {
      var Menarquia_M = $("#Menarquia").val();
      var Irs_M = $("#Irs").val(); 
      var RegimenCatamenial_M  = $("#RegimenCatamenial").val();
      var FormulaObstetrica_M = $("#FormulaObstetrica").val();
      var MetodoPPFF_M = $("#MetodoPPFF").val();
      var Alergias_M = $("#Alergias").val();
      var Hipertension_M = $("#Hipertension").val();
      var Cirugias_M = $("#Cirugias").val();
      var TBC_M = $("#TBC").val();   
      var ETC_M = $("#ETC").val();
      var Otros_M = $("#Otros").val();
      var Temperatura_M = $("#Temperatura").val();
      var P_M = $("#P").val();
      var PresionArterial_M = $("#PresionArterial").val();
      var Peso_M = $("#Peso").val(); 
      var PAP_M = $("#PAP").val(); 
      var FUR_M = $("#FUR").val();
      var FUM_M = $("#FUM").val();
      $.ajax({
        method: "GET",
        url: "actualizar-antecedentes.php",
        data: { 
          tipo : consultorio,
          id : id_paciente,
          val1 : Menarquia_M,
          val2 : Irs_M,
          val3 : RegimenCatamenial_M,
          val4 : FormulaObstetrica_M,
          val5 : MetodoPPFF_M,
          val6 : Alergias_M,
          val7 : Hipertension_M,
          val8 : Cirugias_M,
          val9 : TBC_M,
          val10 : ETC_M,
          val11 : Otros_M,
          val12 : Temperatura_M,
          val13 : P_M,
          val14 : PresionArterial_M,
          val15 : Peso_M,
          val16 : PAP_M,
          val17 : FUR_M,
          val18 : FUM_M
        }
      })
      .done(function( msg ) {
        alert( msg );
      });
    } else if (consultorio == 2) {
      var Menarquia2 = $("#Menarquia").val();
      var Irs2 = $("#Irs").val(); 
      var RegimenCatamenial2 = $("#RegimenCatamenial").val();
      var FormulaObstetrica2 = $("#FormulaObstetrica").val();
      var MetodoPPFF2 = $("#MetodoPPFF").val();
      var Alergias2 = $("#Alergias2").val();
      var PAP2 = $("#PAP2").val()
      var FUR2 = $("#FUR2").val();
      var FUM2 = $("#FUM2").val();
      $.ajax({
        method: "GET",
        url: "actualizar-antecedentes.php",
        data: { 
          tipo : consultorio,
          id : id_paciente,
          val1 : Menarquia2,
          val2 : Irs2,
          val3 : RegimenCatamenial2,
          val4 : FormulaObstetrica2,
          val5 : MetodoPPFF2,
          val6 : Alergias2,
          val7 : PAP2,
          val8 : FUR2,
          val9 : FUM2
        }
      })
      .done(function( msg ) {
        alert( msg );
      });
    } else if (consultorio == 3) {
      var Peso_P = $("#Peso").val();
      var Talla_P = $("#Talla").val(); 
      var Vacunas_P  = $("#Vacunas").val();
      var Complicaciones_P = $("#Complicaciones").val();
      var Culminacion_P = $("#Culminacion").val();
      var Parto_P = $("#Parto").val();
      var NacidoCesarea_P = $("#NacidoCesarea").val();
      var Ictericia_P = $("#Ictericia").val();
      var ComplicacionesNeonatales_P = $("#ComplicacionesNeonatales").val();
      var LecheMaterna_P = $("#LecheMaterna").val();
      var EdadAblactacion_P= $("#EdadAblactacion").val();
      var AlimentacionActual_P = $("#AlimentacionActual").val();
      var Nro_hijo_P = $("#Nro_hijo").val();
      var Alergias_P = $("#Alergias").val();
      $.ajax({
        method: "GET",
        url: "actualizar-antecedentes.php",
        data: { 
          tipo : consultorio,
          id : id_paciente,
          val1 : Peso_P,
          val2 : Talla_P,
          val3 : Vacunas_P,
          val4 : Complicaciones_P,
          val5 : Culminacion_P,
          val6 : Parto_P,
          val7 : NacidoCesarea_P,
          val8 : Ictericia_P,
          val9 : ComplicacionesNeonatales_P,
          val10 : LecheMaterna_P,
          val11 : EdadAblactacion_P,
          val12 : AlimentacionActual_P,
          val13 : Nro_hijo_P,
          val14 : Alergias_P
        }
      })
      .done(function( msg ) {
        alert( msg );
      });
    };
  });
  $("#verExamenes").click(function () {
    var id_paciente = $("#DNI").val();    
      $.ajax({
        method: "GET",
        url: "examenes-paciente.php",
        data: { 
          id : id_paciente
        }
      })
      .done(function( data ) {
        $("#examenesPaciente").html(data);
        $("#tabla-examenes").dataTable();
      });
  });
});