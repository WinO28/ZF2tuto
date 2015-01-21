CREATE TABLE album (
   id int(11) NOT NULL auto_increment,
   artist varchar(100) NOT NULL,
   title varchar(100) NOT NULL,
   PRIMARY KEY (id)
 );
 INSERT INTO album (artist, title)
     VALUES  ('The  Military  Wives',  'In  My  Dreams');
 INSERT INTO album (artist, title)
     VALUES  ('Adele',  '21');
 INSERT INTO album (artist, title)
     VALUES  ('Bruce  Springsteen',  'Wrecking Ball (Deluxe)');
 INSERT INTO album (artist, title)
     VALUES  ('Lana  Del  Rey',  'Born  To  Die');
 INSERT INTO album (artist, title)
     VALUES  ('Gotye',  'Making  Mirrors');
     
     
CREATE TABLE users (
   id int(11) NOT NULL auto_increment,
   user_name varchar(100) NOT NULL,
   pass_word varchar(100) NOT NULL,
   role varchar(100) NOT NULL,
   PRIMARY KEY (id)
 );
 INSERT INTO users (user_name, pass_word, role)
     VALUES  ('hugo', 'azerty123', 'admin');
 INSERT INTO users (user_name, pass_word, role)
     VALUES  ('hugo', 'azerty123', 'fan');
