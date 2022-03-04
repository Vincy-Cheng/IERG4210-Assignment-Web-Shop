-- SQL Statement that used in the cart.db

-- create/ open database
sudo sqlite3 /var/www/cart.db

-- create table

-- schema :
-- CATEGORIES
CREATE TABLE CATEGORIES (
 CATID INTEGER PRIMARY KEY,
 NAME TEXT
);
-- PRODUCTS
-- Required columns: pid (primary key), catid, name, price, description
CREATE TABLE PRODUCTS (
 PID INTEGER PRIMARY KEY,
 CATID INTEGER,
 NAME TEXT,
 PRICE REAL,
 DESCRIPTION TEXT,
 QUANTITY INTEGER,
 FOREIGN KEY(CATID) REFERENCES CATEGORIES(CATID)
);

-- CHECK WHAT HAVE CREATED
-- .schema

-- DELETE TABLE
DROP TABLE PRODUCTS;

-- INSERT RECORD

-- example
INSERT INTO CATEGORIES VALUES (NULL, "Food");

INSERT INTO PRODUCTS VALUES (NULL, 1, "Elephanet-Rice", 100, "Essential food.", 489);

-- OR
INSERT INTO PRODUCTS (catid, name, price,description) VALUES (1, "rice", 100,"cheap");
-- DELETE

DELETE FROM PRODUCTS WHERE name='rice';

-- UPDATE

UPDATE PRODUCTS SET NAME = $name, PRICE = $price, DESCRIPTION = $desc , QUANTITY = $quan  WHERE PID=$pid;
UPDATE PRODUCTS SET NAME = "Water", PRICE = 23, DESCRIPTION = "Water" , QUANTITY = 444  WHERE PID=6;
UPDATE PRODUCTS SET CATID = 1 WHERE PID=6;


SELECT * FROM PRODUCTS;