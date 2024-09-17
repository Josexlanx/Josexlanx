<?php

require_once "../Controladores/pacientesC.php";
require_once "../Modelos/pacientesM.php";

class HistorialA {

    public $datos;

    public function ActualizarHistorialA() {
        $datos = $this->datos;

        $controlador = new PacientesC();
        $resultado = $controlador->ActualizarHistorialC($datos);

        echo json_encode($resultado);  // Enviar respuesta de éxito o error en formato JSON
    }
}

if (isset($_POST["id_paciente"])) {
    $actualizarHistorial = new HistorialA();
    $actualizarHistorial->datos = $_POST;  // Asignar los datos del formulario enviados por AJAX
    $actualizarHistorial->ActualizarHistorialA();
}
?>
