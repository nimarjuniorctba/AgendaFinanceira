<html>
<head>
	<title>{$pagina->empresa_nome}</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.js"   integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="   crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">	

	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="{$pagina->base}css/style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	<script type="text/javascript" src="{$pagina->base}js/jquery.mask.js"></script>
	<script type="text/javascript" src="{$pagina->base}js/geral.js"></script>

<head>
<body>
	<input type="hidden" id="host" value="{$pagina->base}">

	<div class="topo" style="display:inline-block;width:100%;height: 120px;">
			<div style="float:left;display:none;">            
			</div>	
			<div style="text-align: center;margin-top: 6px;">
				<div class="containerClock">
					<div class="clock"></div>
				</div>
			</div>	
			<div style="float: right;margin-right:30px;display:flex;cursor:pointer;">            
				<div style="background:#2d4a69;color:white;width:auto;padding: 8px;border-radius: 5px 0px 0px 5px;margin-right:0px;">{$pagina->mensagem_identificacao}</div>
				<div style="background:#2d4a69;color:white;width:auto;padding: 8px;border-radius: 0px 5px 5px 0px;"></div>            
			</div>
			<div style="clear:both;"></div>
			{if $aviso_validade_sistema=="s"}	
				<div style="width:100%;display: flex;justify-content: center;">
					<div style="background-color: #f3bab6;border-radius: 3px;width: 500px;text-align: center;line-height: 33px;color: rgb(177, 34, 27);;border: 1px dashed;"><span style="font-weight: 600;">Sua licença do sistema irá vencer em {$dias_faltando_validade_sistema} dias</span> - <a href="{$pagina->base}/planos">Renovar Agora?</a></label></div>
				</div>
			{elseif $aviso_validade_sistema=="v"}	
				<div style="width:100%;display: flex;justify-content: center;">
					<div style="background-color: #f3bab6;border-radius: 3px;width: 500px;text-align: center;line-height: 33px;color: rgb(177, 34, 27);;border: 1px dashed;"><span style="font-weight: 600;">Sua licença do sistema já venceu faz {$dias_faltando_validade_sistema} dias</span> - <a href="{$pagina->base}/planos">Renovar Agora?</a></label></div>
				</div>				
			{/if}
			
	</div>
	<div style="clear:both;"></div>


	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="height: 67px;">
		<div style="height:100px;"></div>
		<div style="display:flex;">            
		<img src="{$pagina->base}imagens/config/logo.png" class="img-topofix">    
		<div class="menu">        
			<ul style="margin-left: 260px;">
				<li style="display:none;">
					<a href="{$pagina->base}clientes/"><img src="{$pagina->base}imagens/icones/computador_branco.png" style="width:25px;height: 25px;margin-right: 7px;">Home</a>
				</li>
				<li style="width:114px;">
					<img src="{$pagina->base}imagens/icones/cadastro_branco.png" style="width:25px;height: 25px;margin-right: 7px;">Cadastros
					<ul>
						<a href="{$pagina->base}clientes/"><li>Clientes</li></a>
					</ul>
				</li>
				<li style="">
					<img src="{$pagina->base}imagens/icones/config_branco.png" style="width:25px;height: 25px;margin-right: 7px;">
					Vendas            
				 <ul>
					<li>Cadastros
						<ul>
							<a href="{$pagina->base}produtos-animais/" style="display:none;"><li>Animais</li></a>
							<a href="{$pagina->base}produtos-categorias/"><li>Categorias</li></a>
							<a href="{$pagina->base}produtos-fornecedores/"><li>Fornecedores</li></a>
							<a href="{$pagina->base}produtos/"><li>Produtos</li></a>
							<a href="{$pagina->base}estoque/"><li>Estoque</li></a>   
						</ul>
					</li>
					<a href="{$pagina->base}pdv/"><li>PDV</li></a>                            
				 </ul>
				</li>				
				<li style="width:123px;">
					<img src="{$pagina->base}imagens/icones/financeiro_branco.png" style="width:25px;height: 25px;margin-right: 7px;">Financeiro
					<ul>
					   <a href="{$pagina->base}minhas-compras/"><li>Minhas compras</li></a>
					   <a href="{$pagina->base}planos/"><li style="color: #fd9a30;font-weight: 600;">Renovar Planos</li></a>   
					</ul>                
				</li>
				<li>
					<img src="{$pagina->base}imagens/icones/config_branco.png" style="width:25px;height: 25px;margin-right: 7px;">Opções
					<ul>
					   <a href="{$pagina->base}meus-dados/"><li>Meus Dados</li></a>
					   <a href="{$pagina->base}usuarios/"><li>Usuários</li></a>   
					</ul>                
				</li>
				<li>
					<a href="{$pagina->base}sair"><img src="{$pagina->base}imagens/icones/sair_branco.png" style="width:25px;height: 25px;margin-right: 7px;">
					Sair</a>
				</li>
			</ul>
		</div>
		</div>
	</nav>

	<input type="hidden" id="pagina_base" value="{$pagina->base}"> 
	<input type="hidden" id="base_upload" value="{$pagina->upload}"> 