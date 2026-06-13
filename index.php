<?php
	
require_once 'smarty/config.ini.php';
require_once 'classes/Autoload.class.php';

$opcao      =   isset($_GET['opcao'])?$_GET['opcao']:'home';
$acao       =   isset($_GET['acao'])?$_GET['acao']:'listar';
$valor      =   isset($_GET['valor'])?$_GET['valor']:'';

$pdo        =   MySQL_PDO::conexao();
$opc        =   new Opcoes();
$smarty     =   new Smarty();

//echo "passo 1 - inicio<br>";
//echo "<br>d:".$opc->decodificaDados("V1cweGMyUkdiRmxUVkRBOQ==");
/*
	echo "Opcao:".$opcao;
	echo "<br>Acao:".$acao;
	echo "<br>ID:".$id;
*/

$pagina =   new stdClass();

$pagina->empresa_nome   = "Sistema AgendaFinanceira";
$pagina->opcao          = $opcao;
$pagina->acao           = $acao;
//Verifica origem
$https =
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
    || ($_SERVER['SERVER_PORT'] ?? 80) == 443
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') == 'https');

$pagina->base =
    ($https ? 'https' : 'http')
    .'://'
    .$_SERVER['HTTP_HOST']
    .'/AgendaFinanceira/';

$pagina->upload         = "imagens/uploads/";

    switch($opcao){

            case 'home':			
                            require_once('dashboard.php');
                            break;
            case 'agenda':			
                            require_once('agenda.php');
                            break;
            case 'financeiro-lancamento':	               
                            require_once('financeiro_lancamento.php');
                            break;
            case 'financeiro-movimentacoes':
                            require_once('financeiro_movimentacoes.php');
                            break;                              
            case 'cadastrar-agendamento':			
                            require_once('cadastrar_agendamento.php');
                            break;        
            case 'cadastrar-clientes':			
                            require_once('cad_clientes.php');
                            break;   
            case 'cadastrar-servico':			
                            require_once('cad_servico.php');
                            break; 
            case 'cadastrar-pista':			
                            require_once('cad_pista.php');
                            break;                             
            case 'cadastrar-veiculo':			
                            require_once('cad_veiculo.php');
                            break;                
            case 'configuracoes':			
                            require_once('configuracao_agenda.php');
                            break;                                                  
            default:
                            require_once('dashboard.php');
                            break;

        }	
