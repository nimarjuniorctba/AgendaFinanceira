<?php
require_once 'classes/Autoload.class.php';

$pdo = MySQL_PDO::conexao();

$id = $_POST['id'];

$pdo->prepare("
    UPDATE mod_financeiro 
    SET fin_status = 'e'
    WHERE fin_id = ?
")->execute([$id]);