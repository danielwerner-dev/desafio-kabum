<?php
namespace Lib\DAO;

class CidadeDAO {

    private $persistence;

    public function __construct($connection) {
        $this->persistence = new \Lib\Webservice\PersistenceData($connection);
    }

    public function listAll($estadoid) {
        $query = "SELECT id as value, nome as text FROM cidade WHERE ativo = :ativo and estadoid = :estadoid";
        $sth = $this->persistence->getConnection()->prepare($query);
        $sth->bindValue(":ativo", 1, \PDO::PARAM_INT);
        $sth->bindValue(":estadoid", $estadoid, \PDO::PARAM_INT);
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return !empty($result) ? $result : array();
    }

}
