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
<h1 class="tsignin"><i>THE R00M</i></h1> 

<div class ="booking_container">
<form method = "get">
  <label> Titre </label>
  <input size = 50 placeholder="Votre réservation" type="text" name="titre"> </input>
  <label> Description </label>
  <input size = 50 placeholder="Votre description" type="text" name="description" class="desc"> </input>
  <label> Date de début </label>
  <input size = 50 placeholder="Your event here" type="datetime-local" name="sdate"> </input>
  <label> Date de fin </label>
  <input size = 50 placeholder="Your event here" type="datetime-local" name="edate"> </input>
  <input type ="submit"class ="book" value= "Réserver"></input>
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
$comment = $_GET["comment"];
$date = date('Y-m-d H:i:s');

//_________________save COMMENT_________________//

if(isset($_GET["comment"])){
  if ($_GET["comment"]== NULL){
    echo "<p id='update'>Veuillez entrer un commentaire.</p>";
  } 
  else{
  $sql = "INSERT INTO `commentaires` (`commentaire`, `id_utilisateur`, `date`) VALUES('$comment', '$id_user', '$date')";
  $query = $conn->query($sql);
  header("Location:livre-or.php");
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