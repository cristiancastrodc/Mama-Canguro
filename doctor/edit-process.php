<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('doctor');
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Actualizar Datos Personales | Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/style-menu-doctor.css" rel='stylesheet' type='text/css' />
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
    <link rel="stylesheet" href="assets/css/layout.css">
  </head>
  <body>
    <div class="bg">
      <div class="container">
        <a value="Default Message" class="myButton" id="default" href="index.php">
        <div class="banner-grid banner-grid-active text-center">
          <span class="top-icon1"> </span>
          <h3>Página Principal</h3>
        </div>
      </a>
      <a value="Default Message" class="myButton" id="default" href="edit.php">
        <div class="banner-grid text-center">
          <span class="top-icon2"> </span>
          <h3>Actualizar mis datos</h3>
        </div>
      </a>
      <a value="Default Message" class="myButton" id="default" href="../logout.php">
        <div class="banner-grid text-center">
          <span class="top-icon3"> </span>
          <h3>Cerrar Sesión</h3>
        </div>
      </a>
    </div>
    <div class="banner-info">
      <div class="container">
        <div class="form-panel">
          <h3><i class="fa fa-angle-double-right"></i> Datos actualizados</h3>
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
          <a href="index.php" class="btn btn-primary btn-block">Ir a Menú</a>
        </div>
      </div>
    </div>
    <?php
      _print_footer();
    ?>
    <script src="assets/js/jquery.js"></script>
    <script src="../assets/js/lock.js"></script>
  </body>
</html>

