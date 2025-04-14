<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['reportes']==1)
{


require "../config/Conexion.php";


//Inlcuímos a la clase PDF_MC_Table
require('../reportes/PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();
 
//Agregamos la primera página al documento pdf
$pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
 
//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',12);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'Ferreteria Beardi',1,0,'C'); 
$pdf->Ln(10);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'Ventas Semanales',1,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(58,6,'Nombre del Usuario',1,0,'C',1); 
$pdf->Cell(27,6,utf8_decode('Monto Compra'),1,0,'C',1);
$pdf->Cell(35,6,'Fecha',1,0,'C',1);
 
$pdf->Ln(10);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Consultas.php";
$consulta = new Consultas();

$rspta = $consulta->comprasultimosdias();

//Table with 20 rows and 4 columns
$pdf->SetWidths(array(58,30,27,35,25));

while($reg= $rspta->fetch_object())
{  
    $nombre = $reg->nombre;
    $total = $reg->total;
    $fecha = $reg->fecha;
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($nombre),$total,$fecha));
}
 
//Mostramos el documento pdf
$pdf->Output();
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>