{include file="abas.tpl"}

<h2>Cadastro Veículo</h2>

<form method="POST">

    Cliente:
    <select name="cliente">
        {foreach from=$CLIENTES item=c}
            <option value="{$c.cli_id}">{$c.cli_nome}</option>
        {/foreach}
    </select><br>

    Placa: <input type="text" name="placa"><br>
    Modelo: <input type="text" name="modelo"><br>
    Marca: <input type="text" name="marca"><br>
    Cor: <input type="text" name="cor"><br>

    Comentário:
    <textarea name="comentario"></textarea><br>

    <button>Salvar</button>

</form>