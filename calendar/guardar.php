<?php
require './helper.php';
$m=''; //for error messages
$id_event=''; //id event created 
$link_event;
$client = getClient();
$calendarService = new Google_Service_Calendar($client);
$calendarId = 'primary';
//echo $_POST['personas']; exit;
if(isset($_POST['agendar'])){
	$datetime_start = new DateTime($_POST['date_start']);
	$datetime_end = new DateTime($_POST['date_start']);

	//aumentamos una hora a la hora inicial/ add 1 hour to start date
	$time_end = $datetime_end->add(new DateInterval('PT1H'));

	//datetime must be format RFC3339
	$time_start =$datetime_start->format(\DateTime::RFC3339);
	$time_end=$time_end->format(\DateTime::RFC3339);
	$nombre=(isset($_POST['titulo']))?$_POST['titulo']:' xyz ';
	try{
	    //instanciamos el servicio
	  
	    //parámetros para buscar eventos en el rango de las fechas del nuevo evento
	    //params to search events in the given dates
	    $optParams = array(
	        'orderBy' => 'startTime',
	        'maxResults' => 20,
	        'singleEvents' => TRUE,
	        'timeMin' => $time_start,
	        'timeMax' => $time_end,
	    );

	    //obtener eventos 
	    $events=$calendarService->events->listEvents($calendarId,$optParams);
	    
	    //obtener número de eventos / get how many events exists in the given dates
	    $cont_events=count($events->getItems());
	 
	    //crear evento si no hay eventos / create event only if there is no event in the given dates
	    if($cont_events == 0){

	        $event = new Google_Service_Calendar_Event();
	        $event->setSummary($nombre);
	        $event->setDescription($_POST['descripcion']);

	        //fecha inicio
	        $start = new Google_Service_Calendar_EventDateTime();
	        $start->setDateTime($time_start);
	        $event->setStart($start);

	        //fecha fin
	        $end = new Google_Service_Calendar_EventDateTime();
	        $end->setDateTime($time_end);
	        $event->setEnd($end);
	        if (!empty($_POST['personas'])) {
	        }
	        $event->setAttendees(array($_POST['personas']));

	      
	        $createdEvent = $calendarService->events->insert($calendarId, $event);
	        $id_event= $createdEvent->getId();
	        $titulo_event=$createdEvent->getSummary();
	        $link_event= $createdEvent->gethtmlLink();
	        
	    }else{
	        $m = "Hay ".$cont_events." eventos en ese rango de fechas";
	    }

	}catch(Google_Service_Exception $gs){
	 
		$m = json_decode($gs->getMessage());
		$m= $m->error->message;

	}catch(Exception $e){
		$m = $e->getMessage();
	}
}
if(isset($_POST['eliminar'])){
	try{

		$createdEvent = $calendarService->events->delete($calendarId, $_POST['idEvento']);

	}catch(Google_Service_Exception $gs){
	 
		$m = json_decode($gs->getMessage());
		$m= $m->error->message;

	}catch(Exception $e){
		$m = $e->getMessage();
	}
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
    <script type="text/javascript" src="moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <style type="text/css">
        body{
            background-color: #0174DF;
        }
          
        form{
            background-color: #fff;
            /*width: 50%;*/
            border: 2px solid;
            padding: 15px;
            margin-top: 100px;
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
			<div class="col-md-6 offset-md-3">
			 	<form action="" method="POST">
				    <?php 
				    if(isset($_POST['agendar'])){
				      if($m!=''){
				      ?>
				      <label class="control-form">Error :<?php echo $m;   ?></label>
				      <?php
				      }
				      elseif($id_event!=''){
				        ?>
				        <label class="control-form">ID EVENTO :<?php echo $id_event;   ?></label><br>
				        <label class="control-form">TÍTULO :<?php echo $titulo_event;   ?></label><br>
				        <a href="<?php  echo $link_event;  ?>" target="_blank">LINK</a>
				        <?php
				      }
				      ?><br>
				      <button type="button" class="btn btn-primary btn-block" onclick="reload();">Volver</button>
				      <?php
				    }
				    if(isset($_POST['eliminar'])){
				      if($m!=''){
				      ?>
				      <label class="control-form">Error :<?php echo $m;   ?></label>
				      <?php
				      }
				      else{
				        ?>
				        <label class="control-form">Tarea eliminada</label><br>
				        <?php
				      }
				      ?><br>
				      <button type="button" class="btn btn-primary btn-block" onclick="reload();">Volver</button>
				      <?php
				    }
				    ?>
				</form>
				
			</div>
		</div>		
	</div>
	<script type="text/javascript">
	    function reload(){
	        location.href="index.php";
	    }
	</script>
</body>
</html>