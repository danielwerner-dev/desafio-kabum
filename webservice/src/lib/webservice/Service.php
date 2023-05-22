<?php

namespace Lib\Webservice;

class Service {
    /*
     * Nome do serviço
    */
    private $name;
    
    /**
     * Body do serviço
    */
    private $bodyRequest;
        
    /**
     * id do serviço
    */
    private $id;
    
    public function __construct($service, $id = null) {
        
        $this->normalizeServiceName($service);
        $this->normalizeID($id);
        $this->getBodyRequest();
    }
    
    private function removeTypeFile($path) {
        return preg_replace('/[.php]/', "", basename($path));
    }
    
    private function getAllowedServices(){
        $allowedServices = array();
        
        // faz a leitura da pasta de serviços
        $allowedServices = array_map(array($this, 'removeTypeFile'), 
                glob(_SERVICE_ . DIRECTORY_SEPARATOR ."*" . "*"));
        
        return $allowedServices;
    }
    
    private function normalizeServiceName($name){
        // remove espaço do inicio e do final e qualquer caractere que não 
        // seja uma letra
        $this->name = preg_replace('/[^a-zA-Z]/', '', trim($name));
    }
    
    private function normalizeID($id){
        $this->id = !empty($id) ? preg_replace('/[^0-9]/', "", trim($id)) : null;
    }
    
    public function getBodyRequest(){
        $this->bodyRequest = json_decode(file_get_contents('php://input'), TRUE);
    }
    
    public function getBody(){
        return !empty($this->bodyRequest) ? $this->bodyRequest : array();
    }
    
    public function processesRequest(){
        if(isset($this->name) && !empty($this->name)
                && in_array($this->name, $this->getAllowedServices())){
            
            $allowedVerb = array("POST", "GET", "DELETE", "PUT", "PATCH");
            if(in_array($_SERVER["REQUEST_METHOD"], $allowedVerb)){
                
                return array(
                    "service" => $this->name,
                    "param" => $this->id,
                    "body" => $this->bodyRequest
                );
            }
            
            return array();
        }
    }
}