<?php 
require_once "../modelos/General.php";

$general=new General();

$idglobal=isset($_POST["idglobal"])? limpiarCadena($_POST["idglobal"]):"";
$empresa=isset($_POST["empresa"])? limpiarCadena($_POST["empresa"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$porcentaje=isset($_POST["porcentaje"])? limpiarCadena($_POST["porcentaje"]):"";
$simbolo_moneda=isset($_POST["simbolo_moneda"])? limpiarCadena($_POST["simbolo_moneda"]):"";
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/general/" . $imagen);
			}
		}
		if (empty($idglobal)){
			$rspta=$general->insertar($empresa,$impuesto,$porcentaje,$simbolo_moneda,$imagen);
			echo $rspta ? "Datos registrados" : "Datos no se pudieron registrar";
		}
		else {
			$rspta=$general->editar($idglobal,$empresa,$impuesto,$porcentaje,$simbolo_moneda,$imagen);
			echo $rspta ? "Datos actualizados" : "Datos no se pudieron actualizar";
		}
	break;

	case 'activar':
		$rspta=$general->activar($idglobal);
 		echo $rspta ? "Empresa activada" : "Empresa no se puede activar";
	break;

	case 'desactivar':
		$rspta=$general->desactivar($idglobal);
 		echo $rspta ? "Empresa Desactivada" : "Empresa no se puede desactivar";
	break;

	case 'listar':
		$rspta=$general->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idglobal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idglobal.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idglobal.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idglobal.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->idglobal,
 				"2"=>$reg->empresa,
 				"3"=>$reg->impuesto,
 				"4"=>$reg->porcentaje,
 				"5"=>$reg->simbolo_moneda,
 				"6"=>"<img src='../files/general/".$reg->imagen."' height='50px' width='50px' >",
 				"7"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'mostrar':
		$rspta=$general->mostrar($idglobal);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
}
?>