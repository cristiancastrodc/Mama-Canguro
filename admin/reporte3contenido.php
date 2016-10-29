<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('admin');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperar datos enviados por GET
  $id_servicio = $_GET["servicio"];
  $sentencia = "CALL sp_taservicio_listar($id_servicio);";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      if ($fila = mysqli_fetch_row($resultado)) {
        $denominacion = $fila[0];
        $denominacion = utf8_encode($denominacion);
        echo "<h4 class='uppercase'><i class='fa fa-angle-right'></i> $denominacion</h4>";
      }
      mysqli_free_result($resultado);
    }
    mysqli_next_result($conexion);
  }
  $fecha_inicio = $_GET["inicio"];
  $fecha_fin = $_GET["fin"];
  $sentencia = "CALL sp_taatencion_especialidad_periodo($id_servicio, '$fecha_inicio', '$fecha_fin')";
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
?>