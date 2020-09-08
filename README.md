Тестовое задание на вакансию PHP-разработчика в Start Mobile

  1. Команды для развертки проекта:

    make install - поднятие Docker-контейнеров, создание базы данных, заполнение базы фикстурами


    make stop - остановка контейнеров

    make dropdb - дроп базы данных


  2.CRUD-методы для автора:

    GET http://localhost:8080/admin/authors/{id} - вывод автора с идентификатором id

    POST http://localhost:8080/admin/authors - создание автора, метод получает заголовок Content-Type "application/json" с соответствующим json'ом, например:
        {
            "name": "sample_name",
        }

    PUT http://localhost:8080/admin/authors/{id} - редактирование автора с идентификатором id, метод получает заголовок Content-Type "application/json" с соответствующим json'ом с новыми значениями полей

    DELETE http://localhost:8080/admin/authors/{id} - удаление автора с идентификатором id


  3. CRUD-методы для книги:

    GET http://localhost:8080/admin/books/{id} - вывод книги с идентификатором id

    POST http://localhost:8080/admin/books - создание книги, метод получает заголовок Content-Type "application/json" с соответствующим json'ом, например:
        {
            "title": "test_title",
            "author": {
              "id": "1"
            },
            "publication_year": 1501,
            "page": 250
        }

    PUT http://localhost:8080/admin/books/{id} - редактирование книги, метод получает заголовок Content-Type "application/json" с соответствующим json'ом с новыми значениями полей

    DELETE http://localhost:8080/admin/authors/{id} -удаление книги с идентификатором id