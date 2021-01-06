
-- ESTAS 3 LINEAS(DROP, CREATE, USE) AL SUBIR LA WEB AL HOSTING LAS COMENTAMOS, (solo lo usaremos para workbench) PORQUE LA BBDD YA ESTA CREADA Y NO ES NECESARIO, SOLAMENTE DEJAREMOS LAS TABLAS


DROP SCHEMA IF EXISTS DB_Project ;
CREATE SCHEMA IF NOT EXISTS DB_Project;
USE DB_Project;
-- -----------------------------------------------------------------------------------------------
-- TABLA DE USUARIOS
-- -----------------------------------------------------------------------------------------------
create table users(
    id int primary key auto_increment,
    user varchar(45),
    pass varchar(45),
    registerDate datetime default current_timestamp(),
    -- IsAdmin = este campo es únicamente para el admin (si IsAdmin = 1, tendrá acceso al crud)
	IsAdmin int not null default 0
);
-- -----------------------------------------------------------------------------------------------
-- TABLA DE SUSCRIPCIONES
-- -----------------------------------------------------------------------------------------------
create table suscripciones(
    id int primary key auto_increment,
	nombre varchar(45),
    apellidos varchar(45),
    email varchar(45),
    newsletter boolean default 0,
	suscriptionDate datetime default current_timestamp()

);
-- -----------------------------------------------------------------------------------------------
-- TABLA  DE CATEGORIAS
-- -----------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categorias(
    idcategorias INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(45)
);
-- -----------------------------------------------------------------------------------------------
-- TABLA DE PRODUCTOS
-- -----------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS productos(
    idproductos INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(45),
    descr VARCHAR(100),
    image VARCHAR(100),
    categorias_idcategorias INT,

    CONSTRAINT fk_1
    FOREIGN KEY (categorias_idcategorias)
    REFERENCES categorias (idcategorias)
    ON DELETE RESTRICT
    ON UPDATE CASCADE

    -- CREO UNA FOREIGN KEY QUE ME RELACIONA ID DE PRODUCTS CON ID DE USERS
	-- CONSTRAINT fk_2
    -- FOREIGN KEY (idproductos)
    -- REFERENCES users (id)
    -- ON DELETE RESTRICT
    -- ON UPDATE CASCADE
);

select * from users;
select * from suscripciones;
select * from productos;
select * from categorias;
-- -----------------------------------------------------------------------------------------------
-- INSERTS
-- -----------------------------------------------------------------------------------------------
-- USER: ADMIN CON PERMISO
insert into users values(null,'admin@gmail.com','111111',default, 1);
-- -----------------------------------------------------------------------------------------------
-- INSERTS CATEGORIAS
-- -----------------------------------------------------------------------------------------------
insert into categorias values(null, 'CASERAS');
insert into categorias values(null, 'PREMIUM');
insert into categorias values(null, 'LIGERAS');
insert into categorias values(null, 'CHIPS');
insert into categorias values(null, 'CHURRERIA');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
insert into categorias values(null, 'Nueva Categoria');
-- -----------------------------------------------------------------------------------------------
-- INSERTS SUSCRIPCIONES
-- -----------------------------------------------------------------------------------------------
insert into suscripciones values(null, 'ruben', 'fernandez', 'r.fp09@hotmail.com', 1, default);
insert into suscripciones values(null, 'jorge', 'fernandez', 'pruebascifovioleta20@gmail.com', 1, default);
insert into suscripciones values(null, 'Luis', 'Bobia', 'luis.bobia@gmail.com', 1, default);
insert into suscripciones values(null, ':nombre', ':apellidos', 'email4', 0, default);
insert into suscripciones values(null, ':nombre', ':apellidos', 'email5', 0, default);
select * from suscripciones;

select email from suscripciones where newsletter = 1;
select email from suscripciones;
