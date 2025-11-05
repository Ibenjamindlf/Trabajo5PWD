CREATE DATABASE pwd_login;
USE pwd_login;

CREATE TABLE usuario (
    idusuario BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usnombre VARCHAR(50) NOT NULL,
    uspass INT(11) NOT NULL,
    usmail VARCHAR(50),
    usdeshabilitado TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE rol (
    idrol BIGINT(20) NOT NULL AUTO_INCREMENT,
    roldescripcion VARCHAR(50),
    PRIMARY KEY (idrol)
);

CREATE TABLE usuariorol (
    idusuario BIGINT(20) NOT NULL,
    idrol BIGINT(20) NOT NULL,
    PRIMARY KEY (idusuario, idrol),
    FOREIGN KEY (idusuario) REFERENCES usuario(idusuario),
    FOREIGN KEY (idrol) REFERENCES rol(idrol)
);
