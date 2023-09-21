<?php

    class Actividades Extends Controller {

        public function render() {

            # inicio o continuo sesión
            sec_session_start();

            # compruebo usuario autentificado
            if (!isset($_SESSION['id'])) {
                $_SESSION['mensaje'] = "Usuario debe autentificarse";
                
                header("location:". URL. "login");
                
            } else {

                # Comprueba si existe mensaje
                if (isset($_SESSION['mensaje'])) {
                    $this->view->mensaje = $_SESSION['mensaje'];
                    unset($_SESSION['mensaje']);
                }

                // Mostrará todas las actividades
                $this->view->title="Actividades";
                $this->view->actividades = $this->model->get();
                
                $this->view->render('actividades/main/index');

                # En la carpeta views tengo que crear la carpeta alumnos
                # Dentro de la carpeta alumnos creo main
                # En main creo index.php que corresponde a la vista que muestra los alumnos

            }

            
        }

        public function nuevo() {

            # Iniciamos o continuamos sesión
            sec_session_start();

            # Compruebo usuario autentificado
            if (!isset($_SESSION['id'])) {
                $_SESSION['mensaje'] = "Usuario debe autentificarse";
                
                header("location:". URL. "login");
                
            } else if ((!in_array($_SESSION['id_rol'], $GLOBALS['crear']))){

                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" .URL. "alumnos");

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

                # carge la vista nuevo formulario
                $this->view->render('actividades/nuevo/index');

            }

        }

        public function create($param = []) {

            # inicio sesión
            sec_session_start();

            # Compruebo usuario autentificado
            if (!isset($_SESSION['id'])) {
                $_SESSION['mensaje'] = "Usuario debe autentificarse";
                
                header("location:". URL. "login");
                
            } else if ((!in_array($_SESSION['id_rol'], $GLOBALS['crear']))){

                $_SESSION['mensaje'] = "Operación sin privilegios";
                header("location:" .URL. "alumnos");

            } else {


            # Validación Formularios
            # 1. Saneamos datos del formulario FILTER_SANITIZE
            $nombre = filter_var($_POST['nombre'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'] ??= '', FILTER_SANITIZE_EMAIL);
            $titulo = filter_var($_POST['titulo'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $descripcion = filter_var($_POST['descripcion'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $lugar_celebracion = filter_var($_POST['lugar_celebracion'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $especialidad = filter_var($_POST['especialidad'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $jornadas = filter_var($_POST['jornadas'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            $fecha_inicio = filter_var($_POST['fecha_inicio'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_fin = filter_var($_POST['fecha_fin'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $hora_inicio = filter_var($_POST['hora_incio'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $hora_fin = filter_var($_POST['hora_fin'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);

            $tramo_horario = $_POST['tramo_horario'];

            $fechaNac = filter_var($_POST['fechaNac'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $poblacion = filter_var($_POST['poblacion'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $dni = filter_var($_POST['dni'] ??= '', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_curso = filter_var($_POST['id_curso'] ??= '', FILTER_SANITIZE_NUMBER_INT);
            
            # 2. Creamos el objeto alumno con los datos saneados
            $new_alumno = new Alumno(
                null,
                $nombre,
                $apellidos,
                $email,
                null,
                null,
                $poblacion,
                null,
                null, 
                $dni,      
                $fechaNac,
                $id_curso
            );

            # 3. Validación de los datos
            
            $errores = [];

            // Validamos nombre
            // Valor obligatorio
            if(empty($nombre)) {
                $errores['nombre'] = 'Campo obligatorio';
            } 

            // Validamos apellidos
            // Valor obligatorio
            if(empty($apellidos)) {
                $errores['apellidos'] = 'Campo obligatorio';
            }

            // Validamos población
            // Campo opcional

            // Validamos email
            // Verificar obligatorio, email, único
            if(empty($email)) {
                $errores['email'] = 'Campo obligatorio';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores['email'] = 'Email incorrecto';
            } else if (!$this->model->validarEmail($email)) {
                $errores['email'] = 'Email registrado';
            }

            // Validamos fecha nacimiento
            // Campo obligatorio
            if(empty($fechaNac)) {
                $errores['fechaNac'] = 'Campo obligatorio';
            }

            // Validamos dni
            // Verificar obligatorio, formato dni, único
            $options = [
                'options' => [
                    'regexp' => '/^(\d{8})([A-Z])$/'
                ]
            ];
            if(empty($dni)) {
                $errores['dni'] = 'Campo obligatorio';
            } else if (!filter_var($dni, FILTER_VALIDATE_REGEXP, $options)) {
                $errores['dni'] = 'DNI con formato incorrecto';
            } else if (!$this->model->validarDNI($dni)) {
                $errores['dni'] = 'DNI ya ha sido registrado';
            }

            // Validamos id_curso
            // Verificar obligatorio, entero, existe
            if(empty($id_curso)) {
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

                header('location:'. URL. 'alumnos/nuevo');
            } else {

                # Crear alumno
                $this->model->create($new_alumno);

                # Crear mensaje
                $_SESSION['mensaje'] = 'Alumno creado correctamente';

                # Redireccionamos 
                header('location:'.URL.'alumnos');
            }
        
        }


        }
        
        /*
        public function new() {

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
        public function create() {

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

?>