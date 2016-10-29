<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('doctor');
  // Conexión a la base de datos
  $conexion_aux = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);

  $id_paciente = $_GET["id"];

  $titulos = array('0','Examen','Recepcion de muestra','Llenado de resultado','');
  $sentencia = "CALL sp_taatencion_listar_examenes('$id_paciente');";

  echo "<div class='panel panel-default mt'>";
    echo "<div class='panel-heading'>Examenes Realizados al Paciente</div>";
    echo "<div class='panel-body'>";
      echo "<section id='no-more-tables'>";
        echo "<table class='table table-striped table-condensed cf table-hover' id='tabla-examenes'>";
          echo "<thead>";
          echo "<tr>";
  for ($i=1; $i < 5; $i++) {
    echo "<th>$titulos[$i]</th>";
  }
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
  if (mysqli_multi_query($conexion_aux, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion_aux)) {
      while ($fila = mysqli_fetch_row($resultado)) {
        $nro_atencion = $fila[0];
        $examen = $fila[1];
        $examen = utf8_encode($examen);
        $fecha_muestra = $fila[2];
        $fecha_resultado = $fila[3];
        $estado = $fila[4];
          echo "<tr>";
            echo "<td data-title='$titulos[1]' class='uppercase'>$examen</td>";
            echo "<td data-title='$titulos[2]'>$fecha_muestra</td>";
            echo "<td data-title='$titulos[3]'>$fecha_resultado</td>";
        if ($estado == 'EMuestra') {
            echo "<td><a role='button' class='btn btn-round btn-danger'>Pendiente</a></td>";
        } elseif ($estado == 'atendido') {
            echo "<td><a href='imprimir-resultado-examen.php?nroatencion=$nro_atencion' target='_blank' role='button' class='btn btn-round btn-primary'>Ver Resultado</a></td>";
        } elseif ($estado == 'no atendido') {
            echo "<td><a role='button' class='btn btn-round btn-danger'>Pendiente</a></td>";
        }
          echo "</tr>";
      }
      mysqli_free_result($resultado);
    }
    mysqli_next_result($conexion_aux);
  }
          echo "</tbody>";
        echo "</table>";
      echo "</section>";
    echo "</div>";
  echo "</div>";
?>