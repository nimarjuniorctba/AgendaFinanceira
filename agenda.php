<?php

require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

error_reporting(E_ALL & ~E_DEPRECATED);

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

// DATA ATUAL
$data = date('Y-m-d');

// =============================
// 🔹 HORÁRIOS
// =============================
$horarios = $pdo->query("
    SELECT hor_id, hor_hora 
    FROM mod_horarios 
    ORDER BY hor_id
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
// 🔹 AGENDAMENTOS (COM STATUS PAGO)
// =============================
$stmt = $pdo->prepare("
SELECT 
    a.age_id,
    a.age_hora_inicio_fk,
    a.pis_id_fk,
    s.ser_nome,
    s.ser_cor,
    s.ser_duracao,
    c.cli_nome,
    v.vei_placa,

    (
        SELECT COUNT(*) 
        FROM mod_financeiro f
        WHERE f.age_id_fk = a.age_id
        AND f.fin_status = 'a'
    ) AS ja_pago

FROM mod_agendamentos a
LEFT JOIN mod_servicos s ON s.ser_id = a.ser_id_fk
LEFT JOIN mod_clientes c ON c.cli_id = a.cli_id_fk
LEFT JOIN mod_veiculos v ON v.vei_id = a.vei_id_fk
WHERE a.age_data = ?
AND a.age_status = 'a'
");

$stmt->execute([$data]);
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// =============================
// 🔹 MAPA
// =============================
$mapa = [];
foreach ($horarios as $i => $h) {
    $mapa[$h['hor_id']] = $i;
}

// =============================
// 🔹 OCUPADOS + ROWSPAN
// =============================
$ocupados = [];
$rowspan = [];

foreach ($agendamentos as $a) {

    if (!isset($mapa[$a['age_hora_inicio_fk']])) continue;

    $inicio = $mapa[$a['age_hora_inicio_fk']];
    $slots  = max(1, intval($a['ser_duracao'] / 5));

    for ($i = 0; $i < $slots; $i++) {

        $pos = $inicio + $i;

        if (isset($horarios[$pos])) {

            $hid = $horarios[$pos]['hor_id'];

            $ocupados[$hid][$a['pis_id_fk']] = [
                'id'       => $a['age_id'],
                'cliente'  => $a['cli_nome'],
                'servico'  => $a['ser_nome'],
                'placa'    => $a['vei_placa'],
                'cor'      => $a['ser_cor'],
                'pago'     => $a['ja_pago'] > 0
            ];

            $rowspan[$hid][$a['pis_id_fk']] = ($i == 0) ? $slots : 0;
        }
    }
}

// =============================
$smarty->assign('DATA_ATUAL', $data);
$smarty->assign('HORARIOS', $horarios);
$smarty->assign('PISTAS', $pistas);
$smarty->assign('OCUPADOS', $ocupados);
$smarty->assign('ROWSPAN', $rowspan);

$smarty->display('agenda.tpl');