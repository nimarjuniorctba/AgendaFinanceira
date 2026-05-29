<?php
require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

// SALVAR
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'] ?? null;
    $servico = $_POST['servico'] ?? null;

    $pdo->prepare("
        INSERT INTO mod_financeiro (
            fin_data,
            fin_tipo,
            fin_origem,
            fin_valor,
            fin_valor_final,
            fin_descricao,
            fin_categoria,
            ser_id_fk
        ) VALUES (
            CURDATE(),
            ?,
            'manual',
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ")->execute([
        $tipo,
        $valor,
        $valor,
        $descricao,
        $categoria,
        $servico
    ]);

    header('Location: financeiro_lancamento.php');
    exit;
}

// BUSCAR LANÇAMENTOS
$lancamentos = $pdo->query("
    SELECT fin_id, fin_tipo, fin_descricao, fin_valor_final
    FROM mod_financeiro
    WHERE fin_data = CURDATE() AND fin_status = 'a'
")->fetchAll(PDO::FETCH_ASSOC);

// SERVIÇOS
$servicos = $pdo->query("
    SELECT ser_id, ser_nome FROM mod_servicos WHERE ser_status = 'a'
")->fetchAll(PDO::FETCH_ASSOC);

// CATEGORIAS
$categorias = $pdo->query("
    SELECT cat_id, cat_nome FROM mod_categoria_lancamentos WHERE cat_status = 'a'
")->fetchAll(PDO::FETCH_ASSOC);

$smarty->assign('LANCAMENTOS', $lancamentos);
$smarty->assign('SERVICOS', $servicos);
$smarty->assign('CATEGORIAS', $categorias);

$smarty->display('financeiro_lancamento.tpl');