1. Сделать ```git clone``` репозитория
2. Скопировать файл ```.env.template``` в ```.env```
3. Настроить ```.env``` 
4. Скопировать файл в ```/app/www/.env.example``` в ```/app/www/.env```
5. Поднять контейнеры ```docker-compose up -d```
6. Зайти в контейнер приложения ```docker-compose exec -it app bash``` 
7. Установить зависимости ```composer i```
8. Выполнить миграции ```php artisan migrate```
9. Запустить seeder ```php artisan db:seed --class=DatabaseStart```