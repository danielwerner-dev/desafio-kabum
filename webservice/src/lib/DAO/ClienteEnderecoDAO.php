<?php
namespace Lib\DAO;

class ClienteEnderecoDAO {
    private $persistence;
    
    public function __construct($connection) {
        $this ->persistence = new \Lib\Webservice\PersistenceData($connection);
    }
    
    public function cadEndereco($clienteEnderecoVO){
        $id = $this ->persistence->insert("cliente_endereco", array(
            "endereco" => array("value"=> $clienteEnderecoVO->getEndereco(), "data_type" => \PDO::PARAM_STR),
            "numero" => array("value"=> $clienteEnderecoVO->getNumero(), "data_type" => \PDO::PARAM_STR),
            "bairro" => array("value"=> $clienteEnderecoVO->getBairro(), "data_type" => \PDO::PARAM_STR),
            "cep" => array("value"=> $clienteEnderecoVO->getCep(), "data_type" => \PDO::PARAM_STR),
            "clienteid" => array("value"=> $clienteEnderecoVO->getClienteID(), "data_type" => \PDO::PARAM_INT),
            "estadoid" => array("value"=> $clienteEnderecoVO->getEstadoID(), "data_type" => \PDO::PARAM_INT),
            "cidadeid" => array("value"=> $clienteEnderecoVO->getCidadeID(), "data_type" => \PDO::PARAM_INT)
        ));
        
        return $id;
    }
    
    public function getAllEnderecoCliente($clienteid){
        $query = "
            SELECT
              cliente_endereco.*, cliente.nome
            FROM
              cliente_endereco
            JOIN cliente on cliente.id = cliente_endereco.clienteid
            WHERE 
              cliente.ativo > 0 
              AND cliente_endereco.ativo > 0
              AND clienteid = :clienteid
            ORDER BY cliente_endereco.endereco
        ";
        
        $sth = $this->persistence->getConnection()->prepare($query);
        $sth->bindValue(":clienteid", $clienteid, \PDO::PARAM_INT);
        $sth->execute();
        
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return !empty($result) ? $result : array();
    }


    public function getById($id, $fields){
        return $this ->persistence->getById("cliente_endereco", $id, $fields);
    }
    
    public function editarEndereco($clienteEnderecoVO){
        
        $this ->persistence->edit("cliente_endereco", 
        array(
            "id" => array("value" => $clienteEnderecoVO->getId(), "data_type" => \PDO::PARAM_INT)
        ),
        array(
            "endereco" => array("value" => $clienteEnderecoVO->getEndereco(), "data_type" => \PDO::PARAM_STR),
            "numero" => array("value" => $clienteEnderecoVO->getNumero(), "data_type" => \PDO::PARAM_STR),
            "bairro" => array("value" => $clienteEnderecoVO->getBairro(), "data_type" => \PDO::PARAM_STR),
            "cep" => array("value" => $clienteEnderecoVO->getCep(), "data_type" => \PDO::PARAM_STR),
            "estadoid" => array("value"=> $clienteEnderecoVO->getEstadoID(), "data_type" => \PDO::PARAM_INT),
            "cidadeid" => array("value"=> $clienteEnderecoVO->getCidadeID(), "data_type" => \PDO::PARAM_INT)            
        ));
    }
    
    public function removeEndereco($id){
        $this ->persistence->edit("cliente_endereco", 
        array(
            "id" => array("value" => $id, "data_type" => \PDO::PARAM_INT)
        ),
        array(
            "ativo" => array("value" => 0, "data_type" => \PDO::PARAM_INT)
        ));
    }    
}
