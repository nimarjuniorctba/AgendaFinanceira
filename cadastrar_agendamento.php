<?php

require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

// =============================
// 🔹 CLIENTES
// =============================
$clientes = $pdo->query("
    SELECT cli_id, cli_nome 
    FROM mod_clientes 
    WHERE cli_status='a'
    ORDER BY cli_nome
")->fetchAll(PDO::FETCH_ASSOC);

// =============================
// 🔹 SERVIÇOS
// =============================
$servicos = $pdo->query("
    SELECT ser_id, ser_nome, ser_valor, ser_duracao, ser_cor
    FROM mod_servicos
    WHERE ser_status='a'
    ORDER BY ser_nome
")->fetchAll(PDO::FETCH_ASSOC);

// =============================
// 🔹 PISTAS
// =============================
$pistas = $pdo->query("
    SELECT pis_id, pis_nome 
    FROM mod_pistas 
    WHERE pis_status='a'
")->fetchAll(PDO::FETCH_ASSOC);

// =============================
// 🔹 HORÁRIOS
// =============================
$horarios = $pdo->query("
    SELECT hor_id, hor_hora 
    FROM mod_horarios 
    ORDER BY hor_hora
")->fetchAll(PDO::FETCH_ASSOC);


// =============================
// 💾 SALVAR
// =============================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data     = $_POST['data'];
    $hora_ini = $_POST['hora_inicio'];
    $pista    = $_POST['pista'];
    $servico  = $_POST['servico'];
    $cliente  = $_POST['cliente'];
    $veiculo  = $_POST['veiculo'];
    $desconto = $_POST['desconto'] ?? 0;

    // 🔹 pega dados do serviço
    $stmt = $pdo->prepare("
        SELECT ser_valor, ser_duracao 
        FROM mod_servicos 
        WHERE ser_id=?
    ");
    $stmt->execute([$servico]);
    $ser = $stmt->fetch(PDO::FETCH_ASSOC);

    $valor = (float)$ser['ser_valor'];
    $duracao = (int)$ser['ser_duracao'];

    // 🔹 calcula slots
    $slots = max(1, intval($duracao / 5));
    $hora_fim = $hora_ini + $slots;

    $valor_final = $valor - (float)$desconto;

    // 🔹 salva
    $stmt = $pdo->prepare("
        INSERT INTO mod_agendamentos
        (age_data, age_hora_inicio_fk, age_hora_fim_fk, pis_id_fk, ser_id_fk, cli_id_fk, vei_id_fk, age_desconto, age_valor_final)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $ok = $stmt->execute([
        $data,
        $hora_ini,
        $hora_fim,
        $pista,
        $servico,
        $cliente,
        $veiculo,
        $desconto,
        $valor_final
    ]);

    echo "<script>alert('Agendamento realizado!');</script>";
}


// envia pro template
$smarty->assign('CLIENTES', $clientes);
$smarty->assign('SERVICOS', $servicos);
$smarty->assign('PISTAS', $pistas);
$smarty->assign('HORARIOS', $horarios);

$smarty->display('templates/agenda/cadastrar_agendamento.tpl');