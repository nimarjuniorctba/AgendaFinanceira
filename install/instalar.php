<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbName = "agenda";

$conn = new mysqli($host, $user, $pass);

$etapa = $_POST['etapa'] ?? 1;

$response = [
    "log" => "",
    "progresso" => 0,
    "finalizado" => false
];

// ETAPA 1 - Criar banco
if ($etapa == 1) {

    $conn->query("CREATE DATABASE IF NOT EXISTS $dbName");

    $response["log"] = "✔ Banco criado/verificado";
    $response["progresso"] = 25;
}

// ETAPA 2 - Selecionar banco
if ($etapa == 2) {

    $conn->select_db($dbName);

    $response["log"] = "✔ Banco selecionado";
    $response["progresso"] = 50;
}

// ETAPA 3 - Executar SQL
if ($etapa == 3) {

    $conn->select_db($dbName);

    $sql = file_get_contents("../banco/criacao.sql");

    if ($conn->multi_query($sql)) {

        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());

        $response["log"] = "✔ Tabelas criadas";
    } else {
        $response["log"] = "❌ Erro SQL: " . $conn->error;
    }

    $response["progresso"] = 75;
}

// ETAPA 4 - Finalizar
if ($etapa == 4) {

    $response["log"] = "✔ Finalizando instalação";
    $response["progresso"] = 100;
    $response["finalizado"] = true;
}

echo json_encode($response);