<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('doctor');
  // Conexion al servidor
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $Atencion = $_GET["nro_atencion"];
  $Servicio = $_GET["id_servicio"];

  $sql = "CALL spu_taatencion_numero_orden('".$Servicio."');";

  if (mysqli_multi_query($conexion,$sql)) {
    if($result=mysqli_store_result($conexion)){
      if ($row=mysqli_fetch_row($result)) {
        $nro_orden = $row[0];
        $nro_orden++;
      }
      mysqli_free_result($result);
    }
    mysqli_next_result($conexion);
  }

  $sql = "CALL sp_taatencion_postergar(".$Atencion.",".$nro_orden.");";
  if (mysqli_multi_query($conexion,$sql)) {
    header("Location:index.php");
    exit;
  }
?>