<?php

# Pendiente
// ValidateDepartamento()
// ValidateCoordinador()

class actividadesModel extends Model
{

    # Extraer todos los actividads
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

    public function create(Actividad $actividad)
    {

        try {

            $sql = "
                    INSERT INTO Actividades (
                       num_actividad,
                       curso, 
                       titulo,
                       descripcion,
                       jornadas,
                       fecha_inicio,
                       fecha_fin,
                       hora_inicio,
                       hora_fin,
                       dia_completo,
                       horas_lectivas,
                       eval,
                       cursos,
                       observaciones_cursos_horas,
                       especialidad,
                       tramo_horario,
                       num_alumnos,
                       lugar_celebracion,
                       colaboracion_coordinador,
                       colaboracion_departamentos,
                       profesores_participantes,
                       que_hacen_afectados,
                       observaciones,
                       adjuntos,
                       categorias,
                       estado,
                       departamento_id,
                       coordinador_id,
                       email,
                       nombre,
                       user_id
                    )
                    VALUES (
                       :num_actividad,
                       :curso, 
                       :titulo,
                       :descripcion,
                       :jornadas,
                       :fecha_inicio,
                       :fecha_fin,
                       :hora_inicio,
                       :hora_fin,
                       :dia_completo,
                       :horas_lectivas,
                       :eval,
                       :cursos,
                       :observaciones_cursos_horas,
                       :especialidad,
                       :tramo_horario,
                       :num_alumnos,
                       :lugar_celebracion,
                       :colaboracion_coordinador,
                       :colaboracion_departamentos,
                       :profesores_participantes,
                       :que_hacen_afectados,
                       :observaciones,
                       :adjuntos,
                       :categorias,
                       :estado,
                       :departamento_id,
                       :coordinador_id,
                       :email,
                       :nombre,
                       :user_id
                    )
            ";

            # Conectar con la base de datos
            $conexion = $this->db->connect();

            $pdoSt = $conexion->prepare($sql);

            $pdoSt->bindParam(':num_actividad', $actividad->num_actividad, PDO::PARAM_INT);
            $pdoSt->bindParam(':curso', $actividad->curso, PDO::PARAM_STR, 5);
            $pdoSt->bindParam(':titulo', $actividad->titulo, PDO::PARAM_STR);
            $pdoSt->bindParam(':descripcion', $actividad->descripcion, PDO::PARAM_STR);
            $pdoSt->bindParam(':jornadas', $actividad->jornadas, PDO::PARAM_INT);
            $pdoSt->bindParam(':fecha_inicio', $actividad->fecha_inicio);
            $pdoSt->bindParam(':fecha_fin', $actividad->fecha_fin);
            $pdoSt->bindParam(':hora_inicio', $actividad->hora_inicio);
            $pdoSt->bindParam(':hora_fin', $actividad->hora_fin);
            $pdoSt->bindParam(':dia_completo', $actividad->dia_completo, PDO::PARAM_INT);
            $pdoSt->bindParam(':horas_lectivas', $actividad->horas_lectivas, PDO::PARAM_INT);
            $pdoSt->bindParam(':eval', $actividad->eval, PDO::PARAM_STR, 1);
            $pdoSt->bindParam(':cursos', implode('; ', $actividad->cursos), PDO::PARAM_STR, 255);
            $pdoSt->bindParam(':observaciones_cursos_horas', $actividad->observaciones_cursos_horas, PDO::PARAM_STR, 255);
            $pdoSt->bindParam(':especialidad', $actividad->especialidad, PDO::PARAM_STR, 50);
            $pdoSt->bindParam(':tramo_horario', implode('; ', $actividad->tramo_horario), PDO::PARAM_STR, 20);
            $pdoSt->bindParam(':num_alumnos', $actividad->num_alumnos, PDO::PARAM_INT);
            $pdoSt->bindParam(':lugar_celebracion', $actividad->lugar_celebracion, PDO::PARAM_STR, 100);
            $pdoSt->bindParam(':colaboracion_coordinador', $actividad->colaboracion_coordinador, PDO::PARAM_STR, 255);
            $pdoSt->bindParam(':colaboracion_departamentos', $actividad->colaboracion_departamentos, PDO::PARAM_STR, 255);
            $pdoSt->bindParam(':profesores_participantes', implode('; ', $actividad->profesores_participantes), PDO::PARAM_STR);
            $pdoSt->bindParam(':que_hacen_afectados', $actividad->que_hacen_afectados, PDO::PARAM_STR);
            $pdoSt->bindParam(':observaciones', $actividad->observaciones, PDO::PARAM_STR);
            $pdoSt->bindParam(':adjuntos', $actividad->adjuntos, PDO::PARAM_STR, 255);
            $pdoSt->bindParam(':categorias', $actividad->categorias, PDO::PARAM_STR, 255);
            $pdoSt->bindParam(':estado', $actividad->estado, PDO::PARAM_STR);
            $pdoSt->bindParam(':departamento_id', $actividad->departamento_id, PDO::PARAM_INT);
            $pdoSt->bindParam(':coordinador_id', $actividad->coordinador_id, PDO::PARAM_INT);
            $pdoSt->bindParam(':email', $actividad->email, PDO::PARAM_STR, 100);
            $pdoSt->bindParam(':nombre', $actividad->nombre, PDO::PARAM_STR, 100);
            $pdoSt->bindParam(':user_id', $actividad->user_id, PDO::PARAM_INT);
            # Insertar actividad    
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
                                curso,
                                titulo,
                                poblacion,
                                jornadas,
                                fechaNac,
                                id_curso
                        FROM 
                                actividads
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

    public function update(actividad $actividad, $id)
    {

        try {

            $sql = "
                
                UPDATE actividads
                SET
                        nombre = :nombre,
                        curso = :curso,
                        titulo = :titulo,
                        poblacion = :poblacion,
                        jornadas = :jornadas,
                        fechaNac = :fechaNac,
                        id_curso = :id_curso
                WHERE
                        id = :id
                LIMIT 1
                ";

            $conexion = $this->db->connect();

            $pdoSt = $conexion->prepare($sql);

            $pdoSt->bindParam(':id', $id, PDO::PARAM_INT);

            $pdoSt->bindParam(':nombre', $actividad->nombre, PDO::PARAM_STR, 30);
            $pdoSt->bindParam(':curso', $actividad->curso, PDO::PARAM_STR, 50);
            $pdoSt->bindParam(':titulo', $actividad->titulo, PDO::PARAM_STR, 50);
            $pdoSt->bindParam(':poblacion', $actividad->poblacion, PDO::PARAM_STR, 30);
            $pdoSt->bindParam(':jornadas', $actividad->jornadas, PDO::PARAM_STR, 9);
            $pdoSt->bindParam(':fechaNac', $actividad->fechaNac);
            $pdoSt->bindParam(':id_curso', $actividad->id_curso, PDO::PARAM_INT);

            $pdoSt->execute();
        } catch (PDOException $e) {
            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    public function delete($id)
    {

        try {
            $sql = "DELETE FROM actividads WHERE id = :id limit 1";
            $conexion = $this->db->connect();
            $pdoSt = $conexion->prepare($sql);
            $pdoSt->bindParam(':id', $id, PDO::PARAM_INT);
            $pdoSt->execute();
        } catch (PDOException $error) {

            include_once('template/partials/errorDB.php');
            exit();
        }
    }

    # Extraer todos los actividads
    public function order($criterio)
    {

        try {
            # Plantilla
            $sql = "
                
                    SELECT a.id,
                        a.nombre,
                        a.curso,
                        a.titulo,
                        a.poblacion,
                        a.fechaNac,
                        c.nombreCorto curso
                    FROM actividads as a inner join cursos as c
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
                       a.curso,
                       a.titulo,
                       a.poblacion,
                       a.fechaNac,
                       c.nombreCorto curso
                FROM actividads as a inner join cursos as c
                     ON a.id_curso = c.id
                WHERE 
                        CONCAT_WS(', ', 
                                  a.id,
                                  a.nombre,
                                  a.curso,
                                  a.poblacion,
                                  a.jornadas,
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

    public function validarjornadas($jornadas)
    {

        try {
            $sql = "
                    SELECT * FROM actividads
                    WHERE jornadas = :jornadas
            ";

            # Conectamos con la base de datos
            $conexion = $this->db->connect();

            # Ejecutamos mediante prepare la consulta SQL
            $result = $conexion->prepare($sql);
            $result->bindParam(':jornadas', $jornadas, PDO::PARAM_STR);
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
