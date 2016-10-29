<?php
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Recuperamos el usuario y contraseña
  $usuario = $_POST["txtUsuario"];
  $clave = $_POST["txtClave"];
  // Verificamos si el usuario y contraseña son correctos
  /****************************************
  Conexión a la Base de Datos
  ****************************************/
  // Llamado a las variables globales
  require_once "global.php";
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $consulta = "CALL sp_tausuario_existe('".$usuario."','".$clave."')";
  mysqli_multi_query($conexion, $consulta);
  $Res = mysqli_store_result($conexion);
  $Nro = mysqli_num_rows($Res);
  if($Nro > 0){
    //Acceso al sistema
    $Fila = mysqli_fetch_row($Res);
    mysqli_free_result($Res);
    mysqli_next_result($conexion);
    $Tipo = $Fila[2];
    $Estado = $Fila[3];
    if ($Estado =="Habilitado" || $Estado =="En Sesion") {
      $ubicacion = "Location: /".$Tipo;
      $_SESSION["UsuarioLogueado"] = $usuario;
      $_SESSION["TipoUsuario"] = $Tipo;
      $_SESSION["EstadoUsuario"] = "";
      //--Cambiar Estado
      $consulta = "CALL sp_tausuario_cambiar_estado('$usuario', 'En Sesion')";
      mysqli_multi_query($conexion,$consulta);
      header($ubicacion);
      exit;
    }
    else{
    ?>
     <script languaje="javascript">
        alert("Usuario Deshabilitado..Comuniquese con el Administrador!");
        location.href = "/";
     </script>
    <?php
    }
  }
  else{
    // Password y/o usuario incorrectos
  ?>
   <script languaje="javascript">
      alert("Error..Inicio de Sesion!..vuelva intentarlo!");
      location.href = "/";
   </script>
 <?php
  }
?>
