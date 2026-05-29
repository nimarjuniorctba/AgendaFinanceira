

-- ============================
-- HORÁRIOS
-- ============================
CREATE TABLE IF NOT EXISTS agenda.mod_horarios (
    hor_id INT AUTO_INCREMENT PRIMARY KEY,
    hor_hora VARCHAR(5) NOT NULL
);

-- Preenche horários de 5 em 5 min 
INSERT INTO agenda.mod_horarios (hor_hora)
WITH RECURSIVE horarios AS (
    SELECT TIME('00:00:00') AS hora
    UNION ALL
    SELECT ADDTIME(hora, '00:05:00')
    FROM horarios
    WHERE hora < '23:55:00'
)
SELECT DATE_FORMAT(hora, '%H:%i') FROM horarios;

-- ============================
-- PISTAS
-- ============================
CREATE TABLE IF NOT EXISTS agenda.mod_pistas (
    pis_id INT AUTO_INCREMENT PRIMARY KEY,
    pis_nome VARCHAR(50) NOT NULL,
    pis_status VARCHAR(1) NOT NULL COMMENT 'a=ativo;i=inativo;e=excluido',
	pis_dt_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP	
);

INSERT INTO agenda.mod_pistas (pis_nome, pis_status) VALUES
('Pista 1', 'a'),
('Pista 2', 'a');

-- ============================
-- SERVIÇOS
-- ============================
CREATE TABLE IF NOT EXISTS agenda.mod_servicos (
    ser_id INT AUTO_INCREMENT PRIMARY KEY,
    ser_nome VARCHAR(100),
    ser_valor DECIMAL(10,2),
    ser_duracao INT,
	ser_cor VARCHAR(7) DEFAULT '#dc3545',
    ser_status VARCHAR(1) DEFAULT 'a' COMMENT 'a=ativo;c=cancelado;e=excluido',
	ser_dt_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP	
);


-- ============================
-- CLIENTES
-- ============================
CREATE TABLE IF NOT EXISTS agenda.mod_clientes (
    cli_id INT AUTO_INCREMENT PRIMARY KEY,
    cli_nome VARCHAR(100),
    cli_email VARCHAR(100),
    cli_status VARCHAR(1) DEFAULT 'a' COMMENT 'a=ativo;i=inativo;e=excluido',
	cli_dt_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- ============================
-- COMENTÁRIOS
-- ============================
CREATE TABLE IF NOT EXISTS agenda.mod_comentario (
    com_id INT AUTO_INCREMENT PRIMARY KEY,
    com_comentario VARCHAR(255),
    com_status VARCHAR(1) DEFAULT 'a' COMMENT 'a=ativo;i=inativo;e=excluido',
	cli_id_fk INT COMMENT 'mod_clientes',
	vei_id_fk INT COMMENT 'mod_veiculos',
	age_id_fk INT COMMENT 'mod_agendamentos',
	com_dt_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- ============================
-- VEICULOS
-- ============================
CREATE TABLE mod_veiculos (
    vei_id INT AUTO_INCREMENT PRIMARY KEY,
    vei_placa VARCHAR(10) NOT NULL,
    vei_modelo VARCHAR(100),
    vei_marca VARCHAR(100),
    vei_cor VARCHAR(50),
    vei_status VARCHAR(1) DEFAULT 'a' COMMENT 'a=ativo;i=inativo;e=excluido',
	cli_id_fk INT NOT NULL  COMMENT 'mod_clientes',
	vei_dt_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP	
);

-- ============================
-- AGENDAMENTOS
-- ============================
CREATE TABLE IF NOT EXISTS agenda.mod_agendamentos (
    age_id INT AUTO_INCREMENT PRIMARY KEY,
    age_data DATE NOT NULL,
    age_status VARCHAR(1) DEFAULT 'a'  COMMENT 'a=ativo;c=cancelado;e=excluido',
    age_desconto DECIMAL(10,2),
    age_valor_final DECIMAL(10,2),
	age_hora_inicio_fk INT COMMENT 'mod_horarios',
    age_hora_fim_fk INT COMMENT 'mod_horarios',
    pis_id_fk INT COMMENT 'mod_pistas',
    ser_id_fk INT COMMENT 'mod_servicos',
    cli_id_fk INT COMMENT 'mod_clientes',	
    com_id_fk INT COMMENT 'mod_comentarios',
	vei_id_fk INT COMMENT 'mod_veiculos',
    age_dt_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP	

);

-- ============================
-- FORMA DE PAGAMENTO
-- ============================

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
('Outros', 'a');
