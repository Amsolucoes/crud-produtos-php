# CRUD Produtos API

API REST simples de CRUD de Produtos, construída como projeto de estudo em Laravel, preparando para um projeto real com stack PHP 8.2 + MySQL 8 + Angular + REST API (JSON).

## Stack

- PHP 8.2
- Laravel 12
- MySQL 8
- Composer

## Pré-requisitos

Antes de rodar o projeto, é necessário ter instalado:

- **PHP 8.2** (com as extensões `fileinfo`, `pdo_mysql` e `mysqli` habilitadas no `php.ini`)
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

A API estará disponível em `http://127.0.0.1:8000/api/produtos`.

## Endpoints

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/produtos` | Lista todos os produtos |
| POST | `/api/produtos` | Cria um novo produto |
| GET | `/api/produtos/{id}` | Busca um produto específico |
| PUT/PATCH | `/api/produtos/{id}` | Atualiza um produto |
| DELETE | `/api/produtos/{id}` | Remove um produto |

## Exemplo de payload (POST/PUT)

```json
{
    "nome": "Teclado Mecânico",
    "descricao": "Teclado mecânico RGB",
    "preco": 250.90,
    "quantidade_estoque": 15
}
```

## Campos da tabela `produtos`

| Campo | Tipo | Obrigatório |
|---|---|---|
| nome | string | Sim |
| descricao | text | Não |
| preco | decimal(10,2) | Sim |
| quantidade_estoque | integer | Não (padrão 0) |
