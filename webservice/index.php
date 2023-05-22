<?php
$info = array(
    "nome" => "Webservice Kabum",
    "versao" => " V1.0",
);
echo json_encode(str_replace('"', '', $info));