-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Lisää CREATE TABLE lauseet tähän tiedostoon

INSERT INTO Status (name) VALUES ('käsitellään');
INSERT INTO Status (name) VALUES ('toimitettu');
INSERT INTO Status (name) VALUES ('hylätty');

INSERT INTO User1 (forename, surname, phonenumber, email, password, address, zipcode, postoffice, role) VALUES ('TestiAdmin', 'Jokunen', '0501234567', 'admin@admin.com', 'admin', 'Testauskatu 12 A 3', 00100, 'Helsinki', 1);

INSERT INTO User1 (forename, surname, phonenumber, email, password, address, zipcode, postoffice, role) VALUES ('TestiKäyttäjä', 'Jokunen', '0401234567', 'user@user.com', 'user', 'Testauskatu 12 A 3', 00100, 'Helsinki', 2);

INSERT INTO Category (name) VALUES ('Vapaa-aika');
INSERT INTO Category (name) VALUES ('Puutarha');
INSERT INTO Category (name) VALUES ('Koti ja sisustus');

INSERT INTO Product (category_id, name, description, price, available) VALUES (1, 'polkupyörä', 'Hyvä pyörä!', 23, 't');

INSERT INTO Order1 (user1_id, status_id, forename, surname, phonenumber, email, delivery_address, zipcode, postoffice) VALUES (1, 1, 'Matti', 'Testinen', '0101234567', 'matti.testinen@testi.com', 'Testauskatu 12 A 3', 00100, 'Helsinki');

INSERT INTO ProductInstance (product_id, order1_id, price) VALUES (1, 1, 23);

INSERT INTO ProductInstance (product_id) VALUES (1);
