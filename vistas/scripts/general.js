var tabla;

//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
	
	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#idglobal").val("");
	$("#empresa").val("");
	$("#impuesto").val("");
	$("#porcentaje").val("");
	$("#simbolo_imagen").val("");
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
					url: '../ajax/general.php?op=listar',
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
		url: "../ajax/general.php?op=guardaryeditar",
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

function mostrar(idglobal)
{
	$.post("../ajax/general.php?op=mostrar",{idglobal : idglobal}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#empresa").val(data.empresa);
		$("#impuesto").val(data.impuesto);
		$("#porcentaje").val(data.porcentaje);
		$("#simbolo_moneda").val(data.simbolo_moneda);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/general/"+data.imagen);
		$("#imagenactual").val(data.imagen);
		$("#idglobal").val(data.idglobal);
 	})
}

//Función para desactivar registros
function desactivar(idglobal)
{
	bootbox.confirm("¿Está Seguro de desactivar la Empresa?", function(result){
		if(result)
        {
        	$.post("../ajax/general.php?op=desactivar", {idglobal : idglobal}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idglobal)
{
	bootbox.confirm("¿Está Seguro de activar la Empresa?", function(result){
		if(result)
        {
        	$.post("../ajax/general.php?op=activar", {idglobal : idglobal}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}
init();