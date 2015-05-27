<?php  session_start();  ?>
<!DOCTYPE html>
 
<?php
     // [ INCLUDE  _____________________________________________________________ 
           include './funciones.php';
     // ] INCLUDE ______________________________________________________________
        
     if(!empty($_POST['login']))   { 
        $user     = $_POST["login"];
        $password = $_POST["pass"] ; 
      }else{
          
           if(!empty($_SESSION["login"]))   { 
                $user     = $_SESSION["login"];
                $password = $_SESSION["pass"] ; 
           }
           else{
                //controlar cuando no se indiquen valores user y/o password
                $user = "123";  
                $password = "123"; 
           }
      } 
     // [ VARIABLES SESIÓN______________________________________________________
            $_SESSION["login"] = $user;
            $_SESSION["pass"] = $password;

            $_SESSION["array_grupos"]  = @getGroups($user,$password);
            $_SESSION["arra_usuarios"] = @getUsers($user,$password); 
            $allGRoups =  $_SESSION["array_grupos"] ;  
            $allUsers =   $_SESSION["arra_usuarios"] ;
     // ] VARIABLES SESIÓN______________________________________________________
 ?>
<html>
    <head>
        <title>Conexión a LDAP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/skeleton.css">
    </head>
    <body>   
 <?php if ( accessLDAP($user,$password)==true) {?>    
        <div class="container">
                <form action="form1.php" method="post">
                    <?php 
                         
                        echo "<div>";
                        echo "Selecciona un usuario<br>" ;
                        echo "<select name='gUsuario'>";
                                for ($i=0; $i<$allUsers["count"]; $i++) { 
                                    echo "<option  value=".$allUsers[$i]["cn"][0].">"
                                            .$allUsers[$i]["cn"][0]
                                            ."</option>  "; 
                                }
                        echo "</select>";
                        echo "</div>";
                   ?>  
                     <br>
                    <?php 
                        echo "<div>";
                        
                        echo "Selecciona un grupo<br>" ;
                        echo "<select name='grupo'>";
                                for ($i=0; $i<$allGRoups["count"]; $i++) { 
                                    echo "<option  value=".$allGRoups[$i]["name"][0].">"
                                            .$allGRoups[$i]["name"][0]
                                         ."</option>  "; 
                                }
                        echo "</select>";
                        echo "</div>";
                   ?>
                    <br>
                    <br>                    
                    <input type="submit" value="MOSTRAR MIEMBROS DEL GRUPO"></input>
                    <br><i>Ejemplo: usuario msmith0 esta contenido en testers y trends</i>
                </form>
        
 <?php } else {?>
                <form action="index.php" method="post">
                  No tiene acceso.
                    <br>
                   <br>
                   <input class="button-primary" type="submit" value="ATRAS"></input>
               </form>
 <?php } ?>  
            </div>
    </body>
</html>
 