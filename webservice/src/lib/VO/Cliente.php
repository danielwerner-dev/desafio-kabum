<?php
namespace Lib\VO;

class Cliente {
    private $id;
    private $ativo;
    private $nome;
    private $datanascimento;
    private $cpf;
    private $rg;
    private $telefone;
    private $celular;
    private $usuarioid;
    
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

    public function getDatanascimento() {
        return $this->datanascimento;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getRg() {
        return $this->rg;
    }

    public function getTelefone() {
        return $this->telefone;
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

    public function setDatanascimento($datanascimento) {
        $this->datanascimento = $datanascimento;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setRg($rg) {
        $this->rg = $rg;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
    
    public function getCelular() {
        return $this->celular;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }
    public function getUsuarioid() {
        return $this->usuarioid;
    }

    public function setUsuarioid($usuarioid) {
        $this->usuarioid = $usuarioid;
    }
}