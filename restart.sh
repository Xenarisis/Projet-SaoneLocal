#!/bin/bash

if [ "$1" == "y" ]; then
    CACHE_FLAG=""
else
    CACHE_FLAG="--no-cache"
fi

echo "Shutting down docker :"
sudo docker compose down -v

echo "Starting build :"
sudo docker compose build $CACHE_FLAG

echo "Starting docker :"
sudo docker compose up -d

echo "Everything seems good, feel free to visit at : http://localhost:8000"
