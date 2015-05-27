<?php  session_start();  ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
     include './funciones.php';
     
    //  if(empty($_SESSION['login'])) else     
       $usuario           =  $_SESSION["login"] ;
       $contrasenya       =  $_SESSION["pass"];
       
       $grupo          =  $_POST["grupo"];
       $filtro_usuario =  $_POST["gUsuario"];
       $allGRoups =  $_SESSION["array_grupos"] ; 
       $allUsers =   $_SESSION["arra_usuarios"] ;               
    // si el usuario de sesión y el password se ha perdido se tendrá que ir a la pagina de login para volver a acceder     
         
         
 ?>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/skeleton.css">
    </head>
    <body>
        <div class="container">
        <form action="index.php" method="post">
        <?php if((verUsuarios($allUsers,$grupo,$filtro_usuario,$usuario,$contrasenya))==1){ ?>            
            
            <?php
                
                            echo "<h4> MIEMBROS DEL GRUPO ".$grupo."</h4>" ;

                           // echo 'acceso permitido?'.verUsuarios($allUsers,$grupo,$filtro_usuario,$usuario,$contrasenya); 
                            $info_members= getMember($grupo,$usuario,$contrasenya); 

                             for ($i=0; $i<$info_members[0]["member"]["count"]; $i++) { 
                                    $mostrar =  $info_members[0]["member"][$i] ;
                                    $mostrar= str_replace("CN=","",$mostrar);
                                    $mostrar= str_replace(",".DB_LDAP_DN,"",$mostrar);
                                    echo "<div class='listas'><a>".$mostrar."</a></div><br>";
                             }        
        }else{ 
                          echo "  EL USUARIO ESCOJIDO NO ESTA CONTENIDO EN EL GRUPO SELECCIONADO."
                                . "<br>NO PUEDES VER LOS USUARIOS";
                            
         }?>
            <br><br>
            <input class="button-primary" type="submit" value="INICIO"></input>
        </form>
        <form action="form0.php" method="post">
            <button type="submit">VOLVER</button>
        </form>
        </div>
    </body>
</html>
 