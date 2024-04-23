<?php

# Pendiente
// ValidateDepartamento()
// ValidateCoordinador()

class actividadesModel extends Model
{

    # Extraer todos los alumnos
    public function get()
    {

        try {
            # Plantilla
            $sql = "
                
                SELECT 
                a.id,
                a.num_actividad,
                a.titulo,
                a.fecha_inicio,
                a.hora_inicio,
                a.hora_fin,
                a.cursos,
                p.nombre,
                d.departamento,
                a.lugar_celebracion
            FROM
                idace.actividades a
                    INNER JOIN
                idace.profesores p ON a.coordinador_id = p.id
                    INNER JOIN
                idace.departamentos d ON a.departamento_id = d.id

                ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();


            # Ejecutamos mediante prepare la consulta SQL
            $result = $conexion->prepare($sql);
            $result->setFetchMode(PDO::FETCH_OBJ);
            $result->execute();

            return $result;
        } catch (PDOException $e) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    # Extraer los cursos 
    public function getCursos()
    {

        try {
            # Plantilla
            $sql = "
                
                    SELECT 
                            id,
                            curso,
                            nivel,
                            ciclo
                    FROM 
                            cursos
                    ORDER BY id
                ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();

            # ejecutar PREPARE
            $result = $conexion->prepare($sql);

            # establezco com quiero que devuelva el resultado
            $result->setFetchMode(PDO::FETCH_OBJ);

            # ejecuto
            $result->execute();

            return $result;
        } catch (PDOException $e) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    # Extraer los profesores 
    public function getProfesores()
    {

        try {
            # Plantilla
            $sql = "
                
                    SELECT 
                            id,
                            nombre profesor
                    FROM 
                            profesores
                    ORDER BY profesor

                ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();

            # ejecutar PREPARE
            $result = $conexion->prepare($sql);

            # establezco com quiero que devuelva el resultado
            $result->setFetchMode(PDO::FETCH_OBJ);

            # ejecuto
            $result->execute();

            return $result;
        } catch (PDOException $e) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    # Extraer los departamentos 
    public function getDepartamentos()
    {

        try {
            # Plantilla
            $sql = "
                
                    SELECT 
                            id,
                            departamento
                    FROM 
                            departamentos
                    ORDER BY departamento

                ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();

            # ejecutar PREPARE
            $result = $conexion->prepare($sql);

            # establezco com quiero que devuelva el resultado
            $result->setFetchMode(PDO::FETCH_OBJ);

            # ejecuto
            $result->execute();

            return $result;
        } catch (PDOException $e) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    # Extraer los departamentos 
    public function getCategorias()
    {

        try {
            # Plantilla
            $sql = "
                
                    SELECT 
                            id,
                            categoria
                    FROM 
                            categorias
                    ORDER BY categoria

                ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();

            # ejecutar PREPARE
            $result = $conexion->prepare($sql);

            # establezco com quiero que devuelva el resultado
            $result->setFetchMode(PDO::FETCH_OBJ);

            # ejecuto
            $result->execute();

            return $result;
        } catch (PDOException $e) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function create(Alumno $alumno)
    {

        try {

            $sql = "
                    INSERT INTO Alumnos (
                        nombre,
                        apellidos,
                        email,
                        poblacion,
                        dni,
                        fechaNac,
                        id_curso
                    )
                    VALUES (
                        :nombre,
                        :apellidos,
                        :email,
                        :poblacion,
                        :dni,
                        :fechaNac,
                        :id_curso
                    )
            ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();

            $pdoSt = $conexion->prepare($sql);

            $pdoSt->bindParam(':nombre', $alumno->nombre, PDO::PARAM_STR, 30);
            $pdoSt->bindParam(':apellidos', $alumno->apellidos, PDO::PARAM_STR, 50);
            $pdoSt->bindParam(':email', $alumno->email, PDO::PARAM_STR, 50);
            $pdoSt->bindParam(':poblacion', $alumno->poblacion, PDO::PARAM_STR, 30);
            $pdoSt->bindParam(':dni', $alumno->dni, PDO::PARAM_STR, 9);
            $pdoSt->bindParam(':fechaNac', $alumno->fechaNac);
            $pdoSt->bindParam(':id_curso', $alumno->id_curso, PDO::PARAM_INT);

            $pdoSt->execute();
        } catch (PDOException $e) {
            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function read($id)
    {

        try {
            $sql = "
                        SELECT 
                                id,
                                nombre, 
                                apellidos,
                                email,
                                poblacion,
                                dni,
                                fechaNac,
                                id_curso
                        FROM 
                                alumnos
                        WHERE
                                id = :id
                ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();


            $pdoSt = $conexion->prepare($sql);

            $pdoSt->bindParam(':id', $id, PDO::PARAM_INT);
            $pdoSt->setFetchMode(PDO::FETCH_OBJ);
            $pdoSt->execute();

            return $pdoSt->fetch();
        } catch (PDOException $e) {
            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function update(Alumno $alumno, $id)
    {

        try {

            $sql = "
                
                UPDATE alumnos
                SET
                        nombre = :nombre,
                        apellidos = :apellidos,
                        email = :email,
                        poblacion = :poblacion,
                        dni = :dni,
                        fechaNac = :fechaNac,
                        id_curso = :id_curso
                WHERE
                        id = :id
                LIMIT 1
                ";

            $conexion = $this->db->connect();

            $pdoSt = $conexion->prepare($sql);

            $pdoSt->bindParam(':id', $id, PDO::PARAM_INT);

            $pdoSt->bindParam(':nombre', $alumno->nombre, PDO::PARAM_STR, 30);
            $pdoSt->bindParam(':apellidos', $alumno->apellidos, PDO::PARAM_STR, 50);
            $pdoSt->bindParam(':email', $alumno->email, PDO::PARAM_STR, 50);
            $pdoSt->bindParam(':poblacion', $alumno->poblacion, PDO::PARAM_STR, 30);
            $pdoSt->bindParam(':dni', $alumno->dni, PDO::PARAM_STR, 9);
            $pdoSt->bindParam(':fechaNac', $alumno->fechaNac);
            $pdoSt->bindParam(':id_curso', $alumno->id_curso, PDO::PARAM_INT);

            $pdoSt->execute();
        } catch (PDOException $e) {
            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function delete($id)
    {

        try {
            $sql = "DELETE FROM alumnos WHERE id = :id limit 1";
            $conexion = $this->db->connect();
            $pdoSt = $conexion->prepare($sql);
            $pdoSt->bindParam(':id', $id, PDO::PARAM_INT);
            $pdoSt->execute();
        } catch (PDOException $error) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    # Extraer todos los alumnos
    public function order($criterio)
    {

        try {
            # Plantilla
            $sql = "
                
                    SELECT a.id,
                        a.nombre,
                        a.apellidos,
                        a.email,
                        a.poblacion,
                        a.fechaNac,
                        c.nombreCorto curso
                    FROM alumnos as a inner join cursos as c
                        ON a.id_curso = c.id
                    ORDER BY $criterio

                ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();


            # Ejecutamos mediante prepare la consulta SQL
            $result = $conexion->prepare($sql);
            $result->setFetchMode(PDO::FETCH_OBJ);
            $result->execute();

            return $result;
        } catch (PDOException $e) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function filter($expresion)
    {
        try {
            $sql = "
                
                SELECT a.id,
                       a.nombre,
                       a.apellidos,
                       a.email,
                       a.poblacion,
                       a.fechaNac,
                       c.nombreCorto curso
                FROM alumnos as a inner join cursos as c
                     ON a.id_curso = c.id
                WHERE 
                        CONCAT_WS(', ', 
                                  a.id,
                                  a.nombre,
                                  a.apellidos,
                                  a.poblacion,
                                  a.dni,
                                  TIMESTAMPDIFF(YEAR, a.fechaNac, now()),
                                  a.fechaNac,
                                  c.nombreCorto,
                                  c.nombre) 
                        like :expresion
                ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();

            $pdoSt = $conexion->prepare($sql);

            $pdoSt->bindValue(':expresion', '%' . $expresion . '%', PDO::PARAM_STR);
            $pdoSt->setFetchMode(PDO::FETCH_OBJ);
            $pdoSt->execute();
            return $pdoSt;
        } catch (PDOException $e) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function validateCoordinador($id_coordinador)
    {

        try {
            $sql = "
                    SELECT * FROM profesores
                    WHERE id = :id_coordinador
            ";

            # Conectamos con la base de datos
            $conexion = $this->db->connect();

            # Ejecutamos mediante prepare la consulta SQL
            $result = $conexion->prepare($sql);
            $result->bindParam(':id_coordinador', $id_coordinador, PDO::PARAM_INT);
            $result->execute();

            if ($result->rowCount() == 1)
                return TRUE;
            return FALSE;
        } catch (PDOException $e) {
            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function validateDepartamento($id_departamento)
    {

        try {
            $sql = "
                    SELECT * FROM departamentos
                    WHERE id = :id_departamento
            ";

            # Conectamos con la base de datos
            $conexion = $this->db->connect();

            # Ejecutamos mediante prepare la consulta SQL
            $result = $conexion->prepare($sql);
            $result->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
            $result->execute();

            if ($result->rowCount() == 1)
                return TRUE;
            return FALSE;
        } catch (PDOException $e) {
            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function validarDni($dni)
    {

        try {
            $sql = "
                    SELECT * FROM alumnos
                    WHERE dni = :dni
            ";

            # Conectamos con la base de datos
            $conexion = $this->db->connect();

            # Ejecutamos mediante prepare la consulta SQL
            $result = $conexion->prepare($sql);
            $result->bindParam(':dni', $dni, PDO::PARAM_STR);
            $result->execute();

            if ($result->rowCount() == 1)
                return FALSE;
            return TRUE;
        } catch (PDOException $e) {
            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function validarCurso($id_curso)
    {

        try {
            $sql = "
                    SELECT * FROM cursos
                    WHERE id = :id_curso
            ";

            # Conectamos con la base de datos
            $conexion = $this->db->connect();

            # Ejecutamos mediante prepare la consulta SQL
            $result = $conexion->prepare($sql);
            $result->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
            $result->execute();

            if ($result->rowCount() == 1)
                return TRUE;
            return FALSE;
        } catch (PDOException $e) {
            include_once('template/partials/errorDB.php');
            exit();
        }
    }
}
