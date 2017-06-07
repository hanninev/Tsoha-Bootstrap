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
zipcode integer NOT NULL,
postoffice varchar NOT NULL
);

CREATE Table Role(
id SERIAL PRIMARY KEY,
name varchar NOT NULL
);

CREATE Table Category(
id SERIAL PRIMARY KEY,
name varchar(50) NOT NULL,
parentcategory_id INTEGER REFERENCES Category(id),
description varchar
);

CREATE Table Product(
id SERIAL PRIMARY KEY,
category_id INTEGER REFERENCES Category(id),
name varchar(50) NOT NULL,
photo varchar(50),
description varchar,
price integer NOT NULL,
available boolean
);

CREATE Table UserRole(
user1_id INTEGER REFERENCES User1(id),
role_id INTEGER REFERENCES Role(id)
);

CREATE TABLE Order1(
id SERIAL PRIMARY KEY,
user1_id INTEGER REFERENCES User1(id),
status_id INTEGER REFERENCES Status(id),
forename varchar(50) NOT NULL,
surname varchar(50) NOT NULL,
phonenumber varchar(10) NOT NULL,
email varchar,
delivery_address varchar NOT NULL,
zipcode integer NOT NULL,
postoffice varchar NOT NULL,
time DATE
);

CREATE Table ProductInstance(
id SERIAL PRIMARY KEY,
product_id INTEGER REFERENCES Product(id),
order1_id INTEGER REFERENCES Order1(id),
price integer
);
