-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE Table Status(
id SERIAL PRIMARY KEY,
name varchar NOT NULL
);

CREATE Table User1(
id SERIAL PRIMARY KEY,
forename varchar(50) NOT NULL,
surname varchar(50) NOT NULL,
phonenumber varchar(10) NOT NULL,
email varchar,
password varchar,
address varchar NOT NULL,
zipcode varchar(5) NOT NULL,
postoffice varchar NOT NULL,
role integer NOT NULL
);

CREATE Table Category(
id SERIAL PRIMARY KEY,
name varchar(50) NOT NULL,
description varchar
);

CREATE Table Product(
id SERIAL PRIMARY KEY,
category_id INTEGER REFERENCES Category(id) ON DELETE SET NULL,
name varchar(50) NOT NULL,
description varchar,
price integer NOT NULL,
available boolean
);

CREATE TABLE Order1(
id SERIAL PRIMARY KEY,
user1_id INTEGER REFERENCES User1(id) ON DELETE SET NULL,
status_id INTEGER REFERENCES Status(id),
forename varchar(50) NOT NULL,
surname varchar(50) NOT NULL,
phonenumber varchar(10) NOT NULL,
email varchar,
delivery_address varchar NOT NULL,
zipcode varchar (5) NOT NULL,
postoffice varchar NOT NULL
);

CREATE Table ProductInstance(
id SERIAL PRIMARY KEY,
product_id INTEGER REFERENCES Product(id),
order1_id INTEGER REFERENCES Order1(id) ON DELETE SET NULL,
price integer
);

CREATE Table ProductCategory(
product_id INTEGER REFERENCES Product(id),
category_id INTEGER REFERENCES Category(id)
);
