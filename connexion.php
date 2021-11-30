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
        <h1 class="tsignin"><i>The R00M</i></h1>
        <div class="container">
        <form class="myform" method="post">
            <label name="login">Login</label>
            <input type="text" name="login"></input>
            <label name="password">Password</label>
            <input type="password" name="password"></input>
            <input type ="submit"></input>
            </form>
        </div>
    </main>
    <?php 

    //_________________connect to DB_________________//

    include "db_link.php";  

    //_________________select DATA_________________//

    // get DATA from utilisateurs

    $sql = "SELECT * FROM utilisateurs" ;
    $query = $conn->query($sql);
    $users = $query->fetch_all();

    //_________________connect USER_________________//

    session_start();

    $_SESSION["connected"];
    foreach($users as $user){
        if ( isset($_POST["login"]) && $_POST["login"] == $user[1] && password_verify($_POST['password'],$user[2]) == true){
            $_SESSION["connected"] = $_POST["login"] ;
            header("Location:index.php");
        }
        if ( isset($_POST["login"]) && $_POST["login"] == $user[1] && $_POST['password'] == $user[2]){
            $_SESSION["connected"] = $_POST["login"] ;
            header("Location:index.php");
        }
    }
    ?>
    <footer>
        <div class="square">
            <a href="https://github.com/antoine-maherault/reservation-salles"> Github </a> 
        </div>   
    </footer>
</body>
</html>