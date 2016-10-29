<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Asignamos la zona horaria, para cálculos con fechas
  date_default_timezone_set('America/Lima');
  // Recuperar el nombre del paciente
  $nombres = $_GET['nombres'];
  $apellidos = $_GET['apellidos'];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Consulta
  $sentencia ="CALL sp_tapaciente_listar_nombre('$nombres', '$apellidos')";
  $resultado = mysqli_query($conexion,$sentencia);
  $nro_filas = mysqli_num_rows($resultado);
  // Si existen pacientes con datos similares
  if ($nro_filas >= 1) {
    $titulos_filas = array('0','Nombres','Apellidos','Domicilio','F.Nacimiento','Teléfono','Grado Ins.','Estado Civil','Sexo','Ocupación','F. Filiación','DNI');
    echo "<div id='tabla-pacientes'>";
    echo "<div class='alert alert-warning center-align'><b>Encontrados $nro_filas resultados.</b></div>";
    echo "<h4><i class='fa fa-angle-right'></i> Pacientes con datos similares</h4>";
    echo "<section id='no-more-tables'>";
      echo "<table class='table table-striped table-condensed cf'>";
      echo "<thead>";
      echo "<tr>";
      echo "<th>Nombres</th>";
      echo "<th>Apellidos</th>";
      echo "<th>Domicilio</th>";
      echo "<th>F. Nacimiento</th>";
      echo "<th>Teléfono</th>";
      echo "<th>Sexo</th>";
      echo "<th>F. Filiación</th>";
      echo "<th>DNI</th>";
      echo "<th>Acción</th>";
      echo "</tr>";
      echo "</thead>";
      while ($fila = mysqli_fetch_row($resultado)) {
        $id = $fila[0];
        echo "<tr>";
          for ($i=1; $i < 12; $i++) {
            if ($i != 6 && $i != 7 && $i != 9) {
              echo "<td data-title='$titulos_filas[$i]'>".utf8_encode($fila[$i])."</td>";
            }
          }
          echo "<td data-title='Acción'><a onclick='formpacientenombres(".'"'.$id.'"'.")' role='button' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Seleccionar</a></td>";
        echo "</tr>";
      }
      echo "</table>";
    echo "</section>";
    echo "</div>";
    echo "<div id='pacienteenviado'>";
    echo "</div>";
  }
  // Si el paciente no existe
  else{
    echo "<div class='alert alert-warning center-align'><b>Ningún paciente</b> coincide con los datos ingresados.</div>";
    echo "<a role='button' class='btn btn-primary btn-block btn-lg' id='buagregar'><i class='fa fa-plus'></i> AGREGAR PACIENTE</a>";
    echo "<div id='nuevopaciente'>";
    echo "</div>";
  }
  mysqli_close($conexion);
?>