<?php

class Actividades extends Controller
{

    function render()
    {

        # inicio o continuo sesión
        sec_session_start();

        # compruebo usuario autentificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario debe autentificarse";
            header("location:" . URL . "login");
        } else if ((!in_array($_SESSION['id_rol'], $GLOBALS['actividad']['main']))) {
            $_SESSION['mensaje'] = "Ha intentado realizar operación sin privilegios";
            header('location:' . URL . 'index');
        } else {

            # Comprueba si existe mensaje
            if (isset($_SESSION['mensaje'])) {
                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }

            // Mostrará todas las actividades
            $this->view->title = "Actividades";
            $this->view->actividades = $this->model->get();

            $this->view->render('actividades/main/index');

            # En la carpeta views tengo que crear la carpeta alumnos
            # Dentro de la carpeta alumnos creo main
            # En main creo index.php que corresponde a la vista que muestra los alumnos

        }
    }

    function nuevo()
    {

        # Iniciamos o continuamos sesión
        sec_session_start();

        # Compruebo usuario autentificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario debe autentificarse";

            header("location:" . URL . "login");
        } else if ((!in_array($_SESSION['id_rol'], $GLOBALS['actividad']['new']))) {
            $_SESSION['mensaje'] = "Operación sin privilegios";
            header("location:" . URL . "actividad");
        } else {

            # Crear objeto vacío de la clase actividad
            $this->view->actividad = new Actividad();

            # Compruebo si existe algún error en la validación
            if (isset($_SESSION['error'])) {

                # Mensaje de error
                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                # Autorrelleno del formulario
                $this->view->actividad = unserialize($_SESSION['actividad']);
                unset($_SESSION['actividad']);

                # Cargo los errores específicos
                $this->view->errores = $_SESSION['errores'];
                unset($_SESSION['errores']);
            }



            # título de la vista
            $this->view->title = "DACE - Formulario Planificación Actividades";

            # obtener los profesores generar dinámicamente combox de profesores
            $this->view->profesores = $this->model->getProfesores();

            $this->view->acompanantes = $this->model->getProfesores();

            # obtener los departamentos generar dinámicamente combox de departamentos
            $this->view->departamentos = $this->model->getDepartamentos();

            # obtener las categorías generar dinámicamente etiquetas de categorías
            $this->view->categorias = $this->model->getCategorias();

            # obtener los cursos
            $this->view->cursos = $this->model->getCursos();

            # cargar los campos por defecto nombre usuario y email
            $this->view->actividad->nombre = $_SESSION['name_user'];
            $this->view->actividad->email = $_SESSION['email_user'];


            # carge la vista nuevo formulario
            $this->view->render('actividades/nuevo/index');
        }
    }

    function create($param = [])
    {

        # inicio sesión
        sec_session_start();

        # Compruebo usuario autentificado
        if (!isset($_SESSION['id'])) {
            $_SESSION['mensaje'] = "Usuario debe autentificarse";
            header("location:" . URL . "login");
        } else if ((!in_array($_SESSION['id_rol'], $GLOBALS['actividad']['new']))) {
            $_SESSION['mensaje'] = "Operación sin privilegios";
            header("location:" . URL . "actividad");
        } else {


            # Validación Formularios
            # 1. Saneamos datos del formulario FILTER_SANITIZE
            $nombre = filter_var($_POST['nombre'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);
            $estado = filter_var($_POST['estado'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $titulo = filter_var($_POST['titulo'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $descripcion = filter_var($_POST['descripcion'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $lugar_celebracion = filter_var($_POST['lugar_celebracion'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $especialidad = filter_var($_POST['especialidad'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            # calendario

            $jornadas = filter_var($_POST['jornadas'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $fecha_inicio = filter_var($_POST['fecha_inicio'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_fin = filter_var($_POST['fecha_fin'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $eval = filter_var($_POST['eval'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            # horario
            $hora_inicio = filter_var($_POST['hora_inicio'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $hora_fin = filter_var($_POST['hora_fin'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tramo_horario = $_POST['tramo_horario'] ??= [];
            $dia_completo = filter_var($_POST['dia_completo'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $horas_lectivas = filter_var($_POST['horas_lectivas'] ??= '', FILTER_SANITIZE_NUMBER_FLOAT);


            # alumnos

            $cursos = $_POST['cursos'] ??= [];
            $num_alumnos = filter_var($_POST['num_alumnos'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $observaciones_cursos_horas = filter_var($_POST['observaciones_cursos_horas'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            # organización
            $coordinador_id = filter_var($_POST['coordinador_id'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $departamento_id = filter_var($_POST['departamento_id'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $profesores_participantes = $_POST['profesores_participantes'] ??= [];
            $que_hacen_afectados = filter_var($_POST['que_hacen_afectados'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $colaboracion_coordinador = filter_var($_POST['colaboracion_coordinador'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            # final
            $ficheros = $_FILES['files'] ??= [];
            $observaciones = filter_var($_POST['observaciones'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            # control para subida archivos
            $subir_archivos = false;

            # 2. Creamos el objeto alumno con los datos saneados
            $actividad = new Actividad(
                null,
                null,
                CURSO,
                $titulo,
                $descripcion,
                $jornadas,
                $fecha_inicio,
                $fecha_fin,
                $hora_inicio,
                $hora_fin,
                $dia_completo,
                $horas_lectivas,
                $eval,
                $cursos,
                $observaciones_cursos_horas,
                $especialidad,
                $tramo_horario,
                $num_alumnos,
                $lugar_celebracion,
                $colaboracion_coordinador,
                null,
                $profesores_participantes,
                $que_hacen_afectados,
                $observaciones,
                null,
                null,
                $estado,
                $departamento_id,
                $coordinador_id,
                $email,
                $nombre,
                $_SESSION['id']
            );

            # 3. Validación de los datos

            $errores = [];

            // Validamos nombre
            // - Valor obligatorio
            if (empty($nombre)) {
                $errores['nombre'] = 'Campo obligatorio';
            }

            // Validamos email
            // - Verificar obligatorio, formato email válido
            if (empty($email)) {
                $errores['email'] = 'Campo obligatorio';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores['email'] = 'Email incorrecto';
            }

            // Validación del título
            // - campo obligatorio
            if (empty($titulo)) {
                $errores['titulo'] = 'Campo obligatorio';
            }

            // Validación de la descripción
            // - campo obligatorio
            if (empty($descripcion)) {
                $errores['descripcion'] = 'Es necesario especificar una descripción corta de la actividad';
            }

            // Validación del lugar celebración
            // - campo obligatorio
            if (empty($lugar_celebracion)) {
                $errores['lugar_celebracion'] = 'Campo obligatorio';
            }

            // Validación de la especialidad
            // - campo no obligatorio


            // Validación jornadas
            // - campo obligatorio
            if (empty($jornadas)) {
                $errores['jornadas'] = 'Campo obligatorio';
            } else if (!filter_var($jornadas, FILTER_VALIDATE_INT)) {
                $errores['jornadas'] = 'Introducir número entero';
            }

            // Validamos fecha inicio
            // - Campo obligatorio
            if (empty($fecha_inicio)) {
                $errores['fecha_inicio'] = 'Campo obligatorio';
            }

            // Validamos fecha fin
            // - Campo no obligatorio

            // Validamos eval (trimestre en la que se celebra la actividad)
            // - Campo obligatorio
            if (empty($eval)) {
                $errores['eval'] = 'Campo obligatorio';
            } else if (!in_array($eval, [1, 2, 3])) {
                $errores['eval'] = 'Seleccione trimestre válido';
            }

            // Validación horarios
            // - hora_inicio
            // - hora_fin
            // - tramo_horario
            // - horas_lectivas
            if (empty($horas_lectivas)) {
                $errores['horas_lectivas'] = 'Campo obligatorio';
            } else if (!filter_var($horas_lectivas, FILTER_VALIDATE_INT)) {
                $errores['horas_lectivas'] = 'Puedes introducir número con 1 posición decimal';
            }

            // Validación cursos
            // - campo no obligatorio

            // Validacion observaciones_cursos_horas
            // - campo no obligatorio

            // Validación num_alumnos
            // - campo obligatorio
            // - campo entero
            if (empty($jornadas)) {
                $errores['num_alumnos'] = 'Campo obligatorio';
            } else if (!filter_var($num_alumnos, FILTER_VALIDATE_INT)) {
                $errores['num_alumnos'] = 'Introducir número entero';
            }

            // Validación coordinador_id
            // - campo obligatorio
            // - valor válido relacionado con la tabla profesores
            if (empty($coordinador_id)) {
                $errores['coordinador_id'] = 'Debe seleccionar un coordinador';
            } else if (!filter_var($coordinador_id, FILTER_VALIDATE_INT)) {
                $errores['coordinador_id'] = 'Coordinador no válido';
            } else if (!$this->model->validateCoordinador($coordinador_id)) {
                $errores['coordinador_id'] = 'Seleccionar un coordinador válido';
            }

            // Validación departamento_id
            // - campo obligatorio
            // - valor válido relacionado con la tabla departamentos
            if (empty($departamento_id)) {
                $errores['departamento_id'] = 'Debe seleccionar un departamento';
            } else if (!filter_var($departamento_id, FILTER_VALIDATE_INT)) {
                $errores['departamento_id'] = 'Departamento no válido';
            } else if (!$this->model->validateDepartamento($departamento_id)) {
                $errores['departamento_id'] = 'Seleccionar un departamento válido';
            }

            // Validación profesores_participantes
            // - campo opcional

            // Validación que_hacen_afectados
            // - campo opcional

            // Validación colaboracion_coordinador
            // - campo opcional

            // Validación observaciones
            // - campo opcional

            // Validación files
            // - campo opcional
            // - tipos ficheros admitidos: 
            //    - Imagen: jpg, jpeg, png, gif
            //    - Pdf
            //    - Texto: 

            # genero array de error de fichero
            $FileUploadErrors = array(
                0 => 'No hay error, fichero subido con éxito.',
                1 => 'El fichero subido excede la directiva upload_max_filesize de php.ini.',
                2 => 'El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTML.',
                3 => 'El fichero fue sólo parcialmente subido.',
                4 => 'No se subió ningún fichero.',
                6 => 'Falta la carpeta temporal.',
                7 => 'No se pudo escribir el fichero en el disco.',
                8 => 'Una extensión de PHP detuvo la subida de ficheros.',
            );

            if (!empty($ficheros['name'][0])) {

                # Validar número de archivos subidos

                # Validar todos los archivos
                foreach ($ficheros['name'] as $index => $nombreArchivo) {
                    # control de subida de archivos
                    $this->subir_archivos = false;

                    # Comprobar si hay errores
                    if ($ficheros['error'][$index] !== UPLOAD_ERR_OK) {
                        $errores['files'] = $FileUploadErrors[$ficheros['error'][$index]];
                        break;
                    } else {
                        # Validar el tamaño máximo
                        $maxSize = 2 * 1024 * 1024; // 2 MB
                        if ($ficheros['size'][$index] > $maxSize) {
                            $errores['files'] = "El tamaño excede de 2MB.";
                            break;
                        }

                        # Validar el tipo de archivo
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx'];
                        $fileInfo = new SplFileInfo($nombreArchivo);
                        $extension = $fileInfo->getExtension();

                        if (!in_array(strtolower($extension), $allowedExtensions)) {
                            $errores['files'] = "Tipos de archivos válidos JPG, JPEG, PNG, PDF";
                            break;
                        }
                        # activo control subida archivos
                        $subir_archivos = true;
                    }
                }
            }

            # 4. Comprobar validación

            if (!empty($errores)) {

                # Debug
                //print_r($errores);
                //exit();

                // Si $errores no está vacio el formulario no ha sido validado
                $_SESSION['actividad'] = serialize($actividad);
                $_SESSION['error'] = 'Debe repasar el formulario, NO HA SIDO VALIDADO';
                $_SESSION['errores'] = $errores;

                # Redireccionamos a nuevo alumno

                header('location:' . URL . 'actividades/nuevo');
            } else {

                # Mostrar actividad prueba
                // var_dump($actividad);
                // exit();

                # Crear actividad
                # Devuelve el id de la actividad creada, en caso decincluir archivos
                # se creará una carpeta con dicho id 
                $carpeta = $this->model->create($actividad);

                # Compruebo subida de archivos
                if ($subir_archivos) {
                    
                    echo 'subo_archivos';

                    # carpeta destino
                    $carpeta_destino = 'ficheros/'.$carpeta;


                    if (!is_dir($carpeta_destino)) {
                        if (!mkdir($carpeta_destino, 0755, true)) {
                            echo "Lo siento, no se pudo crear la carpeta de destino.";
                            $uploadOk = 0;
                        }
                    }

                    # Muevo todos los archivos desde la carpeta tempora a la destino
                    foreach ($ficheros['name'] as $index => $nombreArchivo) {
                        move_uploaded_file($ficheros['tmp_name'][$index], $carpeta_destino . '/' . $nombreArchivo);
                    }
                }

                # Crear mensaje
                $_SESSION['mensaje'] = 'Actividad creada correctamente';

                # Redireccionamos 
                header('location:' . URL . 'actividades');
            }
        }
    }
}
