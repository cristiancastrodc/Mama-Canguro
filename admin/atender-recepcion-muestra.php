<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  //Recuperar la informacion del usuario
  $User = $_SESSION["UsuarioLogueado"];
  $nro_atencion = $_GET["atencion"];
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $sentencia ="CALL sp_taatencion_emuestra('$nro_atencion','$User');";

  if (mysqli_multi_query($conexion, $sentencia)) {
    header("Location: confirmacion.php?nromensaje=2");
    exit;
  }
?>