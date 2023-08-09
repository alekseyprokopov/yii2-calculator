Приложение расчета стоимости доставки
=========================================

# Запуск приложения через Docker Compose

1. скопировать .env.dist в .env
2. настроить переменные окружения
3. выполнить команду make install, дождаться завершения установки
4. открыть приложение в браузере по адресу http://localhost:{APP_WEB_PORT}

## Команды Make

- `make install` - выполнить установку приложения
- `make up` - запуск контейнеров приложения
- `make down` - остановка контейнеров приложения
- `make ps` - статус контейнеров приложения
- `make docker-logs` - логи контейнеров приложения
- `make app-php-cli-exec` - запуск команды внутри контейнера php-cli
- `composer-install` - установка пакетов-зависимостей php приложения
- `make run-yii` - просмотра доступных команд приложения на Yii2

## Миграции

- `yii migrate` - запуск основных миграций. Создание таблиц: tonnage, month, raw_type, price, user, history
- `yii migrate --migrationPath=@yii/rbac/migrations` - создание таблиц для сохранения rbac-данных
- `yii rbac/init` - создание ролей (admin, user), назначение первичных маршрутов для ролей. Назнечение ролей
  пользователям admin, user

## API example
- `api/calculate-price?raw_type=соя&tonnage=25&month=январь`

## CMD example
- `yii calculate --month=январь --raw_type=соя --tonnage=25`
