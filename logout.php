<?php
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  // Recuperamos el dni del usuario
  $User = $_SESSION["UsuarioLogueado"];
  /****************************************
  Conexión a la Base de Datos
  ****************************************/
  // Llamado a las variables globales
  require_once "global.php";
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $consulta = "CALL sp_tausuario_cambiar_estado('$User', 'Habilitado')";
  mysqli_query($conexion, $consulta);
  session_destroy();
  header("Location: /");
  exit;
?>