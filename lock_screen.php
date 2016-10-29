<?php
  // Inicializar la sesion
  session_start();
  // Recuperamos el identificador del usuario
  $User = $_SESSION["UsuarioLogueado"];
  // Si el usuario está logueado, redireccionar a su menú
  if($User == ""){
    header("Location: sin-acceso.html");
    exit;
  }
  // Cambiamos al usuario a modo bloqueo
  $_SESSION["EstadoUsuario"] = "En Bloqueo";
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Mamá Canguro</title>
    <link rel="icon" type="image/png" href="assets/img/icon.ico"/>
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>
  <body onload="getTime()">
    <!-- Contenido Principal -->
    <div class="container">
      <div id="showtime"></div>
      <div class="col-lg-4 col-lg-offset-4">
        <div class="lock-screen">
          <h2><a data-toggle="modal" href="#myModal"><i class="fa fa-lock"></i></a></h2>
          <p><font color="white">DESBLOQUEAR</font></p>
          <!-- Modal -->
          <form action="validar-usuario.php" method="post">
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Bienvenido de nuevo</h4>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" id="txtUsuario" name="txtUsuario" value="<?=$User?>">
                    <p class="centered"><img class="img-circle" width="80" src="assets/img/logo_canguro.png"></p>
                    <input type="password" id="txtClave" name="txtClave" placeholder="Password" autocomplete="off" class="form-control placeholder-no-fix" autofocus>
                  </div>
                  <div class="modal-footer centered">
                    <button data-dismiss="modal" class="btn btn-theme04" type="button">Cancelar</button>
                    <button type="submit" class="btn btn-theme03">Login</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- modal -->
          </form>
        </div><!-- /lock-screen -->
      </div><!-- /col-lg-4 -->
    </div><!-- /container -->

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.png", {speed: 500});
    </script>
    <script>
      function getTime(){
        var today=new Date();
        var h=today.getHours();
        var m=today.getMinutes();
        var s=today.getSeconds();
        // add a zero in front of numbers<10
        h=checkTime(h);
        m=checkTime(m);
        s=checkTime(s);
        document.getElementById('showtime').innerHTML=h+":"+m+":"+s;
        t=setTimeout(function(){getTime()},500);
      }

      function checkTime(i){
        if (i<10){
          i="0"+i;
        }
        return i;
      }
    </script>
  </body>
</html>
