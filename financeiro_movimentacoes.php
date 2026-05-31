<?php

$servicos = $pdo->query("
    SELECT ser_id, ser_nome
    FROM mod_servicos
    WHERE ser_status='a'
")->fetchAll(PDO::FETCH_ASSOC);

$smarty->assign('SERVICOS', $servicos);
$smarty->assign('pagina', $pagina);

$smarty->display('financeiro_movimentacoes.tpl');