
$(".DT").on("click", ".EliminarSecretaria", function(){

	val = confirm('¿Estás seguro de que deseas eliminar ala secretaria?');	
	if (val){
		var Sid = $(this).attr("id");
		var imgS = $(this).attr("imgS");

		window.location = "index.php?url=secretarias&Sid="+Sid+"&imgS="+imgS;
	}

})


$(document).ready(function(){
    $(".EditarSecretaria").click(function(){
        var id = $(this).data("id");
        var apellido = $(this).data("apellido");
        var nombre = $(this).data("nombre");
        var usuario = $(this).data("usuario");
        var clave = $(this).data("clave");

        $("#Sid").val(id);
        $("#apellidoE").val(apellido);
        $("#nombreE").val(nombre);
        $("#usuarioE").val(usuario);
        $("#claveE").val(clave);
    });
});



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
