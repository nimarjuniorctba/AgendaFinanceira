
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #f5f5f5;
}

/* NAVBAR */
.navbar {
    background: #1e1e2f;
    color: #fff;
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 60px;
    padding: 0 20px;
}

.logo {
    font-size: 20px;
    font-weight: bold;
}

/* MENU */
.menu {
    list-style: none;
    display: flex;
}

.menu li {
    position: relative;
}

/* LINKS */
.menu li a,
.menu li label {
    display: block;
    padding: 20px;
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}

.menu li a:hover,
.menu li label:hover {
    background: #33334d;
}

/* SUBMENU */
.submenu {
    display: none;
    position: absolute;
    top: 60px;
    left: 0;
    background: #2c2c44;
    min-width: 180px;
    flex-direction: column;
}

.submenu li a {
    padding: 12px;
}

/* DESKTOP HOVER */
.menu li:hover > .submenu {
    display: flex;
}

/* BOTÃO MOBILE */
.menu-toggle {
    display: none;
    font-size: 28px;
    cursor: pointer;
}

/* RESPONSIVO */
@media (max-width: 768px) {

    .menu {
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background: #1e1e2f;
        flex-direction: column;
        display: none;
    }

    .menu li {
        width: 100%;
    }

    .menu li a,
    .menu li label {
        padding: 15px;
        border-top: 1px solid #333;
    }

    .submenu {
        position: static;
    }

    /* desativa hover no mobile */
    .menu li:hover > .submenu {
        display: none;
    }

    /* ativa clique via checkbox */
    .menu li input:checked ~ .submenu {
        display: flex;
    }

    .menu-toggle {
        display: block;
    }

    #menu-check:checked ~ .menu {
        display: flex;
    }
}
</style>
</head>

<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">AgendaFinanceira</div>

        <!-- BOTÃO MOBILE -->
        <label for="menu-check" class="menu-toggle">☰</label>
        <input type="checkbox" id="menu-check" hidden>

        <!-- MENU -->
        <ul class="menu">

            <li><a href="inicial.php">Home</a></li>
			<li><a href="agenda.php">Agenda</a></li>
            <li>
                <label for="sub1">Cadastro</label>
                <input type="checkbox" id="sub1" hidden>

                <ul class="submenu">
                    <li><a href="cadastrar_agendamento.php" hidden>Agenda</a></li>
					<li><a href="cad_clientes.php">Cliente</a></li>
                    <li><a href="cad_servico.php">Serviços</a></li>
					<li><a href="cad_pista.php">Pista</a></li>
					<li><a href="cad_veiculo.php">Veiculo</a></li>
                </ul>
            </li>

            <li>
                <label for="sub2">Financeiro</label>
                <input type="checkbox" id="sub2" hidden>

                <ul class="submenu">
                    <li><a href="financeiro_lancamento.php">Lançamento</a></li>
                    <li><a href="financeiro_movimentacoes.php">Movimentação</a></li>
                </ul>
            </li>
            <li hidden><a href="#">Configurações</a></li>

        </ul>
    </div>
</nav>
<br>