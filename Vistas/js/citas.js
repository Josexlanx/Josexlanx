$(".DT").on("click", ".EliminarCita", function(){
    // Mostrar confirmación antes de eliminar
    var val = confirm('¿Estás seguro de que deseas eliminar esta cita?');
    
    if (val) {
        // Si el usuario confirma, continuar con la eliminación
        var idCita = $(this).attr("idCita");

        $.ajax({
            url: "/proyectoclinica/Ajax/citasA.php",
            method: "POST",
            data: { idCita: idCita },
            success: function(respuesta) {
                if (respuesta == "ok") {
                    // Recargar la página si la eliminación es exitosa
                    window.location = "";
                } else {
                    // Mostrar mensaje de error si la eliminación falla
                    alert("Error al eliminar la cita.");
                }
            }
        });
    }
});
