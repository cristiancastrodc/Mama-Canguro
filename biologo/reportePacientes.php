<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('biologo');
  /**************************/
  /*** CUERPO DEL REPORTE ***/
  /**************************/
  ob_start ();

  require('fpdf/fpdf.php');
  class PDF extends FPDF {
    var $widths;
    var $aligns;

    function SetWidths($w) {
      //Set the array of column widths
      $this->widths=$w;
    }

    function SetAligns($a) {
      //Set the array of column alignments
      $this->aligns=$a;
    }

    function Row($data) {
      //Calculate the height of the row
      $nb=0;
      for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
      $h=5*$nb;
      //Issue a page break first if needed
      $this->CheckPageBreak($h);
      //Draw the cells of the row
      for($i=0;$i<count($data);$i++) {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border

        $this->Rect($x,$y,$w,$h);

        $this->MultiCell($w,5,$data[$i],0,$a,'true');
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
      }
      //Go to the next line
      $this->Ln($h);
    }

    function CheckPageBreak($h) {
      //If the height h would cause an overflow, add a new page immediately
      if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt) {
      //Computes the number of lines a MultiCell of width w will take
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
      $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      $s=str_replace("\r",'',$txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
      $sep=-1;
      $i=0;
      $j=0;
      $l=0;
      $nl=1;
      while($i<$nb) {
        $c=$s[$i];
        if($c=="\n") {
          $i++;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
          continue;
        }
        if($c==' ')
          $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax) {
          if($sep==-1) {
            if($i==$j)
              $i++;
          } else
            $i=$sep+1;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
        } else
          $i++;
      }
      return $nl;
    }

    function Header() {

      $this->SetFont('Arial','',10);
      $this->Ln(10);
      $this->Text(20,14,'',0,'C', 0);
      $this->Ln(20);
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont('Arial','B',8);
      $d = date("d");
      $m = date("m");
      $y = date("Y");
      $fecha=$d.'/'.$m.'/'.$y;
      $this->Cell(100,10,'Reporte Pacientes de Laboratorio',0,0,'L');
      $this->Cell(200,10,'Fecha:'.$fecha,0,0,'L');
    }
  }

  $paciente= $_GET['DNI'];

  $pdf=new PDF();
  $pdf->Open();
  $pdf->AddPage();
  $pdf->SetMargins(23,20,20);
  $pdf->Cell(700,85,$pdf->Image('../assets/img/cabecera.png',23,12,160),0,0,'C');
  $pdf->Ln(10);

  $pdf->SetWidths(array(15, 25, 60, 40,20));
  $pdf->SetFont('Arial','B',10);
  $pdf->SetFillColor(155, 41, 41);
  $pdf->SetTextColor(255);

  for($i=0;$i<1;$i++) {
    $pdf->Row(array('Nro','Documento','Paciente','Sexo','Edad'));
  }

  $con = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $sql = "CALL sp_tapacientes_laboratorio();";
  if (mysqli_multi_query($con,$sql)) {
    if ($result=mysqli_store_result($con)) {
      $i=0;
      while ($row=mysqli_fetch_row($result)) {
        $DNI=$row[1];
        $Nombre = $row[2];
        $Apellidos = $row[3];
        $Sexo = $row[4];
        $y = date("Y");
        $FechaNac = strtotime($row[5]);
        $nacimiento = date('Y', $FechaNac);
        $edad = $y - $nacimiento;

        $pdf->SetFont('Arial','',10);
        if($i%2 == 1) {
          $pdf->SetFillColor(247, 225, 226);
          $pdf->SetTextColor(0);
          if($Sexo=="F") {
            $pdf->Row(array($i+1, $DNI,$Nombre." ".$Apellidos, 'Femenino',$edad));
          } else {
            $pdf->Row(array($i+1, $DNI,$Nombre." ".$Apellidos, 'Masculino',$edad));
          }
        } else {
          $pdf->SetFillColor(255,255,255);
          $pdf->SetTextColor(0);
          if($Sexo=="F") {
            $pdf->Row(array($i+1, $DNI,$Nombre." ".$Apellidos, 'Femenino',$edad));
          } else{
            $pdf->Row(array($i+1, $DNI,$Nombre." ".$Apellidos, 'Masculino',$edad));
          }
        }
        $i++;
      }
      mysqli_free_result($result);
    }
    mysqli_next_result($con);
  }

  ob_end_clean ();
  $pdf->Output();
?>