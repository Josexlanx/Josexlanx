<?php

require_once "../Controladores/secretariasC.php";
require_once "../Modelos/secretariasM.php";

class SecretariaA{

    public $Pid;

    public function ESecretariasA(){
        $columna = "id";
        $valor = $this->id;

        $resultado = SecretariasC::SecretariasC($columna, $valor);

        echo json_encode($resultado);
    }
}

if(isset($_POST["id"])){
    $eP = new SecretariasA();
    $eP -> Pid = $_POST["id"];
    $eP -> ESecretariasA();
}

?>
