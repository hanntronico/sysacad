<?php 
session_start();
require 'conex.php';
$codcur = $_GET["cur"];
$cic = $_SESSION["cic"];

// echo $_GET["cur"];

// SELECT * FROM notas WHERE curso=1 and ciclo='2012-II' and nota >=11 
// SELECT * FROM notas WHERE curso=1 and ciclo='2012-II' and nota<11

$sql="SELECT * FROM notas WHERE curso=".$codcur." and ciclo='".$cic."' and nota >=11";
// echo $sql."<br>";
$result = $db->prepare("SET NAMES utf8");
$result->execute();
$rs1 = $db->prepare($sql);
$rs1->execute();
// $row1 = $rs1->fetch();
$numfilas = $rs1->rowCount();
$a = $numfilas;
 
// echo "filas:".$numfilas; 

$sql="SELECT * FROM notas WHERE curso=".$codcur." and ciclo='".$cic."' and nota < 11";
// echo $sql."<br>";
$result = $db->prepare("SET NAMES utf8");
$result->execute();
$rs1 = $db->prepare($sql);
$rs1->execute();
// $row1 = $rs1->fetch();
$numfilas = $rs1->rowCount();
$d = $numfilas;

// echo "filas:".$numfilas; 

Header("Content-type: image/png");
//Header( "Content-type: image/jpeg");

if($bkg == "") $bkg="C0C0C0";
if($wdt == "") $wdt=400;
if($hgt == "") $hgt=180;

	$por = array();
	$dato = array();
	$dato = split(",", str_replace(" ","",168));
	
	$archivo_fuente = 'graficos/coolvetica.ttf';

	// echo $dato[0].$por[0];
	// exit();

	/* crea imagen */
	$image = imagecreate($wdt +1,$hgt+80);

	// librerias de Colores y Funciones
	include('graficos/libcolores.php');
	include('graficos/libfunciones.php');

	sscanf($bkg, "%2x%2x%2x", $rr, $gg, $bb);
	$colorbkg = ImageColorAllocate($image,$rr,$gg,$bb);

	// crea bkg blanco
	ImageFilledRectangle($image,0,0,$wdt +1,$hgt+80,$colorbkg);

	$nvars = 0;
	foreach ($dato as $valor) {
  		$total += $dato[$i];
		$nvars++;
	}

	for ($i = 0;$i < $nvars;$i++)
		$total += $dato[$i];

	// for ($i = 0; $i < $nvars; $i++)
	// 	$por[$i] = ($dato[$i] * 360) / $total;

	$inicio = 0;
	$final = 0;

	for ($j = ($hgt/2)+15;$j > $hgt/2;$j--) {
		for ($i = 0, $c = 1;$i < $nvars;$i++,$c+=3) {
			$final += $por[$i];
			imagefilledarc ($image, $wdt/2, $j, $wdt, $hgt, $inicio, $final, $colores[$c], IMG_ARC_PIE);
			$inicio = $final;
		}
	}

	
//	aprobados: 15; desarpobados= 6


	//  0.71=255.6  -  0.29=104.4

	// $a=16;
	// $d=8;

	if (($a+$d)!=0){
		$aprob = round(($a/($a+$d))*360, 0);
		$desaprob = round(($d/($a+$d))*360, 0);

		imagefttext($image, 13, 0, 50, 225, $colores[26], $archivo_fuente, 'APROBADOS: '.$a);
		imagefttext($image, 13, 0, 50, 245, $colores[5], $archivo_fuente, 'DESAPROBADOS: '.$d);

	}else {
		$aprob =0;
		$desaprob=0;
		imagefttext($image, 13, 0, 50, 225, $colores[1], $archivo_fuente, 'SIN NOTAS REGISTRADAS');

	}

	// echo "aprobados: ".$aprob."; desarpobados: ".$desaprob;
	// exit();

	if($a!=0) {
			$inicio = 0;
			$final = $aprob;

			for ($i = 0, $c = 26;$i < $nvars;$i++, $c+=3) {
				$final += $por[$i];
				imagefilledarc ($image, $wdt/2, $hgt/2, $wdt, $hgt, $inicio, $final, $colores[$c], IMG_ARC_PIE);
				$inicio = $final;
			}
		}


	if($d!=0) {	
		$inicio = $aprob;
		$final = 360;

		for ($i = 0, $c = 5;$i < $nvars;$i++, $c+=3) {
			$final += $por[$i];
			imagefilledarc ($image, $wdt/2, $hgt/2, $wdt, $hgt, $inicio, $final, $colores[$c], IMG_ARC_PIE);
			$inicio = $final;
		}
	}	




/* Realiza la generacion del grafico */
ImagePNG($image);
//ImageJPEG($image,'',100);

/* Vacia la memoria */
ImageDestroy($image);

?>

