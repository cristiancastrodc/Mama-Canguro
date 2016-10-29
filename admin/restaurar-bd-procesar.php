<?php
  /*
  ********************************************************************************************
  Restaurar el estado anterior de una base de datos MySQL utilizando:
  - html para seleccionar el archivo
  - php para el procesamiento
  Versión: 1.0alfa
  Autor: Cristian Castro Del Carpio - facebook.com/xtiancastro7
  ********************************************************************************************
  */
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  // Nombre del archivo temporal, creado al enviar el formulario
  $filename = $_FILES["archivoSubida"]["tmp_name"];
  // Usuario
  $user = $_POST["txtuser"];
  // Contraseña
  $pass = $_POST["txtpass"];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $sentencia_comprobacion = "CALL sp_tausuario_existe('".$user."', '".$pass."')";
  if (mysqli_multi_query($conexion, $sentencia_comprobacion)) {
    if ($resultado = mysqli_store_result($conexion)) {
      if ($fila = mysqli_fetch_row($resultado)) {
        $tipo = $fila[2];
        if ($tipo == 'administrador') {
          mysqli_free_result($resultado);
          mysqli_next_result($conexion);
          // Variable temporal para almacenar la consulta
          $templine = '';
          // Leer y almacenar el archivo completo
          $lines = file($filename);
          // Avanzar cada línea
          foreach ($lines as $line){
            // No tomar en cuenta si es un comentario
            if (substr($line, 0, 2) == '--' || $line == '')
              continue;
            // Añadir la línea a la variable temporal
            $templine .= $line;
            // Si existe punto y coma al final de la línea, entonces la consulta está completa y se ejecuta
            if (substr(trim($line), -1, 1) == ';'){
              // Ejecutar la consulta
              if (mysqli_multi_query($conexion, $templine)) {
                continue;
              }
              else{
                header("Location: index.php");
              }
              // Reset temp variable to empty
              $templine = '';
            }
          }
          header("Location: confirmacion.php?nromensaje=1");
        }
        else{
          header("Location: index.php");
        }
      }
      else{
        header("Location: index.php");
      }
    }
  }
?>