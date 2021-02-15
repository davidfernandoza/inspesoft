USE mysql;
UPDATE user SET Password=PASSWORD('0123456789') WHERE User='root';
flush privileges;

CREATE DATABASE IF NOT EXISTS inspesoft DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci ;
USE inspesoft;

-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS impresiones
(
	id 									INTEGER(1)	 	UNSIGNED NOT NULL,
	secretaria		 			VARCHAR(100) 	NOT NULL,
	titulo 							VARCHAR(100) 	NOT NULL,
	juramento				 		TEXT 					NOT NULL,
	nombre 							VARCHAR(100) 	NOT NULL,
	lema 								VARCHAR(100) 	NOT NULL,
	direccion 					VARCHAR(100) 	NOT NULL,
	telefono 						VARCHAR(30) 	NOT NULL,
	fax 								VARCHAR(30) 	NOT NULL,
	email 							VARCHAR(100) 	NOT NULL,
	web 								VARCHAR(100) 	NOT NULL,	
	
	PRIMARY KEY 				(id)
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;

-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS usuarios
(
	id 									BIGINT	 		 	UNSIGNED NOT NULL,
	primer_nombre 			VARCHAR(45) 	NOT NULL,
	segundo_nombre 			VARCHAR(45) 	,
	primer_apellido 		VARCHAR(45) 	NOT NULL,
	segundo_apellido 		VARCHAR(45)	 	,
	email 							VARCHAR(150) 	UNIQUE NOT NULL,
	password 						BLOB 					NOT NULL,
	rol 								ENUM					('REGULAR', 'ADMINISTRADOR') NOT NULL,
	estado 							ENUM					('ACTIVO', 'INACTIVO') NOT NULL,
	
	PRIMARY KEY 				(id)
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;


-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS apoderados
(
	id 									BIGINT 		 		UNSIGNED NOT NULL,
	primer_nombre 			VARCHAR(45) 	NOT NULL,
	segundo_nombre 			VARCHAR(45) 	,
	primer_apellido 		VARCHAR(45) 	NOT NULL,
	segundo_apellido		VARCHAR(45) 	,
	targeta_pro 				VARCHAR(32) 	UNIQUE NOT NULL,
	telefono 						VARCHAR(15) 	,
	email 							VARCHAR(150) 	,
	estado 							ENUM					('ACTIVO', 'INACTIVO') NOT NULL,
	
	PRIMARY KEY 				(id)
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;


-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS personas
(
	id 									VARCHAR(32)	 	NOT NULL,
	cedula							VARCHAR(15)		UNIQUE,
	primer_nombre 			VARCHAR(45) 	NOT NULL,
	segundo_nombre 			VARCHAR(45),
	primer_apellido 		VARCHAR(45),
	segundo_apellido 		VARCHAR(45),
	direccion 					VARCHAR(200) 	NOT NULL,
	telefono 						VARCHAR(15),
	estado 							ENUM					('ACTIVO', 'INACTIVO') NOT NULL,
	
	PRIMARY KEY 				(id)
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;

-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS comparendos
(
	id 									VARCHAR(20)	 	NOT NULL,
	personas_id 				VARCHAR(32),
	tipo 								ENUM					('1', '2', '3', '4') NOT NULL,
	articulo 						TEXT 					NOT NULL,
	numeral 						VARCHAR(4) 		NOT NULL,
	literal 						VARCHAR(4) 		,
	multa 							FLOAT 			 	UNSIGNED ,
	num_folios 					VARCHAR(30)		UNIQUE,
	num_caja 						VARCHAR(11),
	fecha 			 				DATE 					NOT NULL,
	estado 							ENUM					('FAVOR', 'CONTRA', 'APELADO', 'ACEPTADO', 'INACTIVO') NOT NULL,
	
	
	PRIMARY KEY 				(id),
	CONSTRAINT 					fk_comparendos_personas
	FOREIGN KEY 				(personas_id)
	REFERENCES  				personas (id)
	ON UPDATE CASCADE
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;


-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS casos
(
	id 									VARCHAR(20)		NOT NULL,
	usuarios_id 				BIGINT	 		 	UNSIGNED NOT NULL,
	fecha_inicio 				DATE 					NOT NULL,
	fecha_cierre 				DATE,
	asunto 							VARCHAR(300) 	NOT NULL,
	hechos 							TEXT 					NOT NULL,	
	num_folios 					VARCHAR(30)		UNIQUE,
	num_caja 						VARCHAR(11),
	estado 							ENUM					('ACTIVO', 'CERRADO') NOT NULL,
	
	PRIMARY KEY 				(id),
	CONSTRAINT 					fk_casos_usuarios
	FOREIGN KEY 				(usuarios_id)
	REFERENCES 					usuarios (id)
	ON UPDATE CASCADE
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;


-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS eventos
(
	id 									BIGINT	 		 	UNSIGNED ZEROFILL AUTO_INCREMENT NOT NULL,
	casos_id						VARCHAR(20),
	comparendos_id      VARCHAR(20),

	title								VARCHAR(45)	 	NOT NULL,
	descripcion					TEXT,
	color								VARCHAR(30) 	NOT NULL,
	start 							DATETIME 			NOT NULL,
	
	PRIMARY KEY 				(id),
	CONSTRAINT 					fk_eventos_casos
	FOREIGN KEY 				(casos_id)
	REFERENCES  				casos (id)
		ON UPDATE CASCADE,
	CONSTRAINT 					fk_eventos_comparendos
	FOREIGN KEY 				(comparendos_id)
	REFERENCES  				comparendos (id)
		ON UPDATE CASCADE
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;

-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS involucrados
(
	id 									BIGINT	 		 	UNSIGNED ZEROFILL AUTO_INCREMENT NOT NULL,
	personas_id 				VARCHAR(32)		NOT NULL,
	casos_id						VARCHAR(20)		NOT NULL,
	tipo 								ENUM					('DENUNCIANTE', 'OFENDIDO', 'CONTRAVENTOR') NOT NULL,
	subtipo 						ENUM					('OFENDIDO', 'NO') ,
	estado 							ENUM					('ACTIVO', 'INACTIVO') NOT NULL,
	
	PRIMARY KEY 				(id),
	CONSTRAINT 					fk_involucrados_personas
	FOREIGN KEY 				(personas_id)
	REFERENCES  				personas (id)
	ON UPDATE CASCADE,
	CONSTRAINT 					fk_involucrados_casos
	FOREIGN KEY 				(casos_id)
	REFERENCES  				casos (id)
	ON UPDATE CASCADE
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;

-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS representaciones
(
	casos_id 						VARCHAR(20)		NOT NULL,
	apoderados_id 			BIGINT	 		 	UNSIGNED NOT NULL,
	personas_id 				VARCHAR(32)		NOT NULL,
	estado 							ENUM					('ACTIVO', 'INACTIVO') NOT NULL,
	
	PRIMARY KEY 				(casos_id, apoderados_id, personas_id),
	CONSTRAINT 					fk_representaciones_casos
	FOREIGN KEY 				(casos_id)
	REFERENCES  				casos (id)
	ON UPDATE CASCADE,
	CONSTRAINT 					fk_representaciones_apoderados
	FOREIGN KEY 				(apoderados_id)
	REFERENCES  				apoderados (id)
	ON UPDATE CASCADE,
	CONSTRAINT 					fk_representaciones_personas
	FOREIGN KEY 				(personas_id)
	REFERENCES  				personas (id)
	ON UPDATE CASCADE
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;



-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS audiencias
(
	id  								BIGINT			 	UNSIGNED NOT NULL ,
	eventos_id 					BIGINT	 		 	UNSIGNED ZEROFILL AUTO_INCREMENT NOT NULL,

	asistencia_d				ENUM					('SI', 'NO') NOT NULL,
	escusa_d						ENUM					('VALIDA', 'INVALIDA', 'NO'),
	argumento_d					ENUM					('SI', 'NO'),
	pruebas_d						ENUM					('SI', 'NO'),
	recursos_d					ENUM					('SI', 'NO'),
	

	asistencia_c				ENUM					('SI', 'NO') NOT NULL,
	escusa_c						ENUM					('VALIDA', 'INVALIDA', 'NO'),
	argumento_c					ENUM					('SI', 'NO'),
	pruebas_c						ENUM					('SI', 'NO'),
	recursos_c					ENUM					('SI', 'NO'),


	conciliacion				ENUM					('SI', 'NO'),
	detalles						TEXT,

	
	PRIMARY KEY 				(id),
	CONSTRAINT 					fk_audiencias_eventos
	FOREIGN KEY 				(eventos_id)
	REFERENCES  				eventos (id)
		ON UPDATE CASCADE
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;


-- --------------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS fallos
(
	num_resolucion 			VARCHAR(45)		NOT NULL,
	casos_id 						VARCHAR(20),
	fallo 							VARCHAR(300) 	NOT NULL,
	detalles 						TEXT 					,
	tipo 								ENUM					('APELACION', 'FINAL', 'PRIMERA INSTANCIA') NOT NULL,
	fecha 							DATE 					NOT NULL,
	estado 							ENUM					('ACTIVO', 'INACTIVO') NOT NULL,
	
	PRIMARY KEY 				(num_resolucion),
	CONSTRAINT 					fk_fallos_casos
	FOREIGN KEY 				(casos_id)
	REFERENCES 					casos (id)
	ON UPDATE CASCADE
)
ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_spanish2_ci;

-- --------------------------------------------------------------------------------------
-- Usuarios:
INSERT INTO usuarios VALUES (123456789,'USUARIO','','ADMIN','','usuario@admin.com','q11AvjxRCjlEOdXlRiQSdc/1TQMyKchEhOXRhpgZcBoGqJy8YO5ChzGG1BD5x8TAvLjX0SMi1fl9osygTLvyCg==','ADMINISTRADOR','ACTIVO');

INSERT INTO usuarios VALUES (012345678,'USUARIO','','REGULAR','','usuario@regular.com','i+Sqt6DrWSXrp8eG8idpikBNxkwmlCWAuyPTd9Ts1X/rT2yiTQX7NkqGr5MeGhUMZzdUz8DjMgL6ui0qiJ7pUw==','REGULAR','ACTIVO');


-- Impresiones
INSERT INTO impresiones VALUES (1,'SECRETARIA DE GOBIERNO TRANSITO Y TRASNPORTE','FORMULARIO DE INFORMACION DE COMPORTAMIENTO CONTRARIO A LA CONVIVENCIA.','El suscrito Inspector le tomo el juramento de rigor de conformidad con lo dispuesto en el articulo 442 del Codigo de Procedimiento Penal prometiendo decir toda la verdad en su denuncia.','JUAN CARLOS MEZA OCAMPO','SANTA ROSA DE CABAL NUESTRO OBJETIVO COMUN','CARRERA 14 # 12-08 C.A.M','3660972 - 3660977','3660973','inspesoft@gmail.com','www.santarosadecabal-risaralda.gov.co');