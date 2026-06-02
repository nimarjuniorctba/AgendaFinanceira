{include file="abas.tpl"}
<h2>Configuração de Horário de Funcionamento</h2>

<form method="post" action="{$pagina->base}configuracao_agenda.php?acao=salvar">

    <div style="margin-bottom:15px;">
        <label><strong>Abre às:</strong></label>

        <select name="hora_inicio" required>

            {foreach from=$HORARIOS item=h}

                <option value="{$h.hor_id}"
                {if $CONFIG.cfg_hora_inicio_fk == $h.hor_id}selected{/if}>
                    {$h.hor_hora}
                </option>

            {/foreach}

        </select>
    </div>


    <div style="margin-bottom:15px;">
        <label><strong>Fecha às:</strong></label>

        <select name="hora_fim" required>

            {foreach from=$HORARIOS item=h}

                <option value="{$h.hor_id}"
                {if $CONFIG.cfg_hora_fim_fk == $h.hor_id}selected{/if}>
                    {$h.hor_hora}
                </option>

            {/foreach}

        </select>
    </div>


    <button type="submit">
        Salvar
    </button>

</form>