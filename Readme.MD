Проект представляет из себя API для записи книг в библиотеке, стек - Symfony и автотестирование данного API, стек - codeception.

Чтобы запустить проект, нужно:
1. Запустить Docker
2. В терминале перейти в директорию example-project и запустить контейнер командой docker-compose up
3. Войти в контейнер docker exec -it php sh
4. Выполнить composer update
5. Выполнить команду для очистки БД php bin/console doctrine:schema:drop --force
6. Выполнить команду для создания миграции php bin/console make:migration
7. Запустить все миграции php bin/console doctrine:migrations:migrate
8. Запускаем локальный-сервер командой symfony serve --allow-all-ip
9. Открываем новый терминал, снова заходим в контейнер docker exec -it php sh
10. Запускаем автотесты командой php vendor/bin/codecept run Api
11. Должно успешно пройти 13 тестов и упасть 2 теста. По упавшим тестам составлены баг-репорты ниже.

Просмотр баг-репортов: https://docs.google.com/spreadsheets/d/1YPPhutQXyhp60vzyi39r8-e4X5r1ke2o7by7F_AMl9s/edit?usp=sharing