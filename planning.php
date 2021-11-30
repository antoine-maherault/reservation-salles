<!DOCTYPE html>
<html>
 <head>
 <title>The R00M</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
 </head>
 <body>

 <header>
   <a href="index.php"> Home </a> 
   <?php include "header.php";?> 
</header>

<main>
<?php

session_start();
//_________________connect to DB_______________//

include "db_link.php"; 

//_________________get EVENTS_________________//

$sql = "SELECT * FROM reservations" ;
$query = $conn->query($sql);
$events = $query->fetch_all();

//_________________ get USERNAME  _________________//

// get LOGIN from utilisateurs and reservations

$sql = "SELECT utilisateurs.login FROM utilisateurs INNER JOIN reservations ON reservations.id_utilisateur = utilisateurs.id" ;
$query = $conn->query($sql);
$users = $query->fetch_all();

//_________________change WEEKS_________________//

/////////////// InitWeekNum /////////////// 

if ($_SESSION["init"] == 0){
  $date = new DateTime();
  $_SESSION['week'] = $date->format("W");
  $_SESSION['week_i'] = $date->format("W");
  $_SESSION["init"]++;
}

/////////////// Get WeekStart and WeekEnd from WeekNumber /////////////// 

function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('d-m-Y');
  $dto->modify('+4 days');
  $ret['week_end'] = $dto->format('d-m-Y');
  return $ret;
}

$week_array = getStartAndEndDate($_SESSION['week'],date("Y"));

/////////////// Change WeekStart and WeekEnd when hit ARROW /////////////// 

if($_POST['lweek'] == "<" && $_SESSION['week']>$_SESSION['week_i']){
  header("Location:planning.php");
  $_SESSION['week'] --;
}

if($_POST['nweek'] == ">"){
  header("Location:planning.php");
  $_SESSION['week'] ++;
}

/////////////// Display Event /////////////// 

foreach($events as $event){ 
 
  // get username for event 
  $u_login = $event[5];
  $sql = "SELECT utilisateurs.login FROM utilisateurs INNER JOIN reservations ON reservations.id_utilisateur = utilisateurs.id WHERE reservations.id_utilisateur = $u_login" ;
  $query = $conn->query($sql);
  $username = $query->fetch_all();
  $username = $username[0][0];

  // create date of event (format)
  $date_event = date_create($event[3]);
  $date_event = date_format($date_event, 'd-m-Y');

  // create day of event  
  $day_event = date('w', strtotime($date_event));

  // create hour of event 
  $hour_event = date_create($event[3]);
  $hour_event = date_format($hour_event, 'H');

  // display events of the week 

  if(strtotime($date_event) >= strtotime($week_array['week_start']) && strtotime($date_event) <= strtotime($week_array['week_end'])){
    $hour_event=ltrim($hour_event,'0');
    $ev = "event".$hour_event."_".$day_event;  
    $$ev = $event[1].' '.$username;
    $evID = "event".$hour_event."_".$day_event."_ID"; 
    $$evID = $event[0];
  }
}

//_________________display PLANNING_________________//

echo "
<div class ='pContainer'>
<div class ='weekSelect'>   
 <form method ='post'> 
    <input type ='submit' name ='lweek' value = '<'>  </input>  Semaine du ".$week_array['week_start']." au ".$week_array['week_end']." <input type ='submit' name ='nweek' value = '>'>  </input> 
       </form> <br></br>
  </div>";

echo"
<form action = 'event.php' method = 'get'>
<table class='planning'>
  <thead>
  <th> Horaires </th>
  <th> Lundi </th>
  <th> Mardi </th>
  <th> Mercredi </th>
  <th> Jeudi </th>
  <th> Vendredi </th>
    </thead>
  <tbody>
  <tr>
  <td>08h - 09h</td> 
  <td> <input name = '$event8_1_ID' class ='reza' type='submit' value='$event8_1'></input></td> 
  <td> <input name = '$event8_2_ID' class ='reza' type='submit' value='$event8_2'></input></td> 
  <td> <input name = '$event8_3_ID' class ='reza' type='submit' value='$event8_3'></input></td> 
  <td> <input name = '$event8_4_ID' class ='reza' type='submit' value='$event8_4'></input></td> 
  <td> <input name = '$event8_5_ID' class ='reza' type='submit' value='$event8_5'></input></td> 
    </tr>
  <tr>
  <td>09h - 10h</td> 
  <td> <input name = '$event9_1_ID' class ='reza' type='submit' value='$event9_1'></input></td> 
  <td> <input name = '$event9_2_ID' class ='reza' type='submit' value='$event9_2'></input></td> 
  <td> <input name = '$event9_3_ID' class ='reza' type='submit' value='$event9_3'></input></td> 
  <td> <input name = '$event9_4_ID' class ='reza' type='submit' value='$event9_4'></input></td> 
  <td> <input name = '$event9_5_ID' class ='reza' type='submit' value='$event9_5'></input></td> 
    </tr>
     <tr>
  <td>10h - 11h</td> 
  <td> <input name = '$event10_1_ID' class ='reza' type='submit' value='$event10_1'></input></td> 
  <td> <input name = '$event10_2_ID' class ='reza' type='submit' value='$event10_2'></input></td> 
  <td> <input name = '$event10_3_ID' class ='reza' type='submit' value='$event10_3'></input></td> 
  <td> <input name = '$event10_4_ID' class ='reza' type='submit' value='$event10_4'></input></td> 
  <td> <input name = '$event10_5_ID' class ='reza' type='submit' value='$event10_5'></input></td> 
    </tr>
   <tr>
  <td>11h - 12h</td> 
  <td> <input name = '$event11_1_ID' class ='reza' type='submit' value='$event11_1'></input></td> 
  <td> <input name = '$event11_2_ID' class ='reza' type='submit' value='$event11_2'></input></td> 
  <td> <input name = '$event11_3_ID' class ='reza' type='submit' value='$event11_3'></input></td> 
  <td> <input name = '$event11_4_ID' class ='reza' type='submit' value='$event11_4'></input></td> 
  <td> <input name = '$event11_5_ID' class ='reza' type='submit' value='$event11_5'></input></td> 
    </tr>
     <tr>
  <td>12h - 13h</td>
  <td> <input name = '$event12_1_ID' class ='reza' type='submit' value='$event12_1'></input></td> 
  <td> <input name = '$event12_2_ID' class ='reza' type='submit' value='$event12_2'></input></td> 
  <td> <input name = '$event12_3_ID' class ='reza' type='submit' value='$event12_3'></input></td> 
  <td> <input name = '$event12_4_ID' class ='reza' type='submit' value='$event12_4'></input></td> 
  <td> <input name = '$event12_5_ID' class ='reza' type='submit' value='$event12_5'></input></td> 
    </tr>
  <td>13h - 14h</td> 
  <td> <input name = '$event13_1_ID' class ='reza' type='submit' value='$event13_1'></input></td> 
  <td> <input name = '$event13_2_ID' class ='reza' type='submit' value='$event13_2'></input></td> 
  <td> <input name = '$event13_3_ID' class ='reza' type='submit' value='$event13_3'></input></td> 
  <td> <input name = '$event13_4_ID' class ='reza' type='submit' value='$event13_4'></input></td> 
  <td> <input name = '$event13_5_ID' class ='reza' type='submit' value='$event13_5'></input></td> 
    </tr>
    <tr>
  <td>14h - 15h</td> 
  <td> <input name = '$event14_1_ID' class ='reza' type='submit' value='$event14_1'></input></td> 
  <td> <input name = '$event14_2_ID' class ='reza' type='submit' value='$event14_2'></input></td> 
  <td> <input name = '$event14_3_ID' class ='reza' type='submit' value='$event14_3'></input></td> 
  <td> <input name = '$event14_4_ID' class ='reza' type='submit' value='$event14_4'></input></td> 
  <td> <input name = '$event14_5_ID' class ='reza' type='submit' value='$event14_5'></input></td> 
    </tr>
   <tr>
  <td>15h - 16h</td> 
  <td> <input name = '$event15_1_ID' class ='reza' type='submit' value='$event15_1'></input></td> 
  <td> <input name = '$event15_2_ID' class ='reza' type='submit' value='$event15_2'></input></td> 
  <td> <input name = '$event15_3_ID' class ='reza' type='submit' value='$event15_3'></input></td> 
  <td> <input name = '$event15_4_ID' class ='reza' type='submit' value='$event15_4'></input></td> 
  <td> <input name = '$event15_5_ID' class ='reza' type='submit' value='$event15_5'></input></td> 
    </tr>
     <tr>
  <td>16h - 17h</td> 
  <td> <input name = '$event16_1_ID' class ='reza' type='submit' value='$event16_1'></input></td> 
  <td> <input name = '$event16_2_ID' class ='reza' type='submit' value='$event16_2'></input></td> 
  <td> <input name = '$event16_3_ID' class ='reza' type='submit' value='$event16_3'></input></td> 
  <td> <input name = '$event16_4_ID' class ='reza' type='submit' value='$event16_4'></input></td> 
  <td> <input name = '$event16_5_ID' class ='reza' type='submit' value='$event16_5'></input></td> 
    </tr>
    <tr>
  <td>17h - 18h</td> 
  <td> <input name = '$event17_1_ID' class ='reza' type='submit' value='$event17_1'></input></td> 
  <td> <input name = '$event17_2_ID' class ='reza' type='submit' value='$event17_2'></input></td> 
  <td> <input name = '$event17_3_ID' class ='reza' type='submit' value='$event17_3'></input></td> 
  <td> <input name = '$event17_4_ID' class ='reza' type='submit' value='$event17_4'></input></td> 
  <td> <input name = '$event17_5_ID' class ='reza' type='submit' value='$event17_5'></input></td> 
    </tr>
    <tr>
  <td>18h - 19h</td> 
  <td> <input name = '$event18_1_ID' class ='reza' type='submit' value='$event18_1'></input></td> 
  <td> <input name = '$event18_2_ID' class ='reza' type='submit' value='$event18_2'></input></td> 
  <td> <input name = '$event18_3_ID' class ='reza' type='submit' value='$event18_3'></input></td> 
  <td> <input name = '$event18_4_ID' class ='reza' type='submit' value='$event18_4'></input></td> 
  <td> <input name = '$event18_5_ID' class ='reza' type='submit' value='$event18_5'></input></td> 
    </tr>
    </tbody>
  </table>
  </form>
  </div>
";

//_________________add new EVENT_________________//

if(isset($_SESSION['connected'])){ ?>
<a class="evlink"href="reservation-form.php"><div id=newevent>
  <article class ="addEvent">Faire une réservation</article>
</div><a>
<?php  }?>

</main>
<footer>  
</footer>
</body>
</html>