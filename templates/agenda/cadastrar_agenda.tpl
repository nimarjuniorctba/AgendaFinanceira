<h2>Novo Agendamento</h2>

<form id="formAgenda">

    <label>Data:</label><br>
    <input type="date" name="data" value="{$dataSelecionada}" required><br><br>

    <label>Cliente:</label><br>
    <select name="cliente" id="cliente" required>
        <option value="">Selecione</option>
        {foreach from=$CLIENTES item=c}
            <option value="{$c.cli_id}">{$c.cli_nome}</option>
        {/foreach}
    </select><br><br>

    <label>Veículo:</label><br>
    <select name="veiculo" id="veiculo" required>
        <option value="">Selecione o cliente primeiro</option>
    </select><br><br>

    <label>Serviço:</label><br>
    <select name="servico" required>
        {foreach from=$SERVICOS item=s}
            <option value="{$s.ser_id}">{$s.ser_nome}</option>
        {/foreach}
    </select><br><br>

    <label>Pista:</label><br>
    <select name="pista" required>
        {foreach from=$PISTAS item=p}
            <option value="{$p.pis_id}" {if $p.pis_id == $pistaSelecionada}selected{/if}>
                {$p.pis_nome}
            </option>
        {/foreach}
    </select><br><br>

    <label>Horário:</label><br>
    <select name="hora" required>
        {foreach from=$HORARIOS item=h}
            <option value="{$h.hor_id}" {if $h.hor_id == $horaSelecionada}selected{/if}>
                {$h.hor_hora}
            </option>
        {/foreach}
    </select><br><br>

    <label>Comentário:</label><br>
    <textarea name="comentario"></textarea><br><br>

    <button type="submit">Salvar</button>

</form>

{literal}
<script>

// 🔄 carregar veículos
$('#cliente').change(function(){

    let cliente_id = $(this).val();

    $('#veiculo').html('<option>Carregando...</option>');

    $.get('agenda_ajax.php?acao=veiculos&cliente_id='+cliente_id, function(res){

        let html = '<option value="">Selecione</option>';

        res.forEach(function(v){
            html += '<option value="'+v.vei_id+'">'+v.vei_placa+' - '+v.vei_modelo+'</option>';
        });

        $('#veiculo').html(html);

    }, 'json');

});


// 💾 salvar
$('#formAgenda').submit(function(e){

    e.preventDefault();

    $.post('agenda_ajax.php?acao=salvar', $(this).serialize(), function(res){

        if(res.status === 'ok'){
            alert('Agendado com sucesso!');
            location.reload();
        } else {
            alert('Erro ao salvar');
            console.log(res);
        }

    }, 'json');

});

</script>
{/literal}