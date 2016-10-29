<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  date_default_timezone_set('America/Lima');
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  /********** FUNCIONES PARA GENERAR REPORTES **********/
  /****** REPORTE 1 ******/
  function _r_atenciones_por_dia($conexion, $fecha){
    echo "<h3><i class='fa fa-angle-double-right ml'></i> Lista de Atenciones del $fecha</h3>";
    $sentencia = "CALL sp_taatencion_fecha_atencion('$fecha')";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        $titulos = array('Paciente', 'Servicio', 'Pago');
        $nro = 1;
        echo "<section id='no-more-tables'>";
          echo "<table class='table table-striped table-condensed table-hover cf'>";
            echo "<thead>";
            echo "<tr>";
              echo "<th>Nro.</th>";
              echo "<th>Paciente</th>";
              echo "<th>Servicio</th>";
              echo "<th>Pago</th>";
            echo "</tr>";
            echo "</thead>";
            $total = 0;
              while ($fila = mysqli_fetch_row($resultado)) {
                echo "<tr>";
                  echo "<td data-title='Nro.'>$nro</td>";
                  for ($i=0; $i < 3; $i++) {
                    echo "<td data-title='$titulos[$i]' class='uppercase";
                    if ($i == 2) {
                      echo " right-align";
                    }
                    echo "'>".utf8_encode($fila[$i])."</td>";
                  }
                echo "</tr>";
                $nro++;
                $total += $fila[2];
              }
              $total = number_format($total, 2, '.', ',');
            echo "<tr><td class='right-align' colspan='3'><b>TOTAL</b></td><td class='right-align'>$total</td></tr>";
          echo "</table>";
        echo "</section>";
      }
      mysqli_free_result($resultado);
    }
    mysqli_next_result($conexion);
  }
  /****** REPORTE 2 ******/
  function _r_atenciones_especialidad_dia($conexion, $fecha){
    echo "<h3><i class='fa fa-angle-double-right ml'></i> Atenciones por Servicio del $fecha</h3>";
    // Sentencia de consulta a la Base de Datos
    $sentencia = "CALL sp_taatencion_servicios_cuenta_diaria('$fecha')";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        $titulos = array('Servicio', 'Cuenta', 'Total');
    echo "<div class='row'>";
      echo "<div class='col-md-6 ml'>";
        echo "<section id='no-more-tables'>";
          echo "<table class='table table-striped table-condensed table-hover cf' id='tabla-reporte'>";
            echo "<thead>";
            echo "<tr>";
              echo "<th>Servicio</th>";
              echo "<th class='right-align'>Cuenta</th>";
              echo "<th class='right-align'>Total</th>";
            echo "</tr>";
            echo "</thead>";
            $total_pago = 0;
            $total_atencion = 0;
              while ($fila = mysqli_fetch_row($resultado)) {
                echo "<tr>";
                  for ($i=0; $i < 3; $i++) {
                    echo "<td data-title='$titulos[$i]' class='uppercase";
                    if ($i == 1 || $i == 2) {
                      echo " right-align";
                    }
                    echo "'>".utf8_encode($fila[$i])."</td>";
                  }
                echo "</tr>";
                $total_atencion += $fila[1];
                $total_pago += $fila[2];
              }
              $total_pago = number_format($total_pago, 2, '.', ',');
            echo "<tr><td class='right-align'><b>TOTAL</b></td><td class='right-align'>$total_atencion</td><td class='right-align'>$total_pago</td></tr>";
          echo "</table>";
        echo "</section>";
      echo "</div>";
    echo "</div>";
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }
  /****** REPORTE 4 ******/
  function _r_atenciones_especialidad_mes($conexion, $mes){
    $meses = array('0', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                  'Octubre', 'Noviembre', 'Diciembre');
    echo "<h3><i class='fa fa-angle-double-right ml'></i> Atenciones por Servicio del mes de $meses[$mes]</h3>";
    // Sentencia de consulta a la Base de Datos
    $sentencia = "CALL sp_taatencion_servicios_cuenta_mes($mes)";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        $titulos = array('Servicio', 'Cuenta', 'Total');
    echo "<div class='row'>";
      echo "<div class='col-md-6 ml'>";
        echo "<section id='no-more-tables'>";
          echo "<table class='table table-striped table-condensed table-hover cf' id='tabla-reporte'>";
            echo "<thead>";
            echo "<tr>";
              echo "<th>Servicio</th>";
              echo "<th class='right-align'>Cuenta</th>";
              echo "<th class='right-align'>Total</th>";
            echo "</tr>";
            echo "</thead>";
            $total_pago = 0;
            $total_atencion = 0;
              while ($fila = mysqli_fetch_row($resultado)) {
                echo "<tr>";
                  for ($i=0; $i < 3; $i++) {
                    echo "<td data-title='$titulos[$i]' class='uppercase";
                    if ($i == 1 || $i == 2) {
                      echo " right-align";
                    }
                    echo "'>".utf8_encode($fila[$i])."</td>";
                  }
                echo "</tr>";
                $total_atencion += $fila[1];
                $total_pago += $fila[2];
              }
              $total_pago = number_format($total_pago, 2, '.', ',');
            echo "<tr><td class='right-align'><b>TOTAL</b></td><td class='right-align'>$total_atencion</td><td class='right-align'>$total_pago</td></tr>";
          echo "</table>";
        echo "</section>";
      echo "</div>";
    echo "</div>";
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }
  /****** REPORTE 3 ******/
  function _r_atenciones_especialidad_periodo($conexion, $inicio, $fin){
    echo "<h3><i class='fa fa-angle-double-right ml'></i> Atenciones y Cobros Diarios de un Servicio entre el $inicio y $fin</h3>";
    echo "<input type='hidden' id='fechaInicio' value='$inicio'>";
    echo "<input type='hidden' id='fechaFin' value='$fin'>";
    echo "<div class='panel panel-default'>";
      echo "<div class='panel-body'>";
      _print_lista_servicios($conexion, 3);
      echo "</div>";
    echo "</div>";
    echo "<div id='reporte3contenido'></div>";
  }
  /****** REPORTE 5 ******/
  function _r_ultimas_atenciones($conexion, $inicio, $fin){
    echo "<h3><i class='fa fa-angle-double-right ml'></i> Atenciones y Cobros Totales Diarios entre el $inicio y el $fin</h3>";
    // Sentencia de consulta a la Base de Datos
    $sentencia = "CALL sp_taatencion_cuenta_atenciones_por_fecha('$inicio', '$fin')";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        $titulos = array('Fecha', 'Cuenta de Atenciones', 'Total Pago');
    echo "<div class='row'>";
      echo "<div class='col-md-6 ml'>";
        echo "<section id='no-more-tables'>";
          echo "<table class='table table-striped table-condensed table-hover cf' id='tabla-reporte'>";
            echo "<thead>";
            echo "<tr>";
              echo "<th>Fecha</th>";
              echo "<th class='right-align'>Cuenta de Atenciones</th>";
              echo "<th class='right-align'>Total Pago</th>";
            echo "</tr>";
            echo "</thead>";
            $total_pago = 0;
            $total_atencion = 0;
              while ($fila = mysqli_fetch_row($resultado)) {
                echo "<tr>";
                  for ($i=0; $i < 3; $i++) {
                    echo "<td data-title='$titulos[$i]' class='uppercase";
                    if ($i == 1 || $i == 2) {
                      echo " right-align";
                    }
                    echo "'>".utf8_encode($fila[$i])."</td>";
                  }
                echo "</tr>";
                $total_atencion += $fila[1];
                $total_pago += $fila[2];
              }
              $total_pago = number_format($total_pago, 2, '.', ',');
            echo "<tr><td class='right-align'><b>TOTAL</b></td><td class='right-align'>$total_atencion</td><td class='right-align'>$total_pago</td></tr>";
          echo "</table>";
        echo "</section>";
      echo "</div>";
    echo "</div>";
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }
  /****** REPORTE 6 ******/
  function _r_atenciones_mensuales($conexion){
    $year = date('Y');
    echo "<h3><i class='fa fa-angle-double-right ml'></i> Lista de Atenciones Mensuales del $year</h3>";
    // Sentencia de consulta a la Base de Datos
    $sentencia = "CALL sp_taatencion_cuenta_meses()";
    $meses = array('0', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        $titulos = array('Mes', 'Cuenta de Atenciones', 'Total Pago');
    echo "<div class='row'>";
      echo "<div class='col-md-6 ml'>";
        echo "<section id='no-more-tables'>";
          echo "<table class='table table-striped table-condensed table-hover cf'>";
            echo "<thead>";
            echo "<tr>";
              echo "<th>Mes</th>";
              echo "<th class='right-align'>Cuenta de Atenciones</th>";
              echo "<th class='right-align'>Total Pago</th>";
            echo "</tr>";
            echo "</thead>";
            $total_pago = 0;
            $total_atencion = 0;
              while ($fila = mysqli_fetch_row($resultado)) {
                echo "<tr>";
                  for ($i=0; $i < 3; $i++) {
                    echo "<td data-title='$titulos[$i]' class='uppercase";
                    if ($i == 1 || $i == 2) {
                      echo " right-align";
                    }
                    echo "'>";
                    if ($i == 0) {
                      $mes = $fila[$i];
                      echo $meses[$mes]."</td>";
                    } else {
                      echo utf8_encode($fila[$i])."</td>";
                    }
                  }
                echo "</tr>";
                $total_atencion += $fila[1];
                $total_pago += $fila[2];
              }
              $total_pago = number_format($total_pago, 2, '.', ',');
            echo "<tr><td class='right-align'><b>TOTAL</b></td><td class='right-align'>$total_atencion</td><td class='right-align'>$total_pago</td></tr>";
          echo "</table>";
        echo "</section>";
      echo "</div>";
    echo "</div>";
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }
  /****** REPORTE 7 ******/
  function _r_filiaciones_periodo($conexion, $fechainicio, $fechafin){
    echo "<h3><i class='fa fa-angle-double-right ml'></i> Filiaciones Diarias entre el $fechainicio y el $fechafin</h3>";
    $sentencia = "CALL sp_tapaciente_filiaciones_periodo('$fechainicio', '$fechafin')";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        $titulos = array('Fecha', 'Filiaciones');
    echo "<div class='row'>";
      echo "<div class='col-md-6 ml'>";
        echo "<section id='no-more-tables'>";
          echo "<table class='table table-striped table-condensed table-hover cf' id='tabla-reporte'>";
            echo "<thead>";
            echo "<tr>";
              echo "<th>Fecha</th>";
              echo "<th class='right-align'>Filiaciones</th>";
            echo "</tr>";
            echo "</thead>";
            $total_filiaciones = 0;
              while ($fila = mysqli_fetch_row($resultado)) {
                echo "<tr>";
                  for ($i=0; $i < 2; $i++) {
                    echo "<td data-title='$titulos[$i]' class='uppercase";
                    if ($i == 1) {
                      echo " right-align";
                    }
                    echo "'>".utf8_encode($fila[$i])."</td>";
                  }
                echo "</tr>";
                $total_filiaciones += $fila[1];
              }
            echo "<tr><td class='right-align'><b>TOTAL</b></td><td class='right-align'>$total_filiaciones</td></tr>";
          echo "</table>";
        echo "</section>";
      echo "</div>";
    echo "</div>";
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }
  /****** REPORTE 8 ******/
  function _r_estadistico_pacientes($conexion, $fechainicio, $fechafin){
    echo "<h3><i class='fa fa-angle-double-right ml'></i> Estadístico de Pacientes entre el $fechainicio y el $fechafin</h3>";
    $sentencia = "CALL sp_tapaciente_estadistico('$fechainicio', '$fechafin')";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        $titulos = array('Fecha', 'Filiaciones', 'Acumulado', 'Relación');
    echo "<div class='row'>";
      echo "<div class='col-md-6 ml'>";
        echo "<section id='no-more-tables'>";
          echo "<table class='table table-striped table-condensed table-hover cf'>";
            echo "<thead>";
            echo "<tr>";
              echo "<th>Fecha</th>";
              echo "<th class='right-align'>Filiaciones</th>";
              echo "<th class='right-align'>Acumulado</th>";
            echo "</tr>";
            echo "</thead>";
            $acumulado = 0;
            $j = 0;
            while ($fila = mysqli_fetch_row($resultado)) {
              echo "<tr>";
                for ($i = 0; $i < 2; $i++) {
                  if ($i == 0) {
                    if ($j == 0) {
                      echo "<td data-title='$titulos[$i]'>Hasta el $fila[$i]</td>";
                      $j++;
                    } else {
                      echo "<td data-title='$titulos[$i]'>$fila[$i]</td>";
                    }
                  } elseif ($i == 1) {
                    echo "<td data-title='$titulos[$i]' class='right-align'>$fila[$i]</td>";
                  }
                }
              $acumulado += $fila[1];
              echo "<td data-title='Acumulado' class='right-align'>$acumulado</td>";
              echo "</tr>";
            }
          echo "</table>";
        echo "</section>";
      echo "</div>";
    echo "</div>";
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }
?>