<?php 
require_once "../modelos/Role.php";

$role=new Role();

$idrole=isset($_POST["idrole"])? limpiarCadena($_POST["idrole"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		
		if (empty($idrole)){
			$rspta=$role->insertar($nombre,$_POST['permiso']);
			echo $rspta ? "Role registrado" : "Role no se pudo registrar";
		}
		else {
			$rspta=$role->editar($idrole,$nombre,$_POST['permiso']);
			echo $rspta ? "Role actualizado" : "Role no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$role->eliminar($idrole);
 		echo $rspta ? "Role eliminado" : "Role no se puede eliminar";
	break;

	case 'mostrar':
		$rspta=$role->mostrar($idrole);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	
	case 'listar':
		$rspta=$role->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idrole.')"><i class="fa fa-pencil"></i></button>'.' <button class="btn btn-danger" onclick="eliminar('.$reg->idrole.')"><i class="fa fa-close"></i></button>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'permisos':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../modelos/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();

		//Obtener los permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $role->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores=array();

		//Almacenar los permisos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idpermiso);
			}

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
				{
					$sw=in_array($reg->idpermiso,$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
				}
	break;
}
?>