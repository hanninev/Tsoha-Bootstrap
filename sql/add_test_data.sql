-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Lisää CREATE TABLE lauseet tähän tiedostoon

INSERT INTO Tila VALUES (1, 'kesken');

INSERT INTO Kayttaja VALUES (1, 'Jaska', 'Jokunen', '4342', 'matticom', 'Testauskatu 12 A 3', 100, 'Helsinki');

INSERT INTO Rooli VALUES (1, 'Käyttäjä');

INSERT INTO Kategoria VALUES (1, 'Polkupöyrät');

INSERT INTO Tuote (kategoria_id, nimi, kuva, kuvaus, hinta) VALUES (1, 'polkupöyrä', 'ei kuvaa', 'Hyvä pöyrä!', 23);

INSERT INTO KayttajaRooli VALUES (1, 1);

INSERT INTO Tilaus VALUES (1, 1, 1, 'Matti', 'Testinen', '42342342', 'matti.testinentesti.com', 'Testauskatu 12 A 3', 00100, 'Helsinki');

INSERT INTO Tuoteilmentyma VALUES (1, 1, 1);

INSERT INTO Tuoteilmentyma VALUES (2, 1, 1);
