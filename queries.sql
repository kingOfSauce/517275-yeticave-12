INSERT INTO user (date_of_registration, email, name, password, contacts) VALUES ("2016-01-24", "abc@gmail.com", "Игорь", "secret", "8546124");
INSERT INTO user (date_of_registration, email, name, password, contacts) VALUES ("2012-05-13", "gmail@gmail.com", "Витя", "top_secret", "7153264");
INSERT INTO user (date_of_registration, email, name, password, contacts) VALUES ("2018-09-21", "mail@mail.ru", "Олег", "top_top_secret", "9812534");


INSERT INTO category (name, symbol_code) VALUES ("Шапки", "hats");
INSERT INTO category (name, symbol_code) VALUES ("Куртки", "jackets");
INSERT INTO category (name, symbol_code) VALUES ("Штаны", "pants");
INSERT INTO category (name, symbol_code) VALUES ("Обувь", "boots");

INSERT INTO lot (date_of_create, title, description, img, start_price, expiration_date, bet_step, category_id, user_id) VALUES ("2016-05-26", "Ботинки для лыж", "Ботинки для горых лыж средней ценовой категории", "img", "2600", "2020-12-31", "200", 33, 23);
INSERT INTO lot (date_of_create, title, description, img, start_price, expiration_date, bet_step, category_id, user_id) VALUES ("2017-05-09", "Куртка для лыж", "Куртка для горых лыж средней ценовой категории", "img", "5600", "2020-11-25", "400", 31, 24);
INSERT INTO lot (date_of_create, title, description, img, start_price, expiration_date, bet_step, category_id, user_id) VALUES ("2018-03-13", "Штаны для лыж", "Штаны для горых лыж средней ценовой категории", "img", "4600", "2020-09-27", "150", 32, 25);
INSERT INTO lot (date_of_create, title, description, img, start_price, expiration_date, bet_step, category_id, user_id) VALUES ("2020-01-13", "Шапка для лыж", "Шапка для горых лыж средней ценовой категории", "img", "1000", "2020-08-17", "100", 30, 23);

INSERT INTO bet (user_id, date, price, lot_id) VALUES (23, "2020-01-24 6:10", "2800", 13);
INSERT INTO bet (user_id, date, price, lot_id) VALUES (25, "2020-02-17 10:17", "5600", 12);
INSERT INTO bet (user_id, date, price, lot_id) VALUES (23, "2020-03-01 13:20", "1100", 14);
INSERT INTO bet (user_id, date, price, lot_id) VALUES (24, "2020-04-18 18:30", "4750", 11);


SELECT * FROM category;
SELECT title, start_price, img, category_id, c.name FROM lot l JOIN category c ON l.category_id = c.id WHERE date_of_create < expiration_date && expiration_date > SYSDATE();
SELECT l.id, date_of_create, title, description, img, start_price, bet_step, category_id, c.name FROM lot l JOIN category c ON l.category_id = c.id WHERE l.category_id = 31;
UPDATE lot SET title = 'Супер куртка для лыж' WHERE id = 12;
SELECT * FROM lot WHERE id IN (12, 13, 14) ORDER BY date_of_create DESC;