#!/bin/bash

# Function to stop and remove containers
stop_and_remove_containers() {
    echo "Stopping and removing containers..."
    docker-compose down
}

# Function to start containers and run migrations
start_containers_and_run_migrations() {
    echo "Starting containers and running migrations..."
    docker-compose build
    docker-compose up -d
    docker-compose exec php php bin/doctrine orm:schema-tool:create
}

# Check if the containers are already running
if [ "$(docker ps -q -f name=php)" ] || [ "$(docker ps -q -f name=database)" ] || [ "$(docker ps -q -f name=phpmyadmin)" ]; then
    stop_and_remove_containers
fi

# Start containers and run migrations
start_containers_and_run_migrations
