# SaôneLocal

Plateforme web de mise en relation entre consommateurs et producteurs locaux du Chalonnais.

## Liens Utiles
- [Site en production](https://saone-local.ddns.net/)
- [Maquettes Figma](https://www.figma.com/design/j8HW8bzwOwDSd974oRtFbt/Sa%C3%B4neLocal?node-id=0-1&p=f&t=JDBuZWnP8la3OKwZ-0)

## Technologies
- **Backend:** Laravel (PHP)
- **Frontend:** Laravel Blade, Alpine.js, TailwindCSS
- **Authentification:** JWT (JSON Web Tokens)

## Installation Locale

1. Installer les dépendances :
```bash
composer install
npm install
```

2. Configurer l'environnement :
```bash
cp .env.example .env
php artisan key:generate
```

3. Exécuter les migrations et lier le stockage public :
```bash
php artisan migrate --seed
php artisan storage:link
```

4. Démarrer les serveurs de développement :
```bash
# Dans un terminal
php artisan serve

# Dans un autre terminal
npm run dev
```
