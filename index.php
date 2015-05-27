<?php 
    session_start();

    session_destroy();
?> 
<html>
    <head> 
        <meta charset="utf-8">
        <title> LDAP </title>
        <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/skeleton.css">
    </head>
    <body>
        <div class="container">
            <h1 class="row">Acceso a  LDAP </h1>
            <form action="form0.php" method="post">
            <div class="row six columns">
		<div class="six columns">
                    <label>Usuario</label>
                    <input class="u-full-width" type="text" name="login">
                    <label>Contraseña</label>
                    <input class="u-full-width" type="password" name="pass">
                    <input class="button-primary" type="submit" value="MOSTRAR MIEMBROS">
                </div>
            </div>
            </form>
        </div>
    </body>
