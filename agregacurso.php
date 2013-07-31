<?php 
session_start();

$cur = $_GET["cur"];
$alu = $_SESSION["alu"];
$cic = $_SESSION["cic"];

require 'conex.php';


$result = $db->prepare("SET NAMES utf8");
$result->execute();
$consulta = "SELECT count(*) from matricula where alumno=".$alu." and curso=".$cur." and ciclo='".$cic."'";
$rs = $db->prepare($consulta);
$rs->execute();
$row = $rs->fetch();

if($row[0]>0){
	echo "<script language='JavaScript' type='text/javascript'>"
		."alert('ALUMNO YA SE MATRICULO EN ESTE CURSO');</script>";
		exit();
}


$result = $db->prepare("SET NAMES utf8");
$result->execute();
$consulta = "SELECT count(*) as APROB from notas where alumno=".$alu." and curso=".$cur." and nota>=11";

$rs = $db->prepare($consulta);
$rs->execute();
$row = $rs->fetch();
//echo $row[0];
//exit();

if($row[0]>0){
	echo "<script language='JavaScript' type='text/javascript'>"
	."alert('EL CURSO HA SIDO APROBADO');</script>";
	exit();
}



$rs = $db->prepare("Select creditos from cursos where codigo=".$cur);
$rs->execute();
$row = $rs->fetch();
$codactual = $row[0];

$consulta = "select sum(creditos) from matricula, cursos where matricula.curso = cursos.codigo".
			" and matricula.ciclo = ".$cic.
			" and matricula.alumno =".$alu;
$rs = $db->prepare($consulta);
$rs->execute();
$row = $rs->fetch();
$credsuma = $row[0];

$cred = $credsuma+$codactual;

if($cred>14){
	echo "<script language='JavaScript' type='text/javascript'>"
	."alert('Nº MAXIMO DE CREDITOS SUPERADOS');</script>";
	exit();
}


$result = $db->prepare("SET NAMES utf8");
$result->execute();
$sql = "SELECT count(*) from matricula where curso=".$cur;
$rs1 = $db->prepare($sql);
$rs1->execute();
$row1 = $rs1->fetch();

$sql2 = "SELECT capacidad FROM cursos where codigo=".$cur;
$rs2 = $db->prepare($sql2);
$rs2->execute();
$row2 = $rs2->fetch();

if ($row1[0]<$row2[0]){


		$sql3 = "select count(prerequisito) as cantidad 
		from prerequisitos where curso=".$cur
		." and prerequisito not in (select curso from notas where alumno=".$alu
		." and nota>=11)";
		
		$rs3 = $db->prepare($sql3);
		$rs3->execute();
		$row3 = $rs3->fetch();

		if ($row3[0]==0){

			echo "<script>
			if(confirm('¿Seguro que desea registrar la matricula?'))
			 {
			 	registrar(".$alu.",'".$cic."',".$cur.");
			 }
			else
			 {	return false;}	
			</script>";

		}else {
			echo "<script language='JavaScript' type='text/javascript'>
			 	   alert('NO HA APROBADO PRE-REQUISITOS');
			 	  </script>";
		}
		

}else {
	// echo "<script language='JavaScript' type='text/javascript'>
	// 	   alert('El curso llegado a su maxima capacidad de alumnos');
	// 	  </script>";
}

?>

