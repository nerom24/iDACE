LOAD DATA INFILE "C:/Users/Juan Carlos/Downloads/tabla_profesores_22_23.csv" INTO TABLE 
idace.profesores
CHARACTER SET UTF8
FIELDS TERMINATED BY ';' optionally ENCLOSED BY '\"' LINES TERMINATED BY '\n'
IGNORE 1 LINES
(nombre, puesto, telefono, usuario, email);

LOAD DATA INFILE "C:/xampp/htdocs/idace/bd/tabla_profesores_22_23.csv" INTO TABLE 
idace.profesores
CHARACTER SET UTF8
FIELDS TERMINATED BY ';' optionally ENCLOSED BY '\"' LINES TERMINATED BY '\n'
IGNORE 1 LINES
(nombre, puesto, telefono, usuario, email);

