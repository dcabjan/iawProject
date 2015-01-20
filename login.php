<?php 

session_start();

require("requireDB.php");


if (isset($_GET['tanca']))//si en un altre script m´han passat sa variable tanca elimina la sessio
{
session_unset();

// destroy the session
session_destroy(); 
//print("destrueix sessio");
}


//
//if ($_SERVER['REQUEST_METHOD'] == 'POST')
 //{
  // if ($_POST['user']=="admin")
  // { 
  //   if ($_POST['pass']=="1234")
  //   {
	 
	// $_SESSION['login']  = 'true'; //login es sa variable que heu d´emplear per comprovar que s´ha iniciat sessio
	// print($_SESSION['login']); 

  //header('Location:list.php');//AQUI S´HA DE POSAR EL NOM DE LA PRIMERA PAGINA vostra
 //  exit;
  //   }
  //   else
	// {
	//  $error2="password incorrecte";
	// }
  // }
  // else
  // { 
     
	//$error="usuari incorrecte";
	
  // }
 
  
//}
//





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
     //if ($nums>0)
    //{
	 
	 $_SESSION['login']  = 'true'; //login es sa variable que heu d´emplear per comprovar que s´ha iniciat sessio
	 print($_SESSION['login']); 

 header('Location:list.php');//AQUI S´HA DE POSAR EL NOM DE LA PRIMERA PAGINA vostra
   exit;
     }
     else
	 {
	  $error="user/password incorrecte";
	 }
   //}
   //else
  //{ 
     
	//$error="usuari incorrecte";
	
   //}
 
  
}







 

?>
<html>
<head><title>LOGIN</title></head>
 <link rel="stylesheet" type="text/css" href="stylelogin.css" />
 <!--<link rel="stylesheet" type="text/css" href="style.css" />-->
 
<body>
<div id=box>
<h3>Login</h3>
<form class="contact_form" action="login.php" method="post">
  
  <div class=row><div class=row-1>login:</div><div class=row-2><input type="text" name="user" required <?php if (isset($error)) { print('value="'.$_POST[user].'"');} ?> /></div>
  <?php
  if (isset( $error))
  {
	  ?> <div class=row-3> <?php
   print($error);
   ?> </div> <?php
  }
  ?>
  </div>
  <div class=row><div class=row-1>password</div><div class=row-2><input type="password" name="pass" required /></div>
  <?php
   if (isset( $error2))
   {
	   	  ?> <div class=row-3> <?php

   print($error2);
      ?> </div> <?php

   }
   ?>
   </div>
<!--<div class=row><div class=row-b><input type="submit" value="Enviar" /></div>
<div class="row-b"><input type="reset" value="Reset" /></div></div>-->
<div><div><input type="submit" name="submit" value="Enviar" /></div>
<div><input type="reset" name="reset" value="Reset" /></div></div>

</form>
 </div>
</body>
</html>

