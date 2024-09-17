<?php
require_once "../Controladores/citasC.php";
require_once "../Modelos/citasM.php";

class CitasA {
    public $idCita;

    public function ECitaA() {
        $idCita = $this->idCita;
        $respuesta = CitasC::EliminarCitaC($idCita);
        echo $respuesta;
    }
}

if (isset($_POST["idCita"])) {
    $eC = new CitasA();
    $eC->idCita = $_POST["idCita"];
    $eC->ECitaA();
}
?>
