### CONVERSOR DE DADOS EM SCRIPT SQL

Este projeto foi criado com o objetivo de facilitar o meu trabalho na importação de dados, quando estes vêm em planilhas de EXCEL. O mesmo converte dados de planilhas (formato XLS e XLSX) para SCRIPTS SQL de "INSERT" ou "UPADTE OR INSERT". 

### ALGUMAS INFORMAÇÕES DO PROJETO

- Laravel versão 8;
- Node versão 14.17.5;
- Integração com Laravel-AdminLTE: https://github.com/jeroennoten/Laravel-AdminLTE;
- Banco de dados SQLite ;
- Instalado o pacote Laravel Excel: https://laravel-excel.com;

### A QUEM POSSA INTERESSAR

Para utilizá-lo (após clonar) será necessário ter o Composer e Node instalado no seu computador e seguir os passos abaixo:
- Habilitar no PHP.INI a extensão gd;
- Dentro da pasta do projeto pelo prompt de comando (CMD), instalar os pacotes do PHP e NODE com os comandos: "composer install" e "npm install && npm run dev";
- Renomear o arquivo ".env.example" para ".env";
- Dentro da pasta do projeto pelo prompt de comando (CMD), gerar chave do Laravel com o comando: "php artisan key:generate";
- Dentro da pasta do projeto pelo prompt de comando (CMD), iniciar o servidor com o comando: "php artisan serve". Caso deseje evitar está iniciando o servidor sempre pelo Laravel, realize uma configuração de servidor através do xampp, wampp, lampp, etc;
- Abrir o navegador de sua preferência, digitar o endereco: localhost:8000 ou 127.0.0.1:8000, e logar na aplicação com os dados => email/usuario: admin@email.com | Senha: 123456;
