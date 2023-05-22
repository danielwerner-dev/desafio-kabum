<?php
namespace Lib\VO;

class Cidade {
    private $id;
    private $ativo;
    private $nome;
    private $estadoid;
    
    public function __construct() {}
    
    public function getId() {
        return $this->id;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEstadoid() {
        return $this->estadoid;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEstadoid($estadoid) {
        $this->estadoid = $estadoid;
    }
}