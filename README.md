# ATELIÊ

Aplicação php/laravel para gerência de Ateliês de costura.

# ESPECIFICAÇÃO DA ARQUITETURA

```
ARQUITETURA LIMPA

DOMÍNIO - núcleo das regras de negócios
na forma de código executável. nível de
independência quase absoluto.

APLICAÇÃO - casos de uso, orquestração
dos objetos de domínio para execução
de ações. Depende de domínio. Independe
de camadas superiores.

INFRAESTRUTURA - Gerenciar serviços externos
relativos ao domíno técnico. EX: banco de dados,
sistemas de arquivos, comunicação TCP/IP HTTP
e etc ...

PRESENTATION (UI) - Camada externa para o usuário
final. Depende da camada de aplicação e está
em mesmo nível com INFRAESTRUTURA. Interage com
a lógica de negócio nuclear onde detalhes externos
são expostos.

```
## PRINCÍPIOS, PRÁTICAS E PADRÕES

```
DOMAIN DRIVEN DESIGN - Eric Evans
Entidades
Objetos de valor
Agregados
Serviços de Domínio
Repositórios
Eventos de Domínio

OBJECT CALISTHENICS - nine steps to better software design today - Jeff Bay
One level identation per method.
Don't use else keyword.
Wrap all primitives and strings.
Use only one dot per line.
Don't abbreviate.
Keep all entities small.
Don't use any classes with more than two instance variables (constructor parameters).
Use first-class collections.
Don't use any getters/setters/properties.

SOLID
Single responsibility
Open to extend/Closed to modify
Liskov substitution
Interface segregation
Dependency inversion


```
## CARACTERÍSTICAS DA RESSUREIÇÃO DO PROJETO ATELIÊ

Projeto PHP com dependências preferêncialmente
simples adicionadas em função da necessidade
técnica para garantia de funcionamento como
servidor HTTP.

## OBJETIVOS DA APLICAÇÃO

- Controle dos processos de cada serviço.
- Noção do custo de produção e margem de lucro.
- Organização local de informações.


