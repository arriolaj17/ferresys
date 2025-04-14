var tabla;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	
}

//Función mostrar formulario
function mostrarform(flag)
{
	
	if (flag)
	{
		$("#listadoregistros").show();
	}
	else
	{
		$("#listadoregistros").show();
	}

}
//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(true);
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
					url: '../ajax/comprarealizada.php?op=listar',
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

//Función Listar




init();