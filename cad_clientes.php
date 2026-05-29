<?php
require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $comentario = $_POST['comentario'];

    $pdo->prepare("
        INSERT INTO mod_clientes (cli_nome, cli_email)
        VALUES (?, ?)
    ")->execute([$nome, $email]);

    $cli_id = $pdo->lastInsertId();

    if (!empty($comentario)) {
        $pdo->prepare("
            INSERT INTO mod_comentario (com_comentario, cli_id_fk)
            VALUES (?, ?)
        ")->execute([$comentario, $cli_id]);
    }

    echo "Salvo!";
}

$smarty->display('templates/cad_cliente.tpl');