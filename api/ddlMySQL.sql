CREATE TABLE associationCateg
(
  categ       INT PRIMARY KEY NOT NULL,
  categParent INT
);
CREATE TABLE associationCategMusee
(
  musee     INT PRIMARY KEY NOT NULL,
  categorie INT
);
CREATE TABLE categorie
(
  id    INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  label VARCHAR(45)     NOT NULL
);
CREATE TABLE musee
(
  id          INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nom         VARCHAR(45)     NOT NULL,
  description VARCHAR(255)
);
CREATE UNIQUE INDEX musee_UNIQUE ON associationCategMusee (musee);
