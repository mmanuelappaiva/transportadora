<?php
//configuração
header("Content-Type: application/json;charset=utf-8");
//DEFINE A RESPOSTA DA API, NESTE CASO JSON

header ("Access-Control-Allow-Origin: *");
//DEFINE O ACESSO A API, NESSE * QUER DIZER TODAS AS ORIGEM

header ("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
//DEFINE OS MÉTODOS QUE PODEM SER FEITOS NESSA API

require "config.php";

$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];

//variável para capturar as informações das requisições
$corpo = json_decode(file_get_contents("php://input"), true) ?? [];

function teste(){
    echo json_encode (["mensagem" => "Back-end respondendo com sucesso!"]);
    exit;
}


//funções: onde fica o crud
function createCliente($con, $dados){
    $stmt = $con->prepare("INSERT INTO CLIENTE (NOME, ENDERECO, TELEFONE, EMAIL) VALUES (?,?,?,?)");
    $stmt -> execute([$dados["nome"], $dados["endereco"], $dados["telefone"], $dados["email"] ]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Cliente criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readCliente($con){
    $stmt = $con->query("SELECT * FROM Cliente");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateCliente($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Cliente SET nome = ?, endereco = ?, telefone = ?, email = ? WHERE idCliente = ?");
    $stmt -> execute([$dados["nome"], $dados["endereco"], $dados["telefone"], $dados["email"], $id]);
    echo json_encode(["mensagem" => "Cliente alterado com sucesso!"]);
}

function deleteCliente ($con, $id){
    $stmt = $con->prepare("DELETE FROM Cliente WHERE idCliente = ?");
    $stmt ->execute([$id]);
    echo json_encode(["mensagem" => "Cliente removido com sucesso!"]);
}

function createFuncionario($con, $dados){
    $stmt = $con->prepare("INSERT INTO FUNCIONARIO (NOME, CARGO, SALARIO) VALUES (?,?,?)");
    $stmt -> execute([$dados["nome"], $dados["cargo"], $dados["salario"]]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Funcionário criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readFuncionario($con){
    $stmt = $con->query("SELECT * FROM Funcionario");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateFuncionario($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Funcionario SET nome = ?, cargo = ?, salario = ? WHERE idFuncionario = ?");
    $stmt -> execute([$dados["nome"], $dados["cargo"], $dados["salario"], $id]);
    echo json_encode(["mensagem" => "Funcionário alterado com sucesso!"]);
}

function deleteFuncionario ($con, $id){
    $stmt = $con->prepare("DELETE FROM Funcionario WHERE idFuncionario = ?");
    $stmt ->execute([$id]);
    echo json_encode(["mensagem" => "Funcionario removido com sucesso!"]);
}

function createRota($con, $dados){
    $stmt = $con->prepare("INSERT INTO Rota (origem, destino, distancia) VALUES (?, ?, ?)");
    $stmt -> execute([$dados["origem"], $dados["destino"], $dados["distancia"]]);
    http_response_code(201);
    echo json_encode(["mensagem" => "Veículo criado com sucesso!", "id" => $con->lastInsertId()]);
}

function readRota($con){
    $stmt = $con->query("SELECT * FROM Rota");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function updateRota($con, $id, $dados){
    $stmt = $con->prepare("UPDATE Rota SET origem = ?, destino = ?, distancia = ? WHERE idRota = ?");
    $stmt -> execute([$dados["origem"], $dados["destino"], $dados["distancia"], $id]);
    echo json_encode(["mensagem" => "Rota alterada com sucesso!"]);
}

function deleteRota ($con, $id){
    $stmt = $con->prepare("DELETE FROM Rota WHERE idRota = ?");
    $stmt ->execute([$id]);
    echo json_encode(["mensagem" => "Rota removida com sucesso!"]);
}



// rotas nomeadas
 if ($rota === "cliente"){
    switch($metodo){
        case "POST":
            createCliente($con, $corpo);
            break;
        case "GET":
            readCliente($con);
            break;
        case "PUT":
            updateCliente($con, $_GET["id"], $corpo);
            break;
        case "DELETE":
            deleteCliente($con, $_GET["id"]);
            break;

        default: 
        teste();
    }
 }

 else if ($rota=== "funcionario"){
    switch($metodo){
        case "POST":
            createFuncionario($con, $corpo);
            break;

        case "GET":
            readFuncionario($con);
            break;

        case "PUT":
            updateFuncionario($con, $_GET["id"], $corpo);
            break;

        case "DELETE":
            deleteFuncionario($con, $_GET["id"]);
            break;

        default: 
        teste();
    }

 }

else if ($rota=== "rota"){
    switch($metodo){
        case "POST":
            createRota($con, $corpo);
            break;

        case "GET":
            readRota($con);
            break;

        case "PUT":
            updateRota($con, $_GET["id"], $corpo);
            break;

        case "DELETE":
            deleteRota($con, $_GET["id"]);
            break;

        default: 
        teste();
    }
 }
?>