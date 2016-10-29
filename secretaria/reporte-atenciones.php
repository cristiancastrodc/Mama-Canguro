<?php
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);

  function _print_reporte($conexion){
    $sentencia = "CALL sp_taatencion_por_dia()";
    $titulos = array('Nro.', 'Paciente', 'Servicio', 'Total (S/.)');
    echo "<section id='no-more-tables'>";
      echo "<table class='table table-bordered table-striped table-condensed cf table-hover'>";
        echo "<thead class='cf'>";
          echo "<tr>";
            echo "<th>Nro.</th>";
            echo "<th>Paciente</th>";
            echo "<th>Servicio</th>";
            echo "<th>Total (S/.)</th>";
          echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        $total = 0;
        $j = 1;
        while ($fila=mysqli_fetch_row($resultado)) {
          echo "<tr>";
            echo "<td data-title='$titulos[0]' class='right-align'><b>$j</b></td>";
          for ($i = 1; $i < 4; $i++) {
            if ($i == 3) {
              echo "<td class='right-align' data-title='$titulos[$i]'>".utf8_encode($fila[$i])."</td>";
            }else{
              echo "<td data-title='$titulos[$i]'>".utf8_encode($fila[$i])."</td>";
            }
          }
          echo "</tr>";
          $total += $fila[3];
          $j++;
        }
      }
    }
    $total = number_format($total, 2, '.', ',');
          echo "<tr>";
            echo "<td colspan='3' class='right-align'><b>TOTAL DEL DÍA</b></td>";
            echo "<td class='right-align'>S/. $total</td>";
          echo "</tr>";
        echo "</tbody>";
      echo "</table>";
    echo "</section>";
  }
?>