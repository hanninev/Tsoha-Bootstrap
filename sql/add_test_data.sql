-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Lisää CREATE TABLE lauseet tähän tiedostoon

INSERT INTO Status VALUES (1, 'kesken');

INSERT INTO User1 VALUES (1, 'JaskaAdmin', 'Jokunen', '4342', 'admin', 'admin', 'Testauskatu 12 A 3', 100, 'Helsinki', 1);

INSERT INTO User1 VALUES (2, 'JaakkoKäyttäjä', 'Jokunen', '4342', 'matti', 'matti', 'Testauskatu 12 A 3', 100, 'Helsinki', 2);

INSERT INTO Category (id, name) VALUES (1, 'Vapaa-aika');

INSERT INTO Category (id, name, parentcategory_id) VALUES (2, 'Polkupöyrät', 1);

INSERT INTO Product (category_id, name, photo, description, price) VALUES (1, 'polkupöyrä', 'ei kuvaa', 'Hyvä pöyrä!', 23);

INSERT INTO Order1 VALUES (1, 1, 1, 'Matti', 'Testinen', '42342342', 'matti.testinentesti.com', 'Testauskatu 12 A 3', 00100, 'Helsinki');

INSERT INTO ProductInstance VALUES (1, 1, 1, 23);

INSERT INTO ProductInstance VALUES (2, 1, 1, 23);
