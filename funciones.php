<?php
include './configuracion/database.php';
 

/*
 * obtener todos los grupos sin filtro
 */
function getGroups($usuario,$contrasenya) {     
       //consulta de grupos_______________________________
           $query  = "(objectClass=group)";  
           return connectLDAP($query,$usuario,$contrasenya);    
 } 
  
/*
 * obtener todos los grupos sin filtro
 */
function getUsers($usuario,$contrasenya) {     
       //consulta de users_______________________________
           $query  = "(objectClass=user)";  
           return connectLDAP($query,$usuario,$contrasenya);    
 }  
 /*
  * Devuelve Si o No el usuario pertenece al grupo seleccionado.
  */
 function getUsuarioExisteEnGrupo($grupo,$filtro_usuario,$usuario,$contrasenya) {     
 
    
       //consulta de grupos_______________________________
           $query  = "(&(objectClass=user)(CN=".$filtro_usuario."))";  
           $array_grupos = connectLDAP($query,$usuario,$contrasenya);  
           //print_r($array_grupos);
           //echo "<hr>";
          // print_r($array_grupos[0]['memberof']); //--> tenemos lista de grupos del usuario
           $array_grupos_usuario = $array_grupos[0]['memberof'];
           
       //¿$grupo esta contenido en la lista de grupos del usuario?              
            $encontrar = "CN=".$grupo.",".DB_LDAP_DN;
            
            if (in_array($encontrar, $array_grupos_usuario)) {
                $siExiste = true; 
            }else{
                $siExiste = false; 
            } 
            return $siExiste;
 } 
 
 
  /*
  * Devuelve Si o No el usuario pertenece al grupo seleccionado.
  */
 function verUsuarios($array_users,$filtro_usuario,$filtro_grupo,$usuario,$contrasenya) {     
 
    
       //consulta de grupos_______________________________
           $query  = "(&(objectClass=user)(CN=".$filtro_grupo."))";  
           
           //tenemos lista de grupos del usuario
           $array_grupos_usuario = $array_users[0]['memberof'];
           
       //¿$grupo esta contenido en la lista de grupos del usuario?              
            $encontrar = "CN=".$filtro_usuario.",".DB_LDAP_DN;
            
            if (in_array($encontrar, $array_grupos_usuario)) {
                $siExiste = true; 
            }else{
                $siExiste = false; 
            } 
            return $siExiste;
 }
 
 /*
  * //consulta de miembros del grupo especificado
  */
 function getMember($groupName,$usuario,$contrasenya){
       
           $query  = "(CN=".$groupName.")";  
           return connectLDAP($query,$usuario,$contrasenya);  
 }
  
 /*
  * CONEXION LDAP
  */
 function connectLDAP($query,$user,$psw) {
    //_________________________________________________
    $ds = ldap_connect(DB_LDAP_SERVER);

    if ($ds) {
        //NECESARIO PARA QUE FUNCIONE LA CONEXION __________________________________
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

        // AUTENTIFICACIÓN DE USUARIO ______________________________________________
        $r = ldap_bind($ds, $user . DB_LDAP_DOMAIN, $psw);
 
        // OBTENEMOS DATOS DE LOS GRUPOS
        $sr = ldap_search($ds, DB_LDAP_DN, $query);

        $info = ldap_get_entries($ds, $sr);

        return $info;

        //CERRAR CONEXIÓN
        ldap_close($ds);
    } else {
        echo "<h4>No hay conexión con el servidor LDAP </h4>";
    }
}

/*
 * ¿ ACCESO PERMITIDO con user y passwords indicados?
 */
function accessLDAP($user, $psw) {
    //_________________________________________________
    $ds = ldap_connect(DB_LDAP_SERVER);

    if ($ds) {
        //NECESARIO PARA QUE FUNCIONE LA CONEXION __________________________________
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

        // AUTENTIFICACIÓN DE USUARIO ______________________________________________
        $bind = @ldap_bind($ds, $user . DB_LDAP_DOMAIN, $psw);

        if (!$bind) {
            $r = 0;
        } else {
            $r = 1;
        }
        //CERRAR CONEXIÓN
        ldap_close($ds);
    } else {
        echo "<h4>No hay conexión con el servidor LDAP </h4>";
         $r = 0;
    }

    return $r;
}
