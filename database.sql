CREATE TABLE vendedores(
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(45),
    apellidos VARCHAR(45),
    telefono VARCHAR(10)
)ENGINE=INNODB;

CREATE TABLE propiedades(
	id INT(11) PRIMARY KEY AUTO_INCREMENT,
    idVendedor INT(11),
    titulo VARCHAR(60),
    precio DECIMAL(10,2),
    imagen VARCHAR(200),
    descripcion LONGTEXT,
    habitaciones INT(1),
    wc INT(1),
    estacionamiento INT(1),
    creado DATE,
    FOREIGN KEY (idVendedor) REFERENCES vendedores (id)
)ENGINE=INNODB;