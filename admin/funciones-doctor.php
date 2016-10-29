<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  setlocale(LC_ALL, '');
  // Asignamos la zona horaria, para cálculos con fechas
  date_default_timezone_set('America/Lima');
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');

  function _print_pacientes_espera($conexion){
    $sentencia = "CALL sp_taatencion_consultas_no_atendidas()";
    echo "<section id='no-more-tables' class='ml'>";
      echo "<table class='table table-striped table-condensed table-hover' id='tabla-pacientes-espera'>";
        echo "<thead>";
          echo "<tr>";
            echo "<th>Fecha de Atención</th>";
            echo "<th>Servicio</th>";
            echo "<th>DNI</th>";
            echo "<th>Nombre del paciente</th>";
            echo "<th>Acción</th>";
          echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        while ($fila = mysqli_fetch_array($resultado)) {
          $fecha = $fila["fechaatencion"];
          $servicio = utf8_encode($fila["denominacion"]);
          $dni = $fila["dni"];
          $nombre = utf8_encode($fila["nombre"]);
          $idpaciente = $fila["idpaciente"];
          $idservicio = $fila["idservicio"];
          $nroatencion = $fila["nroatencion"];
          echo "<tr>";
            echo "<td class='black' data-title='Fecha de atención'>$fecha</td>";
            echo "<td data-title='Servicio'><span class='label ";
            if ($idservicio == 1) {
              echo "label-info";
            } elseif ($idservicio == 2) {
              echo "label-warning";
            } elseif ($idservicio == 3) {
              echo "label-success";
            } else {
              echo "label-primary";
            }
            echo "''>$servicio</span></td>";
            echo "<td data-title='DNI'>$dni</td>";
            echo "<td data-title='Nombre del paciente'>$nombre</td>";
            echo "<td data-title='Acción'><a role='button' class='btn btn-success btn-xs' href='atender-paciente.php?nroatencion=$nroatencion&idservicio=$idservicio&idpaciente=$idpaciente'><i class='fa fa-check'></i> Atender</a></td>";
          echo "</tr>";
        }
      }
    }
        echo "<tbody>";
      echo "</table>";
    echo "</section>";
  }

  function _print_datos_paciente($conexion, $nro_atencion) {
    $sentencia = "CALL sp_taatencion_recuperar_paciente($nro_atencion)";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_array($resultado)) {
          $nombre = $fila["nombre"];
          $fecha_nacimiento = $fila["fechanacimiento"];
          $nacimiento = strtotime($fecha_nacimiento);
          $nacimiento = date('Y', $nacimiento);
          $hoy = date('Y');
          $edad = $hoy - $nacimiento;
          $grado_instruccion = $fila["gradoinstruccion"];
          $estado_civil = $fila["estadocivil"];

          echo "<form class='form-horizontal style-form'>";
            echo "<div class='form-group'>";
              echo "<label class='col-md-2 control-label'>Nombre</label>";
              echo "<div class='col-md-4'>";
                echo "<input readonly class='form-control' value='".utf8_encode($nombre)."'>";
              echo "</div>";
              echo "<label class='col-md-2 control-label'>Fecha Nacimiento</label>";
              echo "<div class='col-md-2'>";
                echo "<input readonly class='form-control' value='$fecha_nacimiento'>";
              echo "</div>";
              echo "<label class='col-md-1 control-label'>Edad</label>";
              echo "<div class='col-md-1'>";
                echo "<input readonly class='form-control right-align' value='$edad'>";
              echo "</div>";
            echo "</div>";
            echo "<div class='form-group'>";
              echo "<label class='col-sm-2 control-label'>Grado Instrucción</label>";
              echo "<div class='col-sm-4'>";
                echo "<input readonly class='form-control' value='".utf8_encode($grado_instruccion)."'>";
              echo "</div>";
              echo "<label class='col-sm-2 control-label'>Estado Civil</label>";
              echo "<div class='col-sm-4'>";
                echo "<input readonly class='form-control' value='$estado_civil'>";
              echo "</div>";
            echo "</div>";
          echo "</form>";
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }

  function _print_antecedentes($conexion, $nro_atencion, $id_servicio, $id_paciente) {
    // Recuperar el consultorio al que va el servicio.
    $sentencia = "CALL sp_taservicio_recuperar_consultorio($id_servicio);";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_array($resultado)) {
          $consultorio = $fila["consultorio"];
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }

    echo "<input type='hidden' class='form-control' id='consultorio' value='$consultorio'>";

    if ($consultorio == 1) {
      _print_antecedentes_generales($conexion, $id_paciente);
    } elseif ($consultorio == 2) {
      _print_antecedentes_ginecologicos($conexion, $id_paciente);
    } elseif ($consultorio == 3) {
      _print_antecedentes_pediatricos($conexion, $id_paciente);
    }
  }

  function _print_antecedentes_generales($conexion, $id_paciente) {
    $sentencia = "CALL sp_taantecedente_medicina_general_existe('$id_paciente');";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_row($resultado)) {
          $Menarquia3 = $fila[1];
          $Irs3 = $fila[2];
          $RegimenCatamenial3  = $fila[3];
          $FormulaObstetrica3 = $fila[4];
          $MetodoPPFF3 = $fila[5];
          $Alergias3 = $fila[6];
          $Hipertension3 = $fila[7];
          $Cirugias3 = $fila[8];
          $TBC3 = $fila[9];
          $ETC3 = $fila[10];
          $Otros = $fila[11];
          $Temperatura3 = $fila[12];
          $P3 = $fila[13];
          $PresionArterial3 = $fila[14];
          $Peso3 = $fila[15];
          $PAP3 = $fila[16];
          $FUR3 = $fila[17];
          $FUM3 = $fila[18];
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
    // Mostrar el formulario de antecedentes
    echo "<div id='antecedentes'>";
    echo "<form class='form-horizontal style-form'>";
    echo "<h4 class='mb'><i class='fa fa-angle-right'></i> Antecedentes Personales</h4>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>Menarquia</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='Menarquia' id='Menarquia' value='$Menarquia3' autofocus>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>IRS</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='Irs' id='Irs' value='$Irs3'>";
      echo "</div>";
    echo "</div>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>Regimen Catamenial</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='RegimenCatamenial' id='RegimenCatamenial' value='$RegimenCatamenial3'>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>Fórmula Obstétrica</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='FormulaObstetrica' id='FormulaObstetrica' value='$FormulaObstetrica3'>";
      echo "</div>";
    echo "</div>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>Método PP.FF. </label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='MetodoPPFF' id='MetodoPPFF' value='$MetodoPPFF3'>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>Alergias</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='Alergias' id='Alergias' value='$Alergias3'>";
      echo "</div>";
    echo "</div>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>Hipertensión</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='Hipertension' id='Hipertension' value='$Hipertension3'>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>Cirugias</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='Cirugias' id='Cirugias' value='$Cirugias3'>";
      echo "</div>";
    echo "</div>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>TBC</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='TBC' id='TBC' value='$TBC3'>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>ETS</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='ETC' id='ETC' value='$ETC3'>";
      echo "</div>";
    echo "</div>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>Otros</label>";
      echo "<div class='col-sm-10'>";
        echo "<input type='text' class='form-control' name='Otros' id='Otros' value='$Otros'>";
      echo "</div>";
    echo "</div>";
    echo "<h4 class='mb'><i class='fa fa-angle-right'></i> Antecedentes Patológicos</h4>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>Temperatura</label>";
      echo "<div class='col-sm-2'>";
        echo "<input type='text' class='form-control' name='Temperatura' id='Temperatura' value='$Temperatura3'>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>Pulso</label>";
      echo "<div class='col-sm-2'>";
        echo "<input type='text' class='form-control' name='P' id='P' value='$P3'>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>Presión Arterial </label>";
      echo "<div class='col-sm-2'>";
        echo "<input type='text' class='form-control' name='PresionArterial' id='PresionArterial' value='$PresionArterial3'>";
      echo "</div>";
    echo "</div>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>Peso</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='Peso' id='Peso' value='$Peso3'>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>PAP</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='PAP' id='PAP' value='$PAP3'>";
      echo "</div>";
    echo "</div>";
    echo "<div class='form-group'>";
      echo "<label class='col-sm-2 control-label'>FUR</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='FUR' id='FUR' value='$FUR3'>";
      echo "</div>";
      echo "<label class='col-sm-2 control-label'>FUM</label>";
      echo "<div class='col-sm-4'>";
        echo "<input type='text' class='form-control' name='FUM' id='FUM' value='$FUM3'>";
      echo "</div>";
    echo "</div>";
    echo "<a role='button' class='btn btn-primary btn-block' id='guardarAntecedentes'><i class='fa fa-refresh'></i> Guardar Cambios</a>";
    echo "</form>";
    echo "</div>";
  }

  function _print_antecedentes_ginecologicos($conexion, $id_paciente) {
    $sentencia = "CALL sp_taantecedente_ginecologico_existe('$id_paciente');";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_row($resultado)) {
          $Menarquia = $fila[1];
          $Irs = $fila[2];
          $RegimenCatamenial = $fila[3];
          $FormulaObstetrica = $fila[4];
          $MetodoPPFF = $fila[5];
          $Alergias_G = $fila[6];
          $PAP_G = $fila[7];
          $FUR_G = $fila[8];
          $FUM_G = $fila[9];
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
    // Mostrar el formulario de antecedentes
    echo "<div id='antecedentes'>";
    echo "<form class='form-horizontal style-form'>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Menarquia</label>";
        echo "<div class='col-sm-4'>";
          echo "<input type='text' class='form-control' name='Menarquia' id='Menarquia' value='$Menarquia' autofocus>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>IRS</label>";
        echo "<div class='col-sm-4'>";
          echo "<input type='text' class='form-control' name='Irs' id='Irs' value='$Irs'>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Regimen Catamenial</label>";
        echo "<div class='col-sm-4'>";
          echo "<input type='text' class='form-control' name='RegimenCatamenial' id='RegimenCatamenial' value='$RegimenCatamenial'>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Fórmula Obstétrica</label>";
        echo "<div class='col-sm-4'>";
          echo "<input type='text' class='form-control' name='FormulaObstetrica' id='FormulaObstetrica' value='$FormulaObstetrica'>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Método PP.FF. </label>";
        echo "<div class='col-sm-4'>";
          echo "<input type='text' class='form-control' name='MetodoPPFF' id='MetodoPPFF' value='$MetodoPPFF'>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Alergias</label>";
        echo "<div class='col-sm-4'>";
          echo "<input type='text' class='form-control' name='Alergias2' id='Alergias2' value='$Alergias_G'>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>PAP </label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='PAP2' id='PAP2' value='$PAP_G'>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>FUR</label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='FUR2' id='FUR2' value='$FUR_G'>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>FUM</label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='FUM2' id='FUM2' value='$FUM_G'>";
        echo "</div>";
      echo "</div>";
      echo "<a role='button' class='btn btn-primary btn-block' id='guardarAntecedentes'><i class='fa fa-refresh'></i> Guardar Cambios</a>";
    echo "</form>";
    echo "</div>";
  }

  function _print_antecedentes_pediatricos($conexion, $id_paciente) {
    $sentencia = "CALL sp_taantecedente_pediatricos_existe('$id_paciente');";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_row($resultado)) {
          $PesoNacer1 = $fila[1];
          $Talla1 = $fila[2];
          $Vacunas1  = $fila[3];
          $Complicaciones1 = $fila[4];
          $Culminacion1 = $fila[5];
          $Parto1 = $fila[6];
          $NacidoCesarea1 = $fila[7];
          $Ictericia1 = $fila[8];
          $ComplicacionesNeonatales1 = $fila[9];
          $LecheMaterna1 = $fila[10];
          $EdadAblactacion1 = $fila[11];
          $AlimientacionActual1 = $fila[12];
          $Nro_hijo1 = $fila[13];
          $Alergias1 = $fila[14];
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
    // Mostrar el formulario de antecedentes
    echo "<div id='antecedentes'>";
    echo "<form class='form-horizontal style-form'>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Peso al Nacer</label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='Peso' id='Peso' value='$PesoNacer1' autofocus>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Nro de Hijo</label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='Nro_hijo' id='Nro_hijo' value='$Nro_hijo1'>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Talla</label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='Talla' id='Talla' value='$Talla1'>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Vacunas</label>";
        echo "<div class='col-sm-4'>";
          echo "<input type='text' class='form-control' name='Vacunas' id='Vacunas' value='$Vacunas1'>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Complicaciones durante el embarazo</label>";
        echo "<div class='col-sm-4'>";
          echo "<input type='text' class='form-control' name='Complicaciones' id='Complicaciones' value='$Complicaciones1'>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Culminación </label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='Culminacion' id='Culminacion' value='$Culminacion1'>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Parto</label>";
        echo "<div class='col-sm-2'>";
          echo "<select maxlength='50' class='form-control' name='Parto' id='Parto'>";
            echo "<option>$Parto1</option>";
            echo "<option>Eutocico</option>";
            echo "<option>Distocico</option>";
          echo "</select>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Nacido de Cesarea</label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='NacidoCesarea' id='NacidoCesarea' value='$NacidoCesarea1'>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Ictericia</label>";
        echo "<div class='col-sm-2'>";
          echo "<select maxlength='2' class='form-control' name='Ictericia' id='Ictericia'>";
            echo "<option>$Ictericia1</option>";
            echo "<option>SI</option>";
            echo "<option>NO</option>";
          echo "</select>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Complicaciones Neonatales</label>";
        echo "<div class='col-sm-2'>";
          echo "<select maxlength='2' class='form-control' name='ComplicacionesNeonatales' id='ComplicacionesNeonatales'>";
            echo "<option>$ComplicacionesNeonatales1</option>";
            echo "<option>SI</option>";
            echo "<option>NO</option>";
          echo "</select>";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Leche Materna</label>";
        echo "<div class='col-sm-2'>";
          echo "<select maxlength='2' class='form-control' name='LecheMaterna' id='LecheMaterna'>";
            echo "<option>$LecheMaterna1</option>";
            echo "<option>SI</option>";
            echo "<option>NO</option>";
          echo "</select>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Edad de Ablactación</label>";
        echo "<div class='col-sm-2'>";
          echo "<input type='text' class='form-control' name='EdadAblactacion' id='EdadAblactacion' value='$EdadAblactacion1' >";
        echo "</div>";
        echo "<label class='col-sm-2 control-label'>Alimentación Actual </label>";
        echo "<div class='col-sm-6'>";
          echo "<input type='text' class='form-control' name='AlimentacionActual' id='AlimentacionActual' value='$AlimientacionActual1' >";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-sm-2 control-label'>Alergias</label>";
        echo "<div class='col-sm-10'>";
          echo "<input type='text' class='form-control' name='Alergias' id='Alergias' value='$Alergias1'>";
        echo "</div>";
      echo "</div>";
      echo "<a role='button' class='btn btn-primary btn-block' id='guardarAntecedentes'><i class='fa fa-refresh'></i> Guardar Cambios</a>";
    echo "</form>";
    echo "</div>";
  }

  function _print_historial_paciente($conexion, $id_paciente) {
    $titulos = array('0','0','Fecha de Atencion', 'Diagnostico', 'Tratamiento', 'Próxima Cita');
    $sentencia = "CALL sp_tadetalle_historia_listar_id('$id_paciente')";
    echo "<div id='historial'>";
    echo "<form class='form-horizontal style-form'>";
      echo "<section id='no-more-tables'>";
        echo "<table class='table table-striped table-condensed cf table-hover'>";
          echo "<thead>";
    for ($i=2; $i < 6; $i++) {
      echo "<th>$titulos[$i]</th>";
    }
          echo "</thead>";
          echo "<tbody>";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        while ($fila = mysqli_fetch_row($resultado)) {
            echo "<tr>";
          for ($j=2; $j < 6; $j++) {
            if ($j == 5) {
              if ($fila[$j] == 0) {
                echo "<td data-title='$titulos[$j]'>Ninguna</td>";
              } else {
                echo "<td data-title='$titulos[$j]'>".utf8_encode($fila[$j])."</td>";
              }
            } else {
              echo "<td data-title='$titulos[$j]'>".utf8_encode($fila[$j])."</td>";
            }
          }
            echo "</tr>";
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
          echo "</tbody>";
        echo "</table>";
      echo "</section>";
      echo "<a role='button' class='btn btn-primary btn-block' id='verExamenes'><i class='fa fa-search'></i> Ver Exámenes</a>";
    echo "</form>";
    echo "<div id='examenesPaciente'></div>";
    echo "</div>";
  }
?>