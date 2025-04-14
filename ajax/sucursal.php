<?php 
require_once "../modelos/Sucursal.php";
session_start();
$sucursal=new Sucursal();

$idsucursal=isset($_POST["idsucursal"])? limpiarCadena($_POST["idsucursal"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$nro_documento=isset($_POST["nro_documento"])? limpiarCadena($_POST["nro_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$representante=isset($_POST["representante"])? limpiarCadena($_POST["representante"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/sucursal/" . $imagen);
			}
		}
		if (empty($idsucursal)){
			$rspta=$sucursal->insertar($razon_social,$tipo_documento,$nro_documento,$direccion,$telefono,$email,$representante,$imagen);
			echo $rspta ? "Sucursal registrada" : "Sucursal no se pudo registrar";
		}
		else {
			$rspta=$sucursal->editar($idsucursal,$razon_social,$tipo_documento,$nro_documento,$direccion,$telefono,$email,$representante,$imagen);
			echo $rspta ? "Sucursal registrada" : "Sucursal no se pudo actualizar";
		}
	break;

	case 'activar':
		$rspta=$sucursal->activar($idsucursal);
 		echo $rspta ? "Sucursal activada" : "Sucursal no se puede activar";
	break;

	case 'desactivar':
		$rspta=$sucursal->desactivar($idsucursal);
 		echo $rspta ? "Sucursal Desactivada" : "Sucursal no se puede desactivar";
	break;

	case 'mostrar':
		$rspta=$sucursal->mostrar($idsucursal);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$sucursal->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"1"=>$reg->razon_social,
 				"2"=>$reg->direccion,
 				"3"=>$reg->telefono,
 				"4"=>$reg->representante,
 				"5"=>"<img src='../files/sucursal/".$reg->imagen."' height='50px' width='50px' >",
 				"6"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idsucursal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idsucursal.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idsucursal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idsucursal.')"><i class="fa fa-check"></i></button>');
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>