SET FOREIGN_KEY_CHECKS=0;
DELETE FROM inventory WHERE stay_date < (UNIX_TIMESTAMP() - 86400) AND (inventory_status = 0 OR status = -1);
SET FOREIGN_KEY_CHECKS=1;
