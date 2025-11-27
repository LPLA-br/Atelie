--  SCRIPT DE INÍCIO DO POSTGRES
-- modelo de classes !== modelo de tabelas relacional

-- BOOT DAS TABELAS

CREATE TABLE IF NOT EXISTS insumos_de_pecas (

);

CREATE TABLE IF NOT EXISTS pecas_de_servicos (

);

-- Endereço e Contato interditados por enquanto
CREATE TABLE IF NOT EXISTS clientes (
  id SERIAL,
  nome VARCHAR(32),
  medida jsonb, --é classe no modelo de domínio.
  medida REFERENCES medidas( id ),
);


CREATE TABLE IF NOT EXISTS medidas (
  id SERIAL,
);

-- contatos e enderecos interditados no momento.

-- ###################### SETOR DE MIGRAÇÕES ############################
-- ALTERAÇÕES EXTENSORAS DE TABELAS (SUPERCONJUNTOS)

-- ALTERAÇÕES TRUNCANTES DE TABELAS (SUBCONJUNTO, DELEÇÃO DE COLUNA) !!CUIDADO!!

