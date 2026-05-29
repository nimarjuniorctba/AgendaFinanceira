{include file="abas.tpl"}
<style>
body {
    font-family: Arial;
    background: #f4f4f4;
    padding: 20px;
}

form {
    background: #fff;
    padding: 20px;
    max-width: 500px;
    border-radius: 8px;
}

label {
    display: block;
    margin-top: 10px;
}

select, input, button {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
}

button {
    background: #28a745;
    color: #fff;
    border: none;
    margin-top: 15px;
    cursor: pointer;
}
</style>

<h2>Novo Agendamento</h2>

<form method="POST">

    <label>Data</label>
    <input type="date" name="data" required>

    <label>Cliente</label>
    <select name="cliente" id="cliente" required>
        <option value="">Selecione</option>
        {foreach from=$CLIENTES item=c}
            <option value="{$c.cli_id}">{$c.cli_nome}</option>
        {/foreach}
    </select>

    <label>Veículo</label>
    <select name="veiculo" id="veiculo" required>
        <option value="">Selecione o cliente primeiro</option>
    </select>

    <label>Serviço</label>
    <select name="servico" required>
        {foreach from=$SERVICOS item=s}
            <option value="{$s.ser_id}">
                {$s.ser_nome} - R$ {$s.ser_valor}
            </option>
        {/foreach}
    </select>

    <label>Pista</label>
    <select name="pista" required>
        {foreach from=$PISTAS item=p}
            <option value="{$p.pis_id}">{$p.pis_nome}</option>
        {/foreach}
    </select>
	
	<select name="forma_pagamento">
    <option value="">Selecione</option>
    <option value="1">Dinheiro</option>
    <option value="2">Pix</option>
	</select>

    <label>Horário Inicial</label>
    <select name="hora_inicio" required>
        {foreach from=$HORARIOS item=h}
            <option value="{$h.hor_id}">{$h.hor_hora}</option>
        {/foreach}
    </select>

    <label>Desconto (R$)</label>
    <input type="number" step="0.01" name="desconto">

    <button type="submit">Agendar</button>

</form>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

// =============================
// 🔄 CARREGAR VEÍCULOS POR CLIENTE
// =============================
$('#cliente').change(function(){

    let cliente = $(this).val();

    $('#veiculo').html('<option>Carregando...</option>');

    $.get('buscar_veiculos.php?cliente='+cliente, function(data){
        $('#veiculo').html(data);
    });

});
</script>