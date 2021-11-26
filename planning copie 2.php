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
//_________________connect to DB_________________//

include "db_link.php"; 

//_________________get EVENTS_________________//

$sql = "SELECT * FROM reservations" ;
$query = $conn->query($sql);
$events = $query->fetch_all();

//_________________ date VAR _________________//

// $date = date('Y-m-d H:i:s');

// echo $date."</br>";
// $day = date('w', strtotime($date));
// echo $day."</br>";

// $week_start = date('Y-m-d', strtotime('-'.($day-1).' days'));
// echo $week_start."</br>";
// $week_end = date('Y-m-d', strtotime('+'.(5-$day).' days'));
// echo $week_end;


// $firstday = date('d/m/Y', strtotime("last week"));
  
// echo "First day of last week: ", $firstday."</br>";

// $lastday = date('d/m/Y', strtotime('+'.(1).' days'));

// echo "Last day of last week: ", $lastday."</br>";

//////// CREATE a DateTime object //////////
$givenDate = date_create("22-11-2021"); 
$givenDate= date_format($givenDate, "d/m/Y"); 
////////////////////////////////////////////

//////// CurrentWeek ///////////////////////
$cweek_start = date('d/m/Y', strtotime("this week"));
$cweek_end = date('d/m/Y', strtotime('+'.(0).' days'));
////////////////////////////////////////////

//////// LastWeek ///////////////////////
$givenDate = date("2021/11/17");
$lweek_start = date('d/m/Y', strtotime('last monday', strtotime($givenDate)));
$lweek_end = date('d/m/Y', strtotime('next friday', strtotime($givenDate)));
////////////////////////////////////////////

//////// NextWeek ///////////////////////
$givenDate = date("2021/12/03");
$nweek_start = date('d/m/Y', strtotime('last monday', strtotime($givenDate)));
$nweek_end = date('d/m/Y', strtotime('next friday', strtotime($givenDate)));
////////////////////////////////////////////

//////// WeekDisplayVar ///////////////////////
$week_start = $cweek_start;
$week_end = $cweek_end;
////////////////////////////////////////////



////______________________///


//////// Debug ///////////////////////
var_dump ($_SESSION["init"] );

////////////////////////////////////////////

//////// InitWeekNum///////////////////////
if ($_SESSION["init"] == 0){
  $date = new DateTime($ddate);
  $_SESSION['week'] = $date->format("W");
  $_SESSION["init"]++;
}
////////////////////////////////////////////

//////// DisplayLastweek && Nextweek///////////////////////


function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('d-m-Y');
  $dto->modify('+4 days');
  $ret['week_end'] = $dto->format('d-m-Y');
  return $ret;
}

$week_array = getStartAndEndDate($_SESSION['week'],2021);






var_dump($week_array);




// if ($_GET['lweek']=="<"){
//   $_SESSION['week'] = $_SESSION['week'] -1;
//   $_GET['lweek']="";
// }

// if ($_GET['nweek']==">"){
//   echo "hey";
//   $_SESSION['week'] = $_SESSION['week'] + 1;
//   $_GET['lweek']="";
//   // header("Location:planning.php");
// }

////////////////////////////////////////////
echo "WeekNumber:".$_SESSION['week']."</br>";


if($_POST['lweek'] == "<"){
  header("Location:planning.php");
  $_SESSION['week'] --;
}

if($_POST['nweek'] == ">"){
  header("Location:planning.php");
  $_SESSION['week'] ++;
}


//////////////////////////////////////
//_________________display PLANNING_________________//

echo "
<div class ='pContainer'>
<div class ='weekSelect'>   
 <form method ='post'> 
    <input type ='submit' name ='lweek' value = '<'>  </input>  Semaine du $week_start au $week_end <input type ='submit' name ='nweek' value = '>'>  </input> 
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
  <td> Titre Nom</td> 

    </tr>
  <tr>
  <td>09h - 10h</td> 
    </tr>
     <tr>
  <td>10h - 11h</td> 
    </tr>
   <tr>
  <td>11h - 12h</td> 
    </tr>
     <tr>
  <td>12h - 13h</td> 
    </tr>
  <td>13h - 14h</td> 
    </tr>
    <tr>
  <td>14h - 15h</td> 
    </tr>
   <tr>
  <td>15h - 16h</td> 
    </tr>
     <tr>
  <td>16h - 17h</td> 
    </tr>
    <tr>
  <td>17h - 18h</td> 
    </tr>
    <tr>
  <td>18h - 19h</td> 
    </tr>
    </tbody>
  </table>
  </form>
  </div>
";

// get DATA from commentaires

$sql = "SELECT * FROM commentaires";
$query = $conn->query($sql);
$comments = $query->fetch_all();

// get LOGIN from utilisateurs and commentaires

$sql = "SELECT utilisateurs.id, utilisateurs.login FROM utilisateurs INNER JOIN commentaires ON commentaires.id_utilisateur = utilisateurs.id" ;
$query = $conn->query($sql);
$users = $query->fetch_all();


//_________________add new COMMENT_________________//

if(isset($_SESSION['connected'])){ ?>
<div id=newcomment>
  <article class ="addComment"><a href="commentaire.php">Ajouter un commentaire<a></article>
</div>
<?php  }?>

</main>
<footer>  
</footer>
</body>
</html>