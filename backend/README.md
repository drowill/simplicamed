Backend
-------

Comandos úteis:

```bash
# Instalar dependências
composer install

# Preparar configurações
php artisan config:clear
php artisan config:cache
php artisan view:clear

# Criar banco inicial
php artisan migrate
php artisan db:seed

# Resetar estado do banco
php artisan migrate:fresh
php artisan db:seed

# Executar o sistema
php artisan serve

# Visualizar rotas
php artisan route:list
```
