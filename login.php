<!-- File: login.php -->
<?php 
session_start();
require("requireDB.php");

if (isset($_GET['tanca']))//si en un altre script m´han passat sa variable tanca elimina la sessio
{
  session_unset();
  session_destroy();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (isset($_POST['user']) && isset($_POST['pass']))
  {
    $u=$_POST['user'];
    $c=$_POST['pass'];

    $usuario="select user from `users` where user='$u' and password='$c'";
    $contraseña="select password from `users` where password='$c' and user='$u'";
    $r=@mysqli_query($dbc,$usuario);
    $numr=mysqli_num_rows($r);
    $s=@mysqli_query($dbc,$contraseña);
    $nums=mysqli_num_rows($s);
  }
  if ($numr>0)
  {
	 $_SESSION['login']  = 'true'; //login es sa variable que heu d´emplear per comprovar que s´ha iniciat sessio
	 print($_SESSION['login']); 

 header('Location: ./list.php');//AQUI S´HA DE POSAR EL NOM DE LA PRIMERA PAGINA vostra
 exit;
}
else
{
  $error = "Incorrect user and/or password.";
}
}
?>

<html>
<head>
  <title>LOGIN</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <div id="box">
   <h1 id="LogH1">SJO-AMPA Notifier</h1>
   <h3 id="LogH3">LOGIN</h3>

   <form class="contact_form" action="login.php" method="post">
    <div>
      <div class="row">Login: <input type="text" name="user" required <?php if(isset($error)){print('value="'. $_POST[user] .'"');} ?> /></div>
      
      <div class="row">Password: <input type="password" name="pass" required />
      </div>  

      <div>
        <input type="submit" name="submit" value="Enviar" />
        <input type="reset" name="reset" value="Reset" />
      </div>
    </div>
  </form>

  <?php
  if (isset($error)){
    ?>

    <div id="errorLogin">
    <div>
      <?php print($error); ?>
      </div>
    </div>

    <?php
  }
  ?>

</div>
</body>
</html>