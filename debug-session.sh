#!/bin/bash

#
# SCRIPT - inicia ambiente de debug
# manual para cada classe apontadas
# nos arquivos ./debug/*-quick.php
#

ARQUIVO=$1;

if [[ -e $ARQUIVO ]]; then
  php -d auto_prepend_file=$ARQUIVO -a;
else
  echo "Arquivo $ARQUIVO não existe. ABORTADO";
  exit 2;
fi


