<?php

require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

// =============================
// 📊 TOTAIS
// =============================
$TOTAL_CLIENTES = $pdo->query("SELECT COUNT(*) FROM mod_clientes WHERE cli_status='a'")->fetchColumn();

$TOTAL_VEICULOS = $pdo->query("SELECT COUNT(*) FROM mod_veiculos WHERE vei_status='a'")->fetchColumn();

$TOTAL_SERVICOS = $pdo->query("SELECT COUNT(*) FROM mod_servicos WHERE ser_status='a'")->fetchColumn();

$TOTAL_AGENDAMENTOS = $pdo->query("
    SELECT COUNT(*) 
    FROM mod_agendamentos 
    WHERE age_data = CURDATE()
    AND age_status='a'
")->fetchColumn();

$FATURAMENTO = $pdo->query("
    SELECT IFNULL(SUM(age_valor_final),0) 
    FROM mod_agendamentos 
    WHERE age_data = CURDATE()
    AND age_status='a'
")->fetchColumn();


// =============================
// 📅 ÚLTIMOS AGENDAMENTOS
// =============================
$AGENDAMENTOS = $pdo->query("
    SELECT 
        a.age_data,
        c.cli_nome,
        v.vei_placa,
        s.ser_nome,
        a.age_valor_final
    FROM mod_agendamentos a
    LEFT JOIN mod_clientes c ON c.cli_id = a.cli_id_fk
    LEFT JOIN mod_veiculos v ON v.vei_id = a.vei_id_fk
    LEFT JOIN mod_servicos s ON s.ser_id = a.ser_id_fk
    ORDER BY a.age_id DESC
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);


// =============================
// 📊 FATURAMENTO ÚLTIMOS 7 DIAS
// =============================
$dadosSemana = [];
$labelsSemana = [];

for ($i = 6; $i >= 0; $i--) {

    $data = date('Y-m-d', strtotime("-$i days"));

    $valor = $pdo->query("
        SELECT IFNULL(SUM(age_valor_final),0)
        FROM mod_agendamentos
        WHERE age_data = '$data'
        AND age_status='a'
    ")->fetchColumn();

    $labelsSemana[] = date('d/m', strtotime($data));
    $dadosSemana[] = (float)$valor;
}


// =============================
// 📊 FATURAMENTO POR MÊS
// =============================
$labelsMes = [];
$dadosMes = [];

for ($m = 1; $m <= 12; $m++) {

    $mes = str_pad($m, 2, '0', STR_PAD_LEFT);

    $valor = $pdo->query("
        SELECT IFNULL(SUM(age_valor_final),0)
        FROM mod_agendamentos
        WHERE DATE_FORMAT(age_data,'%m') = '$mes'
        AND YEAR(age_data) = YEAR(CURDATE())
        AND age_status='a'
    ")->fetchColumn();

    $labelsMes[] = $mes;
    $dadosMes[] = (float)$valor;
}


// =============================
// 📊 SERVIÇOS POR MÊS
// =============================
$labelsServicos = [];
$dadosServicos = [];

for ($m = 1; $m <= 12; $m++) {

    $mes = str_pad($m, 2, '0', STR_PAD_LEFT);

    $qtd = $pdo->query("
        SELECT COUNT(*)
        FROM mod_agendamentos
        WHERE DATE_FORMAT(age_data,'%m') = '$mes'
        AND YEAR(age_data) = YEAR(CURDATE())
        AND age_status='a'
    ")->fetchColumn();

    $labelsServicos[] = $mes;
    $dadosServicos[] = (int)$qtd;
}


// =============================
// 📊 RESUMOS
// =============================
$TOTAL_MES = $pdo->query("
    SELECT IFNULL(SUM(age_valor_final),0)
    FROM mod_agendamentos
    WHERE MONTH(age_data)=MONTH(CURDATE())
    AND YEAR(age_data)=YEAR(CURDATE())
    AND age_status='a'
")->fetchColumn();

$TOTAL_ANO = $pdo->query("
    SELECT IFNULL(SUM(age_valor_final),0)
    FROM mod_agendamentos
    WHERE YEAR(age_data)=YEAR(CURDATE())
    AND age_status='a'
")->fetchColumn();

$TOTAL_SERVICOS_ANO = $pdo->query("
    SELECT COUNT(*)
    FROM mod_agendamentos
    WHERE YEAR(age_data)=YEAR(CURDATE())
    AND age_status='a'
")->fetchColumn();

$ANO_ATUAL = date('Y');


// =============================
// 🔥 ENVIA PRO SMARTY
// =============================
$smarty->assign('TOTAL_CLIENTES', $TOTAL_CLIENTES);
$smarty->assign('TOTAL_VEICULOS', $TOTAL_VEICULOS);
$smarty->assign('TOTAL_SERVICOS', $TOTAL_SERVICOS);
$smarty->assign('TOTAL_AGENDAMENTOS', $TOTAL_AGENDAMENTOS);
$smarty->assign('FATURAMENTO', $FATURAMENTO);

$smarty->assign('AGENDAMENTOS', $AGENDAMENTOS);

// gráficos
$smarty->assign('LABELS_SEMANA', json_encode($labelsSemana));
$smarty->assign('DADOS_SEMANA', json_encode($dadosSemana));

$smarty->assign('LABELS_MES', json_encode($labelsMes));
$smarty->assign('DADOS_MES', json_encode($dadosMes));

$smarty->assign('LABELS_SERVICOS', json_encode($labelsServicos));
$smarty->assign('DADOS_SERVICOS', json_encode($dadosServicos));

// resumo
$smarty->assign('TOTAL_MES', $TOTAL_MES);
$smarty->assign('TOTAL_ANO', $TOTAL_ANO);
$smarty->assign('TOTAL_SERVICOS_ANO', $TOTAL_SERVICOS_ANO);
$smarty->assign('ANO_ATUAL', $ANO_ATUAL);


// =============================
$smarty->display('dashboard.tpl');