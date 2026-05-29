
{include file="abas.tpl"}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body {
    font-family: Arial;
    background: #f4f4f4;
    margin: 0;
}



/* CONTAINER */
.container {
    padding: 20px;
}

/* ================= CARDS ================= */
.cards {
    display: flex;
    gap: 10px;
    flex-wrap: nowrap; /* 🔥 força ficar na mesma linha */
    overflow-x: auto; /* caso não caiba, cria scroll */
}

.card {
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    min-width: 160px;
    flex: 1;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.card h3 {
    margin: 0;
    font-size: 13px;
    color: #666;
}

.card p {
    font-size: 22px;
    margin: 5px 0 0;
    font-weight: bold;
}

/* ================= GRID ================= */
.grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 15px;
    margin-top: 20px;
}

.grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 15px;
    margin-top: 15px;
}

/* BLOCO */
.bloco {
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.bloco h3 {
    margin-top: 0;
}

/* TABELA */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    background: #fff;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
}

th {
    background: #333;
    color: #fff;
}

</style>

</head>
<body>


<div class="container">

    <h2>Dashboard</h2>

    <!-- 🔥 CARDS EM LINHA -->
    <div class="cards">

        <div class="card">
            <h3>Clientes</h3>
            <p>{$TOTAL_CLIENTES}</p>
        </div>

        <div class="card">
            <h3>Veículos</h3>
            <p>{$TOTAL_VEICULOS}</p>
        </div>

        <div class="card">
            <h3>Serviços</h3>
            <p>{$TOTAL_SERVICOS}</p>
        </div>

        <div class="card">
            <h3>Agendamentos Hoje</h3>
            <p>{$TOTAL_AGENDAMENTOS}</p>
        </div>

        <div class="card">
            <h3>Faturamento Hoje</h3>
            <p>R$ {$FATURAMENTO}</p>
        </div>

    </div>

    <!-- 🔥 FATURAMENTO SEMANA + RESUMO -->
    <div class="grid">

        <div class="bloco">
            <h3>Faturamento últimos 7 dias</h3>
            <canvas id="graficoSemana"></canvas>
        </div>

        <div class="bloco">
            <h3>Resumo</h3>
            <p><strong>Mês atual:</strong> R$ {$TOTAL_MES}</p>
            <p><strong>Total serviços:</strong> {$TOTAL_SERVICOS_ANO}</p>
        </div>

    </div>

    <!-- 🔥 3 BLOCOS MENORES -->
    <div class="grid-3">

        <div class="bloco">
            <h3>Faturamento por mês</h3>
            <canvas id="graficoMes"></canvas>
        </div>

        <div class="bloco">
            <h3>Serviços por mês</h3>
            <canvas id="graficoServicos"></canvas>
        </div>

        <div class="bloco">
            <h3>Resumo geral</h3>
            <p><strong>Ano atual:</strong> {$ANO_ATUAL}</p>
            <p><strong>Total faturado:</strong> R$ {$TOTAL_ANO}</p>
        </div>

    </div>

    <!-- 🔥 ÚLTIMOS AGENDAMENTOS -->
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

</div>

<!-- ================= GRÁFICOS ================= -->
<script>

// 📊 FATURAMENTO SEMANA
new Chart(document.getElementById('graficoSemana'), {
    type: 'bar',
    data: {
        labels: {$LABELS_SEMANA},
        datasets: [{
            label: 'R$',
            data: {$DADOS_SEMANA}
        }]
    }
});

// 📊 FATURAMENTO MENSAL
new Chart(document.getElementById('graficoMes'), {
    type: 'line',
    data: {
        labels: {$LABELS_MES},
        datasets: [{
            label: 'R$',
            data: {$DADOS_MES}
        }]
    }
});

// 📊 SERVIÇOS POR MÊS
new Chart(document.getElementById('graficoServicos'), {
    type: 'bar',
    data: {
        labels: {$LABELS_SERVICOS},
        datasets: [{
            label: 'Qtd',
            data: {$DADOS_SERVICOS}
        }]
    }
});

</script>

</body>
</html>