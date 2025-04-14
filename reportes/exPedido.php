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
if ($_SESSION['ventas']==1)
{
//Incluímos el archivo Factura.php
require('Pedido.php');
require ('General.php');

//Establecemos los datos de la empresa
$logo = "logo.jpg";
$ext_logo = "jpg";
$empresa = "Ferreteria Beardi";
$documento = "20477157772";
$telefono = "931742904";
$email = "nellyrivas@gmail.com";

//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/Pedido.php";
$pedido= new Pedido();
$id=$_GET["id"];
$rsptav = $pedido->listarcab($id);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();

//Establecemos la configuración de la factura
$pdf = new PDF_Invoice('P', 'mm', 'A4');
$pdf->AddPage();

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($empresa),
                  $documento."\n" .
                  utf8_decode("Teléfono: ").$telefono."\n" .
                  "Email : ".$email,$logo,$ext_logo);
$pdf->temporaire( "" );
$pdf->addDate( $regv->fecha);

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addProveedorAdresse(utf8_decode($regv->proveedor),"Usuario: ".$regv->usuario,"Monto Total: ".$regv->monto_total);

//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "Nro Pedido"=>23,
             "Articulo"=>78,
             "Cantidad"=>22,
             "Precio Compra"=>25,
             "SUBTOTAL"=>22);
$pdf->addCols( $cols);
$cols=array( "Nro Pedido"=>"L",
             "Articulo"=>"L",
             "Cantidad"=>"C",
             "Precio Compra"=>"R",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 89;

//Obtenemos todos los detalles de la venta actual
$rsptad = $pedido->listarped($id);

while ($regd = $rsptad->fetch_object()) {
  $line = array( "Nro Pedido"=> "$regd->idpedido",
                "Articulo"=> utf8_decode("$regd->nombre"),
                "Cantidad"=> "$regd->cantidad",
                "Precio Compra"=> "$regd->precio_compra",
                "SUBTOTAL"=> "$regd->subtotal");
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
}


$pdf->Output('Reporte de Pedido','I');
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>