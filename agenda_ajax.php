<?php

error_reporting(E_ALL & ~E_DEPRECATED);

require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

$acao = $_GET['acao'] ?? '';


// =============================
// 📅 LISTA DA AGENDA (COM PAGO)
// =============================
if ($acao == 'lista') {

    $data = $_GET['data'] ?? date('Y-m-d');

    $horarios = $pdo->query("
        SELECT hor_id, hor_hora 
        FROM mod_horarios 
        ORDER BY hor_id
    ")->fetchAll(PDO::FETCH_ASSOC);

    $pistas = $pdo->query("
        SELECT pis_id, pis_nome 
        FROM mod_pistas 
        WHERE pis_status='a'
    ")->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("
        SELECT 
            a.age_id,
            a.age_hora_inicio_fk,
            a.pis_id_fk,
            s.ser_nome,
            s.ser_duracao,
            s.ser_cor,
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

    $mapa = [];
    foreach ($horarios as $i => $h) {
        $mapa[$h['hor_id']] = $i;
    }

    $ocupados = [];
    $rowspan  = [];

    foreach ($agendamentos as $a) {

        if (!isset($mapa[$a['age_hora_inicio_fk']])) continue;

        $inicio = $mapa[$a['age_hora_inicio_fk']];
        $slots  = max(1, ceil($a['ser_duracao'] / 5));

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
                    'pago'     => ($a['ja_pago'] > 0)
                ];

                $rowspan[$hid][$a['pis_id_fk']] = ($i == 0) ? $slots : 0;
            }
        }
    }

    $smarty->assign('HORARIOS', $horarios);
    $smarty->assign('PISTAS', $pistas);
    $smarty->assign('OCUPADOS', $ocupados);
    $smarty->assign('ROWSPAN', $rowspan);

    $smarty->display('templates/agenda/agenda_lista.tpl');
    exit;
}


// =============================
// 🚗 VEÍCULOS
// =============================
if ($acao == 'veiculos') {

    $cliente_id = (int)$_GET['cliente_id'];

    $stmt = $pdo->prepare("
        SELECT vei_id, vei_placa, vei_modelo
        FROM mod_veiculos
        WHERE cli_id_fk = ?
        AND vei_status = 'a'
    ");

    $stmt->execute([$cliente_id]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}


// =============================
// 📄 DESCRIÇÃO
// =============================
if ($acao == 'descricao') {

    $id = (int)($_GET['id'] ?? 0);

    if (!$id) {
        header("Location: agenda_ajax.php?acao=cadastrar&data=".$_GET['data']."&hora=".$_GET['hora']."&pista=".$_GET['pista']);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT 
            a.*,
            c.cli_nome,
            c.cli_email,
            v.vei_placa,
            v.vei_modelo,
            s.ser_nome,
            s.ser_valor,
            s.ser_duracao,
            s.ser_cor,
            h.hor_hora,
            com.com_comentario
        FROM mod_agendamentos a
        LEFT JOIN mod_clientes c ON c.cli_id = a.cli_id_fk
        LEFT JOIN mod_veiculos v ON v.vei_id = a.vei_id_fk
        LEFT JOIN mod_servicos s ON s.ser_id = a.ser_id_fk
        LEFT JOIN mod_horarios h ON h.hor_id = a.age_hora_inicio_fk
        LEFT JOIN mod_comentario com ON com.age_id_fk = a.age_id
        WHERE a.age_id = ?
    ");

    $stmt->execute([$id]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dados) {
        header("Location: agenda_ajax.php?acao=cadastrar");
        exit;
    }

    $inicio = strtotime($dados['hor_hora']);
    $dados['hora_fim'] = date('H:i', $inicio + ($dados['ser_duracao'] * 60));

    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM mod_financeiro 
        WHERE age_id_fk = ? 
        AND fin_status = 'a'
    ");
    $stmt->execute([$id]);

    $jaPago = $stmt->fetchColumn() > 0;

    // 🔥 FORMAS DE PAGAMENTO (ADICIONADO)
    $formas = $pdo->query("
        SELECT for_id, for_nome 
        FROM mod_forma_pagamento 
        WHERE for_status='a'
    ")->fetchAll(PDO::FETCH_ASSOC);

    $dados['JA_PAGO'] = $jaPago;

    $smarty->assign('FORMAS', $formas);
    $smarty->assign('AG', $dados);
    $smarty->assign('JA_PAGO', $jaPago);

    $smarty->display('templates/agenda/descricao.tpl');
    exit;
}


// =============================
// 💰 PAGAMENTO (COM FORMA)
// =============================
if ($acao == 'pagar') {

    header('Content-Type: application/json');

    try {

        $id    = $_POST['id'];
        $forma = $_POST['forma'] ?? null;

        if (!$forma) {
            echo json_encode(['status'=>'erro','msg'=>'Selecione a forma de pagamento']);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM mod_agendamentos WHERE age_id = ?");
        $stmt->execute([$id]);
        $ag = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ag) {
            echo json_encode(['status'=>'erro']);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM mod_financeiro 
            WHERE age_id_fk = ? 
            AND fin_status='a'
        ");
        $stmt->execute([$id]);

        if ($stmt->fetchColumn() > 0) {
            echo json_encode(['status'=>'ok']);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO mod_financeiro (
                fin_data,
                fin_tipo,
                fin_origem,
                fin_valor,
                fin_desconto,
                fin_valor_final,
                fin_descricao,
                age_id_fk,
                ser_id_fk,
                cli_id_fk,
                vei_id_fk,
                pis_id_fk,
                for_id_fk
            ) VALUES (?, 'entrada', 'agenda', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $ag['age_data'],
            $ag['age_valor_final'],
            $ag['age_desconto'] ?? 0,
            $ag['age_valor_final'],
            'Pagamento Agenda',
            $id,
            $ag['ser_id_fk'],
            $ag['cli_id_fk'],
            $ag['vei_id_fk'],
            $ag['pis_id_fk'],
            $forma
        ]);

        echo json_encode(['status'=>'ok']);
        exit;

    } catch (Exception $e) {
        echo json_encode(['status'=>'erro','msg'=>$e->getMessage()]);
        exit;
    }
}


// =============================
// ❌ CANCELAR
// =============================
if ($acao == 'cancelar') {

    header('Content-Type: application/json');

    $id = $_POST['id'];

    $pdo->prepare("
        UPDATE mod_agendamentos 
        SET age_status='c' 
        WHERE age_id=?
    ")->execute([$id]);
	
    $pdo->prepare("
        UPDATE mod_financeiro 
        SET fin_status='c' 
        WHERE age_id_fk=?
    ")->execute([$id]);	

    echo json_encode(['status'=>'ok']);
    exit;
}


// =============================
// 🟢 CADASTRO
// =============================
if ($acao == 'cadastrar') {

    $clientes = $pdo->query("SELECT cli_id, cli_nome FROM mod_clientes WHERE cli_status='a'")->fetchAll(PDO::FETCH_ASSOC);
    $servicos = $pdo->query("SELECT ser_id, ser_nome FROM mod_servicos WHERE ser_status='a'")->fetchAll(PDO::FETCH_ASSOC);
    $pistas   = $pdo->query("SELECT pis_id, pis_nome FROM mod_pistas WHERE pis_status='a'")->fetchAll(PDO::FETCH_ASSOC);
    $horarios = $pdo->query("SELECT hor_id, hor_hora FROM mod_horarios")->fetchAll(PDO::FETCH_ASSOC);

    $smarty->assign('horaSelecionada', $_GET['hora'] ?? '');
    $smarty->assign('pistaSelecionada', $_GET['pista'] ?? '');
    $smarty->assign('dataSelecionada', $_GET['data'] ?? date('Y-m-d'));

    $smarty->assign('CLIENTES', $clientes);
    $smarty->assign('SERVICOS', $servicos);
    $smarty->assign('PISTAS', $pistas);
    $smarty->assign('HORARIOS', $horarios);

    $smarty->display('templates/agenda/cadastrar_agenda.tpl');
    exit;
}

// =============================
// 💾 SALVAR AGENDAMENTO
// =============================
if ($acao == 'salvar') {

    header('Content-Type: application/json');

    try {

        $data       = $_POST['data'] ?? '';
        $cliente    = $_POST['cliente'] ?? 0;
        $veiculo    = $_POST['veiculo'] ?? 0;
        $servico    = $_POST['servico'] ?? 0;
        $pista      = $_POST['pista'] ?? 0;
        $hora       = $_POST['hora'] ?? 0;
        $comentario = trim($_POST['comentario'] ?? '');

        // validação
        if (
            !$data ||
            !$cliente ||
            !$veiculo ||
            !$servico ||
            !$pista ||
            !$hora
        ) {

            echo json_encode([
                'status' => 'erro',
                'msg'    => 'Preencha todos os campos'
            ]);

            exit;
        }

        // busca serviço
        $stmt = $pdo->prepare("
            SELECT *
            FROM mod_servicos
            WHERE ser_id = ?
        ");

        $stmt->execute([$servico]);

        $ser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ser) {

            echo json_encode([
                'status' => 'erro',
                'msg'    => 'Serviço inválido'
            ]);

            exit;
        }

        // verifica conflito
        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM mod_agendamentos
            WHERE age_data = ?
            AND pis_id_fk = ?
            AND age_hora_inicio_fk = ?
            AND age_status = 'a'
        ");

        $stmt->execute([
            $data,
            $pista,
            $hora
        ]);

        if ($stmt->fetchColumn() > 0) {

            echo json_encode([
                'status' => 'erro',
                'msg'    => 'Horário já ocupado'
            ]);

            exit;
        }

        // salva agendamento
        $stmt = $pdo->prepare("
            INSERT INTO mod_agendamentos (

                age_data,
                age_hora_inicio_fk,

                cli_id_fk,
                vei_id_fk,
                ser_id_fk,
                pis_id_fk,

                age_desconto,
                age_valor_final,
                age_status

            ) VALUES (

                ?,
                ?,

                ?,
                ?,
                ?,
                ?,

                0,
                ?,
                'a'
            )
        ");

        $stmt->execute([

            $data,
            $hora,

            $cliente,
            $veiculo,
            $servico,
            $pista,

            $ser['ser_valor']
        ]);

        $ageId = $pdo->lastInsertId();

        // comentário
        if ($comentario != '') {

            $stmt = $pdo->prepare("
                INSERT INTO mod_comentario (
                    age_id_fk,
                    com_comentario
                ) VALUES (?, ?)
            ");

            $stmt->execute([
                $ageId,
                $comentario
            ]);
        }

        echo json_encode([
            'status' => 'ok'
        ]);

        exit;

    } catch (Exception $e) {

        echo json_encode([
            'status' => 'erro',
            'msg'    => $e->getMessage()
        ]);

        exit;
    }
}