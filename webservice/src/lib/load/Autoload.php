<?php

namespace Lib\Load;

/*
 * Faz todo contro de autoload do webservice.
 */
class Autoload {
    private $files = array();
    
    public function __construct() {}
    
    /*
    * Adiciona um arquivo na lista de arquivos
    */
    private function addFile($dir, $file){
        $path = $dir. DIRECTORY_SEPARATOR . $file;
        if(is_file($path) && $file != "Autoload.php"){
           $this->files[] = $path;
        }
    }
    
    /*
     * Adiciona arquivos na lista de arcodo com o namespace.
    */
    public function addNamespace($prefix, $dir) {
        if(empty($prefix) || empty($dir)) {
            die("Não foi possível carregar as classes!");
        }
        
        $prefix = trim($prefix);
        $dirNamespace = $dir . DIRECTORY_SEPARATOR . $prefix;
        $filesDir = dir($dirNamespace);
        while (($file = $filesDir->read()) !== false) {
            $this->addFile($dirNamespace, $file);
        }
        $filesDir->close();
    }
    
    /*
     * Registra todos os arquivos da lista;
     */
    public function register() {
        spl_autoload_register(function(){
            foreach ($this->files as $file) {
                require_once($file);
            }
        });
    }
    
    public function getRegisteredFiles() : array {
        return $this->files;
    }
}