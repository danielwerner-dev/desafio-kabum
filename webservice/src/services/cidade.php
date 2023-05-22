<?php

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    $responseWS->addStatus("ERRO");
    $responseWS->getResponseCode(500);
    throw new Exception("Verbo HTTP não permitido");    
}

if (empty($data["param"])) {
    $responseWS->addStatus("REQUIRED_VALUE");
    $responseWS->getResponseCode(400);
    throw new Exception("O ID é obrigatório!");
}

$cidadeDAO = new \Lib\DAO\CidadeDAO($connection);

$responseWS->getResponseCode(200);
$responseWS->addData([
    "cidades" => $cidadeDAO->listAll($data["param"])
]);