Чтобы запустить проект, нужно:
1. Запустить Docker
2. Открыть файл docker-compose.yaml находящийся в папке example-project. Найти раздел services и слева от него запустить БД
3. Удалить старую миграцию composer remove doctrine/doctrine-migrations-bundle
4. Установить миграцию composer require doctrine/doctrine-migrations-bundle
5. Выполнить две команда для миграции  1.(php bin/console make:migration) 2.(php bin/console doctrine:migrations:migrate)
3. Находясь в каталоге example-project устанавливаем зависимостей composer require symfony/serializer-pack
5. Запускаем локальный-сервер командой symfony serve
6. Заходим в браузер и вводим в адресную-строку http://localhost:8000/categories
9. Переходим в каталог PetProject
10. Запускаем автотесты командой php vendor/bin/codecept run Api --debug
11. Проверяем изменение в БД (book_category), а так же можно проверить на локальном сервере