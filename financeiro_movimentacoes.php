<?php
require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$pdo = MySQL_PDO::conexao();

/* =========================
   AJAX LISTAGEM
=========================*/
if(isset($_POST['ajax'])){

    header('Content-Type: application/json');
    error_reporting(0);

    $ini    = $_POST['dataInicio'] ?? null;
    $fim    = $_POST['dataFim'] ?? null;
    $tipo   = $_POST['tipo'] ?? 'todos';
    $origem = $_POST['origem'] ?? 'todos';
    $servico= $_POST['servico'] ?? 'todos';

    $sql = "SELECT f.*, s.ser_nome
            FROM mod_financeiro f
            LEFT JOIN mod_servicos s ON s.ser_id = f.ser_id_fk
            WHERE f.fin_status = 'a'";

    $params = [];

    if($ini){
        $sql .= " AND f.fin_data >= ?";
        $params[] = $ini;
    }

    if($fim){
        $sql .= " AND f.fin_data <= ?";
        $params[] = $fim;
    }

    if($tipo != 'todos'){
        $sql .= " AND f.fin_tipo = ?";
        $params[] = $tipo;
    }

    if($origem != 'todos'){
        $sql .= " AND f.fin_origem = ?";
        $params[] = $origem;
    }

    if($servico != 'todos'){
        $sql .= " AND f.ser_id_fk = ?";
        $params[] = $servico;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

/* =========================
   EDITAR
=========================*/
if(isset($_POST['editar'])){
    $pdo->prepare("
        UPDATE mod_financeiro 
        SET fin_descricao=?, fin_valor_final=? 
        WHERE fin_id=?
    ")->execute([
        $_POST['descricao'],
        $_POST['valor'],
        $_POST['id']
    ]);
    exit;
}

/* =========================
   EXCLUIR
=========================*/
if(isset($_POST['excluir'])){
    $pdo->prepare("
        UPDATE mod_financeiro 
        SET fin_status='e' 
        WHERE fin_id=?
    ")->execute([$_POST['id']]);
    exit;
}

/* =========================
   CARREGAR SERVIÇOS
=========================*/
$servicos = $pdo->query("
    SELECT ser_id, ser_nome 
    FROM mod_servicos 
    WHERE ser_status='a'
")->fetchAll(PDO::FETCH_ASSOC);

$smarty = new Smarty();
$smarty->assign('SERVICOS', $servicos);
$smarty->display('financeiro_movimentacoes.tpl');