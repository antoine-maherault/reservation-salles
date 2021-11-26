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

/////////////// Change WeekStart and WeekEnd when with ARROW /////////////// 

if($_POST['lweek'] == "<" && $_SESSION['week']>$_SESSION['week_i']){
  header("Location:planning.php");
  $_SESSION['week'] --;
}

if($_POST['nweek'] == ">"){
  header("Location:planning.php");
  $_SESSION['week'] ++;
}

if($_SERVER['PHP_SELF']!="/reservation-salles/planning.php"){
  echo "hey";
}

/////////////// Display Event /////////////// 

foreach($events as $event){
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
    $$ev = $event[1];       
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
<form method = 'get'>
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
  <td> <a href='event.php'>$event8_1</a></td>
  <td> <a href='event.php'>$event8_2</a></td> 
  <td> <a href='event.php'>$event8_3</a></td> 
  <td> <a href='event.php'>$event8_4</a></td> 
  <td> <a href='event.php'>$event8_5</a></td> 
    </tr>
  <tr>
  <td>09h - 10h</td> 
  <td> <a href='event.php'>$event9_1</a></td>
  <td> <a href='event.php'>$event9_2</a></td> 
  <td> <a href='event.php'>$event9_3</a></td> 
  <td> <a href='event.php'>$event9_4</a></td> 
  <td> <a href='event.php'>$event9_5</a></td> 
    </tr>
     <tr>
  <td>10h - 11h</td> 
  <td> <a href='event.php'>$event10_1</a></td>
  <td> <a href='event.php'>$event10_2</a></td> 
  <td> <a href='event.php'>$event10_3</a></td> 
  <td> <a href='event.php'>$event10_4</a></td> 
  <td> <a href='event.php'>$event10_5</a></td> 
    </tr>
   <tr>
  <td>11h - 12h</td> 
  <td> <a href='event.php'>$event11_1</a></td>
  <td> <a href='event.php'>$event11_2</a></td> 
  <td> <a href='event.php'>$event11_3</a></td> 
  <td> <a href='event.php'>$event11_4</a></td> 
  <td> <a href='event.php'>$event11_5</a></td> 
    </tr>
     <tr>
  <td>12h - 13h</td>
  <td> <a href='event.php'>$event12_1</a></td>
  <td> <a href='event.php'>$event12_2</a></td> 
  <td> <a href='event.php'>$event12_3</a></td> 
  <td> <a href='event.php'>$event12_4</a></td> 
  <td> <a href='event.php'>$event12_5</a></td>  
    </tr>
  <td>13h - 14h</td> 
  <td> <a href='event.php'>$event13_1</a></td>
  <td> <a href='event.php'>$event13_2</a></td> 
  <td> <a href='event.php'>$event13_3</a></td> 
  <td> <a href='event.php'>$event13_4</a></td> 
  <td> <a href='event.php'>$event13_5</a></td> 
    </tr>
    <tr>
  <td>14h - 15h</td> 
  <td> <a href='event.php'>$event14_1</a></td>
  <td> <a href='event.php'>$event14_2</a></td> 
  <td> <a href='event.php'>$event14_3</a></td> 
  <td> <a href='event.php'>$event14_4</a></td> 
  <td> <a href='event.php'>$event14_5</a></td> 
    </tr>
   <tr>
  <td>15h - 16h</td> 
  <td> <a href='event.php'>$event15_1</a></td>
  <td> <a href='event.php'>$event15_2</a></td> 
  <td> <a href='event.php'>$event15_3</a></td> 
  <td> <a href='event.php'>$event15_4</a></td> 
  <td> <a href='event.php'>$event15_5</a></td> 
    </tr>
     <tr>
  <td>16h - 17h</td> 
  <td> <a href='event.php'>$event16_1</a></td>
  <td> <a href='event.php'>$event16_2</a></td> 
  <td> <a href='event.php'>$event16_3</a></td> 
  <td> <a href='event.php'>$event16_4</a></td> 
  <td> <a href='event.php'>$event16_5</a></td> 
    </tr>
    <tr>
  <td>17h - 18h</td> 
  <td> <a href='event.php'>$event17_1</a></td>
  <td> <a href='event.php'>$event17_2</a></td> 
  <td> <a href='event.php'>$event17_3</a></td> 
  <td> <a href='event.php'>$event17_4</a></td> 
  <td> <a href='event.php'>$event17_5</a></td> 
    </tr>
    <tr>
  <td>18h - 19h</td> 
  <td> <a href='event.php'>$event18_1</a></td>
  <td> <a href='event.php'>$event18_2</a></td> 
  <td> <a href='event.php'>$event18_3</a></td> 
  <td> <a href='event.php'>$event18_4</a></td> 
  <td> <a href='event.php'>$event18_5</a></td> 
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