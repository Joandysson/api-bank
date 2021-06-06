# Informações gerais sobre o projeto

O projeto roda dentro de um container do Docker.
Os testes foram realizados de forma automatica e com o Postman.

#### Tecnologias utilizadas no projeto

- [X] PHP 8
- [X] Mysql
- [X] Redis
- [X] Testes
- [X] Docker

## Pré-requisitos
- Ter o docker-composer instalado (Obrigatório)
- Ter uma ferramenta que faça requisições a API Postman | Insomnia ou alguma outra para efetuar os teste das rotas


### Informações adicionais

Dentro do diretorio raiz tem um arquivo JSON com os testes realizdos um com o postman, caso tenha um postman é somente importar e utilizar, também é possivel desfrutar da documentação que o próprio postman fornece.

- JSON postman
> API Bank - PHP.postman_collection

## Métodos
Requisições para a API seguem os padrões:
| Método | Descrição |
|---|---|
| `GET` | Retorna informações de um ou mais registros. |
| `POST` | Utilizado para criar um novo registro. |
| `PUT` | Atualiza dados de um registro ou altera sua situação. |
| `DELETE` | Remove um registro do sistema. |

# Iniciando projeto
Abaixo segue as informações de execução do projeto

## Iniciar projeto

Para iniciar execute o comando a baixo no diretório do projeto onde está o `docker-compose.yml` e aguarde que seja concluída a execução.

Exemplo:

> D:\MyProjects\api-bank

```bash
docker-composer up -d
```

Após a execução do comando acima e com os containers já ativo é somente acessar o terminal do docker

###### Acessando o bash

```bash
docker exec -it php bash
```

Já dentro do diretório do projeto é então a hora de rodar as migrations para começar a utilizar a aplicação, use o comando

```bash
php artisan migrate
```

O projeto se encontra disponível na porta **80**

**Rotas para Usuario**
|Métodos| Parâmetros | Descrição |
|---|---|---|
|`GET`| `users` | Retorna um JSON com todos os usuário. |
|`GET`| `user/{id}` | Retorna o usurário baseado no `ID` informado. |
|`POST`| `user` | Efetua o cadastro de um usuário. |
|`PUT`| `user/{id}` | Atualiza o usurário baseado no `ID` informado. |
|`DELETE`| `user/{id}` | Deleta o usurário baseado no `ID` informado. |


### Todos os usuários [GET][/users]

+ Response 200 (application/json)
  Todos os dados dos usuários

    + Body

          [
            {
                "name": "test one5 ops",
                "email": "test@one9.com.br",
                "cpf_cnpj": "01359785633",
                "created_at": 2021-01-01,
                "updated_at": 2021-01-01
            }
          [


+ Response 200 (application/json)
  Quando registro não for encontrado.

    + Body

          []


### Detalhes do usuário especifico [GET][/user/{id}]

+ Parameters
    + id: ID do usuário no banco de dados (Número, obrigatório)

+ Request (application/json)

+ Response 200 (application/json)
  Todos os dados do usuario

    + Body

          {
              "name": "test one5 ops",
              "email": "test@one9.com.br",
              "cpf_cnpj": "01359785633",
              "created_at": 2021-01-01,
              "updated_at": 2021-01-01
          }


+ Response 404 (application/json)
  + Quando registro não for encontrado.


### Criar [POST][/user]

+ Atributos (Objeto)

    + nome: nome do usuário (string, obrigatório) - mínimo de 20 máximo 100 caracteres
    + email: e-mail do usuário (string, único, obrigatório)
    + cpf_cnpj: cpf_cnpj do usuário (string, único, obrigatório) - 11|14 dígitos
    + password: password do usuário (string, obrigatório) - 11|14 dígitos

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "name": "test one5 ops",
              "email": "test@one9.com.br",
              "cpf_cnpj": "01359785633",
              "password": "sdfasfjçjkad",
          }

+ Response 201 (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "name": "test one5 ops",
              "email": "test@one9.com.br",
              "cpf_cnpj": "01359785633",
              "created_at": 2021-01-01,
              "updated_at": 2021-01-01
          }

### Atualizar [PUT][/user/{id}]

+ Atributos (Objeto)

    + id: ID do usuário no banco de dados (Número, Obrigatório)
    + nome: nome do usuário (string, opcional) - mínimo de 10 máximo 100 caracteres
    + email: e-mail do usuário (string, único, opcional)
    + cpf_cnpj: cpf_cnpj do usuário (string, único, opcional) - 11|14 dígitos
    + password_current: password atual (string, opcional)
    + password_new: password novo (string, opcional caso password_current não tenha sido informado)

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "name": "test one5 ops",
              "email": "test@one9.com.br",
              "cpf_cnpj": "01359785633",
              "password_current": "aldlajdlkajsls"
              "password_new":a "adakm17!!jabbw"
          }

+ Response 200 (application/json)
  + Quando o registro for encontrado.
+ Response 404 (application/json)
  + Quando nenhum registro não for encontrado.

### Deletar [GET][/user/{id}]

> Ao deletar um usuário também é deletada a conta vinculada ao mesmo

+ Parameters
  + id: ID do usuário no banco de dados (Número, obrigatório)

+ Response 200 (application/json)
  + Quando o usuario for deletado

+ Response 404 (application/json)
  + Quando registro não for encontrado.


**Rotas para Conta**
|Métodos| Parâmetros | Descrição |
|---|---|---|
|`GET`| `accounts` | Retorna um JSON com todas as contas. |
|`GET`| `account/{id}` | Retorna a conta baseado no `ID` informado. |
|`GET`| `accountbyuser/{id}` | Retorna a conta baseado no `ID` do usuario informado. |
|`POST`| `account` | Efetua o cadastro de uma conta. |
|`POST`| `transfer` | Efetua uma transferencia para outra conta. |
|`POST`| `deposit` | Efetua o deposito de um determinado valor. |
|`POST`| `withdraw` | Efetua o saque de um determinado valor. |
|`DELETE`| `account/{id}` | Deleta o usurário baseado no `ID` informado. |

### Todas as contas [GET][/accounts]

+ Response 200 (application/json)
  Todos os dados dos usuários

    + Body

          [
              {
                  "id": 1,
                  "user_id": 1,
                  "balance": 0,
                  "created_at": "2021-06-06T15:53:36.000000Z",
                  "updated_at": "2021-06-06T15:53:36.000000Z",
                  "deleted_at": null
              }
          ]


+ Response 200 (application/json)
  Quando nenhum registro não for encontrado.

    + Body

          []


### Detalhes do usuário especifico [GET][/user/{id}]

+ Parameters
    + id: ID da conta no banco de dados (Número, obrigatório)

+ Response 200 (application/json)
  Todos os dados do usuario

    + Body

          {
              "id": 1,
              "user_id": 1,
              "balance": 0,
              "created_at": "2021-06-06T15:53:36.000000Z",
              "updated_at": "2021-06-06T15:53:36.000000Z",
              "deleted_at": null
          }


+ Response 404 (application/json)
  + Quando registro não for encontrado.


### Criar [POST][/account]

+ Atributos (Objeto)

    + user_id: id do usuário existente (número, obrigatório)
+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "user_id": 1,
          }

+ Response 201 (application/json)

    + Headers

            Content-Type: application/json

    + Body

          {
              "user_id": 1,
              "updated_at": "2021-06-06T15:53:36.000000Z",
              "created_at": "2021-06-06T15:53:36.000000Z",
              "id": 1
          }

+ Response 404 (application/json)
  + Quando o usuario não for encntrado

### Depositar [POST][/account]

+ Atributos (Objeto)

    + account_id: id da conta existente (número, obrigatório)
    + value: Valor a depositar (número, obrigatório)

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "account_id": 1,
              "value": 200
          }

+ Response 200 (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "id": 1,
              "user_id": 1,
              "balance": 100,
              "created_at": "2021-06-06T15:53:36.000000Z",
              "updated_at": "2021-06-06T16:09:43.000000Z",
              "deleted_at": null
          }

+ Response 404 (application/json)
  + Quando a conta não for encontrada

### Sacar [POST][/account]

+ Atributos (Objeto)

    + account_id: id da conta existente (número, obrigatório)
    + value: Valor a sacar (número, obrigatório)

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "account_id": 1,
              "value": 60.05
          }

+ Response 200 (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "id": 1,
              "user_id": 1,
              "balance": 39.95,
              "created_at": "2021-06-06T15:53:36.000000Z",
              "updated_at": "2021-06-06T16:09:43.000000Z",
              "deleted_at": null
          }

+ Response 404 (application/json)
  + Quando a conta não for encontrada

### Transferir [POST][/account]

+ Atributos (Objeto)

    + account: id da conta existente (número, obrigatório)
    + account_to: id da conta destino (número, obrigatório)
    + value: Valor a transferir (número, obrigatório)

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "account": 1,
              "account_to": 2
              "value": 60.05
          }

+ Response 200 (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "id": 1,
              "user_id": 1,
              "balance": 37.95,
              "created_at": "2021-06-06T15:53:36.000000Z",
              "updated_at": "2021-06-06T16:18:40.000000Z",
              "deleted_at": null
          }

+ Response 404 (application/json)
    Quando a conta não for encontrada

### Delete [POST][/account/{id}]

+ Atributos (Objeto)
  + account_id: id da conta existente (número, obrigatório)

+ Response 200 (application/json)
  + Quando a conta for deletada

+ Response 404 (application/json)
  + Quando a conta não for encontrada


**Rotas para Trasações**
|Métodos| Parâmetros | Descrição |
|---|---|---|
|`GET`| `users` | Retorna um JSON com todos os usuário. |

### Todas as transações [GET][/accounts]

+ Response 200 (application/json)
  Todos os dados dos usuários

    + Body

          [
              {
                  "id": 1,
                  "account_id": 1,
                  "value": 100,
                  "account_to": null,
                  "created_at": "2021-06-06T16:09:43.000000Z",
                  "updated_at": "2021-06-06T16:09:43.000000Z",
                  "deleted_at": null
              }
          ]


+ Response 200 (application/json)
  Quando registro não for encontrado.

    + Body

          []

## Testes

Acessar o bash com o projeot já rodando e executar os seguintes comandos

```bash
## acessar bash container
docker exec -it php bash
```

```bash
## Rodar testes
php vendor/phpunit/phpunit/phpunit
```


> by Joandysson Gama