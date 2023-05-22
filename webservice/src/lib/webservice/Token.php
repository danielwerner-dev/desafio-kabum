<?php

namespace Lib\Webservice;

class Token {
    private $header;
    
    private $body;
    
    private $data;
    
    function __construct($data = array()) {
        $this->data = !empty($data) ? $data : array();
        $this->generateHeader();
        $this->generateBody();
    }
    
    private function generateHeader(){
        $header = json_encode(array(
            'alg' => 'HS256',
            'typ' => 'JWT'
        ));
        
        $this->header = base64_encode($header);
    }
    
    private function generateBody(){
        if(!empty($this->data)){
            $body = json_encode($this->data);
            $this->body = base64_encode($body);            
        }
    }
    
    private function generateSignature(){
        if(!empty($this->data) || !empty($this->body)){
            $signature = hash_hmac('sha256',"$this->header.$this->body", SECRET_KEY, true);
            return base64_encode($signature);
        }
    }
    
    public function generateToken(){
        $signature = $this->generateSignature();
        return "$this->header.$this->body.$signature";
    }
    
    public function validToken($token){
        $part = explode(".",$token);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];
            
        
        if(isset($header) && isset($payload) && isset($signature)){
            $valid = hash_hmac('sha256',"$header.$payload", SECRET_KEY, true);
        }
        return $signature == base64_encode($valid);
    }
}