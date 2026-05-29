<style>
table {
    border-collapse: collapse;
    width: 100%;
    background: #fff;
}

th, td {
    border: 1px solid #ccc;
    padding: 6px;
    text-align: center;
}

th {
    background: #333;
    color: #fff;
}

.livre {
    background: #d4edda;
    cursor: pointer;
    font-weight: bold;
}

.livre:hover {
    background: #bfe5c6;
}

.ocupado {
    color: #fff;
    font-weight: bold;
    font-size: 12px;
    cursor: pointer;
    border-radius: 4px;
    padding: 6px;
}

.ocupado small {
    display:block;
    font-size:10px;
}

/* STATUS */
.status-pago {
    color: #00ff9c;
    font-size: 11px;
}

.status-pendente {
    color: #ffd166;
    font-size: 11px;
}
</style>

<table>
<thead>
<tr>
    <th>Horário</th>

    {foreach from=$PISTAS item=p}
        <th>{$p.pis_nome}</th>
    {/foreach}
</tr>
</thead>

<tbody>

{foreach from=$HORARIOS item=h}
<tr>

<td>{$h.hor_hora}</td>

{foreach from=$PISTAS item=p}

{assign var=info value=$OCUPADOS[$h.hor_id][$p.pis_id]|default:null}
{assign var=span value=$ROWSPAN[$h.hor_id][$p.pis_id]|default:0}

{if $info}

    {if $span > 0}

        {* 🔥 DEFINE COR BASEADA NO PAGAMENTO *}
        {if $info.pago}
            {assign var=bg value='#28a745'} {* verde pago *}
        {else}
            {assign var=bg value=$info.cor|default:'#dc3545'} {* cor do serviço *}
        {/if}

        <td class="ocupado"
            rowspan="{$span}"
            data-id="{$info.id}"
            style="background: {$bg};">

            <strong>{$info.cliente}</strong>

            <small>{$info.servico}</small>

            <small>
                🚗 {$info.placa|default:"---"}
            </small>

            {* 🔥 STATUS PAGAMENTO *}
            {if $info.pago}
                <small class="status-pago">✔ Pago</small>
            {else}
                <small class="status-pendente">💰 Pendente</small>
            {/if}

        </td>

    {/if}

{else}

    <td class="livre"
        data-hora="{$h.hor_id}"
        data-pista="{$p.pis_id}">
        Livre
    </td>

{/if}

{/foreach}

</tr>
{/foreach}

</tbody>
</table>