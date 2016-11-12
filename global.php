<?php
  $global_host = '127.0.0.1';
  $global_user_db = 'root';
  $global_pass_db = '';
  $global_db = 'bdmaca';

  function _redireccionar($tipoUsuario){
    if ($_SESSION["UsuarioLogueado"] == "") {
      header("Location: /sin-acceso.html");
      exit;
    } elseif ($_SESSION["EstadoUsuario"] == "En Bloqueo") {
      header("Location: /lock_screen.php");
      exit;
    } elseif ($_SESSION["TipoUsuario"] != $tipoUsuario) {
      header("Location: /".$_SESSION["TipoUsuario"]);
      exit;
    }
  }

  function _print_footer(){
  echo "<footer class='site-footer'>";
    echo "<div class='text-center'>Mamá Canguro Solution - v1.0.0</div>";
    echo "<div class='text-center'>2015 - Copyright BLENS 101</div>";
  echo "</footer>";
  }
?>