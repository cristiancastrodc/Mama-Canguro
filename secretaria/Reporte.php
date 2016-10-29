<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "menu.php";
  require_once "reporte-atenciones.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <!-- General -->
    <meta charset="UTF-8">
    <title>Reporte de Atenciones | Mama Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico">
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/style-menu-secre.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/layout.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/table-responsive.css" rel="stylesheet">
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
        <div class="container">
          <div class="row mt">
            <div class="col-lg-12">
              <div class="content-panel">
                <h3><i class="fa fa-angle-double-right ml"></i> REPORTE DE ATENCIONES DE HOY</h3>
                <?php
                  _print_reporte($conexion);
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        _print_footer();
      ?>
    </section>
    <!-- Javascripts -->
    <script src="../assets/js/lock.js"></script>
  </body>
</html>