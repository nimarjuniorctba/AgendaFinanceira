<h3>Últimos Agendamentos</h3>

<table>
<tr>
<th>Data</th>
<th>Cliente</th>
<th>Veículo</th>
<th>Serviço</th>
<th>Valor</th>
</tr>

{foreach from=$AGENDAMENTOS item=a}
<tr>
<td>{$a.age_data}</td>
<td>{$a.cli_nome}</td>
<td>{$a.vei_placa}</td>
<td>{$a.ser_nome}</td>
<td>R$ {$a.age_valor_final}</td>
</tr>
{/foreach}

</table>