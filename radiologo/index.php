<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Llamado a las funciones del radiologo
  require_once "components.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('radiologo');
  $usuario = $_SESSION["UsuarioLogueado"];
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
  <title>Radiología | Clínica Mamá Canguro</title>
  <link href="../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
  <link href="../assets/css/style-login.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
  <link rel="stylesheet" href="../assets/js/jquery-ui.css">
  <link href="assets/css/style-menu-admin.css" rel='stylesheet' type='text/css' />
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
  <link href="../assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <section id="container" >
    <!--menu start-->
    <div class="bg">
      <div class="container">
        <?php _print_menu(); ?>
      </div>
      <div class="container">
        <div class="row" id="principal"></div>
      </div>
    </div>
    <!--main content end-->
    <?php
      _print_footer();
    ?>
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="assets/js/wow.min.js"></script>
  <script type="text/javascript" src="assets/js/move-top.js"></script>
  <script type="text/javascript" src="assets/js/easing.js"></script>
  <script src="assets/js/index.js"></script>
  <script>
    new WOW().init();
  </script>
</body>
</html>