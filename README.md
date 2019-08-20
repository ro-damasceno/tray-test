# Teste Tray
Teste referente a vaga para programador PHP.

## Instalação
Após instalar o projeto em sua máquina, é preciso instalar os pacotes necessários para seu funcionamento.
Para isto, vá até a pasta raiz do projeto e execute os comandos:

- Back-end:
```
composer install
```

- Front-end: 
```
npm install
```

- Gerar os scripts js e css
```
npm run prod
```

- Gera a chave de criptografia para o funcionamento do laravel.
```
php artisan key:generate
```

### Configuração

Uma vez que os pacotes estejam instalados, deve-se configurar o ambiente. 
Copie o arquivo na raiz do projeto `.env.example` para `.env` e altere seus registros:

- Banco de dados:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_db
DB_USERNAME=root
DB_PASSWORD=
```

- E-mail (utilize estas configurações para teste):
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=asmtpemail@gmail.com
MAIL_PASSWORD=we23we23
MAIL_ENCRYPTION=tls
```

### Migrates

Crie a base de dados local e então execute o comando que irá criar as tabelas.
```
php artisan migrate
```

### Executando o projeto
Por fim, basta executar o comando para inicialização do servidor:
```
php artisan serve
```

## Comandos 

Afim de facilitar os testes, alguns comandos foram criados, são eles:

Cria vendedores. Use o número definido no parâmetro `{quantity}` para definir o quantidade que será criada.
```
    php artisan seed:sellers {quantity}
```

Cria pedidos. Use o número definido no parâmetro `{quantity}` para definir o quantidade que será criada.
Obs: 
- É necessário possuir no mínimo um vendedor para gerar pedidos.
- Os pedidos são atrelados aleatoriamente aos vendedores.
```
    php artisan seed:orders {quantity}
```

Envia o relatório de faturamento das vendas aos vendedores:
```
    php artisan report:daily-billing
```


