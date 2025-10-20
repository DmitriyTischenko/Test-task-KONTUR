# Laravel App - Docker Installation Guide

This guide explains how to set up and run the Laravel application using Docker.

## Prerequisites

Before starting, ensure you have the following installed on your machine:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Setup Instructions

### 1. Configure Environment Variables

1. Navigate to the `.docker` directory:
   ```bash
   cd .docker

2. Copy the example environment file for the docker:
    ```
    cp .env.example .env

3. Edit the .env file.

4. Find the UID= and GID= variables.

5. Replace their values with your user ID and group ID. You can find these by running the id command in your terminal.

6. And the example environment file for the project:
    ```
   cd ../
   cp .env.example .env

### 2. Build and Start Services

Run the following command from the project root (where your main docker-compose.yml file is located (.docker)):
``` 
docker-compose up -d --build
```
## Laravel Application Setup

1.  Access the PHP container's shell:
    ```bash
    docker exec -it robot-php bash
    ```

2.  Inside the container, install PHP dependencies using Composer:
    ```bash
    composer install
    ```

3.  Generate the application key:
    ```bash
    php artisan key:generate
    ```

4.  Run the database migrations to set up the database schema:
    ```bash
    php artisan migrate
    ```

5. Exit the container's shell:
    ```bash
    exit
    ```

## Access the Application

After completing the setup, you can access the Laravel application in your web browser at:

[http://localhost:8000](http://localhost:8000)
[http://localhost:8025](http://localhost:8025)
