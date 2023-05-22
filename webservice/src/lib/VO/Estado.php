<?php
namespace Lib\VO;

class Estado {
    private $id;
    private $ativo;
    private $nome;
    private $sigla;
    
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

    public function getSigla() {
        return $this->sigla;
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

    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }
}