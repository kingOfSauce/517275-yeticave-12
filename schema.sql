CREATE DATABASE IF NOT EXISTS YetiCave
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE YetiCave;

CREATE TABLE IF NOT EXISTS category (
    id INT PRIMARY KEY,
    name VARCHAR(128) UNIQUE,
    symbol_code VARCHAR(128) UNIQUE
);

CREATE TABLE IF NOT EXISTS user (
    id INT PRIMARY KEY,
    date_of_registration DATETIME(6),
    email VARCHAR(128) UNIQUE,
    name VARCHAR(128) UNIQUE,
    password VARCHAR(128) UNIQUE,
    contacts VARCHAR(128)
);

CREATE TABLE IF NOT EXISTS lot (
    id INT PRIMARY KEY,
    date_of_create DATETIME(6),
    title VARCHAR(128),
    description TEXT,
    img VARCHAR(128),
    start_price INT,
    expiration_date DATE,
    bet_step INT,
    category_id INT NOT NULL,
    winner_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (winner_id) REFERENCES user(id),
    FOREIGN KEY (category_id) REFERENCES category(id)
);

CREATE TABLE IF NOT EXISTS bet (
    id INT PRIMARY KEY,
    user_id INT,
    date DATETIME(6),
    price INT,
    lot_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (lot_id) REFERENCES lot(id)
); 

