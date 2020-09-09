Тестовое задание на вакансию PHP-разработчика в Start Mobile

  1. Команды для развертки проекта:

    make install - поднятие Docker-контейнеров, создание базы данных, заполнение базы фикстурами


    make stop - остановка контейнеров

    make dropdb - дроп базы данных


  2.CRUD-методы для автора (реализованы в AuthorController.php):

    GET http://localhost:8080/api/v1/authors/{id} - вывод автора с идентификатором id

    POST http://localhost:8080/api/v1/authors - создание автора, метод получает заголовок Content-Type "application/json" с соответствующим json'ом, например:
        {
            "name": "sample_name"
        }

    POST http://localhost:8080/api/v1/admin/authors/{id} - редактирование автора с идентификатором id, метод получает заголовок Content-Type "application/json" с соответствующим json'ом с новыми значениями полей

    DELETE http://localhost:8080/api/v1/authors/{id} - удаление автора с идентификатором id


  3. CRUD-методы для книги (реализованы в BookController.php):

    POST http://localhost:8080/api/v1/books - создание книги, метод получает заголовок Content-Type "application/json" с соответствующим json'ом, например:
        {
            "title": "test_title",
            "author": {
              "id": "1"
            },
            "publication_year": 1501,
            "page": 250
        }


  4. Список методов, реализованных в ApiController.php:

    GET http://localhost:8080/api/v1/books/list - получение списка книг с именем автора

    GET http://localhost:8080/api/v1/books/by-id/{id} - получение данных книги по id

    POST http://localhost:8080/api/v1/books/update/{id} - обновление данных книги, метод получает заголовок Content-Type "application/json" с соответствующим json'ом с новыми значениями полей

    DELETE http://localhost:8080/api/v1/books/{id} - удаление записи книги из бд

   5. Для доступа к каждому из реализованных методов необходимо отправлять запросы с заголовком API-USER-NAME со значением admin.