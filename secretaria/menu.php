<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');

  function _print_menu(){
    echo "<div class='banner-info'>";
      echo "<a  class='banner-grid text-center' href='../logout.php'>";
      echo "<h3>cerrar sesión</h3></a>";
      echo "<a href='index.php'><span class='top-icon1'> </span>";
      echo "<h1><span>clinica<label>mama canguro</label></span></h1></a>";
    echo "</div>";
  }

  function _print_menu_principal(){
  echo "<header class='pg-header'>CLÍNICA MAMÁ CANGURO</header>";
   echo "<div class='row mt'>";
      echo "<div class='col-lg-12'>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='RegistrarAtencion.php?idservicio=1' accesskey='1'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_registrar1'>";
              echo "<i class ='fa fa-user-md fa-4x'></i>" ;
              echo "<h3>Medicina General (Alt+1)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='RegistrarAtencion.php?idservicio=2' accesskey='2'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_registrar2'>";
              echo "<i class ='fa fa-female fa-4x'></i>" ;
              echo "<h3>Atención Ginecologia (Alt+2)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='RegistrarAtencion.php?idservicio=3' accesskey='3'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_registrar3'>";
              echo "<i class ='fa fa-stethoscope fa-4x'></i>" ;
              echo "<h3>Atención Pediatria (Alt+3)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
    echo "<div class='row mt'>";
      echo "<div class='col-lg-12'>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='RegistrarAtencionOtros.php' accesskey='4'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_registrar4'>";
              echo "<i class ='fa  fa-flask fa-4x'></i>" ;
              echo "<h3>Laboratorio, Controles y Otros (Alt+4)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='filiacion.php' accesskey='5'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_filiacion'>";
              echo "<i class ='fa fa-users fa-4x'></i>";
              echo "<h3>Administrar Pacientes (Alt+5)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='buscar-servicio.php' accesskey='6'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_servicio'>";
              echo "<i class ='fa  fa-list-alt fa-4x'></i>" ;
              echo "<h3>Lista de Servicios (Alt+6)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
    echo "<div class='row mt'>";
      echo "<div class='col-lg-12'>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='Reporte.php' accesskey='7'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_reporte'>";
              echo "<i class ='fa fa-paste fa-4x'></i>" ;
              echo "<h3>Reporte del Día (Alt+7)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='edit.php' accesskey='8'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_datos'>";
              echo "<i class ='fa fa-user fa-4x'></i>" ;
              echo "<h3>Actualizar mis Datos (Alt+8)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
        echo "<div class='col-md-4 col-sm-3 mb'>";
          echo "<a href='../logout.php' accesskey='9'>";
            echo "<div class='weather-3 pn centered resaltar' id='b_datos'>";
              echo "<i class ='fa fa-times-circle-o fa-4x'></i>" ;
              echo "<h3>Cerrar Sesión (Alt+9)</h3>";
            echo "</div>";
          echo "</a>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
  }
?>