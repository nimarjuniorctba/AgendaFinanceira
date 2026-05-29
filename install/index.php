<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbName = "agenda";

$conn = new mysqli($host, $user, $pass);

$existe = false;

if (!$conn->connect_error) {
    $result = $conn->query("SHOW DATABASES LIKE '$dbName'");
    $existe = ($result->num_rows > 0);
}

$conn->close();

if ($existe) {
    echo "<h2>✅ Sistema já instalado</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Instalador</title>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
body {
    font-family: Arial;
    background: #0f172a;
    color: #fff;
    text-align: center;
}

.box {
    margin: 60px auto;
    width: 420px;
    background: #1e293b;
    padding: 25px;
    border-radius: 10px;
}

.progress {
    width: 100%;
    background: #020617;
    border-radius: 5px;
    margin-top: 20px;
    height: 20px;
}

.progress-bar {
    height: 100%;
    width: 0%;
    background: #df6d37;
    border-radius: 5px;
    transition: width 0.3s;
}

.logs {
    margin-top: 20px;
    background: #020617;
    padding: 10px;
    height: 150px;
    overflow-y: auto;
    text-align: left;
    font-size: 13px;
}

button {
    margin-top: 20px;
    padding: 12px;
    width: 100%;
    background: #df6d37;
    border: none;
    font-weight: bold;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="box">

<h2>⚙️ Instalador</h2>

<p>❌ Banco não encontrado</p>

<div class="progress">
    <div class="progress-bar" id="barra"></div>
</div>

<div class="logs" id="logs"></div>

<button id="instalar">🚀 Iniciar Instalação</button>

</div>

<script>

$("#instalar").click(function(){

    $("#logs").html("");
    $("#barra").css("width", "0%");

    var etapa = 1;

    function executarEtapa() {

        $.ajax({
            url: "instalar.php",
            type: "POST",
            data: { etapa: etapa },
            success: function(res){

                var dados = JSON.parse(res);

                $("#logs").append(dados.log + "<br>");
                $("#logs").scrollTop($("#logs")[0].scrollHeight);

                $("#barra").css("width", dados.progresso + "%");

                if (!dados.finalizado) {
                    etapa++;
                    executarEtapa();
                } else {
                    $("#logs").append("<br>✅ Instalação finalizada!");
                }
            }
        });

    }

    executarEtapa();

});

</script>

</body>
</html>