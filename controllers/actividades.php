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
            $hora_inicio = filter_var($_POST['hora_incio'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $hora_fin = filter_var($_POST['hora_fin'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tramo_horario = filter_var($_POST['tramo_horario'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $dia_completo = filter_var($_POST['dia_completo'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $horas_lectivas = filter_var($_POST['horas_lectivas'] ??= '', FILTER_SANITIZE_NUMBER_FLOAT);


            # alumnos

            $cursos = filter_var($_POST['cursos'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $num_alumnos = filter_var($_POST['num_alumnos'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $observaciones_cursos_horas = filter_var($_POST['observaciones_cursos_horas'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            # organización
            $coordinador_id = filter_var($_POST['coordinador_id'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $departamento_id = filter_var($_POST['departamento_id'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $profesores_participantes = filter_var($_POST['profesores_participantes'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $que_hacen_afectados = filter_var($_POST['que_hacen_afectados'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $colaboracion_coordinador = filter_var($_POST['colaboracion_coordinador'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            # final

            $observaciones = filter_var($_POST['observaciones'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            # 2. Creamos el objeto alumno con los datos saneados
            $new_actividad = new Actividad(
                null,
                null,
                '23/24',
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
                'planificado',
                $departamento_id,
                $coordinador_id,
                $email,
                $nombre
            );

            var_dump($new_actividad);
            exit();

            # 3. Validación de los datos

            $errores = [];

            // Validación del título
            // - campo obligatorio
            if (empty($titulo)) {
                $errores['titulo'] = 'Campo obligatorio';
            }

            // Validamos nombre
            // Valor obligatorio
            if (empty($nombre)) {
                $errores['nombre'] = 'Campo obligatorio';
            }

            // Validamos apellidos
            // Valor obligatorio
            if (empty($apellidos)) {
                $errores['apellidos'] = 'Campo obligatorio';
            }

            // Validamos población
            // Campo opcional

            // Validamos email
            // Verificar obligatorio, email, único
            if (empty($email)) {
                $errores['email'] = 'Campo obligatorio';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores['email'] = 'Email incorrecto';
            } else if (!$this->model->validarEmail($email)) {
                $errores['email'] = 'Email registrado';
            }

            // Validamos fecha nacimiento
            // Campo obligatorio
            if (empty($fechaNac)) {
                $errores['fechaNac'] = 'Campo obligatorio';
            }

            // Validamos dni
            // Verificar obligatorio, formato dni, único
            $options = [
                'options' => [
                    'regexp' => '/^(\d{8})([A-Z])$/'
                ]
            ];
            if (empty($dni)) {
                $errores['dni'] = 'Campo obligatorio';
            } else if (!filter_var($dni, FILTER_VALIDATE_REGEXP, $options)) {
                $errores['dni'] = 'DNI con formato incorrecto';
            } else if (!$this->model->validarDNI($dni)) {
                $errores['dni'] = 'DNI ya ha sido registrado';
            }

            // Validamos id_curso
            // Verificar obligatorio, entero, existe
            if (empty($id_curso)) {
                $errores['id_curso'] = 'Campo obligatorio';
            } else if (!filter_var($id_curso, FILTER_VALIDATE_INT)) {
                $errores['id_curso'] = 'Curso no válido';
            } else if (!$this->model->validarCurso($id_curso)) {
                $errores['id_curso'] = 'Curso no existe';
            }

            # 4. Comprobar validación

            if (!empty($errores)) {

                # Debug
                //print_r($errores);
                //exit();

                // Si $errores no está vacio el formulario no ha sido validado
                $_SESSION['alumno'] = serialize($new_alumno);
                $_SESSION['error'] = 'Formulario no ha sido validado';
                $_SESSION['errores'] = $errores;

                # Redireccionamos a nuevo alumno

                header('location:' . URL . 'alumnos/nuevo');
            } else {

                # Crear alumno
                $this->model->create($new_alumno);

                # Crear mensaje
                $_SESSION['mensaje'] = 'Alumno creado correctamente';

                # Redireccionamos 
                header('location:' . URL . 'alumnos');
            }
        }
    }

    /*
         function new() {

            # Iniciar o continuar sesión segura
            sec_session_start();

            # Inicializo los valores del formulario
            $this->view->actividad = new Actividad();

            # Control de los mensajes
            if (isset($_SESSION['mensaje'])) {

                $this->view->mensaje = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);

            }

            # Control de errores
            if (isset($_SESSION['error'])) {

                $this->view->error = $_SESSION['error'];
                unset($_SESSION['error']);

                # Autocompleto los valores del formulario
                $this->view->actividad = unserialize($_SESSION['actividad']);
                unset($_SESSION['actividad']);

                # Tipo de error
                $this->view->errores = $_SESSION['errores'];
                unset($_SESSION['errores']);

            }

            $this->view->render('aut/login/index');
        }

        # 
        # Validación actividad
        #
         function create() {

            # Inicio o reanudación de sessión
            sec_session_start();

            # Saneamos el formulario
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
	        $password = filter_var($_POST['password'],FILTER_SANITIZE_SPECIAL_CHARS);

            # Validaciones

            $errores = array();

            #obtengo el usuario a partir del email
	        $user = $this->model->getUserEmail($email);

            if ($user === false) {

                $errores['email'] = "Email no ha sido registrado";
                $_SESSION['errores'] = $errores;
                
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                
                $_SESSION['error'] = "Fallo en la Autentificación";

                header("location:". URL. "login"); 
                
            } else if (!password_verify($password,$user->password)) {

                $errores['password'] = "Password no es correcto";
                $_SESSION['errores'] = $errores;

                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;

                $_SESSION['error'] = "Fallo en la Autentificación";

                header("location:". URL. "login"); 
                
            } else {
                
                # Autentificación completada

                # Borramos todas las variables de sesión
                session_unset();

                # Destruimos cookie sesión
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                    );
                }

                # Destruimos la sesión
                sec_session_destroy();

                # Iniciamos sesión segura
                sec_session_start();
                
                $_SESSION['id'] = $user->id; 
                $_SESSION['name_user'] = $user->name;
                $_SESSION['id_rol'] = $this->model->getUserIdPerfil($user->id);
                $_SESSION['name_rol'] = $this->model->getUserPerfil($_SESSION['id_rol']);

                $_SESSION['mensaje'] = "Usuario ". $user->name. " ha iniciado sesión" ;
                
                header("location:". URL. "alumnos");
            }


        }
        */
}
