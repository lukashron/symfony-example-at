# Symfony example project

This is a simple example project to show how to use the Symfony framework.

## Installation

1. Clone the repository
2. Build the docker container
    ```bash
    docker compose up -d --build
    ```
3. Install the dependencies
    ```bash
    docker compose exec web composer install
    ```
4. Create the database
    ```bash
    docker compose exec web php bin/console doctrine:schema:create
   ```
5. Open the browser and go to `http://127.0.0.1:8080`


## Import the data

Important! Order is important, first import the users, then the posts and finally the comments.

```bash
    docker compose exec web php bin/console app:import:users
    docker compose exec web php bin/console app:import:posts
    docker compose exec web php bin/console app:import:comments
```