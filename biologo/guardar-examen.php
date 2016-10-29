<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('biologo');
  //Recuperar la informacion del usuario
  $nro_atencion = $_GET["nroatencion"];
  $usuario = $_SESSION["UsuarioLogueado"];
  $resultado = $_GET["resultado"];
  $resultado = utf8_decode($resultado);
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $sentencia = "CALL sp_taatencion_llenar_resultado($nro_atencion,'$usuario','$resultado')";
  if (mysqli_query($conexion, $sentencia)) {
    echo "Examen Guardado Correctamente.";
  }
?>