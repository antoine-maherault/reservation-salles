   <?php 
   //_________________display header according to connection status_________________//

   session_start();
   echo "<a href='planning.php'> Planning </a>";

   if(isset($_SESSION["connected"])){
      echo "<a href='profil.php'> Profil </a>";
   } 
   else{
      echo "<a href='inscription.php'> Inscription </a>";
   }

   if(isset($_SESSION["connected"])){
   echo "
   <form  class ='decoform'method='get'>  
         <input class='deco'  type='submit' name='deco' value='Se déconnecter'></input>
         </form>";
   } 
   else{
   echo "<a href='connexion.php'> Connexion </a>";
   }
   if(isset($_GET['deco'])){
   session_destroy();
   header("Location:index.php");
   }

   //_________________reset date PLANNING_________________//

   if($_SERVER['PHP_SELF']!="planning.php"){
      $_SESSION["init"] = 0;
    }
?>

