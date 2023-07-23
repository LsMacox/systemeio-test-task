# Systemeio test task

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
- Какой-то сервис конвертирования внутренней валюты из конфига в другие
- Тесты

## Шаги реализации:

#### Из основных шагов

- Миграции:
  * products (id, name, price, created_at, updated_at)
  * coupons (id, code, percent, discount_type, discount_amount, is_active, valid_until)
  * country_tax_info (id, format, rate, amount_threshold, country_code, country_name, created_at, updated_at)
- Сервис расчета налога и применения купонов:
  * Стратегия типа TaxCalcStrategy, CouponCalcStrategy
  * TaxCalcStrategy:, проверяем на лимит и применяем
  * CouponCalcStrategy: is_active=false, если нашли. Применяем метод сущности исходя из discount_type  
- Конвертирование внутренней валюты в нужное представление:
  * Указываем где-то в конфиге внутреннею валюту
  * Какой-то сервис для предоставления функционала по конвертированию (скорее всего внешняя библиотека)
