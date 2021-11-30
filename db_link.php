<?php 
   //_________________connect to SQL_________________//

   $servername = "localhost:3306";
   $username = "root__";
   $password = "root__";

   // Create connection

   $conn = new mysqli($servername, $username, $password, 'antoine-maherault_reservationsalles');
   mysqli_set_charset($conn,'utf8');
?>

