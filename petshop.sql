CREATE DATABASE petshop;
USE petshop;

CREATE TABLE funcionario (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  datacadastro DATETIME NOT NULL
);

CREATE TABLE animal (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  raca VARCHAR(255) NOT NULL,
  teldono CHAR(11) NOT NULL,
  datacadastro DATETIME NOT NULL
);

CREATE TABLE atende (
  id INT PRIMARY KEY AUTO_INCREMENT,
  idfuncionario INT NOT NULL,
  idanimal INT NOT NULL,
  data DATETIME NOT NULL,
  FOREIGN KEY (idfuncionario) REFERENCES funcionario(id),
  FOREIGN KEY (idanimal) REFERENCES animal(id)
);
