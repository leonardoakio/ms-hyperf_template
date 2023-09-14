<div align='right'>
    <a href="./README.md">Inglês |</a>
    <a href="./PORTUGUESE.md">Português</a>
</div>

<div align='center'>
    <h1>Template</h1>
    <a href="https://www.linkedin.com/in/leonardo-akio/" target="_blank"><img src="https://img.shields.io/badge/LinkedIn%20-blue?style=flat&logo=linkedin&labelColor=blue" target="_blank"></a> 
    <img src="https://img.shields.io/badge/version-v0.1-blue"/>
    <img src="https://img.shields.io/github/contributors/akioleo/MoneyTransaction_v2"/>
    <img src="https://img.shields.io/github/stars/akioleo/MoneyTransaction_v2?style=sociale"/>
    <img src="https://img.shields.io/github/forks/akioleo/MoneyTransaction_v2?style=social"/>
</div>

## Ambiente
- PHP 8.2.7
- HyperF 3.0.0
- Composer 2.5.8
- Swoole 5.0.3
- Nginx 1.24.0
- MySQL 8.1.0
- MongoDB 7.0
- Redis 7.2.1

## Estrutura de pastas
- Arquivo de start: `bin/hyperf.php`
- Centro de configurações: `config/*`
- Rotas: `config/routes.php`
- Server: `config/autoload/server.php``
- Injeção de dependências: `config/autoload/dependencies.php`
- Design do projeto: `config/autoload/devtool.php`
- Aplicação: `app/*`

### Como verificar as versões dos containeres

- Validar as versões **(PHP, HyperF, Composer, Swoole)**
```
php -v   |  composer --version  | php --ri swoole | 
```

- Buscar pelas ENVs da aplicação
```
env
```
#### Raiz do projeto
- Validar versão do **REDIS** 
```
docker exec -it cliente-total_redis redis-cli
```
```
INFO SERVER
```
- Validar versão do **MySQL** (raiz do projeto)
```
docker exec -it cliente-total_mysql mysql -u root -p 
```
```
SELECT VERSION();
```

## Iniciando o projeto
Criar o arquivo `.env` no projeto
```bash
php -r "copy('.env.example', '.env');"
```    
Faça o build dos containeres no `docker-compose` no diretório raiz:
```bash
docker-compose up -d --build
```


### Serviços e Portas

| Container              | Host Port | Container Port (Internal) |
| ---------------------- | --------- | ------------------------- |
| cliente-total_app        | `9501`    | `9501`                  |
| cliente-total_mysql      | `3306`    | `3306`                  |
| cliente-total_redis      | `6379`    | `6379`                  |

## Health
Endpoint que validam a saúde da aplicação e dos serviços:

- `http://localhost:9501/health`
- `http://localhost:9501/liveness`

## Documentação 
Endpoint da aplicação: `http://localhost:9501/documentation`

A documentação da API deve ser realizada no formato YAML e são armazenados no diretório `storage/view/api-docs` pelo nome `api-docs-v1.yml` e `api-docs-v2.yml`

**Referências:**
- [Especificação OpenAPI - Swagger](https://swagger.io/specification/)
