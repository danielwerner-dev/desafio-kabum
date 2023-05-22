<?php
namespace Lib\DAO;

class UsuarioDAO {
    private $connection;
    
    private $dataSession;
    
    function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function authenticate($login, $senha){
        $query = "SELECT id as usuarioid, nome, login FROM usuario WHERE ativo = :ativo and login = :login and senha = :senha";
        $sth = $this->connection->prepare($query);
        $sth->bindValue(":ativo", 1, \PDO::PARAM_INT);
        $sth->bindValue(":login", $login, \PDO::PARAM_STR);
        $sth->bindValue(":senha", md5($senha), \PDO::PARAM_STR);
        $sth->execute();

        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        $this->dataSession = $result;

        return !empty($result) ? true : false;
    }
    
    public function getDataSession() {
        return $this->dataSession;
    }
    
    public function getById($id){
        $query = "SELECT id FROM usuario WHERE ativo = :ativo and id = :id";
        $sth = $this->connection->prepare($query);
        $sth->bindValue(":ativo", 1, \PDO::PARAM_INT);
        $sth->bindValue(":id", $id, \PDO::PARAM_INT);
        $sth->execute();

        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }
}
