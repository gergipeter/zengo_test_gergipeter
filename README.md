Zengo Test Feladat

<h2>🖥 Screenshot:</h2>

![screenshot](https://github.com/gergipeter/zengo_test_gergipeter/blob/main/screenshot1.PNG)

<h2>🛠️ Installation Steps:</h2>

    git clone https://github.com/gergipeter/zengo_test_gergipeter.git
    cd zengo_test_gergipeter
    composer update
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed --class=CountiesTableSeeder

    php artisan serve
    npm install
    npm run dev
    

<h2>💻 Built with</h2>

Technologies used in the project:

> **PHP** 8.3.1
> **MySQL** 8.0.35
> **NodeJs** 20.1.0
> **Laravel** 10.40.0
> **Vue** 3.4.7
> **Vite** 5.0.2
