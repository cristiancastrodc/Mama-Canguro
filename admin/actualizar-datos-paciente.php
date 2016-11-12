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
  // Recuperamos los parámetros enviados
  $id_paciente = $_POST["txtIdPaciente"];
  $dni = $_POST["txtDNI"];
  $dia_fecha_nac = $_POST["txtDia"];
  $mes_fecha_nac = $_POST["txtMes"];
  $year_fecha_nac = $_POST["txtYear"];
  $fecha_nac = $year_fecha_nac."-".$mes_fecha_nac."-".$dia_fecha_nac;
  $nombres = $_POST["txtNombres"];
  $nombres = utf8_decode($nombres);
  $apellidos = $_POST["txtApellidos"];
  $apellidos = utf8_decode($apellidos);
  $domicilio = $_POST["txtDomicilio"];
  $domicilio = utf8_decode($domicilio);
  $telefono = $_POST["txtTelefono"];
  $sexo = $_POST["txtSexo"];
  $ocupacion = $_POST["txtOcupacion"];
  $ocupacion = utf8_decode($ocupacion);
  $grado = $_POST["txtGrado"];
  $estado = $_POST["txtEstado"];
  // Creamos la sentencia a ejecutar
  $sentencia = "CALL sp_tapaciente_actualizar('$dni','$nombres', '$apellidos', '$domicilio', '$fecha_nac', '$telefono','$grado','$estado','$sexo','$ocupacion','$dni');";
  if (mysqli_query($conexion, $sentencia)) {
    header("Location: confirmacion.php?nromensaje=6");
    exit;
  }
?>