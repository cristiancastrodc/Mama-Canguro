<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
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
    <title>Laboratorio | Clínica Mamá Canguro</title>
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">
    <link href="../assets/css/style-login.css" rel="stylesheet">
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
              <div class="banner-grid text-center banner-grid-active">
                <span class="top-icon2"> </span>
                <h3>Buscar Paciente</h3>
              </div>
            </a>
            <a href="Reportes.php">
              <div class="banner-grid text-center">
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
            <div class="row " id="llenar"><!-- inicio de row1-->
              <div class="col-lg-10 main-chart" >
                <div class="row mt">
                  <div class="panel panel-default">
                    <div class="panel-heading">Pacientes de Laboratorio</div>
                    <div class="panel-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tabla-pers" id="dataTables-example">
                          <thead>
                            <tr>
                              <th>Nro</th>
                              <th>DNI</th>
                              <th>Apellidos</th>
                              <th>Nombres</th>
                              <th>Buscar Examenes</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $sql = "CALL sp_tapacientes_laboratorio();";
                              if (mysqli_multi_query($con,$sql)) {
                                if ($result=mysqli_store_result($con)) {
                                  $i = 1;
                                  while ($row=mysqli_fetch_row($result)) {
                                    $DNI=$row[0];
                                    $Documento=$row[1];
                                    $Nombres = utf8_encode($row[2]);
                                    $Apellidos = utf8_encode($row[3]);
                                    echo "
                            <tr>
                              <td>$i</td>
                              <td>$Documento</td>
                              <td>$Apellidos</td>
                              <td>$Nombres</td>
                              <td>
                                <button class='btn btn-primary' onclick='buscarPaciente(".'"'.$DNI.'"'.")'>BUSCAR</button>
                              </td>
                            </tr>";
                                    $i++;
                                  }
                                  mysqli_free_result($result);
                                }
                                mysqli_next_result($con);
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div> <!-- Final de row mt-->
                <div id="ExamenesPaciente"></div>
              </div><!-- fin del col8-->
            </div><!-- Fin de row1 -->
          </section>
        </section>
      </div>
      <?php
        _print_footer();
      ?>
    </section>
    <script src="assets/js/jquery-v1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="ajax.js"></script>
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="../assets/js/lock.js"></script>
    <!-- Para la primera tabla-->
    <script>
      $(document).ready(function () {
          $('#dataTables-example').dataTable();
      });
      function mostrarExamen(DNI){
        var string='reporteExamenPaciente.php?DNI=';
        var parametro=DNI;
        string+=parametro
        window.open(string);
      }
      function llenarexamen(Atencion){
        var string='llenar-resultado-examen.php?nro_atencion=';
        var parametro=Atencion;
        string+=parametro
        window.location=string;
      }
      function imprimirexamen(Atencion){
        var string='imprimir-resultado-examen.php?nro_atencion=';
        var parametro=Atencion;
        string+=parametro
        window.location=string;
      }
      function recibirMuestra (Atencion) {
        $.ajax({
          method:"GET",
          url: "RecibirMuestra.php",
          data: {
            nroatencion : Atencion
          }
        }).done(function (data) {
          alert(data);
          location.reload();
        });
      }
    </script>
    <script type="text/javascript">
      function buscarPaciente (DNI_paciente) {
        $.ajax({
          method: "GET",
          url: "ExamenesPorPaciente.php",
          data: {
            Atencion : 0,
            DNI : DNI_paciente
          }
        }).done(function ( data ) {
          $("#ExamenesPaciente").html ( data );
          $('#dataTables-example2').dataTable();
        });
      }
    </script>
  </body>
</html>

