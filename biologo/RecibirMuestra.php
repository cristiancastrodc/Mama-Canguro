<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('biologo');
  //Recuperar la informacion del usuario
  $User = $_SESSION["UsuarioLogueado"];
  $nro_atencion = $_GET["nroatencion"];
  if ($conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db)) {
    $sentencia = "CALL sp_taatencion_emuestra($nro_atencion, '$User');";
    if (mysqli_query($conexion, $sentencia)) {
      echo "Recepción registrada";
    }
  }
?>