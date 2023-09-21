DROP DATABASE IF EXISTS idace;
CREATE DATABASE if not exists idace;

USE idace;

DROP TABLE IF EXISTS categorias;
create table IF NOT EXISTS categorias(
    id int unsigned auto_increment primary key,
    categoria varchar(50) unique not null,
    create_at timestamp default current_timestamp,
    update_at timestamp default current_timestamp
  
);

DROP TABLE IF EXISTS departamentos;
create table IF NOT EXISTS departamentos(
    id int unsigned auto_increment primary key,
    departamento varchar(50) unique not null,
    create_at timestamp default current_timestamp,
    update_at timestamp default current_timestamp
  
);

DROP TABLE IF EXISTS cursos;
create table IF NOT EXISTS cursos(
    id int unsigned auto_increment primary key,
    curso varchar(10),
    nivel char(4),
    ciclo char(3),
    create_at timestamp default current_timestamp,
    update_at timestamp default current_timestamp
  
);

DROP TABLE IF EXISTS profesores;
create table IF NOT EXISTS profesores(
    id int unsigned auto_increment primary key,
    nombre varchar(55) not null,
    puesto varchar(100),
    telefono char(9),
    usuario char(10),
    email varchar(100),
    password varchar(255), 
    departamento_id int unsigned,
    foreign key(departamento_id) references departamentos (id) on delete restrict on update cascade,
    
    create_at timestamp default current_timestamp,
    update_at timestamp default current_timestamp
);

DROP TABLE IF EXISTS planificadas;
create table IF NOT EXISTS planificadas(
    id int unsigned auto_increment primary key,
    curso char(5) DEFAULT '22/23',
    titulo varchar(100) not null,
    cursos varchar(255),
    eval char(1),
    inicio datetime,
    fin datetime,
	jornadas tinyint unsigned,
    horas_lectivas tinyint unsigned,
    num_alumnos smallint unsigned,
    lugar_celebracion varchar(100),
    departamento_id int unsigned,
	coordinador_id int unsigned,
    estado ENUM ('planificada', 'enviada', 'validada', 'difundida', 'archivada', 'cancelada') default 'planificada',
    observaciones TEXT,
    foreign key (coordinador_id) references profesores (id) 
    ON delete SET NULL ON UPDATE CASCADE,
    foreign key (departamento_id) references departamentos (id) 
    ON delete SET NULL ON UPDATE CASCADE,
    
    create_at timestamp default current_timestamp,
    update_at timestamp default current_timestamp
);

DROP TABLE IF EXISTS actividades;
create table IF NOT EXISTS actividades(
    id int unsigned auto_increment primary key,
    num_actividad int unsigned,
    curso char(5) DEFAULT '22/23',
    titulo varchar(100) not null,
    descripcion text,
    jornadas tinyint unsigned,
    fecha_inicio date,
    fecha_fin date,
    hora_inicio time,
    hora_fin time,
    dia_completo boolean,
	horas_lectivas tinyint unsigned,
    eval char(1),
    cursos varchar(255),
    observaciones_cursos_horas varchar(255),
    especialidad varchar(50),
    tramo_horario varchar(20),
    num_alumnos integer,
    lugar_celebracion varchar(100),
    colaboracion_coordinador varchar(255),
    colaboracion_departamentos varchar(255),
    profesores_participantes text,
    que_hacen_afectados varchar(100),
    observaciones text,
    adjuntos varchar(100),
    categorias varchar(255),
    estado ENUM ('planificado', 'enviado', 'validado', 'difundido', 'archivado', 'cancelado'),
    departamento_id int unsigned,
	coordinador_id int unsigned,
    email varchar(100),
    nombre varchar(100),
    foreign key (coordinador_id) references profesores (id) 
    ON delete SET NULL ON UPDATE CASCADE,
    foreign key (departamento_id) references departamentos (id) 
    ON delete SET NULL ON UPDATE CASCADE,
    
    create_at timestamp default current_timestamp,
    update_at timestamp default current_timestamp
);

-- Insertar mina de datos 22/23

-- Categorías
INSERT INTO categorias(id, categoria) VALUES
(null, 'Actuación'),(null, 'Baile'),(null, 'Campeonato'),(null, 'Charla'),
(null, 'Circo'),(null, 'Comida'),(null, 'Concierto'),(null, 'Concurso'),
(null, 'Conferencia'),(null, 'Curso'),(null, 'Deportiva'),(null, 'Encuentro'),
(null, 'Excursión'),(null, 'Feria'),(null, 'Intercambio'),(null, 'Juegos'),
(null, 'Lectura'),(null, 'Ponencia'),(null, 'Cine'),(null, 'Recital'),
(null, 'Senderismo'),(null, 'Taller'),(null, 'Teatro'),(null, 'Viaje'), (null, 'Visita');

-- Departamentos
INSERT INTO departamentos(id, departamento) VALUES
(null, 'Lengua y Literatura'),(null, 'Matemáticas'),(null, 'Ciencias Naturales'),(null, 'Física y Química'),
(null, 'Biología y Geología'),(null, 'Tecnología'),(null, 'Educación Física'),(null, 'Música'),
(null, 'Artes Plásticas y Visuales'),(null, 'Filosofía'),(null, 'Historia y Geografía'),(null, 'Inglés'),
(null, 'Francés'),(null, 'Latín y Griego'),(null, 'Religión'),(null, 'Oriengación Educativa y Psicopedagogía'),
(null, 'Actividades Complementarias y Extraescolares'),(null, 'Informática'),(null, 'Coord Bilingüe'),(null, 'Aula de Emprendimiento'),
(null, 'TDE'),(null, 'Coord Competencias Digitales'),(null, 'Competencia Digital'),(null, 'Biblioteca'), (null, 'FP a Distancia'),
(null, 'Plan Autoprotección'),(null, 'Plan Igualdad'),(null, 'Ubrique Blanco Paz'),(null, 'FP Dual'),
(null, 'Coeducación'),(null, 'Innovación Educativa'),(null, 'Dirección'),(null, 'Vicedirección'), (null, 'DACE');

-- Cursos
INSERT INTO cursos(id, curso, nivel, ciclo) VALUES
(null, '1ESOA', '1ESO', 'ESO'),
(null, '1ESOB', '1ESO', 'ESO'),
(null, '1ESOC', '1ESO', 'ESO'),
(null, '1ESOD', '1ESO', 'ESO'),
(null, '2ESOA', '2ESO', 'ESO'),
(null, '2ESOB', '2ESO', 'ESO'),
(null, '2ESOC', '2ESO', 'ESO'),
(null, '3ESOA', '3ESO', 'ESO'),
(null, '3ESOB', '3ESO', 'ESO'),
(null, '3ESOC', '3ESO', 'ESO'),
(null, '3ESOD', '3ESO', 'ESO'),
(null, '4ESOA', '4ESO', 'ESO'),
(null, '4ESOB', '4ESO', 'ESO'),
(null, '4ESOC', '4ESO', 'ESO'),
(null, '4ESOD', '4ESO', 'ESO'),
(null, '1BACHA', '1BACH', 'BACH'),
(null, '1BACHB', '1BACH', 'BACH'),
(null, '1BACHC', '1BACH', 'BACH'),
(null, '2BACHA', '2BACH', 'BACH'),
(null, '2BACHB', '2BACH', 'BACH'),
(null, '2BACHC', '2BACH', 'BACH'),
(null, '2BACHD', '2BACH', 'BACH'),
(null, '1SMR', 'SMR', 'FP'),
(null, '2SMR', 'SMR', 'FP'),
(null, '1DAW', 'DAW', 'FP'),
(null, '2DAW', 'DAW', 'FP'),
(null, '1AD', 'AD', 'FP'),
(null, '2AD', 'AD', 'FP');

-- importar profesores
LOAD DATA INFILE "C:/xampp/htdocs/idace/bd/tabla_profesores_22_23.csv" INTO TABLE 
idace.profesores
CHARACTER SET UTF8
FIELDS TERMINATED BY ';' optionally ENCLOSED BY '\"' LINES TERMINATED BY '\n'
IGNORE 1 LINES
(nombre, puesto, telefono, usuario, email);

-- actividades de muestra
INSERT INTO actividades VALUES 
(
	null, 
    1,
    '22/23',
    'Viaje Fin de curso 4ESO', 
    null, 
    '2023/03/15', 
    null, 
    null, 
    null, 
    false, 
    36, 
    1, 
    '4ESO', 
    null,
    'DACE', 
    null, 
    78, 
    'Pirineos Catalanes', 
    null, 
    null, 
    'Afectados', 
    'Pasarán a prestar servicio de guardia si procede', 
    null, 
    null, 
    'Viajes', 
    'Planificado', 
    1, 
    1, 
    'jmorjim394@gmail.com', 
    'Juan Carlos', 
    default, 
    default 
    );

