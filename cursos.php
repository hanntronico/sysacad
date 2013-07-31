<?php
session_start();
$alu = $_GET["id"];
$cic = $_SESSION["cic"];
require 'conex.php';

$result = $db->prepare("SET NAMES utf8");
$result->execute();
$result = $db->prepare("SELECT * FROM cursos");
$result->execute();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MIS CURSOS</title>
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

<div id="sup">
	<a href="matric.php"><img src="img/back_volver.png">&nbsp;REGRESAR</a>&nbsp;&nbsp;
</div>

<table cellpadding="5" cellspacing="3" class="tbmat"> 
	<caption>MIS CURSOS</caption><br>
	<thead bgcolor="#408080" style="color:#FFFFFF">
		<tr>
			<th>COD.</th>
			<th>NOMBRE DEL CURSO</th>
			<th>CICLO</th>
			<th>CRED.</th>
			<th>CAPACIDAD</th>
			<th>ESTADO</th>
			<th>NOTA</th>
		</tr>
	</thead>
	<tbody bgcolor="#AEFFFF">
	<?php
	while($fila = $result->fetch())
		{
				
			$sql = "SELECT count(*) from matricula where ciclo='".$cic."' and curso=".$fila[0];
			//select * from matricula where ciclo='2013-I' and curso=1;
			$rsa = $db->prepare($sql);
			$rsa->execute();
			$row1 = $rsa->fetch();

			$sql2 = "SELECT capacidad FROM cursos where codigo=".$fila[0];
			$rsb = $db->prepare($sql2);
			$rsb->execute();
			$row2 = $rsb->fetch();

			if ($row1[0]<$row2[0]){
				$capac="DISPONIBLE";
			}else{
				$capac="LLENO";
			}


			$sql3 = "select count(prerequisito) as cantidad 
					from prerequisitos where curso=".$fila[0]
					." and prerequisito not in (select curso from notas where alumno=".$alu
					." and nota>=11)";
			$rs3 = $db->prepare($sql3);
			$rs3->execute();
			$row3 = $rs3->fetch();

			if ($row3[0]==0){	
				$color="#80FF80";	
			}else{
				$color="#FF7171";
			}

			$sql3 = "SELECT count(*) as APROB from notas where alumno=".$alu
					." and curso=".$fila[0]
					." and nota>=11";

			
			$rs3 = $db->prepare($sql3);
			$rs3->execute();
			$row3 = $rs3->fetch();

			if ($row3[0]>0){	
				$est="APROBADO";
				$color="#C0C0C0";
				$txtcolor="#808080";
			}else{
				$est="-----";
				$txtcolor="#000000";
			}

	?>
	<tr bgcolor="<?php echo $color;?>" style="color:<?php echo $txtcolor;?>">
		<td align="center"><?php echo $fila[0]?></td>
		<td><?php echo $fila[1]?></td>
		<td align="center"><?php echo $fila[2]?></td>
		<td align="center"><?php echo $fila[3]?></td>
		<td align="center"><?php echo $fila[4]?></td>
		<td align="center" class="capac"><?php echo $capac?></td>
		<td align="center"><?php echo $est?></td>
	</tr>
	
	<?php
		}
	?>
	</tbody>
</table>
<?php $db = null; ?>

<br>

<table cellpadding="3" cellspacing="3" width="25%" class="tbleyenda">
		<tr>
			<td bgcolor="#C0C0C0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>CURSO APROBADO</td>
		</tr>

		<tr>
			<td bgcolor="#80FF80">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>APTO (prerequisitos aprobados)</td>
		</tr>
	
		<tr>
			<td bgcolor="#FF7171">&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>NO APTO (prerequisitos desaprobados)</td>
		</tr>
</table>



</body>
</html>