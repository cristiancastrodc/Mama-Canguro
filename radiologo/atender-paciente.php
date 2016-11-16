<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('radiologo');
  $usuario = $_SESSION["UsuarioLogueado"];
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Procesar actualización de la atención
  if (isset($_GET["nro_atencion"])) {
    $nro_atencion = $_GET["nro_atencion"];
    if (isset($nro_atencion)) {
      $consulta = "CALL sp_radiologo_atender('$nro_atencion', '$usuario');";
      mysqli_multi_query($conexion, $consulta);
      mysqli_next_result($conexion);
    }
  }
?>
