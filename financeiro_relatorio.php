<?php
require_once 'classes/Autoload.class.php';
//require_once 'vendor/autoload.php';


require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$pdo = MySQL_PDO::conexao();

$ini    = $_GET['dataInicio'] ?? null;
$fim    = $_GET['dataFim'] ?? null;
$tipo   = $_GET['tipo'] ?? 'todos';
$origem = $_GET['origem'] ?? 'todos';

$sql = "SELECT * FROM mod_financeiro WHERE fin_status='a'";
$params = [];

if($ini){
    $sql .= " AND fin_data >= ?";
    $params[] = $ini;
}

if($fim){
    $sql .= " AND fin_data <= ?";
    $params[] = $fim;
}

if($tipo != 'todos'){
    $sql .= " AND fin_tipo = ?";
    $params[] = $tipo;
}

if($origem != 'todos'){
    $sql .= " AND fin_origem = ?";
    $params[] = $origem;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalEntrada = 0;
$totalSaida = 0;

foreach($dados as $d){
    if($d['fin_tipo']=='entrada') $totalEntrada += $d['fin_valor_final'];
    else $totalSaida += $d['fin_valor_final'];
}

$lucro = $totalEntrada - $totalSaida;

$html = "<h2>Movimentações Financeiras</h2>";

$html .= "<table border='1' width='100%'>
<tr>
<th>Data</th><th>Tipo</th><th>Origem</th><th>Descrição</th><th>Valor</th>
</tr>";

foreach($dados as $d){
    $html .= "<tr>
    <td>{$d['fin_data']}</td>
    <td>{$d['fin_tipo']}</td>
    <td>{$d['fin_origem']}</td>
    <td>{$d['fin_descricao']}</td>
    <td>R$ {$d['fin_valor_final']}</td>
    </tr>";
}

$html .= "</table>";

$html .= "<br><b>Total Entrada:</b> $totalEntrada";
$html .= "<br><b>Total Saída:</b> $totalSaida";
$html .= "<br><b>Lucro:</b> $lucro";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("relatorio.pdf", ["Attachment"=>false]);