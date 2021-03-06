CREATE TABLE usuario (
	id INT PRIMARY KEY AUTO_INCREMENT, 
	nome VARCHAR(255) NOT NULL, 
	usuario VARCHAR(30) NOT NULL, 
	senha VARCHAR(34) NOT NULL, 
	email VARCHAR(255) NOT NULL, 
	perfil CHAR(1) NOT NULL, 
	senhaAtiva CHAR(1) NOT NULL,
	observacao TEXT
) ENGINE=InnoDB;

CREATE TABLE pessoa (
	id INT PRIMARY KEY AUTO_INCREMENT, 
	nome VARCHAR(255) NOT NULL, 
	dataNascimento VARCHAR(30) NOT NULL, 
	telefone VARCHAR(30) NOT NULL,
	email VARCHAR(30) NOT NULL, 
	tipoPessoa CHAR(1) NOT NULL, 
	observacao TEXT NOT NULL, 
) ENGINE=InnoDB;

CREATE TABLE treinamento (
	id INT PRIMARY KEY AUTO_INCREMENT, 
	nomeCurso VARCHAR(255) NOT NULL, 
	publicoAlvo VARCHAR(100) NOT NULL, 
	objetivo VARCHAR(255) NOT NULL,
	requisitos TEXT NOT NULL, 
	cargaHoraria VARCHAR(255) NOT NULL, 
	conteudo TEXT NOT NULL, 
) ENGINE=InnoDB;