# Projeto KaBuM

### Especificações do Desafio

* Uma área administrativa onde o(s) usuário(s) devem acessar através de login e senha
* Criar um gerenciador de clientes (Listar, Incluir, Editar e Excluir)
* O cadastro do Cliente deve conter: Nome; Data Nascimento; CPF; RG; Telefone.
* O Cliente pode ter 1 ou N endereços.

## Documentação API

#### HEADER
Em todas as rotas é necessário enviar o token(Authorization) no header da requisição exceto na rota **login**.
**Nota**: O token não expira;


| Parâmetros     | tipo       | Descrição                       |
| -------------  |------------|---------------------------------|
| Authorization  | String     | Token da sessão do usuário      |


**Rotas de cliente**
*  Cadastrar POST - http://localhost/api/cadCliente/
*  Editar PUT - http://localhost/api/editCliente/[clienteID]
*  Remover PUT - http://localhost/api/removeCliente/[clienteID]
*  Listar GET - http://localhost/api/listaCliente/[clienteID]

#### Endereço Cliente

| Parâmetros     | tipo       | Descrição                                                    |
| -------------  |------------|---------------------------------------------------------     |
| ativo          | 0/1        | informa se o endereço está  ou não ativo     **(Required)**  |
| endereco       | String     | nome do cliente                              **(Required)**  |
| numero         | String     | Número                                       **(Required)**  |
| bairro         | String     | Bairro do endereço                           **(Required)**  | 
| cep            | String     | Cep do endereço do cliente                   **(Required)**  |
| clienteid      | int        | clienteid                                    **(Required)**  |
| estadoid       | int        | Estadoid                                                     |
| cidadeid       | int        | cidadeid                                                     |

**Rotas de endereço**
* Todos os campos da entidade ClienteEndereco pode ser passados exceto, clienteid;
* Cadastrar POST - http://localhost/api/cadEnderecoCliente/
* Editar  PUT - http://localhost/api/editCliente/[enderecoClienteEnderecoID]);
* Remover  PUT - http://localhost/api/removerClienteEndereco/[enderecoClienteEnderecoID]
* Listar  GET - http://localhost/api/listaClienteEndereco/[enderecoClienteID]


#### Retorno de Erros

| Status                      | Code | Message                                                  |
| ----------------------------|------|----------------------------------------------------------|
| ERRO                        | 500  | Você não está logado no sistema!                         |
| REQUIRED_VALUE              | 401  | Campos obrigatórios                                      |
| CLIENTE_EXISTS              | 401  | O cliente já está cadastrado!                            |
| CLIENTE_NOT_EXISTS          | 401  | O cliente que você está tentando editar não existe.      |
| CLIENTE_ENDERECO_NOT_EXISTS | 401  | O endereço que você está tentando editar não existe.     |
| NOT_FOUND                   | 404  | Retornado quando algo não foi encontrado                 |

### Diretório remoto

Certifique-se de que você já tenha feito um clone do repositório. Caso não tenha feito, escolha um diretório de seu preferência e utilize o seguinte comando em seu terminal.

```bash
git clone https://github.com/danielwerner-dev/desafio-kabum.git
```

### Depêndencias package.json

Acesse o diretório do painel e digite:
```bash
npm install
```

### Restaurando banco de dados.

Primeiro crie um banco de dados chamado 'kabum'.

```bash 
mysql -uroot -p<password>

create database kabum charset=utf8;
exit;
```

Inicie a restauração da base de dados por linha de comando.
```bash
mysql -u<user> -p<senha> kabum < webservice/src/scripts/database.sql
```


### Webservice PHP

Acesse o diretório kabum-project/webservice/config/src/settings/ e edite o arquivo config.php, configurando os parametros abaixo de acordo com a sua configração realizada.

```php
<?php

/*
 * Define se o ambiente é produção ou desenvolvimento.
 */
$environment = "DEV";

/*
 * Não esqueceça desse diretório.
 * Diretório raiz.
 */
$dirName = "webservice";

/*
 * Host da onde está o banco de dados.
 */
$host = "localhost";

/*
 * Nome do banco de dados.
 */
$dbname = "";

/*
 * Usuário do banco de dados.
 */
$user = "";

/*
 * Senha do banco de dados.
 */
$password = "";

```
