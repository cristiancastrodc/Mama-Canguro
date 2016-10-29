<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('biologo');
  $con = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="BLENS101">
    <title>Clínica - Mamá Canguro</title>
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">
    <link href="../assets/css/style-login.css" rel="stylesheet">
    <link href="assets/css/style-menu-admin.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout.css">
  </head>
  <body>
    <section id="container">
      <!--menu start-->
      <div class="bg">
        <div class="container">
          <div class="top-banner-grids wow bounceInUp" data-wow-delay="0.4s">
            <a href="index.php">
              <div class="banner-grid text-center">
                <span class="top-icon1"> </span>
                <h3>Pagina Principal</h3>
              </div>
            </a>
            <a href="BuscarPaciente.php">
              <div class="banner-grid text-center">
                <span class="top-icon2"> </span>
                <h3>Buscar Paciente</h3>
              </div>
            </a>
            <a href="Reportes.php">
              <div class="banner-grid text-center banner-grid-active">
                <span class="top-icon3"> </span>
                <h3>Generar Reportes</h3>
              </div>
            </a>
            <a href="edit.php">
              <div class="banner-grid text-center">
                <span class="top-icon3"> </span>
                <h3>Actualizar mis Datos</h3>
              </div>
            </a>
            <a href="../logout.php">
              <div class="banner-grid text-center">
                <span class="top-icon5"> </span>
                <h3>Cerrar Sesión</h3>
              </div>
            </a>
            <div class="clearfix"> </div>
          </div>
        </div>
        <!--MENU end-->
        <!--main content start-->
        <section id="main-content">
          <section class="wrapper site-min-height ">
            <div class="row mt" ><!-- inicio de row1-->
              <div class="col-lg-10 main-chart" >
                <div class="form-panel">
                  <h3><i class="fa fa-angle-double-right"></i> Seleccione Tipo de Reporte:</h3>
                  <form class="form-horizontal style-form">
                    <div class="form-group">
                      <label class="col-sm-1 control-label">Reporte</label>
                      <div class="col-sm-6">
                        <select class="form-control" id="seleccion">
                          <option></option>
                          <option>Ver Todos los Pacientes de Laboratorio</option>
                        </select>
                      </div>
                      <button class="btn btn-round btn-danger" style='display:none;' id="Todos" onclick="mostrarTodos()">Ver Reporte</button>
                    </div>
                    <div class="form-group" id="Paciente" style='display:none;'>
                      <label class="col-sm-1 control-label">DNI</label>
                      <div class="col-sm-6">
                        <input type="text" id="id_DNI" class="form-control" placeholder="Escriba el DNI de Paciente">
                      </div>
                      <input type="button" class="btn btn-round btn-danger" value="Ver Reporte" onclick="mostrarPaciente()">
                    </div>
                    <div class="form-group" id="Examen" style='display:none;' >
                      <label class="col-sm-1 control-label">Nro Examen</label>
                      <div class="col-sm-6">
                        <input type="text" id="txtExamen" class="form-control" placeholder="Escriba el Nro de Examen">
                      </div>
                      <input type="button" class="btn btn-round btn-danger" value="Ver Reporte" onclick="mostrarExamen()">
                    </div>
                  </form>
                </div>
              </div>
            </div><!-- fin del col8-->
          </section>
        </section>
        <?php
          _print_footer();
        ?>
      </div>
    </section>
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="assets/js/jquery-v1.min.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script type="text/javascript">
      function mostrarTodos() {
        window.open('reportePacientes.php');
      }
      function mostrarPaciente() {
        var string='reporteExamenPaciente.php?DNI=';
        var parametro=$("#id_DNI").val();
        string+=parametro
        window.open(string);
      }
      function mostrarExamen(){
        var string='reporteExamen.php?Examen=';
        var parametro=$("#txtExamen").val();
        string+=parametro
        window.open(string);
      }
    </script>
    <script type="text/javascript">
      $(function(){
        $("#seleccion").change(function() {
          var porId=document.getElementById("seleccion").value;
          if( porId=="Ver Todos los Pacientes de Laboratorio") {
            document.getElementById('Todos').style.display = 'block';
            document.getElementById('Paciente').style.display = 'none';
            document.getElementById('Examen').style.display = 'none';
          } else {
            if(porId=="Ver Examenes Realizados a un Paciente") {
              document.getElementById('Todos').style.display = 'none';
              document.getElementById('Paciente').style.display = 'block';
              document.getElementById('Examen').style.display = 'none';
            } else {
              if(porId=="Ver Resultados de Un Examen") {
                document.getElementById('Todos').style.display = 'none';
                document.getElementById('Paciente').style.display = 'none';
                document.getElementById('Examen').style.display = 'block';
              } else {
                document.getElementById('Todos').style.display = 'none';
                document.getElementById('Paciente').style.display = 'none';
                document.getElementById('Examen').style.display = 'none';
              }
            }
          }
        });
      });
    </script>
  </body>
</html>