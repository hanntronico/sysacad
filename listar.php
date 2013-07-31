<?php
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
	<title>MATRICULA</title>
</head>
<body>



<table border="1" cellpadding="5" cellspacing="1" width="50%" bgcolor="#2871C8" style="color:#FAC9AB;">
	<tr>
		<th>ID</td>
		<th>CURSO</td>
	</tr>
	<?php
	while($fila = $result->fetch())
	{
	?>
	<tr>
		<td><?php echo $fila[0]?></td>
		<td><?php echo $fila[1]?></td>
	</tr>
	<?php
	}
	?>
</table>
<!-- <a href="index.php">Men&uacute;</a> -->
<?php
$db = null;
?>

</body>
</html>