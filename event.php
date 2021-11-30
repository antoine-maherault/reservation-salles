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

 <?php 
 // DISPLAY PAGE IF CONNECTED
 session_start();
 if(isset($_SESSION['connected'])){
 ?>

<?php

$evID = key($_GET);

//_________________connect to DB_________________//

include "db_link.php"; 

//_________________ redirect if no ID _________________//

if($evID == NULL){
  header("Location:reservation-form.php");
}

//_________________ get EVENT details _________________//

$sql = "SELECT * FROM `reservations` WHERE `id` = '$evID' ";
$query = $conn->query($sql);
$event_details = $query->fetch_all();

$title= $event_details[0][1];
$description = $event_details[0][2];

//Format DATE //
$sDate = $event_details[0][3];
$eDate = $event_details[0][4];

$sDate = date_format(date_create($sDate),'Y-m-d  H:i');
$sDate =strftime('%Y-%m-%dT%H:%M', strtotime($sDate));
$eDate = date_format(date_create($eDate),'Y-m-d  H:i');
$eDate =strftime('%Y-%m-%dT%H:%M', strtotime($eDate));

$u_id= $event_details[0][5];

//_________________ get USERNAME  _________________//

// get LOGIN from utilisateurs and reservations

$sql = "SELECT utilisateurs.login FROM utilisateurs INNER JOIN reservations ON reservations.id_utilisateur = utilisateurs.id WHERE utilisateurs.id = $u_id" ;
$query = $conn->query($sql);
$users = $query->fetch_all();
$u_login = $users[0][0];

?>
<main>
<h1 class="tsigni">BOOKED</h1> 

<div class ="booking_container">
<form method = "get">
  <label> Titre </label>
  <input size = 50 value= "<?php echo $title ?>"type="text" name="titre"> </input>
  <label> Description </label>
  <input size = 50 value= "<?php echo $description ?>" type="text" name="description" class="desc"> </input>
  <label> Date de début </label>
  <input size = 50 type="datetime-local" value="<?php echo $sDate ?>" name="sdate"> </input>
  <label> Date de fin </label>
  <input size = 50 type="datetime-local" value="<?php echo $eDate ?>" name="edate"> </input>
  <label> Par </label>
  <input size = 50 value= "<?php echo $u_login ?>"type="text" name="titre"> </input>
</form>
</div>

</main>
<footer>
<div class="square">
    <a href="https://github.com/antoine-maherault/livre-or"> Github </a> 
  </div>   
</footer>

<?php } else{ echo "<h1 class='title'>Acces denied</h1>"; } ?>

</body>
</html>