<?php
require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

if ($_POST) {

    $pdo->prepare("
        INSERT INTO mod_pistas (pis_nome, pis_status)
        VALUES (?, 'a')
    ")->execute([$_POST['nome']]);

    echo "Salvo!";
}

$smarty->display('templates/cad_pista.tpl');