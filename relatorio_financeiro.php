<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Relatórios</title>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body {
    font-family: Arial;
    margin: 0;
    background: #f4f6f9;
}

/* MENU */
.menu {
    background: #1f2d3d;
    padding: 15px;
}
.menu a {
    color: #fff;
    margin-right: 15px;
    text-decoration: none;
    font-weight: bold;
}

/* CONTAINER */
.container {
    padding: 20px;
    max-width: 1200px;
    margin: auto;
}

/* FILTROS */
.filtros {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 10px;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
}

.filtros label {
    font-size: 13px;
    font-weight: bold;
}

input, select, button {
    padding: 10px;
    width: 100%;
    margin-top: 5px;
    box-sizing: border-box;
}

/* BOTÕES */
button {
    background: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 6px;
}

button:hover {
    background: #0056b3;
}

.btn-pdf {
    background: #28a745;
}
.btn-pdf:hover {
    background: #1e7e34;
}

/* KPI CARDS */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.card h4 {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.card p {
    font-size: 20px;
    margin: 10px 0 0;
    font-weight: bold;
}

.entrada { color: green; }
.saida { color: red; }

/* GRID */
.grid {
    display: flex;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.grafico {
    flex: 2;
    min-width: 300px;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
}

.grafico-pizza {
    flex: 1;
    min-width: 250px;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
}

/* TABELA */
.tabela-box {
    margin-top: 20px;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
}

th {
    background: #333;
    color: #fff;
}

/* RESPONSIVO */
@media (max-width: 600px){
    .menu {
        text-align: center;
    }
}

</style>

</head>
<body>

<div class="menu">
    <a href="#">🏠 Home</a>
    <a href="#">📊 Relatórios</a>
</div>

<div class="container">

<h2>📊 Relatórios Avançados</h2>

<!-- FILTROS -->
<div class="filtros">

<div>
<label>Data Inicial</label>
<input type="date" id="dataInicio">
</div>

<div>
<label>Data Final</label>
<input type="date" id="dataFim">
</div>

<div>
<label>Cliente</label>
<select id="clienteFiltro">
<option value="todos">Todos</option>
</select>
</div>

<div>
<label>Serviço</label>
<select id="servicoFiltro">
<option value="todos">Todos</option>
</select>
</div>

<div>
<label>Pista</label>
<select id="pistaFiltro">
<option value="todos">Todas</option>
</select>
</div>

<div>
<label>Tipo</label>
<select id="tipoFiltro">
<option value="todos">Todos</option>
<option value="entrada">Entrada</option>
<option value="saida">Saída</option>
</select>
</div>

<div>
<label>Origem</label>
<select id="origemFiltro">
<option value="todos">Todos</option>
<option value="agenda">Agenda</option>
<option value="manual">Manual</option>
</select>
</div>

</div>

<br>

<button id="btnFiltrar">🔍 Filtrar</button>
<button id="btnPDF" class="btn-pdf">📄 Gerar PDF</button>

<!-- KPIs -->
<div class="cards">

<div class="card">
<h4>Faturamento</h4>
<p class="entrada">R$ <span id="fat">0</span></p>
</div>

<div class="card">
<h4>Despesas</h4>
<p class="saida">R$ <span id="desp">0</span></p>
</div>

<div class="card">
<h4>Lucro</h4>
<p>R$ <span id="lucro">0</span></p>
</div>

<div class="card">
<h4>Ticket Médio</h4>
<p>R$ <span id="ticket">0</span></p>
</div>

</div>

<!-- GRÁFICOS -->
<div class="grid">

<div class="grafico">
<canvas id="linha"></canvas>
</div>

<div class="grafico-pizza">
<canvas id="pizza"></canvas>
</div>

</div>

<!-- TABELA -->
<div class="tabela-box">

<h3>📋 Detalhamento Financeiro</h3>

<table>
<thead>
<tr>
<th>Data</th>
<th>Tipo</th>
<th>Origem</th>
<th>Valor</th>
</tr>
</thead>
<tbody id="tabela"></tbody>
</table>

</div>

</div>

<script>

// MOCK DATA
let dados = [
{data:"01", valor:100, tipo:"entrada", origem:"agenda"},
{data:"02", valor:150, tipo:"entrada", origem:"manual"},
{data:"03", valor:80, tipo:"saida", origem:"manual"},
{data:"04", valor:200, tipo:"entrada", origem:"agenda"},
{data:"05", valor:50, tipo:"saida", origem:"manual"}
];

let chartLinha = new Chart(document.getElementById('linha'), {type:'line', data:{labels:[], datasets:[{label:'Faturamento', data:[]}]}});  
let chartPizza = new Chart(document.getElementById('pizza'), {type:'doughnut', data:{labels:[], datasets:[{data:[]}]}});

// ATUALIZA TELA
function atualizarTela(lista){

    let entrada = 0;
    let saida = 0;

    let html = "";

    lista.forEach(item => {

        if(item.tipo === 'entrada') entrada += item.valor;
        else saida += item.valor;

        html += `
        <tr>
            <td>${item.data}</td>
            <td class="${item.tipo}">${item.tipo}</td>
            <td>${item.origem}</td>
            <td>R$ ${item.valor}</td>
        </tr>`;
    });

    $('#tabela').html(html);

    let total = entrada + saida;
    let ticket = lista.length ? total / lista.length : 0;

    $('#fat').text(entrada.toFixed(2));
    $('#desp').text(saida.toFixed(2));
    $('#lucro').text((entrada - saida).toFixed(2));
    $('#ticket').text(ticket.toFixed(2));

    chartLinha.destroy();
    chartLinha = new Chart(document.getElementById('linha'), {
        type:'line',
        data:{
            labels: lista.map(d=>d.data),
            datasets:[{label:'Faturamento', data: lista.map(d=>d.valor)}]
        }
    });

    chartPizza.destroy();
    chartPizza = new Chart(document.getElementById('pizza'), {
        type:'doughnut',
        data:{
            labels:['Entrada','Saída'],
            datasets:[{data:[entrada, saida]}]
        }
    });
}

// FILTRO
function aplicarFiltros(){

    let tipo = $('#tipoFiltro').val();
    let origem = $('#origemFiltro').val();

    let filtrado = dados.filter(d => {
        return (tipo === 'todos' || d.tipo === tipo) &&
               (origem === 'todos' || d.origem === origem);
    });

    atualizarTela(filtrado);
}

// EVENTOS
$('#btnFiltrar').click(aplicarFiltros);

$('#btnPDF').click(function(){
    alert('Aqui vai chamar o PHP com DOMPDF');
});

// INIT
atualizarTela(dados);

</script>

</body>
</html>