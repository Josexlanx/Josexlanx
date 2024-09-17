<?php
// Activar la depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once "../Controladores/inicioC.php";
require_once "../Modelos/inicioM.php";

class VerificarActivacionA {
    public function ComprobarEstado() {
        $inicio = new InicioC(); // Crear una instancia de InicioC
        $respuesta = $inicio->verificarActivacion(); // Llamar al método no estático
        echo json_encode($respuesta);
    }

    public function IniciarPrueba() {
        $inicio = new InicioC(); // Crear una instancia de InicioC
        $fechaInicio = $inicio->obtenerFechaInicioPrueba(); // Obtener la fecha de inicio de la prueba
        if (!$fechaInicio) {
            $exito = $inicio->establecerFechaPrueba(date('Y-m-d')); // Establecer la fecha de prueba
            echo json_encode(['exito' => $exito]);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'La fecha de prueba ya está establecida']); 
        }
    }
}

if (isset($_POST["accion"])) {
    $verificar = new VerificarActivacionA();
    if ($_POST["accion"] == "verificar") {
        $verificar->ComprobarEstado();
    } elseif ($_POST["accion"] == "iniciar_prueba") {
        $verificar->IniciarPrueba();
    }
} else {
    echo json_encode(['error' => 'No se recibió la acción']); 
}
?>
