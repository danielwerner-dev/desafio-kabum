<?php
namespace Lib\DAO;

class ClienteDAO {
    private $persistence;
    
    public function __construct($connection) {
        $this ->persistence = new \Lib\Webservice\PersistenceData($connection);
    }
    
    public function cadCliente($clienteVO){
        $id = $this ->persistence->insert("cliente", array(
            "nome" => array("value"=> $clienteVO->getNome(), "data_type" => \PDO::PARAM_STR),
            "datanascimento" => array("value"=> $clienteVO->getDataNascimento(), "data_type" => \PDO::PARAM_STR),
            "cpf" => array("value"=> $clienteVO->getCpf(), "data_type" => \PDO::PARAM_STR),
            "rg" => array("value"=> $clienteVO->getRg(), "data_type" => \PDO::PARAM_STR),
            "telefone" => array("value"=> $clienteVO->getTelefone(), "data_type" => \PDO::PARAM_STR),
            "celular" => array("value"=> $clienteVO->getCelular(), "data_type" => \PDO::PARAM_STR),
            "usuarioid" => array("value"=> $clienteVO->getUsuarioid(), "data_type" => \PDO::PARAM_INT)
        ));
        
        return $id;
    }   
    
    public function findByName($nome, $fields){
        $fields = is_array($fields) ? implode(", ", $fields) : "*";
        $query = "SELECT " . $fields . " FROM cliente WHERE ativo > 0 and nome = :nome";
        $sth = $this->persistence->getConnection()->prepare($query);
        $sth->bindValue(":nome", $nome, \PDO::PARAM_STR);
        $sth->execute();
        
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        
        return !empty($result) ? $result : array();        
    }


    public function listAll($usuarioid){
        $query = "SELECT * FROM cliente WHERE ativo = :ativo and usuarioid = :usuarioid order by nome";
        $sth = $this->persistence->getConnection()->prepare($query);
        $sth->bindValue(":ativo", 1, \PDO::PARAM_INT);
        $sth->bindValue(":usuarioid", $usuarioid, \PDO::PARAM_INT);
        $sth->execute();
        
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        return !empty($result) ? $result : array();        
    }
    
    public function getById($id, $fields){
        return $this ->persistence->getById("cliente", $id, $fields);
    }
    
    public function editarCliente($clienteVO){
        return $this ->persistence->edit("cliente", 
        array(
            "id" => array("value" => $clienteVO->getID(), "data_type" => \PDO::PARAM_INT)
        ),
        array(
            "nome" => array("value" => $clienteVO->getNome(), "data_type" => \PDO::PARAM_STR),
            "datanascimento" => array("value" => $clienteVO->getDataNascimento(), "data_type" => \PDO::PARAM_STR),
            "cpf" => array("value" => $clienteVO->getCpf(), "data_type" => \PDO::PARAM_STR),
            "rg" => array("value" => $clienteVO->getRg(), "data_type" => \PDO::PARAM_STR),
            "telefone" => array("value" => $clienteVO->getTelefone(), "data_type" => \PDO::PARAM_STR),
            "celular" => array("value" => $clienteVO->getCelular(), "data_type" => \PDO::PARAM_STR)
        ));
    }
    
    public function removeCliente($id){
        $this ->persistence->edit("cliente", 
        array(
            "id" => array("value" => $id, "data_type" => \PDO::PARAM_INT)
        ),
        array(
            "ativo" => array("value" => 0, "data_type" => \PDO::PARAM_INT)
        ));
    }    
}
