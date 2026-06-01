<?php

require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$smarty = new Smarty();
$pdo = MySQL_PDO::conexao();

$acao = $_GET['acao'] ?? '';


// ======================
// SALVAR
// ======================
if($acao == 'salvar'){

    $inicio = (int)$_POST['hora_inicio'];
    $fim    = (int)$_POST['hora_fim'];

    $existe = $pdo->query("
        SELECT COUNT(*)
        FROM mod_configuracao_agenda
    ")->fetchColumn();

    if($existe){

        $stmt = $pdo->prepare("
            UPDATE mod_configuracao_agenda
            SET
                cfg_hora_inicio_fk=?,
                cfg_hora_fim_fk=?
            WHERE cfg_id=1
        ");

        $stmt->execute([
            $inicio,
            $fim
        ]);

    }else{

        $stmt = $pdo->prepare("
            INSERT INTO mod_configuracao_agenda (
                cfg_hora_inicio_fk,
                cfg_hora_fim_fk
            ) VALUES (?,?)
        ");

        $stmt->execute([
            $inicio,
            $fim
        ]);
    }

    header('Location: configuracoes');
    exit;
}


// ======================
// TELA
// ======================

$horarios = $pdo->query("
    SELECT *
    FROM mod_horarios
    ORDER BY hor_id
")->fetchAll(PDO::FETCH_ASSOC);

$config = $pdo->query("
    SELECT *
    FROM mod_configuracao_agenda
    LIMIT 1
")->fetch(PDO::FETCH_ASSOC);

$smarty->assign('HORARIOS',$horarios);
$smarty->assign('CONFIG',$config);

$smarty->assign('pagina', $pagina);
$smarty->display('configuracao_agenda.tpl');