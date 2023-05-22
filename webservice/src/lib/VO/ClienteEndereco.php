<?php

namespace Lib\VO;

class ClienteEndereco {

    private $id;
    private $ativo;
    private $endereco;
    private $numero;
    private $cep;
    private $bairro;
    private $clienteID;
    private $estadoID;
    private $cidadeID;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function getClienteID() {
        return $this->clienteID;
    }

    public function setClienteID($clienteID) {
        $this->clienteID = $clienteID;
    }

    public function getEstadoID() {
        return $this->estadoID;
    }

    public function getCidadeID() {
        return $this->cidadeID;
    }

    public function setEstadoID($estadoID) {
        $this->estadoID = $estadoID;
    }

    public function setCidadeID($cidadeID) {
        $this->cidadeID = $cidadeID;
    }

}
