<?php

header("Content-Type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

$id = "";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

if ($metodo == "POST") {

    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $equipamento = $dados["equipamento"];
    $setor = $dados["setor"];
    $descricao = $dados["descricao"];
    $prioridade = $dados["prioridade"];

    if (isset($dados["status"])) {
        $status = $dados["status"];
    } else {
        $status = "aberto";
    }

    $sql = "INSERT INTO chamados 
    (equipamento, setor, descricao, prioridade, status)
    VALUES (?, ?, ?, ?, ?)";

    $comando = $pdo->prepare($sql);

    $comando->execute([
        $equipamento,
        $setor,
        $descricao,
        $prioridade,
        $status
    ]);

    echo json_encode([
        "Mensagem" => "Chamado cadastrado com sucesso"
    ]);
}

if ($metodo == "GET") {

    $sql = "SELECT * FROM chamados";

    $comando = $pdo->query($sql);

    $chamados = $comando->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($chamados);
}

if ($metodo == "PUT") {

    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);

    $equipamento = $dados["equipamento"];
    $setor = $dados["setor"];
    $descricao = $dados["descricao"];
    $prioridade = $dados["prioridade"];
    $status = $dados["status"];

    $sql = "UPDATE chamados SET
    equipamento = ?,
    setor = ?,
    descricao = ?,
    prioridade = ?,
    status = ?
    WHERE id = ?";

    $comando = $pdo->prepare($sql);

    $comando->execute([
        $equipamento,
        $setor,
        $descricao,
        $prioridade,
        $status,
        $id
    ]);

    echo json_encode([
        "Mensagem" => "Chamado atualizado com sucesso"
    ]);
}

if ($metodo == "DELETE") {

    $sql = "DELETE FROM chamados WHERE id = ?";

    $comando = $pdo->prepare($sql);

    $comando->execute([$id]);

    echo json_encode([
        "Mensagem" => "Chamado excluido com sucesso"
    ]);
}

?>