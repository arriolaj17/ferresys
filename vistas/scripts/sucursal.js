var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
	$("#idsucursal").val("");
	$("#razon_social").val("");
	$("#tipo_documento").val("");
	$("#nro_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#representante").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/sucursal.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/sucursal.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idsucursal)
{
	$.post("../ajax/sucursal.php?op=mostrar",{idsucursal : idsucursal}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

 		
		$("#razon_social").val(data.razon_social);
		$("#tipo_documento").val(data.tipo_documento);
		$("#nro_documento").val(data.nro_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#representante").val(data.representante);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/sucursal/"+data.imagen);
		$("#imagenactual").val(data.imagen);
		$("#idsucursal").val(data.idsucursal);

 	})
}

//Función para desactivar registros
function desactivar(idsucursal)
{
	bootbox.confirm("¿Está Seguro de desactivar la Sucursal?", function(result){
		if(result)
        {
        	$.post("../ajax/sucursal.php?op=desactivar", {idsucursal : idsucursal}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idsucursal)
{
	bootbox.confirm("¿Está Seguro de activar la Sucursal?", function(result){
		if(result)
        {
        	$.post("../ajax/sucursal.php?op=activar", {idsucursal : idsucursal}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();