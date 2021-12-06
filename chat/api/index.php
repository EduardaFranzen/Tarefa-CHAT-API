<?php
include "Conexao.php";
$con=Conexao::getConexao();

if($_SERVER['REQUEST_METHOD'] == "GET") {
    if(isset($_REQUEST['timestamp']) and !empty($_REQUEST['timestamp'])) {
        $timestamp = $_REQUEST['timestamp'];
        $sql="SELECT * FROM message WHERE timestamp>$timestamp";
        if ($resultado=$con->query($sql)) {
            $return["status"] = "ok";
            $return["rows"]=$resultado->rowCount();
            $messages=null;
            while($item=$resultado->fetch(PDO::FETCH_ASSOC)) {
                $messages[]=$item;
            }
            $return["msg"] = $messages;
            echo json_encode($return);
            exit;
        }
    } 
} else if($_SERVER['REQUEST_METHOD'] == "POST") {

    if(!(file_get_contents("php://input") != null and !empty(file_get_contents("php://input")))) {
        $return["status"] = "erro";
        $return["mensagem"] = "Request está vazia";
        echo json_encode($return);
        exit;
    }
    if(!($request = json_decode(file_get_contents("php://input"), true))) {
        $return["status"] = "erro";
        $return["mensagem"] = "Request não está em JSON";
        echo json_encode($return);
        exit;
    }

    if(isset($request["nick"]) && isset($request["message"])) {
        $return["status"] = "erro";
        $return["mensagem"] = "Nem todos os parametros foram enviados";
        echo json_encode($return);
        exit;
    }

    $timestamp = time() * 1000;
    $nick = $request["nick"];
    $message = $request["message"];
    $sql = "INSERT INTO message(message, nick, timestamp) VALUES (\"".$message."\",\"".$nick."\",".$timestamp.")";
    if(!($con->query($sql))) {
        $return["status"] = "erro";
        $return["mensagem"] = "Erro ao inserir dados no banco de dados";
        echo json_encode($return);
        exit;
    }
    $return["timestamp"] = $timestamp;
    echo json_encode($return);
    exit;

} else if($_SERVER['REQUEST_METHOD'] == "PUT") {
    echo "{'status': 'PUT'}";
} else if($_SERVER['REQUEST_METHOD'] == "DELETE") {
    echo "{'status': 'DELETE'}";
}