<!doctype html>
<html lang="es">
<head>
    <?php require_once("template/partials/head.php");?>
    <title>Gestión actividads - Home </title>
</head>
<body>
    <?php require_once("template/partials/menuAut.php") ?>
    <!-- Capa Principal -->
    <div class="container">

        <!-- Encabezado proyecto -->
        <?php include("views/actividades/partials/cabecera.php"); ?>

        <!-- Comprobamos si existe algún mensaje -->
        <?php require_once("template/partials/mensaje.php") ?>

        <!-- Comprobamos si existe algún error -->
        <?php require_once("template/partials/error.php") ?>
        
        <!-- Menú actividads -->
        <?php include("views/actividades/partials/menu.php");?>
       
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <!-- Mostramos el encabezado de la tabla -->
                    <tr>
                        <th>Id</th>
                        <th>Num</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Hora Ini</th>
                        <th>Hora Fin</th>
                        <th>Cursos</th>
                        <th>Coordinador</th>
                        <th>Departamento</th>
                        <th>Lugar</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Mostramos cuerpo de la tabla -->
                    <!-- En el foreach incluyo un objeto de la clase pdostatement -->
                    <?php foreach ($this->actividades as $actividad): ?>
                        <tr>
                            <!-- Detalles de artículos -->
                            <td><?= $actividad->id ?></td>
                            <td><?= $actividad->num_actividad ?></td>
                            <td><?= $actividad->titulo ?></td>
                            <td><?= $actividad->fecha_inicio ?></td>
                            <td><?= $actividad->hora_inicio ?></td>
                            <td><?= $actividad->hora_fin ?></td>
                            <td><?= $actividad->cursos ?></td>
                            <td><?= $actividad->nombre ?></td>
                            <td><?= $actividad->departamento ?></td>
                            <td><?= $actividad->lugar_celebracion ?></td>
                            
                            <!-- Columna de acciones -->
                            <td>
                                <div class="btn-group">
                                <!-- Eliminar  -->
                                <a href="<?= URL ?>actividades/eliminar/<?=$actividad->id?>" title="Eliminar" class="btn btn-danger
                                <?= (!in_array($_SESSION['id_rol'], $GLOBALS['eliminar']))? 'disabled': null ?>" 
                                ><i class="bi bi-trash" onclick="return confirm('Confimar elimación del actividad')"></i></a>
                                <!-- Editar -->
                                <a href="<?= URL ?>actividades/editar/<?=$actividad->id?>" title="Editar" class="btn btn-primary
                                <?= (!in_array($_SESSION['id_rol'], $GLOBALS['editar']))? 'disabled': null ?>" 
                                ><i class="bi bi-pencil"></i></a>
                                <!-- Mostrar -->
                                <a href="<?= URL ?>actividades/mostrar/<?=$actividad->id?>" title="Mostrar" class="btn btn-warning
                                <?= (!in_array($_SESSION['id_rol'], $GLOBALS['mostrar']))? 'disabled': null ?>" 
                                ><i class="bi bi-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>   
                </tbody>
                <tfoot>
                    <tr><td colspan="6">Nº Registros <?= $this->actividades->rowCount() ?></td></tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br><br><br>

    <!-- Pie del documento -->
    <?php include("template/partials/footer.php");?>

    <!-- Bootstrap Javascript y popper -->
    <?php include("template/partials/javascript.php");?>
    
 
</body>
</html>