<?php
require_once '../classes/Autoload.class.php';
$pdo = MySQL_PDO::conexao();

$where = "WHERE fin_status='a'";

if(!empty($_POST['ini'])) $where .= " AND fin_data >= '{$_POST['ini']}'";
if(!empty($_POST['fim'])) $where .= " AND fin_data <= '{$_POST['fim']}'";

if($_POST['tipo']!='todos') $where .= " AND fin_tipo='{$_POST['tipo']}'";
if($_POST['origem']!='todos') $where .= " AND fin_origem='{$_POST['origem']}'";

if($_POST['servico']!='todos') $where .= " AND ser_id_fk={$_POST['servico']}";
if($_POST['pista']!='todos') $where .= " AND pis_id_fk={$_POST['pista']}";

$sql = "SELECT fin_id id, fin_data data, fin_tipo tipo,
        fin_origem origem, fin_descricao desc,
        fin_valor_final valor
        FROM mod_financeiro $where";

echo json_encode($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));