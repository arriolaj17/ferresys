<?php 
require_once "../modelos/Unidad_Medida.php";

$unidad_medida=new Unidad_Medida();

$idunidad_medida=isset($_POST["idunidad_medida"])? limpiarCadena($_POST["idunidad_medida"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$prefijo=isset($_POST["prefijo"])? limpiarCadena($_POST["prefijo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idunidad_medida)){
			$rspta=$unidad_medida->insertar($nombre,$prefijo);
			echo $rspta ? "Unidad de Medida registrada" : "Unidad de Medida no se pudo registrar";
		}
		else {
			$rspta=$unidad_medida->editar($idunidad_medida,$nombre,$prefijo);
			echo $rspta ? "Unidad de Medida actualizada" : "Unidad de Medida no se pudo actualizar";
		}
	break;

	case 'activar':
		$rspta=$unidad_medida->activar($idunidad_medida);
 		echo $rspta ? "Unidad de Medida activada" : "Unidad de Medida no se puede activar";
	break;

	case 'desactivar':
		$rspta=$unidad_medida->desactivar($idunidad_medida);
 		echo $rspta ? "Unidad de Medida Desactivada" : "Unidad de Medida no se puede desactivar";
	break;

	case 'mostrar':
		$rspta=$unidad_medida->mostrar($idunidad_medida);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$unidad_medida->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->prefijo,
 				"3"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idunidad_medida.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idunidad_medida.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idunidad_medida.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idunidad_medida.')"><i class="fa fa-check"></i></button>');
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
