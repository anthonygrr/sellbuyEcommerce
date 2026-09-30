-- Migration 001: user address/phone columns + widen orders.address_order.
-- Apply to sellbuy_php_db (fresh containers get this via db/script.sql instead).

ALTER TABLE users
  ADD COLUMN address_user VARCHAR(150) NULL,
  ADD COLUMN city_user VARCHAR(60) NULL,
  ADD COLUMN region_user VARCHAR(60) NULL,
  ADD COLUMN zip_user VARCHAR(10) NULL,
  ADD COLUMN country_user VARCHAR(60) NULL,
  ADD COLUMN phone_user VARCHAR(15) NULL;

ALTER TABLE orders MODIFY COLUMN address_order VARCHAR(150) NULL;
