CREATE TABLE Consumer(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  age INTEGER NOT NULL
);

CREATE TABLE Brand(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL
);
  
CREATE TABLE Product(
  id SERIAL PRIMARY KEY,
  name varchar(50) NOT NULL,
  brand INTEGER REFERENCES Brand(id),  
  description varchar(500),
  ingredients varchar(500)
);

CREATE TABLE Category(
  id SERIAL PRIMARY KEY, 
  name varchar(50) NOT NULL
);

CREATE TABLE ProductCategory(
  product INTEGER REFERENCES Product(id),
  category INTEGER REFERENCES Category(id)
);

CREATE TABLE Comment(
  id SERIAL PRIMARY KEY, 
  product INTEGER REFERENCES Product(id),
  consumer INTEGER REFERENCES Consumer(id),
  comment varchar(500) NOT NULL
);

