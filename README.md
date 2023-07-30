# Systemeio test task

## Запускаем

Сервится на localhost:8050

1) ```docker compose build && docker compose up -d```
2) ```docker compose exec app php bin/console doctrine:database:create```
3) ```docker compose exec app php bin/console doctrine:migration:migrate```
4) ```docker compose exec app php bin/console doctrine:fixtures:load```
5) Отобразить купоны: ``docker compose exec app php bin/console doctrine:query:sql "select (CASE WHEN discount_type = 1 THEN 'fix' WHEN discount_type = 2 THEN 'percent' END) as discount_type_string, code, discount_amount from coupon"``
6) Отобразить товары: ``docker compose exec app php bin/console doctrine:query:sql "select id, name, price from product"``

## Требования:

- Docker: docker-compose.yml, php, nginx, mysql 
- Ендпоинты: 
  * ```POST product/get-price``` чтобы было понятно, что он возвращает данные или ````product/calculate-price(calc-price)````
  * ```POST product/payment_request``` 
- Миграция для: продуктов, купонов и налога для разных стран
- Сервис для расчета налога (если цена продукта больше определенного порога применяется налог страны)
- Сервис для применения купонов
- Используем встроенный валидатор symfony
- Для PaymentProcessor классов использовать адаптер
- Какой-то сервис конвертирования внутренней валюты из конфига в другие -- (не сделал, итак много времени ушло на другие аспекты)
- Тесты -- (не сделал, итак много времени ушло на другие аспекты)

## Шаги реализации:

- Миграции:
  * products (id, name, price, created_at, updated_at)
  * coupons (id, code, discount_type, discount_amount, is_active, valid_until)
  * country_tax_info (id, format, rate_percent, amount_threshold, country_code, country_name, created_at, updated_at)
- Сервис расчета налога и применения купонов:
  * Стратегия типа TaxCalcStrategy, CouponCalcStrategy
  * TaxCalcStrategy:, проверяем на лимит и применяем
  * CouponCalcStrategy: is_active=false, если нашли. Применяем метод сущности исходя из discount_type  
- Конвертирование внутренней валюты в нужное представление:
  * Указываем где-то в конфиге внутреннею валюту
  * Какой-то сервис для предоставления функционала по конвертированию (скорее всего внешняя библиотека) -- не буду реализовывать
