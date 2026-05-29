<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Lançamentos Financeiros</title>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

{include file="abas.tpl"}

<style>
body { font-family: Arial; margin: 0; }

.container { padding:20px; max-width:800px; margin:auto; }

input, select, button {
    padding:10px;
    margin:5px 0;
    width:100%;
    box-sizing:border-box;
}

button {
    background:#28a745;
    color:#fff;
    border:none;
    cursor:pointer;
}
button:hover { background:#218838; }

.btn-danger { background:#dc3545; }
.btn-danger:hover { background:#c82333; }

.hidden { display:none; }

.bloco-tabela { margin-top:30px; }

.topo-tabela {
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.resumo { font-weight:bold; }
.entrada-total { color:green; }
.saida-total { color:red; }

table {
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

th, td {
    padding:10px;
    border:1px solid #ccc;
    text-align:center;
}

th { background:#333; color:#fff; }

.entrada { color:green; }
.saida { color:red; }

.acoes button {
    width:auto;
    padding:5px 8px;
    font-size:12px;
}

/* MODAL */
.modal {
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
}

.modal-content {
    background:#fff;
    padding:20px;
    width:300px;
    margin:10% auto;
    border-radius:8px;
}
</style>
</head>

<body>


<div class="container">

<h2>Novo Lançamento</h2>

<form method="POST" action="financeiro_lancamento.php">

<label>Tipo:</label>
<select name="tipo" id="tipo">
    <option value="entrada">Entrada</option>
    <option value="saida">Saída</option>
</select>

<!-- ENTRADA -->
<div id="boxEntrada">
    <label>Tipo da Entrada:</label>
    <select name="tipoEntrada" id="tipoEntrada">
        <option value="servico">Serviço</option>
        <option value="manual">Manual</option>
    </select>

    <div id="selectServico">
        <label>Serviço:</label>
        <select name="servico">
			<option value="" selected>Escolha um serviço</option>
            {foreach from=$SERVICOS item=s}
                <option value="{$s.ser_id}">{$s.ser_nome}</option>
            {/foreach}
        </select>
    </div>
</div>

<!-- SAÍDA -->
<div id="boxSaida" class="hidden">
    <label>Categoria:</label>
    <select name="categoria">
        {foreach from=$CATEGORIAS item=c}
            <option value="{$c.cat_id}">{$c.cat_nome}</option>
        {/foreach}
    </select>
</div>

<label>Valor:</label>
<input type="number" name="valor" required>

<label>Descrição:</label>
<input type="text" name="descricao" required>

<button type="submit">Salvar</button>

</form>

<!-- BLOCO TABELA -->
<div class="bloco-tabela">

<h3>📅 Lançamentos do Dia</h3>

<div class="topo-tabela">

    <div class="resumo">
        <span class="entrada-total">Entradas: R$ <span id="totalEntrada">0</span></span> |
        <span class="saida-total">Saídas: R$ <span id="totalSaida">0</span></span>
    </div>

    <!-- 🔥 FILTRO RESTAURADO -->
    <div style="width:150px;">
        <select id="filtro">
            <option value="todos">Todos</option>
            <option value="entrada">Entradas</option>
            <option value="saida">Saídas</option>
        </select>
    </div>

</div>

<table>
<thead>
<tr>
    <th>Tipo</th>
    <th>Descrição</th>
    <th>Valor</th>
    <th>Ações</th>
</tr>
</thead>

<tbody id="tabelaDia">
{foreach from=$LANCAMENTOS item=l}
<tr data-tipo="{$l.fin_tipo}">
    <td class="{$l.fin_tipo}">{$l.fin_tipo}</td>
    <td>{$l.fin_descricao}</td>
    <td>R$ {$l.fin_valor_final}</td>
    <td class="acoes">
        <button onclick="abrirModal({$l.fin_id},'{$l.fin_tipo}','{$l.fin_descricao}',{$l.fin_valor_final})">
            <i class="fa-solid fa-pen"></i>
        </button>
    </td>
</tr>
{/foreach}
</tbody>

</table>

</div>
</div>

<!-- MODAL -->
<div class="modal" id="modal">
    <div class="modal-content">

        <h3>Detalhes</h3>

        <input type="hidden" id="modal_id">

        <p><b>Tipo:</b> <span id="modal_tipo"></span></p>
        <p><b>Descrição:</b> <span id="modal_desc"></span></p>
        <p><b>Valor:</b> R$ <span id="modal_valor"></span></p>

        <button id="btnExcluir" class="btn-danger">
            <i class="fa-solid fa-trash"></i> Excluir
        </button>

        <button id="btnFechar">Fechar</button>

    </div>
</div>

{literal}
<script>

// MODAL
function abrirModal(id,tipo,desc,valor){
    $('#modal_id').val(id);
    $('#modal_tipo').text(tipo);
    $('#modal_desc').text(desc);
    $('#modal_valor').text(valor);
    $('#modal').fadeIn();
}

$('#btnFechar').click(function(){
    $('#modal').fadeOut();
});

$('#btnExcluir').click(function(){
    var id = $('#modal_id').val();

    if(confirm('Excluir lançamento?')){
        $.post('financeiro_excluir.php',{id:id},function(){
            location.reload();
        });
    }
});

// FILTRO 🔥
$('#filtro').change(function(){

    var filtro = $(this).val();

    $('#tabelaDia tr').each(function(){

        var tipo = $(this).data('tipo');

        if(filtro === 'todos' || tipo === filtro){
            $(this).show();
        } else {
            $(this).hide();
        }

    });

});

// TIPO FORM
$('#tipo').change(function(){
    if($(this).val() === 'entrada'){
        $('#boxEntrada').show();
        $('#boxSaida').hide();
    } else {
        $('#boxEntrada').hide();
        $('#boxSaida').show();
    }
});

$('#tipoEntrada').change(function(){
    if($(this).val() === 'manual'){
        $('#selectServico').hide();
    } else {
        $('#selectServico').show();
    }
});

// TOTAL
$(document).ready(function(){

    var totalEntrada = 0;
    var totalSaida = 0;

    $('#tabelaDia tr').each(function(){

        var tipo = $(this).find('td:eq(0)').text();
        var valor = parseFloat($(this).find('td:eq(2)').text().replace('R$',''));

        if(tipo === 'entrada') totalEntrada += valor;
        else totalSaida += valor;

    });

    $('#totalEntrada').text(totalEntrada.toFixed(2));
    $('#totalSaida').text(totalSaida.toFixed(2));

});

</script>
{/literal}

</body>
</html>