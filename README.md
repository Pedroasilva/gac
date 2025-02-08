# Desafio para full stack Grupo Adriano Cobuccio

O objetivo consiste na criação de uma interface funcional equivalente a uma carteira financeira em
que os usuários possam realizar transferência de saldo e depósito.

## Tecnologias Utilizadas

- [Laravel v11.41.3](https://laravel.com/docs/11.x)
- [PHP 8.4.3](https://www.php.net/releases/8.4/pt_BR.php)
- [VueJs 3](https://v3.vuejs.org/)
- [Inertia.js](https://inertiajs.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [MySQL](https://www.mysql.com/)

## Requisitos

- Docker
- Docker Compose

## Instalação

1. Clone o repositório:

    ```bash
    git clone https://github.com/Pedroasilva/gac.git
    cd gac
    ```

2. Copie o arquivo `.env.example` para `.env` e configure suas variáveis de ambiente:

    ```bash
    cp .env.example .env
    ```

3. Inicialize os containers do Sail:

    ```bash
    ./vendor/bin/sail up -d
    ```

4. Instale as dependências do Composer:

    ```bash
    ./vendor/bin/sail composer install
    ```

5. Gere a chave da aplicação:

    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6. Execute as migrações do banco de dados:

    ```bash
    ./vendor/bin/sail artisan migrate
    ```

7. Instale as dependências do NPM:

    ```bash
    ./vendor/bin/sail npm install
    ```

## Uso

Para iniciar o servidor de desenvolvimento, utilize o comando:

```bash
./vendor/bin/sail npm run dev
```

A aplicação estará disponível em [http://localhost:8000](http://localhost:8000).

## Contribuição

Sinta-se à vontade para contribuir com este projeto. Faça um fork do repositório, crie uma branch para suas alterações e envie um pull request.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
