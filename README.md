Приложение расчета стоимости доставки
=========================================
# Интерфейс
- Калькулятор
![Screenshot 2023-08-19 112042](https://github.com/alekseyprokopov/yii2-calculator/assets/124125256/f2c09c92-f7e3-4717-a779-8eee9f78651b)
- Расчёта
![Screenshot 2023-08-19 112103](https://github.com/alekseyprokopov/yii2-calculator/assets/124125256/c905949a-2915-49b1-a542-7fb744dd784d)
- Авторизация
![Screenshot 2023-08-19 112112](https://github.com/alekseyprokopov/yii2-calculator/assets/124125256/cb6844d3-0d1f-41c0-b592-b941d9f83e3f)
- Регистрация
![Screenshot 2023-08-19 112124](https://github.com/alekseyprokopov/yii2-calculator/assets/124125256/10161ac4-2d20-408c-9611-dba62c03025f)
- Профиль
![Screenshot 2023-08-19 112140](https://github.com/alekseyprokopov/yii2-calculator/assets/124125256/3b371290-d42f-48b1-9518-fe94cc363b73)
- Журнал расчётов
![Screenshot 2023-08-19 112151](https://github.com/alekseyprokopov/yii2-calculator/assets/124125256/eb483ef2-fa4f-406a-8274-dbc29bc0bbe5)
- Админка
![Screenshot 2023-08-19 112213](https://github.com/alekseyprokopov/yii2-calculator/assets/124125256/d5c70bdb-da90-42d5-a8f9-be006b2c5ef9)

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
