<?php
    class Conectar{
        protected $dbh;
        protected function Conexion(){
            try{
                $conectar=$this->dbh= new PDO("sqlsrv:server=172.28.0.22;database=REPORTES","icesa_bi","Icesabi1234");
                return $conectar;
            }catch(Exception $e){
                print "!Error BD! : ". $e->getMessage()."<br/>";
                die();
            }
        }
        public function set_names(){
            return $this->dbh->query("Set Names 'utf8'");
        }
    }
?>