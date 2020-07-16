DELETE FROM bet;
DELETE FROM lot; 
DELETE FROM category;
DELETE FROM user;

-- add data to user table 
INSERT INTO user (id, date_of_registration, email, name, password, contacts) VALUES (1, "2016-01-24", "abc@gmail.com", "Игорь", "secret", "8546124");
INSERT INTO user (id, date_of_registration, email, name, password, contacts) VALUES (2, "2012-05-13", "gmail@gmail.com", "Витя", "top_secret", "7153264");
INSERT INTO user (id, date_of_registration, email, name, password, contacts) VALUES (3, "2018-09-21", "mail@mail.ru", "Олег", "top_top_secret", "9812534");

-- add data to category table
INSERT INTO category (id, name, symbol_code) VALUES (1, "Шапки", "hats");
INSERT INTO category (id, name, symbol_code) VALUES (2, "Куртки", "jackets");
INSERT INTO category (id, name, symbol_code) VALUES (3, "Штаны", "pants");
INSERT INTO category (id, name, symbol_code) VALUES (4, "Обувь", "boots");

-- add data to lot table
INSERT INTO lot (id, date_of_create, title, description, img, start_price, expiration_date, bet_step, category_id, user_id) VALUES (1, "2016-05-26", "Ботинки для лыж", "Ботинки для горых лыж средней ценовой категории", "img", "2600", "2020-12-31", "200", 4, 2);
INSERT INTO lot (id, date_of_create, title, description, img, start_price, expiration_date, bet_step, category_id, user_id) VALUES (2, "2017-05-09", "Куртка для лыж", "Куртка для горых лыж средней ценовой категории", "img", "5600", "2020-11-25", "400", 2, 1);
INSERT INTO lot (id, date_of_create, title, description, img, start_price, expiration_date, bet_step, category_id, user_id) VALUES (3, "2018-03-13", "Штаны для лыж", "Штаны для горых лыж средней ценовой категории", "img", "4600", "2020-09-27", "150", 3, 2);
INSERT INTO lot (id, date_of_create, title, description, img, start_price, expiration_date, bet_step, category_id, user_id) VALUES (4, "2020-01-13", "Шапка для лыж", "Шапка для горых лыж средней ценовой категории", "img", "1000", "2020-08-17", "100", 1, 3);

-- add data to bet table
INSERT INTO bet (id, user_id, date, price, lot_id) VALUES (1, 1, "2020-01-24 6:10", "2800", 3);
INSERT INTO bet (id, user_id, date, price, lot_id) VALUES (2, 2, "2020-02-17 10:17", "5600", 2);
INSERT INTO bet (id, user_id, date, price, lot_id) VALUES (3, 1, "2020-03-01 13:20", "1100", 4);
INSERT INTO bet (id, user_id, date, price, lot_id) VALUES (4, 3, "2020-04-18 18:30", "4750", 1);

-- get all categories
SELECT * FROM category;
-- Get the latest, open lots. Each lot should include a name, starting price, image link, current price, category name
SELECT title, start_price, img, c.name AS category_name, b.price FROM lot l JOIN category c ON l.category_id = c.id JOIN bet b WHERE date_of_create < expiration_date && expiration_date > NOW() AND winner_id IS NULL GROUP BY l.id ORDER BY b.date DESC;
-- show the lot by its id. Also get the name of the category to which the lot belongs.
SELECT l.id, date_of_create, title, description, img, start_price, bet_step, c.name FROM lot l JOIN category c ON l.category_id = c.id WHERE l.category_id = 2;
-- update the name of the lot by its identifier
UPDATE lot SET title = 'Супер куртка для лыж' WHERE id = 2;
-- get a list of bids for a lot by its identifier, sorted by date
SELECT l.id AS lot_id,  title, price FROM bet b JOIN lot l ON b.lot_id = l.id WHERE l.id IN (2, 3, 4) ORDER BY l.date_of_create DESC;