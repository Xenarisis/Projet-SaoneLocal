#!/bin/bash

printf "Réinitialisation de la base de données via Docker en cours...\n"
sudo docker compose exec app php artisan migrate:fresh --seed
printf "Base de donnees reinitialisee et seeders executes avec succes.\n"
