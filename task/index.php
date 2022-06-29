<?php
require './helper.php';

$client = getClient();
$service = new Google_Service_Tasks($client);
$parametrosListas = array(
    'maxResults' => 1,
);
$resultadoListas = $service->tasklists->listTasklists($parametrosListas);
//$action = $_POST['action'];
/*$action = 'listadoTareas';

switch ($action) {
    case 'agregarTarea':
        try {
            $postBody = new Google_Service_Tasks_Task(array(
                'title' => 'Hola mundo 11',
                'notes' => 'En la casa de homero',
            ));
            $tareaId = 'MTE5NzgwMzUzNDE4NjIyODU1MTk6MDow';
            $postBody = $service->tasks->insert($tareaId, $postBody);
            printf('Tarea creada: %s', $postBody->getTitle());
        }
        catch(Exception $e) {
            echo 'MENSAJE DE ERROR: ' .$e->getMessage();
        }
        break;
    case 'listadoTareas':
        try{
            $parametrosListas = array(
                'maxResults' => 1,
            );
            $parametrosTareas = array(
                'maxResults' => 10,
                'showCompleted' =>true,
                'showHidden'=> true
            );            
            $resultadoListas = $service->tasklists->listTasklists($parametrosListas);
            foreach($resultadoListas as $k){
                $resultadoTareas = $service->tasks->listTasks($k->getId(),$parametrosTareas);
                $tareas = $resultadoTareas->getItems();
                if (count($tareas) == 0) {
                    print "No se encontraron listas.\n";
                } else {
                    print "Mi tareas de la lista (".$k->getId()."): <br>\n";
                    foreach ($tareas as $tasklist) {
                        printf("%s (%s) (%s) |<br>\n", $tasklist->getTitle(), $tasklist->getNotes(), $tasklist->getId());
                    }
                }
            }
        }
        catch(Exception $e) {
            echo 'Mensaje: ' .$e->getMessage();
        }
        break;
    case 'eliminarTarea':
        $tareaId = 'MTE5NzgwMzUzNDE4NjIyODU1MTk6MDow';
        $postBody = $service->tasks->delete($tareaId, 'Z2M4bG96NTVHdUJhVlladw');
        printf('Tarea eliminada:');
        break;
    case 'editarTarea':
        $postBody = new Google_Service_Tasks_Task(array(
            'title' => 'EDITAR TAREA111',
            'notes' => 'En la casa de Bart',
            'request' => array(
                '@type' => 'Mundo mundo',
                'field' => 'America/Bogota',
            ),
        ));
        $tareaId = 'MTE5NzgwMzUzNDE4NjIyODU1MTk6MDow';
        $postBody = $service->tasks->patch($tareaId, 'Z2M4bG96NTVHdUJhVlladw', $postBody);
        printf('Tarea modificada: %s', $postBody->getTitle());
        break;
    default:
        printf('Its not possible to get the events');
        break;
}*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>Api de Google Task</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
    <!-- <script type="text/javascript" src="moment.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script> -->
    <style type="text/css">
        body{
            background-color: #0174DF;
        }
          
        .formulario{
            background-color: #fff;
            width: 100%;
            border: 2px solid;
            padding: 15px;
        }
        @media screen AND (max-width: 480px){
            form{
                margin: 0px 3%;
                width: 94%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-7">
                <h1 align="center">Listado de tareas</h1>
                <?php 
                ?>
                <table border="1" style="text-align: center; width: 100%;" class="table table-dark">
                    <tr>
                        <!-- <td>ID</td> -->
                        <td>Tareas</td>
                        <td>Descripcion</td>
                        <td>Acciones</td>
                    </tr>
                    <?php
                        try{
                            $parametrosListas = array(
                                'maxResults' => 1,
                            );
                            $parametrosTareas = array(
                                'maxResults' => 10,
                                'showCompleted' =>true,
                                'showHidden'=> true
                            );            
                            $resultadoListas = $service->tasklists->listTasklists($parametrosListas);
                            foreach($resultadoListas as $k){
                                $resultadoTareas = $service->tasks->listTasks($k->getId(),$parametrosTareas);
                                $tareas = $resultadoTareas->getItems();
                                if (count($tareas) == 0) {
                                    print "No se encontraron listas.\n";
                                } else {
                                    //print "Mi tareas de la lista (".$k->getId()."): <br>\n";
                                    foreach ($tareas as $tasklist) { ?>
                                        <tr>
                                            <!-- <td>ID</td> -->
                                            <td><?=$tasklist->getTitle()?></td>
                                            <td><?=$tasklist->getNotes()?></td>
                                            <td>Acciones</td>
                                        </tr>
                                        <?php 
                                        //printf("%s (%s) (%s) |<br>\n", $tasklist->getTitle(), $tasklist->getNotes(), $tasklist->getId());
                                    }
                                }
                            }
                        }
                        catch(Exception $e) {
                            echo 'Mensaje: ' .$e->getMessage();
                        }
                    ?>
                </table>
            </div>
            <div class="col-5">
                <h1 align="center">Crear tarea</h1>
                <form action="" method="POST" class="formulario">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control"  name="titulo" placeholder="Título" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <input type="text" class="form-control"  name="descripcion" placeholder="Descripción" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="datetime-local" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="date_start"/>
                            </div>
                        </div>             
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="agendar">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>