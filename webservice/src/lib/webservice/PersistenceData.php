<?php

namespace Lib\Webservice;

class PersistenceData implements Crud {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }

    /*
     * Insere um ou mais valores em uma entidade.
     */
    public function insert($table, $data = array()){
        
        //separado os fields por virgula
        $fieldtNameNormalized =  implode(', ', array_keys($data));
        
        //separado os valores dos fields por virgula
        $fieldValueNormalized = ':'. implode(', :', array_keys($data));
        
        $query = "INSERT INTO ".$table." (".$fieldtNameNormalized.") VALUES (".$fieldValueNormalized.")";
        $sth = $this->connection->prepare($query);
        
        foreach ($data as $key => $dataValue) {
            $sth->bindValue(":".$key, $dataValue["value"], $dataValue["data_type"]);
        }
        
        $sth->execute();
        
        $lastID = $this->connection->lastInsertId();
        return !empty($lastID) ? $lastID : "";
    }

    /*
     * Edita um ou mais valores de uma entidade.
    */
    public function edit($table, $where, $data) {
        $fields = array();
        $filters = array();
        
        //construo o set do update
        foreach ($data as $key => $field) {
            if(isset($field["value"])) {
                $fields[] = $key . " = :" . $key;
            }
        }
        
        //separado o array por virgula para usar na query
        $querySetValues = implode(', ', $fields);
        
        //construo os filtros
        foreach ($where as $key => $value) {
            $filters[] = $key . " = :" . $key;
        }
  
        //separado o array por virgula para usar na query
        $queryFilters = implode(', and ', $filters);
        
        //construo a query do update
        $query = "UPDATE " . $table . " SET ". $querySetValues . " WHERE " . $queryFilters;
        
        // realiza merge dos campos e filtros deixando sempre os filtros por ultimo.
        $newData = array_merge($data, $where);

        $sth = $this->connection->prepare($query);

        //percorro $newData para saber onde colocar os valores do PDO
        foreach ($newData as $key => $fieldValue) {
            if(isset($fieldValue["value"])) {
                $sth->bindValue(":".$key, $fieldValue["value"], $fieldValue["data_type"]);
            }
        }
        
        $sth->execute();
    }

    /*
     * Retornar um ou mais valores de uma entidade.
     */
    public function getAll($table, $fields) {
        $oderBy = "";
        if(is_array($fields)){
            $fields = implode(", ", $fields);
            $oderBy = "order by" . $fields;
        }else{
            $fields = "*";
        }
        
        $query = "SELECT " . $fields . " FROM " . $table ." where ativo > 0 " . $oderBy ;
        $sth = $this->connection->prepare($query);
        $sth->execute();
        
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        
        return !empty($result) ? $result : array();
    }

    /*
     * Retornar uma tupla da entidade.
    */
    public function getById($table, $id, $fields) {
       
        $fields = is_array($fields) ? implode(", ", $fields) : "*";
        $query = "SELECT " . $fields . " FROM " . $table . " WHERE ativo = :ativo and id = :id";
        
        $sth = $this->connection->prepare($query);
        $sth->bindValue(":ativo", 1, \PDO::PARAM_INT);
        $sth->bindValue(":id", $id, \PDO::PARAM_INT);
        $sth->execute();
        
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        return !empty($result) ? $result : array();
    }
    
    public function getConnection() {
        return $this->connection;
    }
}