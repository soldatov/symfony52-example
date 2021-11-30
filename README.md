# Symfony 5.2 service example

Пример REST API сервиса для хранения и работы с данными о книгах и авторах.

- PHP 7.4
- Symfony 5.2
- Postgres 14.1

## Запуск приложения

1. Скопировать `.env.local.distrib` в `.env.local`.
2. Если необходимо, отредактировать `.env.local`. По умолчанию, редактирование не нужно.
3. Веб сервер будет поднять на 80 порту. Нужно убедиться, что свободен порт.
4. Выполнить:
```
make up-first
```
5. Перейти на страницу [веб-клиента Swagger](http://localhost/api/doc/).

## Остановка приложения

Чистит базу с откатом миграции.

```
make down-clear
```

## Реализованы Методы:
- `GET /api/doc.json` - Open API спецификация.
- `/{locale}/books/{id}` - Получение книги по id (пока без авторов).

## Log composer пакетов

Для symfony 5.2 необходимо соблюдать последовательность, иначе крашится.

```
composer create-project symfony/skeleton:"5.2.*" my_app
cd my_app
composer req doctrine/dbal "2.*"
composer req symfony/orm-pack
composer req symfony/security-bundle
composer req knplabs/doctrine-behaviors
composer req nelmio/api-doc-bundle
composer req twig asset
composer req symfony/maker-bundle --dev
composer req --dev orm-fixtures
composer req symfony/translation
composer req symfony/serializer
```
