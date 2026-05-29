<?php

require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

$age_id = $_GET['id'];

// 🔹 DADOS DO AGENDAMENTO
$stmt = $pdo->prepare("
SELECT 
    a.*,
    c.cli_nome,
    c.cli_email,
    v.vei_modelo,
    v.vei_placa,
    s.ser_nome,
    s.ser_valor,
    s.ser_duracao,
    h.hor_hora
FROM mod_agendamentos a
LEFT JOIN mod_clientes c ON c.cli_id = a.cli_id_fk
LEFT JOIN mod_veiculos v ON v.vei_id = a.vei_id_fk
LEFT JOIN mod_servicos s ON s.ser_id = a.ser_id_fk
LEFT JOIN mod_horarios h ON h.hor_id = a.age_hora_inicio_fk
WHERE a.age_id = ?
");
$stmt->execute([$age_id]);

$ag = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔹 VERIFICA SE JÁ FOI PAGO
$stmt = $pdo->prepare("
SELECT fin_id 
FROM mod_financeiro 
WHERE age_id_fk = ? 
AND fin_status = 'a'
LIMIT 1
");
$stmt->execute([$age_id]);

$jaPago = $stmt->fetch() ? true : false;

// envia
$smarty->assign('AG', $ag);
$smarty->assign('JA_PAGO', $jaPago);

$smarty->display('agenda_detalhes.tpl');