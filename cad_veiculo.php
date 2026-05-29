<?php
require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

$clientes = $pdo->query("SELECT cli_id, cli_nome FROM mod_clientes")->fetchAll(PDO::FETCH_ASSOC);

if ($_POST) {

    $pdo->prepare("
        INSERT INTO mod_veiculos 
        (vei_placa, vei_modelo, vei_marca, vei_cor, cli_id_fk)
        VALUES (?, ?, ?, ?, ?)
    ")->execute([
        $_POST['placa'],
        $_POST['modelo'],
        $_POST['marca'],
        $_POST['cor'],
        $_POST['cliente']
    ]);

    $vei_id = $pdo->lastInsertId();

    if (!empty($_POST['comentario'])) {
        $pdo->prepare("
            INSERT INTO mod_comentario (com_comentario, vei_id_fk)
            VALUES (?, ?)
        ")->execute([$_POST['comentario'], $vei_id]);
    }

    echo "Salvo!";
}

$smarty->assign('CLIENTES', $clientes);
$smarty->display('templates/cad_veiculo.tpl');