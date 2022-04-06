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

-- USERS
CREATE TABLE USERS (
 USERID INTEGER PRIMARY KEY,
 USERNAME VARCHAR(20),
 EMAIL VARCHAR(100),
 SALT TEXT,
 SHPWD TEXT,
 ADMINFLAG INTEGER
);

-- CHECK WHAT HAVE CREATED
-- .schema

-- DELETE TABLE
DROP TABLE PRODUCTS;

-- INSERT RECORD

-- example
INSERT INTO CATEGORIES VALUES (NULL, "Food");

INSERT INTO PRODUCTS VALUES (NULL, 1, "Elephanet-Rice", 100, "Essential food.", 489);

-- Admin's password: ierg4210#s19
INSERT INTO USERS VALUES (NULL, "Admin", "admin@ierg4210.s19.com", "50302524248" , "0e2dd22f88eb716ce6159cbbb21343dda6650439a9df145a53eb3e57299e3a05", 1);
-- Vincy's password: vincyC111test2
INSERT INTO USERS VALUES (NULL, "VincyCheng", "vincy19@gmail.com", "42623120538" , "e25d7262754e0cc34db06ffe856e56c2231fbcb7d9acef90efe1a7582c06608e", 0);

-- OR
INSERT INTO PRODUCTS (catid, name, price,description) VALUES (1, "rice", 100,"cheap");
-- DELETE

DELETE FROM PRODUCTS WHERE name='rice';

-- UPDATE

UPDATE PRODUCTS SET NAME = $name, PRICE = $price, DESCRIPTION = $desc , QUANTITY = $quan  WHERE PID=$pid;
UPDATE PRODUCTS SET NAME = "Water", PRICE = 23, DESCRIPTION = "Water" , QUANTITY = 444  WHERE PID=6;
UPDATE PRODUCTS SET CATID = 1 WHERE PID=6;


SELECT * FROM PRODUCTS;
SELECT * FROM USERS;