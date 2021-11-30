<!DOCTYPE html>
<html>
 <head>
 <title>The R00M</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
 </head>

 <body>

 <?php 
 // DISPLAY PAGE IF CONNECTED
 session_start();
 if(isset($_SESSION['connected'])){
 ?>

 <header>
   <a href="index.php"> Home </a> 
   <?php include "header.php";?> 
</header>
<main>
<h1 class="tsigni">BOOK</h1> 

<div class ="booking_container">
<form method = "GET">
  <label> Titre </label>
  <input size = 50 placeholder="Votre réservation" type="text" name="titre" value=<?php echo $_GET["titre"] ?>> </input>
  <label> Description </label>
  <textarea size = 50 placeholder="Votre description" type="text" name="description" class="desc"><?php echo $_GET["description"] ?></textarea>
  <label> Date de début </label>
  <input size = 50 type="datetime-local" name="sdate" value=<?php echo $_GET["sdate"]?>> </input>
  <label> Date de fin </label>
  <input size = 50 type="datetime-local" name="edate" value=<?php echo $_GET["edate"] ?>> </input>
  <input name ="submit" type ="submit"class ="book" value= "Réserver"></input>
</form>
</div>

<?php

//_________________connect to DB_________________//

include "db_link.php"; 

//_________________ user ID _________________//

$co_user = $_SESSION['connected'];
$sql = "SELECT id FROM `utilisateurs` WHERE `login` = '$co_user'" ;
$query = $conn->query($sql);
$id_user = $query->fetch_all();

//_________________set variables_________________//

$id_user = $id_user[0][0];
$titre = $_GET["titre"];
$description = $_GET["description"];
$debut = $_GET['sdate'];
$fin = $_GET['edate'];

//_________________ check EVENTS _________________//

$sql = "SELECT debut FROM `reservations` WHERE `debut` = '$debut'" ;
$query = $conn->query($sql);
$evS = $query->fetch_all();

$sql = "SELECT debut FROM `reservations` WHERE `debut` = '$fin'" ;
$query = $conn->query($sql);
$evE = $query->fetch_all();


// _______ DateTime _______ //

$toDate = date_format(date_create($toDate),'Y-m-d  H:i');
$toDate =strftime('%Y-%m-%dT%H:%M', strtotime($toDate));

$DOW_sdate = date('N', strtotime($debut));
$DOW_edate = date('N', strtotime($fin));

$DOW_sdate = date('N', strtotime($debut));
$DOW_edate = date('N', strtotime($fin));

$day_sdate = date('d-m-Y', strtotime($debut));
$day_edate = date('d-m-Y', strtotime($fin));

$min_sdate = date('i', strtotime($debut));
$min_edate = date('i', strtotime($fin));
$hour_sdate = date('H', strtotime($debut));
$hour_edate = date('H', strtotime($fin));

$hours = "/08|09|10|11|12|13|14|15|16|17|18/i";

//_________________save EVENT_________________//

if(isset($_GET['submit'])){
  if($_GET['titre']!=NULL && $_GET['description']!=NULL && $_GET['sdate']!=NULL && $_GET['edate']!=NULL){
    $err = false;
    if($evS != NULL || $evE != NULL ){
      echo "Il existe déjà un évênement sur ce créneau.</br>";
      $err = true;
    }
    if(strlen($titre) > 10){
      echo "La taille du titre est limitée à 10 charactères.</br>";
      $err = true;
    }
    if($debut < $toDate && $fin < $toDate){
      echo "Les dates de début et de fin doivent être postérieures à aujourd'hui.</br>";
      $err = true;
    }
    if($day_sdate != $day_edate){
      echo "Le jour de début doit être le même que le jour de fin.</br>";
      $err = true;
    }
    if($DOW_sdate == 6 || $DOW_sdate == 7 || $DOW_edate == 6 || $DOW_edate == 7 ){
      echo "The ROOM n'est pas ouverte durant le week-end</br>";
      $err = true;
    }
    if($min_sdate != "00" || $min_edate != "00"){
      echo "Veuillez entrer 00 dans le champ minutes </br>";
      $err = true;
    }
    if(preg_match($hours, $hour_sdate) == false || preg_match($hours, $hour_edate) == false ){
      echo "Les horaires de The ROOM sont compris entre 8 et 19h. </br>";
      $err = true;
    }
    if($hour_edate != ($hour_sdate+1)){
      echo "L'heure de fin doit être une heure après celle de début. </br>";
      $err = true;
    }
    elseif($err ==false){
      $sql = "INSERT INTO `reservations` (`titre`, `description`,`id_utilisateur`,`debut`,`fin`) VALUES('$titre','$description', '$id_user','$debut','$fin')";
      $query = $conn->query($sql);    
      header("Location:planning.php");
    }
  }
  else{
    echo 'Tous les champs doivent être remplis..';
  }
}

?>

</main>
<footer>
<div class="square">
    <a href="https://github.com/antoine-maherault/livre-or"> Github </a> 
  </div>   
</footer>

<?php } else{ echo "<h1 class='title'>Acces denied</h1>"; } ?>

</body>
</html>