# Laravel 11 + Vue 3 + Quasar
## Обновление на текущую версию

### UPDATE SQL
#### users
```
START TRANSACTION;
ALTER TABLE users RENAME COLUMN role_id TO role varchar(50);
UPDATE users SET role = 'user' WHERE role == '1';
UPDATE users SET role = 'sysadmin' WHERE role == '2';
UPDATE users SET role = 'admin' WHERE role == '3';
COMMIT;
```

#### partners
copy table partners to _partners
```
START TRANSACTION;
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
        `_partners`;

INSERT INTO `calls` (
    `partner_id`,
    `mango_telnum`,
    `lost_client_days`,
    `repeat_client_days`,
    `new_client_days`,
    `pay_end`,
    `tg_chat_id`,
    `tg_disabled`
)
SELECT
    `id` as `partner_id`,
    `mango_telnum`,
    `lost_client_days`,
    `repeat_client_days`,
    `new_client_days`,
    `tg_pay_end` as `pay_end`,
    `tg_chat_id`,
    `tg_active` as `tg_disabled`
FROM
    `_partners`;

UPDATE `calls` SET `tg_disabled` = NOT `tg_disabled`;
COMMIT;
```

#### sheets
```
START TRANSACTION;
ALTER TABLE sheets RENAME COLUMN is_published TO disabled;
UPDATE `sheets` SET `disabled` = NOT `disabled`;
COMMIT;
```
