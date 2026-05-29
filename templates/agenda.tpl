{include file="abas.tpl"}
<style>
body {
    font-family: Arial;
    background: #f4f4f4;
    padding: 20px;
}

h2 {
    margin-bottom: 10px;
}

.topo {
    margin-bottom: 15px;
}

table {
    border-collapse: collapse;
    width: 100%;
    max-width: 1100px;
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
}

.ocupado {
    color: #fff;
    font-weight: bold;
    font-size: 12px;
    cursor: pointer;
}

.livre:hover {
    background: #bfe5c6;
}

/* MODAL */
.modal-bg {
    position: fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.6);
    display:none;
    z-index:999;
}

.modal {
    background:#fff;
    width:500px;
    margin:80px auto;
    padding:20px;
    border-radius:8px;
}
</style>
<br>
<h2 hidden>Agenda</h2>

<div class="topo">
    <label><strong>Data:</strong></label>
    <input type="date" id="dataAgenda" value="{$DATA_ATUAL}">
</div>

<!-- MODAL -->
<div id="modalBg" class="modal-bg">
    <div class="modal">
        <div id="modalContent"></div>
    </div>
</div>

<!-- AGENDA -->
<div id="agendaContainer"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

// =============================
// 🔄 CARREGA AGENDA
// =============================
function carregarAgenda(){

    let data = $('#dataAgenda').val();

    $('#agendaContainer').load(
        'agenda_ajax.php?acao=lista&data=' + data
    );
}

// =============================
$('#dataAgenda').on('change', carregarAgenda);

// =============================
setInterval(carregarAgenda, 30000);

// =============================
$(document).on('click', '.livre', function(){

    let hora  = $(this).data('hora');
    let pista = $(this).data('pista');
    let data  = $('#dataAgenda').val();

    $('#modalBg').show();

    $('#modalContent').load(
        'agenda_ajax.php?acao=cadastrar&hora=' + hora + '&pista=' + pista + '&data=' + data
    );
});

// =============================
$(document).on('click', '.ocupado', function(){

    let id = $(this).data('id');

    $('#modalBg').show();

    $('#modalContent').load(
        'agenda_ajax.php?acao=descricao&id=' + id
    );
});

// =============================
$('#modalBg').click(function(e){
    if(e.target.id === 'modalBg'){
        $(this).hide();
    }
});

// =============================
carregarAgenda();

</script>