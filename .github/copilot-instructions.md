# Copilot Instructions for enviador-emails

## Visão Geral
Este projeto é um sistema de envio de e-mails em PHP, utilizando o template engine Smarty. A estrutura é composta por arquivos principais na raiz, diretórios de configuração, templates, cache e a biblioteca Smarty (em `libs/smarty`).

## Componentes Principais
- `index.php`: Ponto de entrada do sistema.
- `configs/`: Contém configurações de conexão e parâmetros do sistema.
- `templates/`: Templates HTML e CSS para a interface.
- `templates_c/`: Cache de templates compilados pelo Smarty (deve ser gravável pelo servidor web).
- `libs/smarty/`: Biblioteca Smarty, incluindo exemplos, documentação e código-fonte.

## Fluxo de Dados
1. Usuário acessa o sistema via navegador.
2. `index.php` carrega configurações de `configs/` e inicializa Smarty.
3. Dados são processados e enviados para templates em `templates/`.
4. Smarty compila templates e armazena em `templates_c/`.
5. E-mails são enviados conforme lógica definida.

## Convenções Específicas
- Templates usam sintaxe Smarty (`{variable}`, `{foreach}`, `{include}` etc.).
- Plugins e funções customizadas do Smarty podem ser usados nos templates (ver exemplos em `libs/smarty/docs/designers/language-custom-functions/`).
- Variáveis globais e de sessão devem ser passadas explicitamente para os templates.
- Diretório `templates_c/` precisa de permissão de escrita.

## Workflows de Desenvolvimento
- **Rodar o projeto:**
  1. Clonar o repositório.
  2. Mover para `htdocs` do XAMPP.
  3. Configurar banco de dados conforme instruções no README.
  4. Acessar via navegador (`http://localhost/caminho-para-o-projeto`).
- **Testar instalação do Smarty:**
  - Use `libs/smarty/src/TestInstall.php` ou o método `testInstall()` da classe Smarty para verificar permissões e diretórios.
- **Debug:**
  - Ative o console de debug do Smarty usando a variável `$debugging` ou o plugin `{debug}` nos templates.

## Integrações e Dependências
- **Smarty:** Template engine principal, customizável via plugins e modificadores.
- **Banco de dados:** Configurado em `configs/conexao.php` e `database.sql`.
- **XAMPP:** Ambiente recomendado para desenvolvimento local.

## Padrões e Recomendações
- Mantenha lógica de negócio fora dos templates; use PHP para processamento e Smarty apenas para apresentação.
- Utilize os exemplos de plugins e modificadores em `libs/smarty/docs/` para criar templates eficientes.
- Consulte o README para instruções de configuração e execução.

## Exemplos de Uso
- Para incluir um template: `{include file="header.tpl"}`
- Para atribuir variáveis: `{assign var=foo value=$bar}`
- Para debug: `{debug}`

---

Consulte os arquivos de documentação em `libs/smarty/docs/` para detalhes sobre funções, modificadores e boas práticas do Smarty.
