<?php

require_once "../Controladores/pacientesC.php";
require_once "../Modelos/pacientesM.php";

class PacientesA{

    public $Pid;

    public function EPacienteA(){
        $columna = "id";
        $valor = $this->Pid;

        $resultado = PacientesC::PacienteC($columna, $valor);

        echo json_encode($resultado);
    }
}

if(isset($_POST["Pid"])){
    $eP = new PacientesA();
    $eP -> Pid = $_POST["Pid"];
    $eP -> EPacienteA();
}


else if (isset($_POST['id_paciente'])) { // Cambia 'id_paciente' por cualquier campo relevante del formulario de historial
    $crearHistorial = new PacientesC();
    $crearHistorial->CrearHistorialOdontoC();
} 
else {
    echo json_encode(['error' => 'Solicitud no válida o parámetros faltantes']);
}

?>
