#!/bin/bash

#
# SCRIPT DETERMINÍSTICO RESPONSÁVEL POR CONVERTER
# CONJUNTO DE CLASSES EM PHP PARA DIAGRAMA
# PLANTUML POR MEIO DE EXPRESSÕES REGULARES.
#

ARQUIVO=./diagrama-classes.txt

# OBTIDO POR find ../Src -iname '*.php' e selecionado por LPLA-br
CLASSES='../Src/Domain/Service/ServicoCostureira.php
../Src/Domain/ValueObject/Prazo.php
../Src/Domain/ValueObject/Preco.php
../Src/Domain/ValueObject/IPreco.php
../Src/Domain/Entity/Peca.php
../Src/Domain/Entity/ITemObterId.php
../Src/Domain/Entity/InsumoQuadrado.php
../Src/Domain/Entity/Cliente.php
../Src/Domain/Entity/AInsumo.php
../Src/Domain/Entity/InsumoUnitario.php
../Src/Domain/Collection/InsumosColecao.php
../Src/Domain/Collection/PecasColecao.php
../Src/Domain/Collection/ACollection.php
../Src/Domain/Enum/EPecaTipo.php
../Src/Domain/Enum/EServicoEstado.php
../Src/Domain/Enum/EPecaEstado.php
../Src/Domain/Enum/EServicoTipo.php';

recriarArquivo()
{
  rm $ARQUIVO;
  echo "" > $ARQUIVO;
}

gerarCabecalho()
{
  echo "@startuml" >> $ARQUIVO;
  echo "!include ./diagrama-class-relacoes.txt" >> $ARQUIVO;
}

gerar()
{
  grep -h -E -e '^ *(enum|case|interface|abstract class|class|public|protected|private)' -e '^\{' -e '^\}' $(echo $CLASSES | tr '\n' ' ') | sed -E 's/public/+/g; s/protected/#/g; s/private/-/g; s/function //g; s/\$//g; s/__construct/construct/g;' >> $ARQUIVO;
}

eliminarExtendsEImplements()
{
  sed --in-place -E 's/ implements.*$//g; s/ extends.*$//g' $ARQUIVO;
}

#considera que switch cases não passarão
tratarEnumeracoes()
{
  sed --in-place -E 's/^ *case / /g; s/ =.*$//g; s/^enum (.*): string/enum \1/g' $ARQUIVO;
}

gerarRodape()
{
  echo "@enduml" >> $ARQUIVO;
}

recriarArquivo;
gerarCabecalho;
gerar;
eliminarExtendsEImplements;
tratarEnumeracoes;
gerarRodape;

echo "GERADO !";
exit 0;
