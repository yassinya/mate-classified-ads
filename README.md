## Installation

- Copy .env.example file to .env and edit database credentials there
- Run composer install
- Run php artisan key:generate
- Run npm install (you must have nodejs installed on your computer)
- Run php artisan migrate --seed (it will setup tables & pre-populate with some data)