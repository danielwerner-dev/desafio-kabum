<?php
$body = $service->getBody();

if(empty($body["login"]) || empty($body["senha"])) {
    $responseWS->addStatus("REQUIRED_VALUE");
    $responseWS->getResponseCode(400);
    throw new Exception("Login e senha são obrigatórios!");
}

$usuarioVO =  new \Lib\VO\Usuario();
$usuarioVO->setLogin($body["login"]);
$usuarioVO->setSenha($body["senha"]);

$login = $usuarioVO->getLogin();
$senha = $usuarioVO->getSenha();

// DAO
$usuarioDAO =  new \Lib\DAO\UsuarioDAO($connection);

if ($usuarioDAO->authenticate($login, $senha)) {
    // Token
    $tokenUser = new \Lib\Webservice\Token([$login, time()]);
    $sessionToken = $tokenUser->generateToken();
    $responseWS->getResponseCode(200);
    $responseWS->addData([
        "token" => $sessionToken,
        "sessionData" => $usuarioDAO->getDataSession()
    ]);
} else {
    $responseWS->addResponseMessage("Usuário ou senha inválidos!");
    $responseWS->getResponseCode(401);    
}