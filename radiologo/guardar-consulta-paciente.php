<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('radiologo');
  // Recuper el identificador del usuario
  $User = $_SESSION["UsuarioLogueado"];
  // Recuperar la informacion enviada por POST
  $diagnostico = $_POST['txtDiagnostico'];
  $diagnostico = utf8_decode($diagnostico);
  $nro_atencion = $_POST['nroAtencion'];
  // Otros valores a almacenar
  $fecha_consulta = date('Y-m-d');
  // Conexion al servidor
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $sentencia = "CALL sp_tadetalle_historia_ultimo();";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      if ($fila = mysqli_fetch_row($resultado)) {
        $nro_detalle = $fila[0];
      }
    }
    mysqli_free_result($resultado);
  }
  mysqli_next_result($conexion);
  $sentencia = "CALL sp_taatencion_paciente($nro_atencion)";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      if ($fila = mysqli_fetch_array($resultado)) {
        $id_paciente = $fila["chr_dni_paciente"];
      }
      mysqli_free_result($resultado);
    }
    mysqli_next_result($conexion);
  }
  $nro_detalle = intval($nro_detalle) + 1;
  // Almacenar la consulta
  $sentencia = "CALL sp_tadetalle_historia_insertar('$id_paciente', $nro_detalle, '$fecha_consulta', '$diagnostico', '', $nro_atencion, '$User', '', '');";
  if (mysqli_multi_query($conexion, $sentencia)) {
    header("Location: buscar-paciente.php");
    exit;
  } else {
    echo mysqli_error($conexion);
  }
?>