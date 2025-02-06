Чтобы запустить проект, нужно:
1. Запустить Docker
2. В терминале перейти в директорию example-project и запустить контейнер командой docker compose up
3. Удалить библиотеку Doctrine composer remove doctrine/doctrine-migrations-bundle
4. Установить библиотеку Doctrine composer require doctrine/doctrine-migrations-bundle
5. Выполнить команду для создания миграции php bin/console make:migration Запустить все миграции php bin/console doctrine:migrations:migrate
6. Находясь в каталоге example-project устанавливаем зависимости composer require symfony/serializer-pack
7. Запускаем локальный-сервер командой symfony serve
8. Заходим в браузер и вводим в адресную-строку http://localhost:8000/categories
9. Запускаем автотесты командой php vendor/bin/codecept run Api --debug
10. Проверяем изменение в консоли

Просмотр баг-репортов: https://docs.google.com/spreadsheets/d/1YPPhutQXyhp60vzyi39r8-e4X5r1ke2o7by7F_AMl9s/edit?usp=sharing