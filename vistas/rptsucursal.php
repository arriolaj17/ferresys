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
$pdf->Cell(100,6,'Lista de Sucursales',1,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(58,6,'Razon Social',1,0,'C',1); 
$pdf->Cell(30,6,utf8_decode('Representante'),1,0,'C',1);
$pdf->Cell(50,6,'Direccion',1,0,'C',1);
$pdf->Cell(35,6,'Telefono',1,0,'C',1);
 
$pdf->Ln(10);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Sucursal.php";
$sucursal = new Sucursal();

$rspta = $sucursal->listar();

//Table with 20 rows and 4 columns
$pdf->SetWidths(array(58,30,50,35));

while($reg= $rspta->fetch_object())
{  
    $razon_social = $reg->razon_social;
    $representante = $reg->representante;
    $direccion = $reg->direccion;
    $telefono =$reg->telefono;
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($razon_social),utf8_decode($representante),utf8_decode($direccion),$telefono));
}
 
//Mostramos el documento pdf
$pdf->Output();

?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>