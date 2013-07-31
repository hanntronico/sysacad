<?php 
session_start();
$ciclo = "2013-I";
$_SESSION["cic"]=$ciclo;

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
</head>

<body>

<table cellpadding="5" cellspacing="3" class="tbmenu"> 
	<thead>
		<tr>
			<th><a href="matric.php">MATRICULAS</a></th>
			<th><a href="reporte.php">REPORTE PDF</a></th>
			<th><a href="grafico.php">GRAFICOS</a></th>
		</tr>
	</thead>
</table>


</body>
</html>