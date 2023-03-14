<?php
    class Bases extends Conectar{
        public function get_base(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="SELECT MARCA,MODELO,CHASIS,MOTOR,COLOR FROM REPORTES.dbo.tbl_motos_hunter_carga";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_OBJ);
        }
        public function insertMotos($chasis,$motor,$fecha,$id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO tbl_hunter_datos_instalaciones VALUES ('$chasis','$motor','$fecha','$id')";
            $sql = $conectar->prepare($sql);
            if($sql->execute()){
                return $resultado = 'realizado';
            }else{
                return $resultado = $sql->errorInfo();
            }
        }
        public function ventasMotos(){
            $conectar = parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM REPORTES.dbo.tbl_venta_hunter";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado = $sql->fetchAll(PDO::FETCH_OBJ);
        }
    } 
?>