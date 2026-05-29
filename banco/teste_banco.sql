-- ============================
-- CLIENTES (10)
-- ============================
INSERT INTO mod_clientes (cli_nome, cli_email) VALUES
('João Silva', 'joao@gmail.com'),
('Maria Oliveira', 'maria@gmail.com'),
('Carlos Souza', 'carlos@gmail.com'),
('Ana Pereira', 'ana@gmail.com'),
('Lucas Santos', 'lucas@gmail.com'),
('Fernanda Costa', 'fernanda@gmail.com'),
('Bruno Almeida', 'bruno@gmail.com'),
('Juliana Rocha', 'juliana@gmail.com'),
('Rafael Martins', 'rafael@gmail.com'),
('Camila Ferreira', 'camila@gmail.com');


-- ============================
-- VEÍCULOS (3 por cliente)
-- ============================
INSERT INTO mod_veiculos (vei_placa, vei_modelo, vei_marca, vei_cor, cli_id_fk) VALUES

-- Cliente 1
('AAA1A11', 'Onix', 'Chevrolet', 'Preto', 1),
('AAA1A12', 'HB20', 'Hyundai', 'Branco', 1),
('AAA1A13', 'Gol', 'VW', 'Prata', 1),

-- Cliente 2
('BBB2B21', 'Civic', 'Honda', 'Preto', 2),
('BBB2B22', 'Corolla', 'Toyota', 'Branco', 2),
('BBB2B23', 'Fit', 'Honda', 'Cinza', 2),

-- Cliente 3
('CCC3C31', 'Ka', 'Ford', 'Vermelho', 3),
('CCC3C32', 'Fiesta', 'Ford', 'Preto', 3),
('CCC3C33', 'Focus', 'Ford', 'Branco', 3),

-- Cliente 4
('DDD4D41', 'Sandero', 'Renault', 'Prata', 4),
('DDD4D42', 'Logan', 'Renault', 'Preto', 4),
('DDD4D43', 'Duster', 'Renault', 'Branco', 4),

-- Cliente 5
('EEE5E51', 'Compass', 'Jeep', 'Preto', 5),
('EEE5E52', 'Renegade', 'Jeep', 'Branco', 5),
('EEE5E53', 'Toro', 'Fiat', 'Prata', 5),

-- Cliente 6
('FFF6F61', 'Cruze', 'Chevrolet', 'Cinza', 6),
('FFF6F62', 'Tracker', 'Chevrolet', 'Preto', 6),
('FFF6F63', 'S10', 'Chevrolet', 'Branco', 6),

-- Cliente 7
('GGG7G71', 'Uno', 'Fiat', 'Vermelho', 7),
('GGG7G72', 'Argo', 'Fiat', 'Branco', 7),
('GGG7G73', 'Mobi', 'Fiat', 'Preto', 7),

-- Cliente 8
('HHH8H81', 'Kwid', 'Renault', 'Branco', 8),
('HHH8H82', 'Captur', 'Renault', 'Preto', 8),
('HHH8H83', 'Oroch', 'Renault', 'Cinza', 8),

-- Cliente 9
('III9I91', 'HRV', 'Honda', 'Preto', 9),
('III9I92', 'City', 'Honda', 'Branco', 9),
('III9I93', 'Civic', 'Honda', 'Prata', 9),

-- Cliente 10
('JJJ0J01', 'T-Cross', 'VW', 'Branco', 10),
('JJJ0J02', 'Nivus', 'VW', 'Cinza', 10),
('JJJ0J03', 'Polo', 'VW', 'Preto', 10);


-- ============================
-- SERVIÇOS (6)
-- ============================
INSERT INTO mod_servicos (ser_nome, ser_valor, ser_duracao, ser_cor) VALUES
('Lavagem Simples', 30.00, 30, '#28a745'),
('Lavagem Completa', 50.00, 60, '#007bff'),
('Lavagem + Cera', 70.00, 90, '#ffc107'),
('Higienização Interna', 100.00, 120, '#6f42c1'),
('Polimento Técnico', 150.00, 180, '#dc3545'),
('Lavagem Premium', 200.00, 240, '#17a2b8');


-- ============================
-- PISTAS (caso ainda não tenha)
-- ============================
INSERT INTO mod_pistas (pis_nome, pis_status) VALUES
('Pista 1', 'a'),
('Pista 2', 'a');


-- ============================
-- AGENDAMENTOS EXEMPLO
-- ============================
INSERT INTO mod_agendamentos 
(age_data, age_hora_inicio_fk, age_hora_fim_fk, pis_id_fk, ser_id_fk, cli_id_fk, vei_id_fk, age_valor_final) VALUES

(CURDATE(), 50, 56, 1, 1, 1, 1, 30.00),
(CURDATE(), 60, 72, 2, 3, 2, 5, 70.00),
(CURDATE(), 20, 32, 1, 2, 3, 7, 50.00),
(CURDATE(), 30, 54, 2, 4, 4, 10, 100.00),
(CURDATE(), 200, 236, 1, 5, 5, 13, 150.00);