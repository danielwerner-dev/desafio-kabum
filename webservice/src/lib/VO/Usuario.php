<?php
namespace Lib\VO;

class Usuario {
    private $id;
    private $ativo;
    private $login;
    private $senha;
    private $permissao;
    
    public function __construct() {}
    
    public function getId() {
        return $this->id;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getPermissao() {
        return $this->permissao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setPermissao($permissao) {
        $this->permissao = $permissao;
    }
}