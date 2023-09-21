<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("template/partials/head.php");?>
    <title><?= $this->title ?></title>
</head>
<body>
    <!-- # Menú Principal fijo arriba -->
    <?php require_once("template/partials/menu.php") ?>
    
    <!-- Capa Principal -->
    <div class="container">
        <br><br>

        <!-- Encabezado proyecto -->
        

        <!-- Comprobamos si existe algún error -->
        <?php require_once("template/partials/error.php") ?>

        <!-- Menú actividads no hace falta -->
        <form action="<?= URL ?>actividades/create" method="POST" enctype="multipart/form-data">
                <legend>Formulario de Planificación de Actividades</legend>
                <!-- nombre -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-control <?= (isset($this->errores['nombre']))? 'is-invalid': null ?>" name="nombre" value="<?= $this->actividad->nombre ?>">
                    <!-- Mostrar posible error -->
                    <?php if (isset($this->errores['nombre'])): ?>
                        <span class="form-text text-danger" role="alert">
                            <?= $this->errores['nombre'] ?>
                        </span>
                    <?php endif; ?>
                </div>
                <!-- email -->
                <div class="mb-3">
                    <label for="" class="form-label">Email Corporativo *</label>
                    <input type="email" class="form-control <?= (isset($this->errores['email']))? 'is-invalid': null ?>" name="email" aria-describedby="emailHelpId" value="<?= $this->actividad->email ?>">
                    <!-- Mostrar posible error -->
                    <?php if (isset($this->errores['email'])): ?>
                        <span class="form-text text-danger" role="alert">
                            <?= $this->errores['email'] ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Sección Detalles de la actividad -->
                <div class="card">
                    <div class="card-header">
                        Detalles de la Actividad
                    </div>
                    <div class="card-body">

                        <!-- titulo -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control <?= (isset($this->errores['titulo']))? 'is-invalid': null ?>" name="titulo" value="<?= $this->actividad->titulo ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['titulo'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['titulo'] ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <!-- descripcion -->
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Descripción</label>
                            <textarea class="form-control <?= (isset($this->errores['descripcion']))? 'is-invalid': null ?>" id="exampleFormControlTextarea1" rows="3" ><?= $this->actividad->descripcion ?></textarea>
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['descripcion'])): ?>
                                    <span class="form-text text-danger" role="alert">
                                        <?= $this->errores['descripcion'] ?>
                                    </span>
                            <?php endif; ?>    
                        </div>

                        <!-- lugar celebración -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Lugar Celebración</label>
                            <input type="text" class="form-control <?= (isset($this->errores['lugar_celebracion']))? 'is-invalid': null ?>" name="lugar_celebracion" value="<?= $this->actividad->lugar_celebracion ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['lugar_celebracion'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['lugar_celebracion'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- especialidad -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Especialidad</label>
                            <input type="text" class="form-control <?= (isset($this->errores['especialidad']))? 'is-invalid': null ?>" name="especialidad" value="<?= $this->actividad->especialidad ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['especialidad'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['especialidad'] ?>
                                </span>
                            <?php endif; ?>
                        </div>
                           
                    </div>
                </div>
                <br>
                
                <!-- Sección Calendario -->
                <div class="card">
                    <div class="card-header">
                        Calendario
                    </div>
                    <div class="card-body">

                        <!-- jornadas -->
                        <div class="mb-3">
                            <label for="jornadas" class="form-label">Jornadas *</label>
                            <input type="number" class="form-control <?= (isset($this->errores['jornadas']))? 'is-invalid': null ?>" name="jornadas" value="<?= $this->actividad->jornadas ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['jornadas'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['jornadas'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- fecha -->
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha *</label>
                            <input type="date" class="form-control <?= (isset($this->errores['fecha_inicio']))? 'is-invalid': null ?>" name="fecha_inicio" value="<?= $this->actividad->fecha_inicio ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['fecha_inicio'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['fecha_inicio'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- fecha fin-->
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Finalización</label>
                            <input type="date" class="form-control <?= (isset($this->errores['fecha_fin']))? 'is-invalid': null ?>" name="fecha_fin" value="<?= $this->actividad->fecha_fin ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['fecha_fin'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['fecha_fin'] ?>
                                </span>
                            <?php endif; ?>
                            <div class="form-text">
                                    Sólo para actividades de varias jornadas
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                
                <!-- Sección Horarios -->
                <div class="card">
                    <div class="card-header">
                        Horarios
                    </div>
                    <div class="card-body">

                        <!-- hora de inicio-->
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de inicio</label>
                            <input type="time" class="form-control <?= (isset($this->errores['hora_inicio']))? 'is-invalid': null ?>" name="hora_inicio" value="<?= $this->actividad->hora_inicio ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['hora_inicio'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['hora_inicio'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- hora de fin -->
                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Horarios</label>
                            <input type="time" class="form-control <?= (isset($this->errores['hora_fin']))? 'is-invalid': null ?>" name="hora_inicio" value="<?= $this->actividad->hora_inicio ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['hora_fin'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['hora_fin'] ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <!-- tramo horario -->
                        <div class="mb-3">
                            <label for="cursos" class="form-label">Tramo Horario</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <td scope="col"></td>
                                    <td scope="col">1ª</td>
                                    <td scope="col">2ª</td>
                                    <td scope="col">3ª</td>
                                    <td scope="col">Recreo</td>
                                    <td scope="col">4ª</td>
                                    <td scope="col">5ª</td>
                                    <td scope="col">6ª</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td scope="col">Horas</td>
                                    <?php for ($i=1;$i<=7;$i++): ?>
                                        <td>
                                        <input class="form-check-input" type="checkbox" value="<?= $i ?>" id="flexCheckDefault" name="tramo_horario[]" >
                                        </td>
                                    <?php endfor; ?>
                                    </tr>
                                    <tr>
                                    <td scope="col">Día Completo</td>
                                    <td colspan="7">
                                    <input  class="form-check-input" type="checkbox" value="<?= $this->actividad->dia_completo ?>" id="flexCheckDefault" name="dia_completo" colspan=6>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br>
                
                <!-- sección alumnos -->
                <div class="card">
                    <div class="card-header">
                        Alumnado
                    </div>
                    <div class="card-body">
                        
                        <!-- cursos -->
                        <div class="mb-3">
                            <label for="cursos" class="form-label">Cursos</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">Nivel Completo</th>
                                    <th scope="col">Grupos A</th>
                                    <th scope="col">Grupos B</th>
                                    <th scope="col">Grupos C</th>
                                    <th scope="col">Grupos D</th>
                                
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nivel_a = NULL;?>
                                    <tr>
                                    <?php 

                                        // Muestra los niveles y cursos en una tabla
                                        foreach ($this->cursos as $curso): 

                                            if ($nivel_a == $curso->nivel): ?>
                                                <td>
                                                    <input class="form-check-input" type="checkbox" value="<?= $curso->curso ?>" id="flexCheckDefault" name="cursos[]" >
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?= $curso->curso ?>
                                                    </label>
                                                </td>

                                            <?php else: ?>
                                                </tr><tr>
                                                <td>
                                                    <input class="form-check-input" type="checkbox" value="<?= $curso->nivel ?>" id="flexCheckDefault" name="cursos[]" >
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?= $curso->nivel ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <input class="form-check-input" type="checkbox" value="<?= $curso->curso ?>" id="flexCheckDefault" name="cursos[]" >
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?= $curso->curso ?>
                                                    </label>
                                                </td>
                                            <?php 
                                                $nivel_a = $curso->nivel;
                                            endif;
                                        endforeach;
                                    
                                    ?>  
                                </tbody>
                            </table>
                        </div>

                        <!-- número de alumnos -->
                        <div class="mb-3">
                            <label for="num_alumnos" class="form-label">Número Alumnos (Aprox)</label>
                            <input type="number" class="form-control <?= (isset($this->errores['num_alumnos']))? 'is-invalid': null ?>" name="num_alumnos" value="<?= $this->actividad->num_alumnos ?>">
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['num_alumnos'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['num_alumnos'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- observaciones cursos horario -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Observaciones Cursos Tramo Horario</label>
                            <textarea class="form-control <?= (isset($this->errores['observaciones_cursos_horas']))? 'is-invalid': null ?>" id="exampleFormControlTextarea1" rows="2" ><?= $this->actividad->observaciones_cursos_horas ?></textarea>
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['observaciones_cursos_horas'])): ?>
                                    <span class="form-text text-danger" role="alert">
                                        <?= $this->errores['observaciones_cursos_horas'] ?>
                                    </span>
                            <?php endif; ?>    
                        </div>
                    </div>
                </div>
                <br>
                
                <!-- sección organización -->
                <div class="card">
                    <div class="card-header">
                        Organización
                    </div>
                    <div class="card-body">

                        <!-- coordinador -->
                        <div class="mb-3">
                            <label for="" class="form-label">Coordinación</label>
                            <select class="form-select form-select-lg <?= (isset($this->errores['coordinador_id']))? 'is-invalid': null ?>" name="coordinador_id">
                                <option selected disabled>Seleccine Coordinador/a</option>
                                <?php foreach ($this->profesores as $profesor): ?>
                                    <option value="<?= $profesor->id ?>"
                                    <?= ($this->actividad->coordinador_id == $profesor->id)? 'selected' : null ?>
                                    ><?= $profesor->profesor ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['coordinador_id'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['coordinador_id'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- departamento -->
                        <div class="mb-3">
                            <label for="" class="form-label">Departamento</label>
                            <select class="form-select form-select-lg <?= (isset($this->errores['departamento_id']))? 'is-invalid': null ?>" name="departamento_id">
                                <option selected disabled>Seleccine Departamento</option>
                                <?php foreach ($this->departamentos as $departamento): ?>
                                    <option value="<?= $departamento->id ?>"
                                    <?= ($this->actividad->departamento_id == $departamento->id)? 'selected' : null ?>
                                    ><?= $departamento->departamento ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['departamento_id'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['departamento_id'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- profesores participantes -->
                        <div class="mb-3">
                            <label for="cursos" class="form-label">Profesores Participantes</label>
                            <table class="table">
                                <tbody><tr>
                                    <?php 
                                        // Muestra lista profesores participantes
                                        $columna = 1;
                                        foreach ($this->acompanantes as $profesor): ?>

                                                
                                                <td>
                                                    <input class="form-check-input" type="checkbox" value="<?= $profesor->id ?>" id="flexCheckDefault" name="participantes[]" >
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <?= $profesor->profesor ?>
                                                    </label>
                                                </td>
                                                
                                                
                                        <?php $columna++;
                                            if ($columna == 4) {
                                                echo "</tr><tr>";
                                                $columna = 1;
                                            }
                                    
                                    endforeach; ?>
                                    
                                </tr></tbody>
                            </table>
                        </div>

                        <!-- profesores afectados -->
                        <div class="mb-3">
                            <label for="" class="form-label">Profesores Afectados</label>
                            <select class="form-select form-select-lg <?= (isset($this->errores['que_hacen_afectados']))? 'is-invalid': null ?>" name="que_hacen_afectados">
                                <option selected disabled>Seleccine Qué Hacen Profesores Afectados</option>
                                
                                    <option value="1"
                                    <?= ($this->actividad->que_hacen_afectados == 1)? 'selected' : null ?>
                                    >Acompañan a los alumnos en la actividad</option>

                                    <option value="2"
                                    <?= ($this->actividad->que_hacen_afectados == 2)? 'selected' : null ?>
                                    >Pasan a prestar servicio de guardia</option>

                                    <option value="3"
                                    <?= ($this->actividad->que_hacen_afectados == 3)? 'selected' : null ?>
                                    >Imparten clase al resto de alumnos, si procede</option>
                                    
                                    <option value="4"
                                    <?= ($this->actividad->que_hacen_afectados == 4)? 'selected' : null ?>
                                    >Sin especificar</option>
                            </select>

                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['que_hacen_afectados'])): ?>
                                <span class="form-text text-danger" role="alert">
                                    <?= $this->errores['que_hacen_afectados'] ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- colaboraciones -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Observaciones y Colaboraciones</label>
                            <textarea class="form-control <?= (isset($this->errores['colaboracion_coordinador']))? 'is-invalid': null ?>" id="exampleFormControlTextarea1" rows="2" ><?= $this->actividad->colaboracion_coordinador ?></textarea>
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['colaboracion_coordinador'])): ?>
                                    <span class="form-text text-danger" role="alert">
                                        <?= $this->errores['colaboracion_coordinador'] ?>
                                    </span>
                            <?php endif; ?>    
                        </div>
                    </div>
                </div>

                <!-- sección organización -->
                <br>
                <div class="card">
                    <div class="card-header">
                        Información General y Adjuntos
                    </div>
                    <div class="card-body">

                        <!-- Adjuntar Archivos -->
                        <div class="mb-3">
                        <label for="formFile" class="form-label">Adjuntar Archivos</label>
                        <input class="form-control" type="file" id="formFile" name="files[]" multiple>
                        </div>

                        <!-- observaciones actividades -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Observaciones Generales</label>
                            <textarea class="form-control <?= (isset($this->errores['observaciones']))? 'is-invalid': null ?>" id="exampleFormControlTextarea1" rows="2" ><?= $this->actividad->observaciones?></textarea>
                            <!-- Mostrar posible error -->
                            <?php if (isset($this->errores['observaciones'])): ?>
                                    <span class="form-text text-danger" role="alert">
                                        <?= $this->errores['observaciones'] ?>
                                    </span>
                            <?php endif; ?>    
                        </div>

                        
                    </div>
                </div>
                <br>

                
                <!-- Botones de acción -->
                <a class="btn btn-secondary" href="<?= URL ?>actividads" role="button">Cancelar</a>
                <button type="reset" class="btn btn-danger">Borrar</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
        
      </form>
    </div>
    <br><br><br>

    <!-- Pie del documento -->
    <?php include("template/partials/footer.php");?>

    <!-- Bootstrap Javascript y popper -->
    <?php include("template/partials/javascript.php");?>
    
 
</body>
</html>