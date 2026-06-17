#!/bin/bash

RED='\033[0;31m'
RESET='\033[0m'

if [ "$1" == "y" ]; then
    CACHE_FLAG=""
    echo -e "${RED}Using cache${RESET}"
else
    CACHE_FLAG="--no-cache"
    echo -e "${RED}Not using cache${RESET}"
fi

echo -e "${RED}Shutting down docker :${RESET}"
sudo docker compose down -v

echo -e "${RED}Starting build :${RESET}"
sudo docker compose build $CACHE_FLAG

echo -e "${RED}Starting docker :${RESET}"
sudo docker compose up -d

echo -e "\033[33mEverything seems good, feel free to visit at : http://localhost:8000 ${RESET}"
