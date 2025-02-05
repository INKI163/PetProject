Чтобы запустить проект, нужно:
1. Запустить Docker
2. В терминале перейти в директорию example-project и запустить контейнер командой docker start postgres
3. Создайте файл в папке example-project .env.local с помощью symfony var:export --multiline > .env.local
4. Пропишите в файл из третьего пункта
   export DATABASE_DATABASE=postgres
   export DATABASE_DRIVER=postgres
   export DATABASE_HOST=127.0.0.1
   export DATABASE_NAME=postgres
   export DATABASE_PASSWORD=12345
   export DATABASE_PORT=5432
   export DATABASE_SERVER=postgres://127.0.0.1:5432
   export DATABASE_URL=postgres://postgres:12345@127.0.0.1:5432/postgres
   export DATABASE_USER=postgres
   export DATABASE_USERNAME=postgres
   export PGDATABASE=postgres
   export PGHOST=127.0.0.1
   export PGPASSWORD=12345
   export PGPORT=5432
   export PGUSER=postgres

5. Удалить старую миграцию composer remove doctrine/doctrine-migrations-bundle
6. Установить миграцию composer require doctrine/doctrine-migrations-bundle
7. Выполнить две команда для миграции  1.(php bin/console make:migration) 2.(php bin/console doctrine:migrations:migrate)
8. Находясь в каталоге example-project устанавливаем зависимостей composer require symfony/serializer-pack
9. Запускаем локальный-сервер командой symfony serve
10. Заходим в браузер и вводим в адресную-строку http://localhost:8000/categories
11. Запускаем автотесты командой php vendor/bin/codecept run Api --debug
12. Проверяем изменение в консоли

Просмотр баг-репортов: https://docs.google.com/spreadsheets/d/1YPPhutQXyhp60vzyi39r8-e4X5r1ke2o7by7F_AMl9s/edit?usp=sharing