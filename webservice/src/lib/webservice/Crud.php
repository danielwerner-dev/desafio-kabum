<?php

namespace Lib\Webservice;

interface Crud {
    public function insert($table, $data);
    public function edit($table, $where, $data);
    public function getById($table, $id, $fields);
    public function getAll($table, $fields);
}