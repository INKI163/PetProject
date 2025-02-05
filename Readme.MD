Чтобы запустить проект, нужно:
1. Запустить Docker
2. В терминале перейти в директорию example-project и запустить контейнер командой docker start postgres
4. Удалить старую миграцию composer remove doctrine/doctrine-migrations-bundle
5. Установить миграцию composer require doctrine/doctrine-migrations-bundle
6. Выполнить две команда для миграции  1.(php bin/console make:migration) 2.(php bin/console doctrine:migrations:migrate)
7. Находясь в каталоге example-project устанавливаем зависимостей composer require symfony/serializer-pack
8. Запускаем локальный-сервер командой symfony serve
9. Заходим в браузер и вводим в адресную-строку http://localhost:8000/categories
10. Запускаем автотесты командой php vendor/bin/codecept run Api --debug
11. Проверяем изменение в консоли

Просмотр баг-репортов: https://docs.google.com/spreadsheets/d/1YPPhutQXyhp60vzyi39r8-e4X5r1ke2o7by7F_AMl9s/edit?usp=sharing