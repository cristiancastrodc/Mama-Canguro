<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Recuperar el servicio
  $servicio = $_GET['servicio'];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Consulta
  $sentencia ="CALL sp_taservicio_buscar_servicio('$servicio')";
  $resultado = mysqli_query($conexion, $sentencia);
  $nro_filas = mysqli_num_rows($resultado);
  // Si existen servicio con datos similares
  if ($nro_filas >= 1) {
    $titulos_filas = array('Servicio','Descripcion','Precio');
    echo "<div class='alert alert-warning center-align'><b>Encontrados $nro_filas resultados.</b></div>";
    echo "<h4><i class='fa fa-angle-right'></i> Servicios similares</h4>";
    echo "<section id='no-more-tables'>";
      echo "<table class='table table-striped table-condensed table-hover cf'>";
      echo "<thead>";
      echo "<tr>";
      echo "<th>Servicio</th>";
      echo "<th>Descripcion</th>";
      echo "<th>Precio</th>";
      echo "</tr>";
      echo "</thead>";
      echo "<tbody>";
      while ($fila = mysqli_fetch_row($resultado)) {
        echo "<tr>";
          for ($i=0; $i < 3; $i++) {
            echo "<td data-title='$titulos_filas[$i]' class='uppercase'>".utf8_encode($fila[$i])."</td>";
          }
        echo "</tr>";
      }
      echo "</tbody>";
      echo "</table>";
    echo "</section>";
  }
  // Si el servicio no existe
  else{
    echo "<div class='alert alert-warning center-align'><b>Ningún servicio</b> coincide con los datos ingresados.</div>";
  }
  mysqli_close($conexion);
?>