<?php
header('Content-Type: application/json');
error_reporting(0);
require_once("../config/conexion.php");
require_once("../models/motosHunter.php");
require_once("../models/autenticacionHunter.php");
$base = new Bases();
$auth = new Autenticar();

$body = json_decode(file_get_contents("php://input"), true);
$headers = getallheaders();

echo  json_encode(array("status"=>"Prueba","message" => "esto es una prueba"));