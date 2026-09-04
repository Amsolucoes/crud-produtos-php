# CRUD Produtos API

API REST de CRUD de Produtos, construída como projeto de estudo em Laravel, preparando para uma stack real com PHP 8.2 + MySQL 8 + Angular + REST API (JSON/XML).

## Stack

- PHP 8.2
- Laravel 12
- MySQL 8
- Laravel Sanctum (autenticação via token)
- PHPUnit (testes automatizados)
- Composer

## Pré-requisitos

Antes de rodar o projeto, é necessário ter instalado:

- **PHP 8.2** (com as extensões `fileinfo`, `pdo_mysql`, `mysqli` e `pdo_sqlite` habilitadas no `php.ini`)
- **Composer**
- **MySQL 8** rodando localmente

## Instalação

1. Clonar o repositório:
```bash
git clone https://github.com/seu-usuario/crud-produtos-api.git
cd crud-produtos-api
```

2. Instalar as dependências:
```bash
composer install
```

3. Criar o arquivo de ambiente:
```bash
copy .env.example .env
```

4. Editar o `.env` com as credenciais do seu MySQL local:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_produtos
DB_USERNAME=root
DB_PASSWORD=sua_senha_aqui
```

5. Gerar a chave da aplicação:
```bash
php artisan key:generate
```

6. Criar o banco de dados (via MySQL Workbench, DBeaver ou terminal):
```sql
CREATE DATABASE crud_produtos;
```

7. Rodar as migrations:
```bash
php artisan migrate
```

8. Subir o servidor:
```bash
php artisan serve
```

A API estará disponível em `http://127.0.0.1:8000/api`.

## Autenticação

A API usa **Laravel Sanctum** (autenticação via token). Todas as rotas de produtos exigem um token válido.

| Método | Endpoint | Descrição |
|---|---|---|
| POST | `/api/register` | Cria uma conta e retorna um token |
| POST | `/api/login` | Autentica e retorna um token |
| POST | `/api/logout` | Revoga o token atual (requer autenticação) |

Envie o token nas requisições autenticadas via header:


### Exemplo de registro

```json
POST /api/register
{
    "name": "André Teste",
    "email": "andre@teste.com",
    "password": "123456",
    "password_confirmation": "123456"
}
```

## Endpoints de Produtos (requer autenticação)

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/produtos` | Lista produtos (paginado, 10 por página) |
| GET | `/api/produtos?page=2` | Lista a página 2 |
| GET | `/api/produtos?per_page=5` | Define quantidade de itens por página |
| POST | `/api/produtos` | Cria um novo produto |
| GET | `/api/produtos/{id}` | Busca um produto específico |
| PUT/PATCH | `/api/produtos/{id}` | Atualiza um produto |
| DELETE | `/api/produtos/{id}` | Remove um produto |
| GET | `/api/produtos-xml` | Lista todos os produtos em formato **XML** |

### Exemplo de payload (POST/PUT)

```json
{
    "nome": "Teclado Mecânico",
    "descricao": "Teclado mecânico RGB",
    "preco": 250.90,
    "quantidade_estoque": 15
}
```

### Exemplo de resposta XML (`GET /api/produtos-xml`)

```xml
<?xml version="1.0"?>
<produtos>
    <produto>
        <id>1</id>
        <nome>Teclado Mecânico</nome>
        <descricao>Teclado mecânico RGB</descricao>
        <preco>250.90</preco>
        <quantidade_estoque>15</quantidade_estoque>
    </produto>
</produtos>
```

## Campos da tabela `produtos`

| Campo | Tipo | Obrigatório |
|---|---|---|
| nome | string | Sim |
| descricao | text | Não |
| preco | decimal(10,2) | Sim |
| quantidade_estoque | integer | Não (padrão 0) |

## Testes automatizados

O projeto conta com uma suíte de testes de integração (Feature Tests) cobrindo todo o CRUD, autenticação e exportação XML.

Rodar todos os testes:
```bash
php artisan test
```

Rodar apenas os testes de Produto:
```bash
php artisan test --filter=ProdutoTest
```

Os testes usam um banco **SQLite em memória** (configurado em `phpunit.xml`), então não afetam o banco MySQL de desenvolvimento.

### Cobertura de testes

- Listagem paginada de produtos
- Criação de produto (dados válidos e inválidos)
- Busca de produto por ID (existente e inexistente)
- Atualização de produto
- Remoção de produto
- Bloqueio de acesso sem autenticação
- Exportação em XML
