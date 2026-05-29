<?php
require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

if ($_POST) {

    $pdo->prepare("
        INSERT INTO mod_servicos 
        (ser_nome, ser_valor, ser_duracao, ser_cor)
        VALUES (?, ?, ?, ?)
    ")->execute([
        $_POST['nome'],
        $_POST['valor'],
        $_POST['duracao'],
        $_POST['cor']
    ]);

    echo "Salvo!";
}

$smarty->display('templates/cad_servico.tpl');