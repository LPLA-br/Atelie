-- ################################################
-- AUTOR: LPLA-br
-- POSTGRES ATELIÊ BOOTSTRAP SEQUÊNCIAL
-- modelo de classes !== modelo de tabelas relacional
-- ################################################

-- Enumerações: extend only !
CREATE TYPE e_servico_tipo AS ENUM (
  'confeccao',
  'conserto',
  'confeccao_e_concerto'
);
CREATE TYPE e_servico_estado AS ENUM (
  'pendente',
  'progredinte',
  'concluido',
  'concluido_parcialmente',
  'abortada'
);
CREATE TYPE e_peca_estado AS ENUM (
  'pendente',
  'progredinte',
  'concluida',
  'abortada'
);
CREATE TYPE e_peca_tipo AS ENUM (
  'vestido',
  'calsao',
  'calsa',
  'camisa',
  'camiseta',
  'mochila',
  'cueca',
  'cinto'
);
CREATE TYPE e_insumo_tipo AS ENUM (
  'quadrado',
  'unitario'
);

-- Endereço e Contato interditados por enquanto
CREATE TABLE IF NOT EXISTS clientes (
  id SERIAL,
  nome VARCHAR(32),
  medida jsonb, --é classe no modelo de domínio.
  CONSTRAINT identitificador_cliente PRIMARY KEY ( id )
);

CREATE TABLE IF NOT EXISTS servicos (
  id SERIAL,
  tipo e_servico_tipo,
  estado e_servico_estado,
  cliente INT,
  CONSTRAINT identificador_servico PRIMARY KEY( id ),
  CONSTRAINT referencia_cliente FOREIGN KEY (cliente) REFERENCES clientes( id )
);


CREATE TABLE IF NOT EXISTS pecas (
  id SERIAL,
  descricao VARCHAR(1024),
  prazo DATE,
  CONSTRAINT identificador_peca PRIMARY KEY ( id )
);

  -- servico 1..N pecas
  CREATE TABLE IF NOT EXISTS servicos_pecas (
    id SERIAL,
    servico INT,
    peca INT,
    CONSTRAINT identificador_servicos_pecas PRIMARY KEY( id ),
    CONSTRAINT referencia_servico FOREIGN KEY (servico) REFERENCES servicos( id ),
    CONSTRAINT referencia_peca FOREIGN KEY (peca) REFERENCES pecas( id )
  );

CREATE TABLE IF NOT EXISTS insumos (
  id SERIAL,
  nome VARCHAR(32),
  preco FLOAT,
  tipo e_insumo_tipo,
  quantidade FLOAT,
  CONSTRAINT identitificador_insumo PRIMARY KEY ( id )
);

  -- peca 1..N insumos
  CREATE TABLE IF NOT EXISTS pecas_insumos (
    id SERIAL,
    peca INT,
    insumo INT,
    CONSTRAINT identificador_insumo PRIMARY KEY ( id ),
    CONSTRAINT referencia_peca FOREIGN KEY (peca) REFERENCES pecas( id ),
    CONSTRAINT referencia_insumo FOREIGN KEY (insumo) REFERENCES insumos( id )
  );

-- contatos e enderecos interditados no momento.

-- ###################### SETOR DE MIGRAÇÕES ############################
-- ALTERAÇÕES EXTENSORAS DE TABELAS (SUPERCONJUNTOS)

-- ALTERAÇÕES TRUNCANTES DE TABELAS (SUBCONJUNTO, DELEÇÃO DE COLUNA) !!CUIDADO!!

