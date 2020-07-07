CREATE DATABASE YetiCave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE UTF8_GENERAL_CI;

USE YetiCave;

CREATE TABLE category (
    category_name CHAR(64) UNIQUE,
    symbol_code CHAR(64) UNIQUE
);

CREATE TABLE lot (
    date_of_create DATETIME(6),
    title CHAR(128),
    description TEXT,
    img CHAR(64),
    start_price INT,
    expiration_date DATE,
    bet_step INT
);

CREATE TABLE bet (
   date DATETIME(6),
   price INT 
); 

CREATE TABLE user (
    date_of_registration DATETIME(6),
    email VARCHAR(128) UNIQUE,
    name CHAR(64) UNIQUE,
    password CHAR(64) UNIQUE,
    contacts VARCHAR(128)
);

CREATE INDEX category_n ON category(category_name);