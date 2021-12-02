<!DOCTYPE html>
<html>
 <head>
 <title>The R00M    </title>
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
<?php 

//_________________connect to DB_________________//

include "db_link.php"; 

//_________________select DATA_________________//

// get DATA from utilisateurs
$co_user = $_SESSION['connected'];

$sql = "SELECT * FROM `utilisateurs` WHERE `login` = '$co_user'" ;
$query = $conn->query($sql);
$user = $query->fetch_all();

$sql = "SELECT * FROM `utilisateurs`" ;
$query = $conn->query($sql);
$users = $query->fetch_all();

// Variables form // 

$login=$user[0][1];
$password=$user[0][2];

?>

<main>
<div class="tsignin">
 <h3>Change your personnal informations</h3>
</div>
<div class="container">
<form method="post" class="myform2">
    <label name="login">Login</label>
        <input type="text" name="login" value=<?php echo $login ?>></input>
    <input type="submit" name="submit1"></input>
    </form>

    <form method="post" class="myform2">
    <label name="password1" type ="password">Old Password</label>
        <input type="password" name="password1"></input>
    <label name="password2">New Password</label>
        <input type="password" name="password2"></input>
    <input type="submit" name="submit2"></input>
    </form>
</div>
</main>

 <?php 

///_________________Change USER Details_________________// 

if(isset($_SESSION["connected"])){
    if($_POST["submit1"]=="Envoyer"){ //update fname + lname + login
        if ($login == NULL && $prenom == NULL && $nom == NULL){}
        else {
            $login=trim($_POST["login"]);
            $prenom=trim($_POST["fname"]);
            $nom=trim($_POST["lname"]);
            if($login == NULL||$prenom == NULL||$nom == NULL){
                if($login == NULL){
                $_SESSION['update'] = 0;
                echo "
                <style>
                input[name='login'] {
                    background-color: #FFBBBB ;
                }
                </style>         
                ";}
                if($prenom == NULL){
                   $_SESSION['update'] = 0;
                    echo "
                    <style>
                    input[name='fname'] {
                    background-color: #FFBBBB ;
                    }
                    </style>         
                    ";        }
                if($nom == NULL){
                   $_SESSION['update'] = 0;
                    echo "
                    <style>
                    input[name='lname'] {
                    background-color: #FFBBBB ;
                    }
                    </style>         
                    ";        }
                $_SESSION['update'] = 3;
            }
            else{
                foreach($users as $users){   // check if Login already exists
                    if ( isset($_POST["login"]) && $_POST["login"] == $users[1] && $_POST["login"] !=$user[0][1]){
                      echo "<p id='update'>login alreay taken</p>";
                      $taken = 1;
                      $_SESSION['update'] = 0;
                    }
                }
                if($taken == false){ // update user infos 
                    $u_login = $user[0][1];
                    $sql = "UPDATE `utilisateurs` SET prenom = '$prenom', login = '$login', nom ='$nom' WHERE login = '$u_login'";
                    $query = $conn->query($sql);
                    $_SESSION['connected'] = $login;
                    header("Location:profil.php");
                    $_SESSION['update'] = 1;
                }
            }
        }
    } 
    }
    
    if(isset($_SESSION["connected"])){
    if($_POST["submit2"]=="Envoyer"){ //update password
       $password1=$_POST["password1"];
       $password2=$_POST["password2"];
       $_SESSION['update'] = 0;
    
       if (password_verify($_POST['password1'],$password)){ // verify old password + update
          $password2 = password_hash($password2, PASSWORD_BCRYPT);
          $u_login = $user[0][1];
          $sql = "UPDATE `utilisateurs` SET password = '$password2'WHERE login = '$u_login'";
          $query = $conn->query($sql);
          $_SESSION['connected'] = $login;
          header("Location:profil.php");
          $_SESSION['update'] = 1;
       } 
       else{
          echo "<p id='update'>wrong password</p>";
          $_SESSION['update'] = 3;
       }
    }
    }
    
    if(isset($_SESSION["connected"])){
    if(isset($_SESSION['update']) && $_SESSION['update'] <= 2 ){ //feedback
       echo "<p id='update'>update successful</p>   ";
       $_SESSION['update'] ++;
    }
    }
    
    ?>
    
<footer>
<div class="square">
    <a href="https://github.com/antoine-maherault/reservation-salles"> Github </a> 
  </div>   
</footer>

<?php 
}
else{
  echo "<h1 class='title'>Acces denied</h1>";
}
?>

 </body>
 
</html>