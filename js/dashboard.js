window.onload = function(){

    // 📅 SEMANA
    let labelsSemana = semana.map(s => s.dia);
    let valoresSemana = semana.map(s => s.total);

    new Chart(document.getElementById('graficoSemana'), {
        type: 'bar',
        data: {
            labels: labelsSemana,
            datasets: [{
                label: 'Faturamento',
                data: valoresSemana
            }]
        }
    });

    // 📅 MÊS
    let labelsMes = meses.map(m => 'Mês ' + m.mes);
    let valoresMes = meses.map(m => m.total);

    new Chart(document.getElementById('graficoMes'), {
        type: 'line',
        data: {
            labels: labelsMes,
            datasets: [{
                label: 'Faturamento',
                data: valoresMes
            }]
        }
    });

    // 🔧 SERVIÇOS
    let labelsServ = servicos.map(s => 'Mês ' + s.mes);
    let valoresServ = servicos.map(s => s.total);

    new Chart(document.getElementById('graficoServico'), {
        type: 'bar',
        data: {
            labels: labelsServ,
            datasets: [{
                label: 'Serviços',
                data: valoresServ
            }]
        }
    });

}