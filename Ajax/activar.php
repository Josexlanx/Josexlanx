<?php
// Activar la depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Encabezado para indicar que se devuelve JSON
header('Content-Type: application/json');

require_once "../Controladores/inicioC.php";
require_once "../Modelos/inicioM.php";

class ActivacionA {
    public $clave;

    public function ActivarSistema() {
        $clave = $this->clave;

        // Instancia la clase InicioC y llama a su método activarSistema
        $inicio = new InicioC(); 
        $resultado = $inicio->activarSistema($clave); 

        // Asegúrate de enviar la respuesta correcta en formato JSON
        if ($resultado) {
            echo json_encode(['estado' => 'activado', 'mensaje' => 'Sistema activado con éxito.']); // Sistema activado con éxito
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Clave incorrecta. Por favor, intente de nuevo.']); // Clave incorrecta
        }
    }
}

if (isset($_POST["clave"])) {
    $activar = new ActivacionA();
    $activar->clave = $_POST["clave"];
    $activar->ActivarSistema();
} else {
    echo json_encode(['estado' => 'error', 'mensaje' => 'No se recibió la clave de activación']); // Manejo de error
}
?>