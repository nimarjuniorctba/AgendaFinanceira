<?php

require_once 'classes/Autoload.class.php';

$pdo = MySQL_PDO::conexao();

$cliente = $_GET['cliente'] ?? 0;

$stmt = $pdo->prepare("
    SELECT vei_id, vei_placa, vei_modelo
    FROM mod_veiculos
    WHERE cli_id_fk = ?
    AND vei_status = 'a'
");

$stmt->execute([$cliente]);

$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<option value="">Selecione</option>';

foreach ($veiculos as $v) {
    echo '<option value="'.$v['vei_id'].'">'
        .$v['vei_placa'].' - '.$v['vei_modelo'].
    '</option>';
}