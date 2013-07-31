<?php 
session_start();
$codalu = $_GET["id"];
$_SESSION["alu"]=$codalu;
$cic = $_SESSION["cic"];

require 'conex.php';

$result = $db->prepare("SET NAMES utf8");
$result->execute();
$rs1 = $db->prepare("SELECT codigo, nombre FROM alumnos WHERE codigo=".$codalu);

$rs1->execute();
$row1 = $rs1->fetch();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MATRICULA</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />

<script type="text/javascript" 
        src="http://www.google.com/jsapi"></script> 
<script type="text/javascript">
  google.load("jquery", "1.4.2");
  google.setOnLoadCallback(function() {
  });
</script>


<script language="JavaScript" type="text/javascript">
<!--
 function agregar()
{
	var param;
	//param=document.frmbuscar.txtbusca.value;
	cur=document.frmbuscar.optcurso.value;

	var content = $("#resultado");
	content.fadeIn('slow').load("agregacurso.php?cur="+cur);
}

 function vercursos()
{
	var content = $("#listado");
	content.fadeIn('slow').load("cursos_matric.php?alu="+<?php echo $codalu;?>);
}


 function registrar(alumno,ciclo,curso)
{
	var content = $("#resultado");
	content.fadeIn('slow').load("reg_matricula.php?alu="+alumno+"&cic="+ciclo+"&cur="+curso);
}

//-->
</script>

</head>
<body onload="vercursos()">
<br>
<div id="dato">&nbsp;&nbsp;MATRICULA DEL ALUMNO: &nbsp; <?php echo "  <b>".$row1[1]."</b> <br>&nbsp;&nbsp;"."SEMESTRE: "."<b>".$cic."</b>"?>

</div>
<br>

<form name="frmbuscar" enctype="multipart/form-data">
<table cellpadding="5" cellspacing="3" class="tbmat">
		<tr>
			<td align="right" colspan="3">
				<a href="matric.php"><img src="img/back_volver.png">&nbsp;REGRESAR</a>
			</td>
		</tr>
		<tr>
			<td>CURSO:</td>
			<td>
			<select name="optcurso">
			<?php  
				$result = $db->prepare("SET NAMES utf8");
				$result->execute();
				$rs2 = $db->prepare("SELECT * FROM cursos");
				$rs2->execute();
							
				while($row2 = $rs2->fetch())
					{
			?>	
					<option value="<?php echo "$row2[0]" ?>"><?php echo "$row2[1]"; ?></option>
			<?php } ?>
			<?php $db = null; ?>			
				
				</select>
				&nbsp; <input type="button" name="btnbuscar" value="..:AGREGAR:.." onclick="agregar();">
				<!-- icono_pdf.gif -->
				
			</td>
			<td align="right"><!-- <a href="pdf/reportes/reporte.php" target="_blank">
				<img src="img/icono_pdf.gif">PDF</a> -->&nbsp;</td>
		</tr>		
</table>
</form>

<br>

<div id="listado">listado</div>
<br>
<div id="resultado"></div>

<div id="sup">
<table border="0" align="right">
	<tr>
		<td>
			<a href="pdf/reportes/reporte.php" target="_blank">
				<img src="img/pdf-icon.png"></a>
		</td>
		<td><a href="pdf/reportes/reporte.php" target="_blank">GENERAR PDF</a></td>
	</tr>
</table>
</div>
	
</body>
</html>

