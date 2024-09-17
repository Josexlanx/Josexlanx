$(".DT").on("click", ".EditarPaciente", function(){

	var Pid = $(this).attr("Pid");
	var datos = new FormData();

	datos.append("Pid", Pid);

	$.ajax({

		url: "Ajax/pacientesA.php",
		method: "POST",
		data: datos,
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,

		success: function(resultado){

			$("#Pid").val(resultado["id"]);
			$("#apellidoE").val(resultado["apellido"]);
			$("#nombreE").val(resultado["nombre"]);
			$("#documentoE").val(resultado["documento"]);
			$("#sexoE").val(resultado["sexo"]);
			$("#fechanacimientoE").val(resultado["fechanacimiento"]);
			$("#edadE").val(resultado["edad"]);
			$("#telefonoE").val(resultado["telefono"]);
			$("#domicilioE").val(resultado["domicilio"]);
			$("#usuarioE").val(resultado["usuario"]);
			$("#claveE").val(resultado["clave"]);

		}

	})

})

$(".DT").on("click", ".EliminarPaciente", function(){
	
	val = confirm('¿Estás seguro de que deseas eliminar este paciente?');	
	if (val){
		var Pid = $(this).attr("Pid");
		var imgP = $(this).attr("imgP");
		window.location = "index.php?url=pacientes&Pid="+Pid+"&imgP="+imgP;
	}
	
	
	

})
$(".DT").DataTable().destroy();
$(".DT").DataTable({
	"pageLength": 100, // Establece el número de registros por defecto a 100
	"language": {
		"sSearch": "Buscar:",
		"sEmptyTable": "No hay datos en la Tabla",
		"sZeroRecords": "No se encontraron resultados",
		"sInfo": "Mostrando registros del _START_ al _END_ de un total _TOTAL_",
		"SInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered": "(filtrando de un total de _MAX_ registros)",
		"oPaginate": {
			"sFirst": "Primero",
			"sLast": "Último",
			"sNext": "Siguiente",
			"sPrevious": "Anterior"
		},
		"sLoadingRecords": "Cargando...",
		"sLengthMenu": "Mostrar _MENU_ registros"
	}
});

