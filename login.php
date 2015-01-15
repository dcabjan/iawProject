<?php 

session_start();

 


if (isset($_GET['tanca']))//si en un altre script m´han passat sa variable tanca elimina la sessio
{
session_unset();

// destroy the session
session_destroy(); 
//print("destrueix sessio");
}



 if ($_SERVER['REQUEST_METHOD'] == 'POST')
 {
   if ($_POST['user']=="admin")
   { 
     if ($_POST['pass']=="1234")
     {
	 
	 $_SESSION['login']  = 'true'; //login es sa variable que heu d´emplear per comprovar que s´ha iniciat sessio
	// print($_SESSION['login']); 

  header('Location:list.php');//AQUI S´HA DE POSAR EL NOM DE LA PRIMERA PAGINA vostra
   exit;
     }
     else
	 {
	  $error2="wrong password  ";
	 }
   }
   else
   { 
     
	$error="wrong user";
	
   }
 
  
}
  
 

?>
<html>
<head><title>LOGIN</title></head>
<style>
#box {
	border: solid;
	width: 420px;
	height: 175px;
	padding-left: 20px;
	background-color: yellow;
	margin: 100px auto;
}
.row {
	width: 400px;
	height: 30px;
	}
	.row-1 {
	width: 100px;
	height: 30px;
	float: left;
	}
	.row-2 {
	width: 150px;
	height: 30px;
	float: left;
	}
	.row-3 {
	width: 150px;
	height: 30px;
	float: left;
	}
	.row-b {
	float: right;
	margin-right: 20px;
	}
</style>
<body>
<div id=box>
<h3>Login</h3>
<form class="contact_form" action="login.php" method="post">
  
  <div class=row><div class=row-1>login:</div><div class=row-2><input type="text" name="user" required <?php if (isset($error) or isset($error2)) { print('value="'.$_POST[user].'"');} ?> /></div>
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
<div class=row><div class=row-b><input type="submit" value="Enviar" /></div>
<div class="row-b"><button type="reset" value="Reset">Borrar</button></div></div>
</form>
 </div>
</body>
</html>

