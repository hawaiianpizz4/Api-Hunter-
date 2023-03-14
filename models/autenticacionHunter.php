<?php
    class Autenticar extends Conectar{
        public function get_user($user,$password){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="select count(*) as valor from  REPORTES.dbo.control_usuarios_api_hunter where usuario ='$user' and pass = '$password'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }
    } 

    
?>