#!/bin/bash
/usr/bin/nvim $(find ./Src/Domain -iname '*.php' | tr '\n' ' ');
