# Laravel 11 + Vue 3 + Quasar
## Обновление на текущую версию

### UPDATE SQL
#### users
```
ALTER TABLE users RENAME COLUMN role_id TO role varchar(50);
UPDATE users SET role = 'user' WHERE role == '1';
UPDATE users SET role = 'sysadmin' WHERE role == '2';
UPDATE users SET role = 'admin' WHERE role == '3';
```

#### partners
copy table partners to _partners
```
INSERT INTO `partners` (
    `id`,
    `organization`,
    `inn`,	
    `name`,
    `contract_number`,
    `email`,
    `telnums`,
    `address`,
    `start_at`,
    `yclients_id`,
    `disabled`
)
SELECT
    `id`,
    `organization`,
    `inn`,	
    `name`,
    `contract_number`,
    `email`,
    `telnums`,
    `address`,
    `start_at`,
    `yclients_id`,
    `disabled`
FROM
	`_partners`
```

```
INSERT INTO `calls` (
    `partner_id`,
    `mango_telnum`,	
    `lost_client_days`,
    `repeat_client_days`,
    `new_client_days`,
    `pay_end`,
    `tg_chat_id`,
    `tg_active`
)
SELECT
    `id` as `partner_id`,
    `mango_telnum`,	
    `lost_client_days`,
    `repeat_client_days`,
    `new_client_days`,
    `tg_pay_end` as `pay_end`,
    `tg_chat_id`,
    `tg_active`
FROM
	`_partners`
```
