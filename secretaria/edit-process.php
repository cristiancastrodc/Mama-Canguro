<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "menu.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  //Recuperar la informacion del usuario
  $IdUsuario = $_POST["txtId"];
  $Nombres=$_POST['txtNombres'];
  $Nombres = utf8_decode($Nombres);
  $AP=$_POST['txtAP'];
  $AP = utf8_decode($AP);
  $Telefono=$_POST['txtTelf'];
  $Dom=$_POST['txtDomi'];
  $Dom = utf8_decode($Dom);
  $Email=$_POST['txtCorreo'];
  $dia_nacimiento = $_POST["txtDia"];
  $mes_nacimiento = $_POST["txtMes"];
  $year_nacimiento = $_POST["txtYear"];
  $Fecha = $year_nacimiento."-".$mes_nacimiento."-".$dia_nacimiento;
  $Sexo=$_POST['txtSexo'];
  $Clave=$_POST['txtClave'];
  $Clave = utf8_decode($Clave);
  $Enlace = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);

  $Consulta ="CALL sp_tausuario_actualizar_user('$IdUsuario','$Nombres','$AP','$Telefono','$Dom','$Email','$Fecha','$Sexo','$Clave')";
  mysqli_query($Enlace,$Consulta);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <!-- General -->
    <meta charset="UTF-8">
    <title>Actualizar Datos Personales | Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico">
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/style-menu-secre.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/layout.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  </head>
  <body>
    <section id="container">
      <div class="bg bg-min-height">
        <div class="container">
          <form method="post">
            <?php
              _print_menu();
            ?>
          </form>
        </div>
        <div class="banner-info">
          <div class="container">
            <div class="form-panel">
              <h3><i class="fa fa-angle-double-right"></i>Datos de la cuenta</h3>
              <table class="table table-striped">
                <tr>
                  <td><b>DNI</b></td>
                  <td><?=$IdUsuario?></td>
                </tr>
                <tr>
                  <td><b>Nombres</b></td>
                  <td><?=utf8_encode($Nombres)?></td>
                </tr>
                <tr>
                  <td><b>Apellidos</b></td>
                  <td><?=utf8_encode($AP)?></td>
                </tr>
                <tr>
                  <td><b>Teléfono</b></td>
                  <td><?=$Telefono?></td>
                </tr>
                <tr>
                  <td><b>Domicilio</b></td>
                  <td><?=utf8_encode($Dom)?></td>
                </tr>
                <tr>
                  <td><b>Email</b></td>
                  <td><?=utf8_encode($Email)?></td>
                </tr>
                <tr>
                  <td><b>Fecha de Nacimiento</b></td>
                  <td><?=$Fecha?></td>
                </tr>
                <tr>
                  <td><b>Sexo</b></td>
                  <td><?=$Sexo?></td>
                </tr>
                <tr>
                  <td><b>Clave</b></td>
                  <td><?=utf8_encode($Clave)?></td>
                </tr>
              </table>
              <a role="button" href="index.php" class="btn btn-primary btn-block">Ir a Menú</a>
            </div>
          </div>
        </div>
      </div>
      <?php
        _print_footer();
      ?>
    </section><!-- col-lg-12-->
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/lock.js"></script>
  </body>
</html>