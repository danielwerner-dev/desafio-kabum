<?php
require_once("./src/settings/config.php");

// Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods:  POST, GET, PATCH, DELTE");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");  


// Header da requisição
$headers = apache_request_headers();

//Objeto de resposta do webservice
$responseWS = new Lib\Webservice\ResponseWS();

try {
    $serviceName = isset($_GET["service"]) ? $_GET["service"] : null;
    $id = isset($_GET["id"]) ? $_GET["id"] : null;
    $tokenHeader = null;

    $token = new Lib\Webservice\Token();
    
    //Objeto de conexão com o banco de dados
    $connection = Lib\Database\Connection::getConnection();
    
    //Processa a requisição
    $service = new Lib\Webservice\Service($serviceName, $id);
    
    //processo a requisição para saber qual verbo está sendo usado
    $data = $service->processesRequest();
    
    if(empty($data)){
        $responseWS->addStatus("ERROR");
        throw new Exception("O serviço não existe!");
    }
    
    $ignoreService = "login";
    if($data["service"] != $ignoreService){
        
        //Verifico se o token veio no HEADER
        if(isset($headers["Authorization"]) && !empty($headers["Authorization"])) {
            $tokenHeader = $headers["Authorization"];
        } else {
            $responseWS->addStatus("ERROR");
            throw new Exception("Token não encontrado!");
        }
    
        //Verifico se o token é válido e se o serviço não é o login
        if($token->validToken($tokenHeader) == false){
            $responseWS->addStatus("ERROR");
            throw new Exception("Token invalido!");
        }
    }    
    
    require_once(_SERVICE_ . DIRECTORY_SEPARATOR . $data["service"] . ".php");
} catch (Exception $ex) {
    $responseWS->addResponseMessage($ex->getMessage());
}

//retorno do web service
echo $responseWS->getResponse();

