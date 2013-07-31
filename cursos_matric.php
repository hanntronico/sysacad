<?php 
//echo $_GET["alu"];

$alu = $_GET["alu"];

require 'conex.php';

$result = $db->prepare("SET NAMES utf8");
$result->execute();
$rs = $db->prepare("select cursos.codigo, cursos.nombre, cursos.creditos, cursos.ciclo 
					from matricula, cursos 
					where matricula.curso = cursos.codigo
					and matricula.ciclo = '2013-I' 					
					and matricula.alumno =".$alu);
$rs->execute();
$numfilas = $rs->rowCount();
?>

<?php  
if ($numfilas>0) {
?>	

	<table cellpadding="5" cellspacing="3" class="tbini">
		<thead>
			<tr>
				<td align="center">COD.</td>
				<td align="center">NOMBRE DEL CURSO</td>
				<td align="center">CREDITO</td>
				<td align="center">CICLO</td>
			</tr>
		</thead>
		
		<tbody>
		<?php
		while($row = $rs->fetch())
			{
		?>
		<tr>
			<td align="center" width="8%"><?php echo $row[0]?></td>
			<td width="70%"><?php echo $row[1]?></td>
			<td align="center"><?php echo $row[2]?></td>
			<td align="center"><?php echo $row[3]?></td>
		</tr>
		<?php
			}
		?>
		</tbody>
	</table>

<?php
}else{
?>
<table cellpadding="5" cellspacing="3" class="tbini">
 	<tbody>
 		<tr>
 			<th>Ningun registro</th>
 		</tr>
 	</tbody>
 </table> 

<?php } ?>

