-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE Table Tila(
id SERIAL PRIMARY KEY,
nimi varchar NOT NULL
);

CREATE Table Kayttaja(
id SERIAL PRIMARY KEY,
etunimi varchar(50) NOT NULL,
sukunimi varchar(50) NOT NULL,
puhelinnumero varchar(10) NOT NULL,
sahkopostiosoite varchar,
kotiosoite varchar NOT NULL,
postinumero integer NOT NULL,
postitoimipaikka varchar NOT NULL
);

CREATE Table Rooli(
id SERIAL PRIMARY KEY,
nimi varchar NOT NULL
);

CREATE Table Kategoria(
id SERIAL PRIMARY KEY,
nimi varchar(50) NOT NULL
);

CREATE Table Tuote(
id SERIAL PRIMARY KEY,
kategoria_id INTEGER REFERENCES Kategoria(id),
nimi varchar(50) NOT NULL,
kuva varchar(50),
kuvaus varchar,
hinta integer NOT NULL
);

CREATE Table KayttajaRooli(
kayttaja_id INTEGER REFERENCES Kayttaja(id),
rooli_id INTEGER REFERENCES Rooli(id)
);

CREATE TABLE Tilaus(
id SERIAL PRIMARY KEY,
kayttaja_id INTEGER REFERENCES Kayttaja(id),
tila_id INTEGER REFERENCES Tila(id),
etunimi varchar(50) NOT NULL,
sukunimi varchar(50) NOT NULL,
puhelinnumero varchar(10) NOT NULL,
sahkopostiosoite varchar,
toimitusosoite varchar NOT NULL,
postinumero integer NOT NULL,
postitoimipaikka varchar NOT NULL,
aika DATE
);

CREATE Table Tuoteilmentyma(
id SERIAL PRIMARY KEY,
tuote_id INTEGER REFERENCES Tuote(id),
tilaus_id INTEGER REFERENCES Tilaus(id)
);
