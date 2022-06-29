<?php
require './helper.php';

$action = 'listEvents';

// SECRET KEY 4/1AY0e-g6CJbONgFg1goc-ExBnbMBZW2orEvPtvJIivd_edesuh5ib5B3Nuww

$client = getClient();
$calendarService = new Google_Service_Calendar($client);

$calendarId = 'primary';
$optParams = array(
    'maxResults' => 10,
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => date('c'),
);
$results = $calendarService->events->listEvents($calendarId, $optParams);
$events = $results->getItems();

/*switch ($action) {
    case 'addEvent':
        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Prueba de creacion de evento en Google Calendar',
            'location' => 'En la casa de Bart',
            'description' => 'Esta es una reunion para divertirnos',
            'start' => array(
                'dateTime' => '2022-06-28T09:00:00-07:00',
                'timeZone' => 'America/Bogota',
            ),
            'end' => array(
                'dateTime' => '2022-06-28T17:00:00-07:00',
                'timeZone' => 'America/Bogota',
            ),
            "conferenceData" => [
                "createRequest" => [
                    "conferenceId" => [
                        "type" => "eventNamedHangout"
                    ],
                    "requestId" => "123"
                ]
            ],
            'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=2'
            ),
            'attendees' => array(
                array('email' => 'lpage@example.com'),
                array('email' => 'sbrin@example.com'),
            ),
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
        ));

        $calendarId = 'primary';
        $event = $calendarService->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);
        printf('Event created: %s\n', $event->getHangoutLink());
        break;
    case 'listEvents':
        print "Upcoming events:<br>\n";
        foreach ($events as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }
            printf("%s (%s)<br>\n", $event->getSummary(), $start);
        }
        break;
    default:
        printf('Its not possible to get the events');
        break;
}*/

if ($events > 0) {
} else {
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Api de Google calendar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
    <!-- <script type="text/javascript" src="moment.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
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
                <h1 align="center">Listado de eventos</h1>
                <table border="1" style="text-align: center; width: 100%;" class="table table-dark">
                    <tr>
                        <!-- <td>ID</td> -->
                        <td>Eventos</td>
                        <td>Fecha</td>
                        <td>Acciones</td>
                    </tr>
                    <?php
                        foreach($events as $event):
                    ?>
                    <tr>
                        <!-- <td><?=$event->getId()?></td> -->
                        <td><?=$event->getSummary()?></td>
                        <td><?=$event->start->dateTime?></td>
                        <td>
                            <form action="guardar.php" method="POST">
                                <input type="hidden" name="idEvento" value="<?=$event->getId()?>">
                                <button type="submit" class="btn btn-primary btn-block" name="eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        endforeach;
                    ?>
                </table>
            </div>
            <div class="col-5">
                <h1 align="center">Crear evento</h1>
                <form action="guardar.php" method="POST" class="formulario">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" class="form-control "  name="titulo" placeholder="Título" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <input type="text" class="form-control "  name="descripcion" placeholder="Descripción" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label>Agregar personas</label>
                                <select name="personas[]" id="personas" class="form-control form-control" multiple>
                                    <option value="antonijleon@gmail.com">antonijleon@gmail.com</option>
                                </select>
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