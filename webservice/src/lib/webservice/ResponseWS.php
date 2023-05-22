<?php
namespace Lib\Webservice;

class ResponseWS {
    
    private $msg = "";
    private $code = 200;
    private $status = "SUCCESS";
    private $data = array();
    
    public function __construct() {}
    
    public function getResponseCode($code){
        $this->code = $code;
        http_response_code($this->code);
    }
    
    public function addResponseMessage($msg){
        $this->msg = $msg;
    }
    
    public function addStatus($status){
        $this->status = $status;
    }
    
    public function addData($data, $key = ""){
        if(is_array($data)){
            $this->data = array_merge($this->data, $data);
        } else if (empty($key)) {
            $this->data = $data;
        } else {
            $this->data[$key] = $data;
        }
    }
    
    function getResponse() {
        return json_encode($response = array_merge(array(
            "code" => $this->code,
            "message" => $this->msg,
            "status" => $this->status,
        ), $this->data));
    }

}