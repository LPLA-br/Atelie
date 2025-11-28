-- ################################################
-- AUTOR: LPLA-br
-- POSTGRES ATELIÊ OBLITERAR BANCO DE DADOS
-- CUIDADO ! ESTE SCRIPT SQL SÓ DEVE SER USADO
-- NO BANCO DE DADOS EM DESENVOLVIMENTO.
-- ################################################

DROP TABLE IF EXISTS servicos_pecas ;
DROP TABLE IF EXISTS pecas_insumos ;

DROP TABLE IF EXISTS servicos ;
DROP TABLE IF EXISTS pecas ;
DROP TABLE IF EXISTS insumos ;
DROP TABLE IF EXISTS clientes ;

DROP TYPE e_servico_tipo;
DROP TYPE e_servico_estado;
DROP TYPE e_peca_estado;
DROP TYPE e_peca_tipo;
DROP TYPE e_insumo_tipo;
