<?php 

	$alu = $_GET["alu"];
	$cic = $_GET["cic"];
	$cur = $_GET["cur"];
	
	require 'conex.php';

	$sql3 = "insert into matricula (alumno, ciclo, curso) 
					 values ('".$alu."', '".$cic."', '".$cur."');";

	$rs3 = $db->prepare($sql3);
	$rs3->execute();


echo "<script language='JavaScript' type='text/javascript'>
		location.href='matricula1.php?id=$alu'		
	 	</script>";

?>