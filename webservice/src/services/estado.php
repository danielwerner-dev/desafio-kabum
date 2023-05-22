<?php

switch($_SERVER["REQUEST_METHOD"] ){
    case "GET":
        $estadoDAO = new \Lib\DAO\EstadoDAO($connection);


        $responseWS->addData(
            array(
                "estados" => $estadoDAO->listAll()
            )
        );
        
        $responseWS->getResponseCode(200);
    break;
    default:
        $responseWS->addStatus("ERRO");
        $responseWS->getResponseCode(500);
        throw new Exception("Verbo HTTP não permitido");    
}