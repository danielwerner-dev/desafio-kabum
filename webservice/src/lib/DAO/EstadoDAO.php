<?php
namespace Lib\DAO;

class EstadoDAO {

    private $persistence;

    public function __construct($connection) {
        $this->persistence = new \Lib\Webservice\PersistenceData($connection);
    }

    public function listAll() {
        $query = "SELECT id as value, sigla as text FROM estado WHERE ativo = :ativo order by sigla";
        $sth = $this->persistence->getConnection()->prepare($query);
        $sth->bindValue(":ativo", 1, \PDO::PARAM_INT);
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return !empty($result) ? $result : array();
    }

}
