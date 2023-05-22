<?php

switch($_SERVER["REQUEST_METHOD"]){
    case "POST":
        $body = $service->getBody();

        if (!isset($body["clienteid"])) {
            $responseWS->getResponseCode(401);
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("Informe o id do cliente!");
        }
        
        if (!isset($body["endereco"])) {
            $responseWS->getResponseCode(401);
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("Endereco é obrigatório!");
        }
        
        if (!isset($body["numero"])) {
            $responseWS->getResponseCode(401);
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("Número é obrigatório!");
        }
        
        if (!isset($body["bairro"])) {
            $responseWS->getResponseCode(401);
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("Bairro é obrigatório!");
        }
        
        if (!isset($body["cep"])) {
            $responseWS->getResponseCode(401);
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("Cep é obrigatório!");
        }
        
        $endereco = isset($body["endereco"]) ? $body["endereco"] : "";
        $numero = isset($body["numero"]) ? $body["numero"] : "";
        $cep = isset($body["cep"]) ? $body["cep"] : "";
        $bairro = isset($body["bairro"]) ? $body["bairro"] : "";
        $clienteid = isset($body["clienteid"]) ? $body["clienteid"] : "";
        $estadoid = isset($body["estadoid"]) ? $body["estadoid"] : "";
        $cidadeid = isset($body["cidadeid"]) ? $body["cidadeid"] : "";
        
        $clienteEnderecoVO = new Lib\VO\ClienteEndereco();
        
        $clienteEnderecoVO->setClienteID($clienteid);
        $clienteEnderecoVO->setEndereco($endereco);
        $clienteEnderecoVO->setNumero($numero);
        $clienteEnderecoVO->setCep($cep);
        $clienteEnderecoVO->setBairro($bairro);
        $clienteEnderecoVO->setEstadoID($estadoid);
        $clienteEnderecoVO->setCidadeID($cidadeid);
        $clienteEnderecoVO->setClienteID($clienteid);

        $clienteDAO = new \Lib\DAO\ClienteDAO($connection);
        $clientesExistentes = $clienteDAO->getById($clienteEnderecoVO->getClienteID(), array("nome"));
        
        if (empty($clientesExistentes)) {
            throw new Exception("O id do cliente é inválido!");
        }
   
        $clienteEnderecoDAO = new \Lib\DAO\ClienteEnderecoDAO($connection);
        $id = $clienteEnderecoDAO->cadEndereco($clienteEnderecoVO);
        
        if (!empty($id)) {
            $responseWS->addData(array("id" => $id), "data");
        }
        
        $responseWS->getResponseCode(200);
    break;
    case "GET":
        if (empty($data["param"])) {
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("O ID é obrigatório!");
        }
        
        $id = $data["param"];
        
        $clienteEnderecoVO = new Lib\VO\ClienteEndereco();
        $clienteEnderecoVO->setClienteid($id);
    
        $clienteEnderecoDAO = new \Lib\DAO\ClienteEnderecoDAO($connection);
        $responseWS->addData(
            array(
                "enderecos" => $clienteEnderecoDAO->getAllEnderecoCliente($clienteEnderecoVO->getClienteid())
            )
        );
        
        $responseWS->getResponseCode(200);
    break;
    case "PATCH":
        $body = $service->getBody();

        if (empty($data["param"])) {
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("O ID é obrigatório!");
        }
        
        $endereco = isset($body["endereco"]) ? $body["endereco"] : "";
        $numero = isset($body["numero"]) ? $body["numero"] : "";
        $cep = isset($body["cep"]) ? $body["cep"] : "";
        $bairro = isset($body["bairro"]) ? $body["bairro"] : "";
        $estadoid = isset($body["estadoid"]) ? $body["estadoid"] : "";
        $cidadeid = isset($body["cidadeid"]) ? $body["cidadeid"] : "";
  
        $clienteEnderecoVO = new Lib\VO\ClienteEndereco();
        $clienteEnderecoVO->setId($data["param"]);
        $clienteEnderecoVO->setEndereco($endereco);
        $clienteEnderecoVO->setNumero($numero);
        $clienteEnderecoVO->setCep($cep);
        $clienteEnderecoVO->setBairro($bairro);
        $clienteEnderecoVO->setEstadoID($estadoid);
        $clienteEnderecoVO->setCidadeID($cidadeid);
    
        $clienteEnderecoDAO = new \Lib\DAO\ClienteEnderecoDAO($connection);
        $clienteEnderecoExistente = $clienteEnderecoDAO->getById($clienteEnderecoVO->getId(), array("id, endereco"));
        
        if (empty($clienteEnderecoExistente["id"])) {
            $responseWS->addStatus("USER_NOT_EXISTS");
            throw new Exception("O endereço que você está tentando editar não existe ! ");
        }
        
        $clienteEnderecoDAO->editarEndereco($clienteEnderecoVO);
        $responseWS->addData(array("id" => $clienteEnderecoVO->getId()), "data");
        
        $responseWS->getResponseCode(200);
    break;
    case "DELETE":
        if (empty($data["param"])) {
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("O ID é obrigatório!");
        }
        
        $clienteEnderecoVO = new Lib\VO\ClienteEndereco();
        $clienteEnderecoVO->setId($id);

        $clienteEnderecoDAO = new \Lib\DAO\ClienteEnderecoDAO($connection);

        $enderecoExiste = $clienteEnderecoDAO->getById($clienteEnderecoVO->getId(), array("id"));
        
        if (!empty($enderecoExiste["id"])) {
            $clienteEnderecoDAO->removeEndereco($clienteEnderecoVO->getId());
        } else {
            $responseWS->addStatus("NOT_FOUND");
            throw new Exception("Endereço não encontrado");
        }
        $responseWS->getResponseCode(200);
    break;
    default:
        $responseWS->addStatus("ERRO");
        $responseWS->getResponseCode(500);
        throw new Exception("Verbo HTTP não permitido");
}