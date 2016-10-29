<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('admin');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperamos los parámetros enviados
  $id_servicio = $_POST["txtIdServicio"];
  if ($id_servicio == "nuevo") {
    $id_servicio = 0;
    $sentencia = "CALL sp_taservicio_ultimo_id();";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_row($resultado)) {
          $id_servicio = $fila[0];
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
    $id_servicio++;
  }
  $denominacion = $_POST["txtDenominacion"];
  $denominacion = utf8_decode($denominacion);
  $descripcion = $_POST["txtDescripcion"];
  $descripcion = utf8_decode($descripcion);
  $precio = $_POST["txtPrecio"];
  $tipo = $_POST["txtTipo"];
  if ($tipo == "Examen") {
    $formato = $_POST["cleditor"];
    $formato = utf8_decode($formato);
  } else {
    $formato = "";
  }
  if ($tipo == "Consulta") {
    $consultorio = $_POST["txtConsultorio"];
  } else {
    $consultorio = 0;
  }
  // Actualizamos la sentencia a ejecutar
  $sentencia = "CALL sp_taservicio_actualizar($id_servicio, '$denominacion', '$descripcion', $precio, '$tipo', '$formato', $consultorio);";
  if (mysqli_multi_query($conexion, $sentencia)) {
    header("Location: confirmacion.php?nromensaje=8");
    exit;
  }
?>