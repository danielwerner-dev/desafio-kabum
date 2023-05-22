<?php

/*
 * Define se o ambiente é produção ou desenvolvimento.
 */
$environment = "DEV";

/*
 * Diretório raiz
 */
$dirName = "webservice";

/*
 * Host da onde está o banco de dados.
 */
$host = "localhost";

/*
 * Nome do banco de dados.
 */
$dbname = "kabum";

/*
 * Usuário do banco de dados.
 */
$user = "root";

/*
 * Senha do banco de dados.
 */
$password = "238664da";

/*
* Define se o ambiente é produção ou desenvolvimento
*/
define("ENVIRONMENT", $environment);

if(in_array(ENVIRONMENT, array("DEV", "PROD")) && ENVIRONMENT == "DEV") {
    if(empty($dirName)) {
        die("Diretório root não de finido!");
    }

    if( empty($host) || empty($dbname) || empty($user) || empty($password)) {
        die("Configuração com o banco de dados não foram definidas!");
    }
} else {
    die("Desculpe, estamos em Manutenção!");
}

/*
 * Diretórios
 */

// diretório root
define("_ROOT_", $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR .$dirName);
 // diretório lib
define("_LIB_", _ROOT_ . "/src/lib");
// diretorio service
define("_SERVICE_", _ROOT_ . "/src/services"); 

/*
 * Informações de conexão com o banco e dados.
 */
define("DATABASE", [
    "HOST" => $host,
    "DBNAME" => $dbname,
    "USER" => $user,
    "PASSWORD" => $password
]);

/*
 * Chave para decifrar o token quem nas requisições.
 */
define("SECRET_KEY", "K@BUM!");

date_default_timezone_set('America/Sao_Paulo');

/*
 * Importa todos os arquivos necessários.
 */
require_once(_ROOT_ . "/src/lib/load/Autoload.php");
$loadFile = new Lib\Load\Autoload();

$loadFile->addNamespace("VO", _LIB_);
$loadFile->addNamespace("DAO", _LIB_);
$loadFile->addNamespace("database", _LIB_);
$loadFile->addNamespace("webservice", _LIB_);
$loadFile->register();
