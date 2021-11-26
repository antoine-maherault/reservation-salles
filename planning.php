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
    for($i=9;$i<=19;$i++){
      if($hour_event==$i){
        if($day_event ==1){
          $event14_1 = $event[1];
        }
        if($day_event ==2){
          $event14_2 = $event[1];
        }
        if($day_event ==3){
          $event14_3 = $event[1];
        }
        if($day_event ==4){
          $event14_4 = $event[1];
        }
        if($day_event ==5){
          $event14_5 = $event[1];
        }
      }
    }
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
  <td> $event8_1</td>
  <td> $event8_2</td> 
  <td> $event8_3</td> 
  <td> $event8_4</td> 
  <td> $event8_5</td> 
    </tr>
  <tr>
  <td>09h - 10h</td> 
  <td> $event9_1</td>
  <td> $event9_2</td> 
  <td> $event9_3</td> 
  <td> $event9_4</td> 
  <td> $event9_5</td> 
    </tr>
     <tr>
  <td>10h - 11h</td> 
  <td> $event10_1</td>
  <td> $event10_2</td> 
  <td> $event10_3</td> 
  <td> $event10_4</td> 
  <td> $event10_5</td> 
    </tr>
   <tr>
  <td>11h - 12h</td> 
  <td> $event11_1</td>
  <td> $event11_2</td> 
  <td> $event11_3</td> 
  <td> $event11_4</td> 
  <td> $event11_5</td> 
    </tr>
     <tr>
  <td>12h - 13h</td>
  <td> $event12_1</td>
  <td> $event12_2</td> 
  <td> $event12_3</td> 
  <td> $event12_4</td> 
  <td> $event12_5</td>  
    </tr>
  <td>13h - 14h</td> 
  <td> $event13_1</td>
  <td> $event13_2</td> 
  <td> $event13_3</td> 
  <td> $event13_4</td> 
  <td> $event13_5</td> 
    </tr>
    <tr>
  <td>14h - 15h</td> 
  <td> $event14_1</td>
  <td> $event14_2</td> 
  <td> $event14_3</td> 
  <td> $event14_4</td> 
  <td> $event14_5</td> 
    </tr>
   <tr>
  <td>15h - 16h</td> 
  <td> $event15_1</td>
  <td> $event15_2</td> 
  <td> $event15_3</td> 
  <td> $event15_4</td> 
  <td> $event15_5</td> 
    </tr>
     <tr>
  <td>16h - 17h</td> 
  <td> $event16_1</td>
  <td> $event16_2</td> 
  <td> $event16_3</td> 
  <td> $event16_4</td> 
  <td> $event16_5</td> 
    </tr>
    <tr>
  <td>17h - 18h</td> 
  <td> $event17_1</td>
  <td> $event17_2</td> 
  <td> $event17_3</td> 
  <td> $event17_4</td> 
  <td> $event17_5</td> 
    </tr>
    <tr>
  <td>18h - 19h</td> 
  <td> $event18_1</td>
  <td> $event18_2</td> 
  <td> $event18_3</td> 
  <td> $event18_4</td> 
  <td> $event18_5</td> 
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