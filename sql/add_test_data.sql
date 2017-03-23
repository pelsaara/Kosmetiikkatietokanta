INSERT INTO Consumer (name, password, age) VALUES ('Minni', 'Minni123', 19);
INSERT INTO Consumer (name, password, age) VALUES ('Lilli', 'Lilli123', 29);

INSERT INTO Brand (name) VALUES ('Too Faced');
INSERT INTO Brand (name) VALUES ('Benefit');
INSERT INTO Brand (name) VALUES ('Lumene');

INSERT INTO Product (name, brand, description, ingredients) VALUES ('Better Than Sex Mascara', 1, 'Tuuheuttava ja pidentävä ripsiväri', 'Aqua, Beeswax, Ink');
INSERT INTO Product (name, brand, description, ingredients) VALUES ('True Mystic Volume Mascara', 3, 'Tuuheuttava ja pidentävä ripsiväri', 'Aqua, Beeswax, Ink');
INSERT INTO Product (name, brand, description, ingredients) VALUES ('Gimme Brow!', 2, 'Tuuheuttava kuitukarvoja sisältävä värillinen kulmageeli', 'Aqua, Beeswax');

INSERT INTO Category (name) VALUES ('Värikosmetiikka');
INSERT INTO Category (name) VALUES ('Ihonhoito');
INSERT INTO Category (name) VALUES ('Kulmakarvat');
INSERT INTO Category (name) VALUES ('Ripsivärit');

INSERT INTO ProductCategory (product, category) VALUES (1, 1);
INSERT INTO ProductCategory (product, category) VALUES (1, 4);
INSERT INTO ProductCategory (product, category) VALUES (2, 1);
INSERT INTO ProductCategory (product, category) VALUES (2, 4);
INSERT INTO ProductCategory (product, category) VALUES (3, 1);
INSERT INTO ProductCategory (product, category) VALUES (3, 3);

INSERT INTO Comment (product, consumer, comment) VALUES (1, 1, 'Paras ripsari!');
INSERT INTO Comment (product, consumer, comment) VALUES (1, 3, 'Luottotuote :)');
INSERT INTO Comment (product, consumer, comment) VALUES (2, 2, 'Kotimainen loistotuote!!');

