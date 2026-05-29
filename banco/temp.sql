CREATE TABLE mod_financeiro (

    fin_id INT AUTO_INCREMENT PRIMARY KEY,
    fin_data DATE NOT NULL,
    fin_hora_fk int NULL COMMENT 'mod_horario',
    fin_tipo ENUM('entrada','saida') NOT NULL,
    fin_origem ENUM('agenda','manual') NOT NULL DEFAULT 'manual',
    fin_valor DECIMAL(10,2) NOT NULL,
	fin_desconto DECIMAL(10,2) DEFAULT 0,
	fin_valor_final DECIMAL(10,2) NOT NULL,
    fin_descricao VARCHAR(255) NULL,
    fin_status ENUM('a','c','e') DEFAULT 'a' COMMENT 'a=ativo;c=cancelado;e=excluido',
    fin_data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
	fin_categoria INT NULL COMMENT 'mod_categoria_lancamentos', 
    age_id_fk INT NULL COMMENT 'mod_agendamentos',
    ser_id_fk INT NULL COMMENT 'mod_servicos',
	for_id_fk INT NULL COMMENT 'mod_forma_pagamento',
	cli_id_fk INT NULL COMMENT 'mod_clientes',
	vei_id_fk INT NULL COMMENT 'mod_veiculos',
	pis_id_fk INT NULL COMMENT 'mod_pistas'
);





CREATE TABLE IF NOT EXISTS agenda.mod_forma_pagamento (
    for_id INT AUTO_INCREMENT PRIMARY KEY,
    for_nome VARCHAR(100) NOT NULL,
    for_status VARCHAR(1) NOT NULL COMMENT 'a=ativo;i=inativo;e=excluido'
);


INSERT INTO agenda.mod_forma_pagamento (for_nome, for_status) VALUES

('Dinheiro', 'a'),
('Pix', 'a'),
('Cartão Débito', 'a'),
('Cartão Crédito', 'a'),
('Transferência Bancária', 'a'),
('Boleto', 'a');



CREATE TABLE IF NOT EXISTS agenda.mod_categoria_lancamentos (
    cat_id INT AUTO_INCREMENT PRIMARY KEY,
    cat_nome VARCHAR(100) NOT NULL,
    cat_status VARCHAR(1) NOT NULL COMMENT 'a=ativo;i=inativo;e=excluido'
);

INSERT INTO agenda.mod_categoria_lancamentos (cat_nome, cat_status) VALUES

('Produto', 'a'),
('Funcionário', 'a'),
('Manutenção', 'a'),
('Marketing', 'a'),
('Despesas Gerais', 'a'),
('Outros', 'a')