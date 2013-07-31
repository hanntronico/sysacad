<?php

session_start();

// $alu = $_SESSION["alu"];

$alu = $_GET["alum"];

// echo $_GET["alum"];

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	public function LoadData($file) {
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line) {
			$data[] = explode(';', chop($line));
		}
		return $data;
	}

	// Colored table
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		
		$this->SetFillColor(64, 128, 128);
		$this->SetTextColor(255);
		$this->SetDrawColor(64, 128, 128);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(15, 80, 20, 20);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach($data as $row) {
			$this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
			$this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
			$this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 011');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

require '../../conex.php';

$result = $db->prepare("SET NAMES utf8");
$result->execute();
$rs = $db->prepare("select * from alumnos where codigo=".$alu);
$rs->execute();
$row = $rs->fetch();


// set default header data
$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, "REPORTE DE CURSOS QUE PUEDE MATRICULARSE  ".date("d/m/Y"), "Alumno : ".$row[0]." - ".$row[1]);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// column titles
//$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
$header = array('COD.', 'CURSO', 'CICLO','CREDITOS');

// data loading
//$data = $pdf->LoadData('data/table_data_demo.txt');



// $sql = "select cursos.codigo, cursos.nombre, cursos.ciclo, cursos.creditos 
// 					from matricula, cursos 
// 					where matricula.curso = cursos.codigo
// 					and matricula.ciclo = '2013-I' 					
// 					and matricula.alumno =".$alu

$sql = "select cursos.codigo, cursos.nombre, cursos.ciclo, cursos.creditos 
		from cursos where codigo in 
		(select prerequisito from prerequisitos where prerequisitos.prerequisito not in 
		(select curso from notas where alumno=".$alu." and nota>=11))";

// echo $sql;
// exit(); 

$result = $db->prepare("SET NAMES utf8");
$result->execute();
$rs = $db->prepare($sql);
$rs->execute();

while($row = $rs->fetch())
	{

		
// SELECT count(*) from matricula where ciclo='2013-I' and curso=1
// SELECT capacidad FROM cursos where codigo=1

			$sql = "SELECT count(*) from matricula where ciclo='".$cic."' and curso=".$row[0];
			$rsa = $db->prepare($sql);
			$rsa->execute();
			$row1 = $rsa->fetch();

			$sql2 = "SELECT capacidad FROM cursos where codigo=".$row[0];
			$rsb = $db->prepare($sql2);
			$rsb->execute();
			$row2 = $rsb->fetch();

			// echo $sql.$sql2."<br>"; 

			if ($row1[0]<$row2[0]){
				// $capac="DISPONIBLE";
				// echo "hann ".$row[0];
				$data[] = array(
					0 =>$row[0],
					1 =>$row[1],
					2 =>$row[2],
					3 =>$row[3]
					);
			}else{
				// $capac="LLENO";
			}
	}	

// echo "<br>"."<br>";
// exit();

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('reporte.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
