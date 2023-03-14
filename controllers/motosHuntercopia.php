<?php
// 
header('Content-Type: application/json');
require_once("../config/conexion.php");
require_once("../models/motosHunter.php");
require_once("../models/autenticacionHunter.php");
$base = new Bases();
$auth = new Autenticar();
$body = json_decode(file_get_contents("php://input"), true);
$headers = getallheaders();
try {
    switch ($_SERVER['REQUEST_METHOD']) {
            // GET request
        case 'GET':
            if ($headers["x-user"] && $headers["x-password"] && !$body) {
                $user = $headers["x-user"];
                $password = $headers["x-password"];
                $aut = $auth->get_user($user, $password);

                if ($aut[0]["valor"] == '1') {
                    $datos = $base->get_base();
                    echo json_encode($datos);
                } else {
                    http_response_code(401);
                    $message = array("ok" => "false", "message" => "credenciales invalidas");
                    echo json_encode($message);
                }
            }

            break;
            // POST request
        case 'POST':
            if ($headers["x-user"] && $headers["x-password"]) {
                $user = $headers["x-user"];
                $password = $headers["x-password"];
                $aut = $auth->get_user($user, $password);
                if ($aut[0]["valor"] == '1') {
                    $insert;
                    $vacio = 0;
                   
                    for ($i = 0; $i < count($body["results"]); $i++) {

                        if (
                            trim(strlen($body["results"][$i]["CHASIS"])) > 0 && trim(strlen($body["results"][$i]["MOTOR"])) > 0
                            && trim(strlen($body["results"][$i]["FECHA_CHEQUEO"])) > 0 && trim(strlen($body["results"][$i]["ID"])) > 0
                        ) {
                            $vacio = 1;
                        } else {
                            $vacio = 0;
                            break;
                        }
                    }
                    // var_dump($vacio);
                    if ($vacio == 1) {
                        for ($i = 0; $i < count($body["results"]); $i++) {
                            $insert = $base->insertMotos($body["results"][$i]["CHASIS"], $body["results"][$i]["MOTOR"], $body["results"][$i]["FECHA_CHEQUEO"], $body["results"][$i]["ID"]);
                        }
                    } else {
                        $resp = array('ok' => 'false', 'message' => 'No debe existir campos en blanco');
                        echo json_encode($resp);
                        die();
                    }
                    if ($insert == 'realizado') {
                        $resp = array('ok' => 'true', 'message' => 'datos guardados correctamente');
                        echo json_encode($resp);
                    } else {
                        $resp = array('ok' => 'flase', 'message' => $insert);
                        echo json_encode($resp);
                    }
                } else {
                    http_response_code(401);
                    $message = array("ok" => "false", "message" => "credenciales invalidas");
                    echo json_encode($message);
                }
            }
            break;
            // End of POST request
    }
} catch (\Throwable $th) {
    http_response_code(405);
    $message = array("ok" => "false", "message" => "error inesperado consulte con el administrador del sistema");
    echo json_encode($message);
}
