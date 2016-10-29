<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Recuperar el servicio
  $servicio = $_GET['servicio'];
  $consulta = $_GET['consulta'];
  $procedimiento = $_GET['procedimiento'];
  $examen = $_GET['examen'];

  if ($consulta == 'true') {
    $consulta_text='Consulta';
  }
  else{
    $consulta_text='';
  }
  if ($procedimiento == 'true') {
    $procedimiento_text='Procedimiento';
  }
  else{
    $procedimiento_text='';
  }
  if ($examen == 'true') {
    $examen_text='Examen';
  }
  else{
    $examen_text='';
  }
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Consulta
  $sentencia ="CALL sp_taservicio_listar_servicio('$servicio','$consulta_text','$procedimiento_text','$examen_text')";
  $resultado = mysqli_query($conexion, $sentencia);
  $nro_filas = mysqli_num_rows($resultado);
  // Si existen servicio con datos similares
  if ($nro_filas >= 1) {
    $titulos_filas = array('Servicio','Descripción','Precio','Acción');
    echo "<div class='alert alert-warning center-align'><b>Encontrados $nro_filas resultados.</b></div>";
    echo "<h4><i class='fa fa-angle-right'></i> Servicios similares <i class='fa fa-minus pull-right' id='toggleTablaServicios'></i></h4>";
    echo "<section id='no-more-tables'>";
      echo "<table class='table table-striped table-condensed cf'>";
      echo "<thead>";
      echo "<tr>";
      echo "<th>Servicio</th>";
      echo "<th>Descripción</th>";
      echo "<th>Precio</th>";
      echo "<th>Acción</th>";
      echo "</tr>";
      echo "</thead>";
      echo "<tbody>";
      while ($fila = mysqli_fetch_row($resultado)) {
        echo "<tr>";
          for ($i=0; $i < 3; $i++) {
            echo "<td data-title='$titulos_filas[$i]'";
            if ($i == 2) {
              echo " class='numero'";
            }
            echo ">".utf8_encode($fila[$i])."</td>";
          }
          $id_servicio = $fila[3];
          echo "<td data-title='Acción'><a onclick='recuperarServicio($id_servicio)' role='button' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Seleccionar</a></td>";

        echo "</tr>";
      }
      echo "</tbody>";
      echo "</table>";
    echo "</section>";
    echo "<div id='contenidoServicio'></div>";
  }
  // Si el servicio no existe
  else{
    echo "<div class='alert alert-warning center-align'><b>Ningún servicio</b> coincide con los datos ingresados.</div>";
    echo "</div>";
  }
  mysqli_close($conexion);
  ?>
