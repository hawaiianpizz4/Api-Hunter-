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

try {
    if (isset($_GET) && $headers["x-user"] && $headers["x-password"]) {
        $user = $headers["x-user"];
        $password = $headers["x-password"];
        $aut = $auth->get_user($user, $password);
        if ($aut[0]["valor"] == '1') {
            $datos = $base->ventasMotos();
            echo json_encode($datos);
        } else {
            http_response_code(401);
            $message = array("ok" => "false", "message" => "credenciales invalidas");
            echo json_encode($message);
        }
    } else {
        http_response_code(405);
        $message = array("ok" => "false", "message" => "error peticion");
        echo json_encode($message);
    }
} catch (\Throwable $th) {
    http_response_code(405);
    $message = array("ok" => "false", "message" => "error inesperado consulte con el administrador");
    echo json_encode($message);
}
