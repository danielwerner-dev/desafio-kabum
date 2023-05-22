<?php

switch($_SERVER["REQUEST_METHOD"] ){
    case "POST":
        $body = $service->getBody();
        $usuarioDAO = new \Lib\DAO\UsuarioDAO($connection);
        
        if (!isset($body["usuarioid"]) || empty($body["usuarioid"])) {
            $responseWS->addStatus("ERRO");
            $responseWS->getResponseCode(500);
            throw new Exception("Você não está logado no sistema!");
        }
        
        $usuarioid = isset($body["usuarioid"]) ? $body["usuarioid"] : null;
        $nome = isset($body["nome"]) ? $body["nome"] : null;
        $dataNascimento = isset($body["datanascimento"]) ? $body["datanascimento"] : null;
        $telefone = isset($body["telefone"]) ? $body["telefone"] : null;
        $celular = isset($body["celular"]) ? $body["celular"] : null;
        $rg = isset($body["rg"]) ? $body["rg"] : null;
        $cpf = isset($body["cpf"]) ? $body["cpf"] : null;
        
        $usuarioExiste = $usuarioDAO->getById($usuarioid, array("id"));

        if (empty($usuarioExiste["id"])) {
            $responseWS->addStatus("ERRO");
            $responseWS->getResponseCode(500);
            throw new Exception("Usuário inválido!");
        }
        
        if (!isset($body["nome"])) {
            $responseWS->getResponseCode(401);
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("Nome é obrigatório!");
        }
        
        $clienteVO = new Lib\VO\Cliente();
        $clienteVO->setNome($nome);
        $clienteVO->setDatanascimento($dataNascimento);
        $clienteVO->setTelefone($telefone);
        $clienteVO->setCelular($celular);
        $clienteVO->setCpf($cpf);
        $clienteVO->setRg($rg);
        $clienteVO->setUsuarioid($usuarioid);
        
        $clienteDAO = new \Lib\DAO\ClienteDAO($connection);
        $clientesExistentes = $clienteDAO->findByName($clienteVO->getNome(), array("nome"));
        
        if (!empty($clientesExistentes)) {
            $responseWS->addStatus("CLIENTE_EXISTS");
            throw new Exception("O cliente já está cadastrado! ");
        }
        
        $id = $clienteDAO->cadCliente($clienteVO);
        
        if (!empty($id)) {
            $responseWS->addData(array("id" => $id), "data");
            $responseWS->getResponseCode(200);
        } else {
            $responseWS->addStatus("ERRO");
            $responseWS->getResponseCode(500);
            throw new Exception("Erro ao cadastrar cliente!");
        }
    
    break;
    case "GET":
        $usuarioDAO = new \Lib\DAO\UsuarioDAO($connection);
        $usuarioid = isset($data["param"]) ? $data["param"] : null;
        
        $clienteVO = new Lib\VO\Cliente();
        $clienteVO->setUsuarioid($usuarioid);

        if (!isset($usuarioid) || empty($usuarioid)) {
            $responseWS->addStatus("ERRO");
            $responseWS->getResponseCode(500);
            throw new Exception("Você não está logado no sistema!");
        }
        
        $usuarioExiste = $usuarioDAO->getById($usuarioid, array("id"));
        

        if (empty($usuarioExiste["id"])) {
            $responseWS->addStatus("ERRO");
            $responseWS->getResponseCode(500);
            throw new Exception("Usuário inválido!");
        }

        $clienteDAO = new \Lib\DAO\ClienteDAO($connection);
        
        $responseWS->addData(array("clientes" => $clienteDAO->listAll($clienteVO->getUsuarioid())));
        $responseWS->getResponseCode(200);
    break;
    case "PATCH":
        $body = $service->getBody();

        if (empty($data["param"])) {
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("O ID é obrigatório!");
        }
        
        $id = isset($data["param"]) ? $data["param"] : "";
        $nome = isset($body["nome"]) ? $body["nome"] : "";
        $dataNascimento = isset($body["datanascimento"]) ? $body["datanascimento"] : null;
        $telefone = isset($body["telefone"]) ? $body["telefone"] : "";
        $celular = isset($body["celular"]) ? $body["celular"] : "";
        $rg = isset($body["rg"]) ? $body["rg"] : "";
        $cpf = isset($body["cpf"]) ? $body["cpf"] : "";
        
        $clienteVO = new Lib\VO\Cliente();
        $clienteVO->setId($id);
        $clienteVO->setNome($nome);
        $clienteVO->setDatanascimento($dataNascimento);
        $clienteVO->setTelefone($telefone);
        $clienteVO->setCelular($celular);
        $clienteVO->setRg($rg);
        $clienteVO->setCpf($cpf);

        $clienteDAO = new \Lib\DAO\ClienteDAO($connection);
        $clientesExistente = $clienteDAO->getById($clienteVO->getId(), array("id, nome"));
        
        if (empty($clientesExistente["id"])) {
            $responseWS->addStatus("USER_NOT_EXISTS");
            throw new Exception("O usuário que você está tentando editar não existe ! ");
        }
        
        
        if (isset($clientesExistente["nome"]) && $clientesExistente["nome"] == $clienteVO->getNome()) {
            $clienteVO->setNome("");
        }
        
        if($clienteDAO->editarCliente($clienteVO)){
            $responseWS->getResponseCode(200);
        }
    break;
    case "DELETE":
        
        if (empty($data["param"])) {
            $responseWS->addStatus("REQUIRED_VALUE");
            throw new Exception("O ID é obrigatório!");
        }
        
        $clienteVO = new Lib\VO\Cliente();
        $clienteVO->setId($id);
          
        $clienteDAO = new \Lib\DAO\ClienteDAO($connection);
        $clienteExiste = $clienteDAO->getById($clienteVO->getId(), array("id"));
        
        if (!empty($clienteExiste["id"])) {
            $clienteDAO->removeCliente($clienteVO->getId());
        } else {
            $responseWS->addStatus("NOT_FOUND");
            throw new Exception("Cliente não encontrado");
        }
        $responseWS->getResponseCode(200);    
    break;
    default:
        $responseWS->addStatus("ERRO");
        $responseWS->getResponseCode(500);
        throw new Exception("Verbo HTTP não permitido");
}