<?php
session_start();
require_once "../modelos/Usuario.php";
require_once "../modelos/Role.php";

$usuario=new Usuario();
$role=new Role();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$idsucursal=isset($_POST["idsucursal"])? limpiarCadena($_POST["idsucursal"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$nro_documento=isset($_POST["nro_documento"])? limpiarCadena($_POST["nro_documento"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$idrole=isset($_POST["idrole"])? limpiarCadena($_POST["idrole"]):"";

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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
		}
		//Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clave);

		if (empty($idusuario)){
			$rspta=$usuario->insertar($idsucursal,$nombre,$tipo_documento,$nro_documento,$cargo,$direccion,$telefono,$email,$imagen,$login,$clavehash,$idrole);
			echo $rspta ? "Usuario registrado" : "Usuario registrado";
		}
		else {
			$rspta=$usuario->editar($idusuario,$idsucursal,$nombre,$tipo_documento,$nro_documento,$cargo,$direccion,$telefono,$email,$imagen,$login,$clavehash,$idrole);
			echo $rspta ? "Usuario actualizado" : "Usuario actualizado";
		} 
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
	break;

	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->sucursal,
 				"3"=>$reg->tipo_documento,
 				"4"=>$reg->nro_documento,
 				"5"=>$reg->telefono,
 				"6"=>$reg->email,
 				"7"=>$reg->login,
 				"8"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
 				"9"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
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

	

	case 'verificar':
		$logina=$_POST['logina'];
	    $clavea=$_POST['clavea'];

	    //Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clavea);

		$rspta=$usuario->verificar($logina, $clavehash);

		$fetch=$rspta->fetch_object();

		if (isset($fetch))
	    {
	        //Declaramos las variables de sesión
	        $_SESSION['idusuario']=$fetch->idusuario;
	        $_SESSION['idsucursal']=$fetch->idsucursal;
	        $_SESSION['idrole']=$fetch->idrole;
	        $_SESSION['razon_social']=$fetch->razon_social;
	        $_SESSION['nombre']=$fetch->nombre;
	        $_SESSION['imagen']=$fetch->imagen;
	        $_SESSION['login']=$fetch->login;

	        //Obtenemos los permisos del usuario
	    	$marcados = $role->listarmarcados($fetch->idrole);

	    	//Declaramos el array para almacenar todos los permisos marcados
			$valores=array();

			//Almacenamos los permisos marcados en el array
			while ($per = $marcados->fetch_object())
				{
					array_push($valores, $per->idpermiso);
				}



			//Determinamos los accesos del usuario
			in_array(1,$valores)?$_SESSION['stock']=1:$_SESSION['stock']=0;
			in_array(2,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
			in_array(3,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
			in_array(4,$valores)?$_SESSION['reportes']=1:$_SESSION['reportes']=0;
			in_array(5,$valores)?$_SESSION['configuracion']=1:$_SESSION['configuracion']=0;
			in_array(6,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;


	    }
	    echo json_encode($fetch);
	break;

	case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");

	break;

	case "selectSucursal":
		require_once "../modelos/Sucursal.php";
		$sucursal = new Sucursal();

		$rspta = $sucursal->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idsucursal . '>' . $reg->razon_social . '</option>';
				}
	break;

	case "selectRole":
		require_once "../modelos/Role.php";
		$role = new Role();

		$rspta = $role->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idrole . '>' . $reg->nombre . '</option>';
				}
	break;
}
?>