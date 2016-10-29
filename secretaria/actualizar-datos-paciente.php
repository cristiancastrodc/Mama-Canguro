<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Recuperamos el dni del usuario
  $User = $_SESSION["UsuarioLogueado"];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperamos los parámetros enviados
  $identificador1 = $_POST["txtdni"];
  $identificador2 = $_POST["txtdni1"];
  $dni = $_POST["txtdocid"];
  $nombres1 = $_POST["txtnombres"];
  $nombres1 = utf8_decode($nombres1);
  $apellidos1 = $_POST["txtapellidos"];
  $apellidos1 = utf8_decode($apellidos1);
  $nombres2 = $_POST["txtnombres1"];
  $nombres2 = utf8_decode($nombres2);
  $apellidos2 = $_POST["txtapellidos1"];
  $apellidos2 = utf8_decode($apellidos2);
  $dia_nac=$_POST["txtDia"];
  $mes_nac=$_POST["txtMes"];
  $year_nac = $_POST["txtYear"];
  $fecha_nac = $year_nac."-".$mes_nac."-".$dia_nac;
  $domicilio = $_POST["txtdomicilio"];
  $domicilio = utf8_decode($domicilio);
  $telefono = $_POST["txttelefono"];
  $sexo = $_POST["txtsexo"];
  $ocupacion = $_POST["txtocupacion"];
  $ocupacion = utf8_decode($ocupacion);
  $grado = $_POST["txtgrado"];
  $estado = $_POST["txtestado"];
  // Creamos la sentencia a ejecutar
  $sentencia = "CALL sp_tapaciente_actualizar('";
  $sentencia .= $identificador2."','";
  if ($nombres2 == "" && $apellidos2 == "") {
    $sentencia .= $nombres1."','".$apellidos1."','";
  }
  else{
    $sentencia .= $nombres2."','".$apellidos2."','";
  }
  $sentencia .= $domicilio."','";
  $sentencia .= $fecha_nac."','";
  $sentencia .= $telefono."','";
  $sentencia .= $grado."','";
  $sentencia .= $estado."','";
  $sentencia .= $sexo."','";
  $sentencia .= $ocupacion."','";
  $sentencia .= $dni."')";
  // Guardamos en la Base de Datos
  if (mysqli_query($conexion,$sentencia)) {
    // redireccionar a una página de confirmación
    header("Location: ../secretaria/confirmacion.php");
  }
  else{
    header("Location: index.php");
  }
?>