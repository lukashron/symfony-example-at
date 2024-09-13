# Symfony example project

This is a simple example project to show how to use the Symfony framework.


## Installation

1. Clone the repository
2. Install application
    ```bash
    make app-build
    ```
3. Open the browser and go to `http://127.0.0.1:8080`


## Import the data
    
```bash
    make app-import-data
```

OR

Manual import data. Order is important, first import the users, then the posts and finally the comments.

```bash
    docker compose exec web php bin/console app:import:users
    docker compose exec web php bin/console app:import:posts
    docker compose exec web php bin/console app:import:comments
```


## Run the tests

```bash
    make open-test
```