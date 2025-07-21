# API заказов на Laravel

## Инструкция по установке

1. Клонируйте репозиторий или скопируйте проект в нужную папку.
2. Перейдите в папку проекта:
   ```bash
   cd it-up-company-tz
   ```
3. Установите зависимости:
   ```bash
   composer install
   ```
4. Скопируйте файл настроек:
   ```bash
   cp .env.example .env
   ```
5. Укажите параметры подключения к БД в `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
6. Сгенерируйте ключ приложения:
   ```bash
   php artisan key:generate
   ```
7. Выполните миграции и наполните справочники:
   ```bash
   php artisan migrate --seed
   ```
8. Установите Sanctum:
   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   ```
9. Запустите сервер:
   ```bash
   php artisan serve
   ```
10. API будет доступен по адресу http://localhost:8000/api

---

## Техническая документация API

### Аутентификация

- **Регистрация**
  - `POST /api/register`
  - Параметры: `name`, `email`, `password`
  - Ответ: JSON с данными пользователя

- **Логин**
  - `POST /api/login`
  - Параметры: `email`, `password`
  - Ответ: `{ "token": "..." }`

**Все остальные методы требуют заголовок:**
```
Authorization: Bearer {token}
```

---

### Получение списка заказов
- `GET /api/orders`
- Параметры (query):
  - `status_id` — фильтр по статусу
  - `book_id` — фильтр по книге
  - `date_from`, `date_to` — фильтр по дате создания
  - `composition` — `short` (по умолчанию) или `extended` (с атрибутами)
  - `per_page` — количество на страницу (по умолчанию 10)
- Ответ: JSON с пагинацией и заказами

---

### Смена статуса заказа
- `POST /api/orders/{order}/change-status`
- Параметры (body):
  - `status_id` — ID нового статуса
- Ответ: JSON с результатом или ошибкой
- Если статус недоступен для смены — ошибка 403

---

## Работа с API через artisan-команды

Для удобства тестирования реализованы artisan-команды (см. `routes/console.php`).

### Примеры использования:

```bash
# Регистрация пользователя
php artisan api:register "Имя" email@example.com password

# Логин (получение токена)
php artisan api:login email@example.com password

# Получение заказов (composition=extended|short, per_page=5)
php artisan api:orders <token> --composition=extended --per_page=5

# Смена статуса заказа
php artisan api:change-status <token> <order_id> <status_id>
```

Описание тестового задания лежит в файле `Тестовое задание - PHP-разработчик (Laravel Framework) - IT Up company.docx` в корне проекта
