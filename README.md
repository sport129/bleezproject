bleezproject
#  Índice

* Iniciando o Projeto

# Iniciando o Projeto

Configurar Inicialmente as configurações do Banco de Dados na pasta api\App\Database\config.php

```
define('DB_HOST', 'localhost');
define('DB_NAME', 'ecommerce');
define('DB_USER', 'root');
define('DB_PASS', '');
```

Injetar o SQL ecommerce.sql no banco de dados de sua preferencia

Na pasta Fron Executar o comando (Lembrar da Maquina Ter o node, NPM ou YARN instalados)

```
npm install
```
ou
```
yarn install
```

Execute o Front com o comando 

```
npm run dev
```
ou
```
yarn run dev
```

E para startar a api navegue até a pasta api e digite o comando 

```
php -S localhost:8080
```