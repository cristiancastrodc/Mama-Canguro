<?php
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario está logueado, redireccionar a su menú
  if (isset($_SESSION["TipoUsuario"]) && $_SESSION["TipoUsuario"] != "") {
    header("Location: /".$_SESSION["TipoUsuario"]);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="BLENS 101">
    <link rel="icon" href="assets/img/icon.ico" type="image/png">
    <title>Iniciar Sesión | Clínica Mamá Canguro</title>
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style-login.css" rel="stylesheet">
  </head>
  <body>
    <!--login modal-->
    <div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
      <header class="pg-header">CLÍNICA MAMÁ CANGURO</header>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="text-center">Iniciar Sesión</h1>
          </div>
          <div class="modal-body">
            <form class="form col-md-12 center-block" action="validar-usuario.php" method="post">
              <div class="form-group">
                <input type="text" class="form-control input-lg" maxlength="8" name="txtUsuario" id="txtUsuario" placeholder="Nombre Usuario" autofocus>
              </div>
              <div cl ass="form-group">
                <input type="password" class="form-control input-lg" id="txtClave" name="txtClave" placeholder="Clave">
              </div>
              <br>
              <div class="form-group">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Iniciar Sesión</button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="col-md-12">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Javascripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>