<?php
// session_start();
// $ciclo = "2013-I";
// $_SESSION["cic"]=$ciclo;

require 'conex.php';

$result = $db->prepare("SET NAMES utf8");
$result->execute();
$result = $db->prepare("SELECT * FROM alumnos");
$result->execute();
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
	param=document.frmbuscar.txtbusca.value;

	var content = $("#resultado");
	content.fadeIn('slow').load("agregacurso.php?param="+param);
}

function enviar(id)
{
	location.href="matricula1.php?id="+id;
}


//-->
</script>

</head>
<body>

<table cellpadding="5" cellspacing="3" class="tbini"> 
	<caption>ALUMNOS</caption>
	<thead>
		<tr>
			<th width="10%">COD.</th>
			<th width="60%">NOMBRES Y APELIIDOS</th>
			<th>CURSOS</th>
			<th>ACCION</th>
		</tr>
	</thead>
	<tbody>
	<?php
	while($fila = $result->fetch())
		{
	?>
	<tr>
		<td><?php echo $fila[0]?></td>
		<td><?php echo $fila[1]?></td>
		<td align="center"><a href="cursos.php?id=<?php echo $fila[0];?>">VER</a></td>
		<td align="center"><a href="#" onclick="enviar(<?php echo $fila[0];?>);return false;">MATRICULAR</a></td>
	</tr>
	<?php
		}
	?>
	</tbody>
</table>
<?php $db = null; ?>
 
	<div id="regresar">
		<a href="index.php"><img src="img/back_volver.png">&nbsp;REGRESAR</a>
	</div>	

</body>
</html>