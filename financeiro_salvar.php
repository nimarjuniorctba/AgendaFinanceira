<?php
require_once 'classes/Autoload.class.php';

$pdo = MySQL_PDO::conexao();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $descricao = $_POST['descricao'];

    if(empty($tipo) || empty($valor)){
        echo "erro";
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO mod_financeiro (
            fin_data,
            fin_tipo,
            fin_origem,
            fin_valor,
            fin_valor_final,
            fin_descricao,
            fin_status
        ) VALUES (
            CURDATE(),
            :tipo,
            'manual',
            :valor,
            :valor,
            :descricao,
            'a'
        )
    ");

    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);

    $stmt->execute();

    echo "ok";
}