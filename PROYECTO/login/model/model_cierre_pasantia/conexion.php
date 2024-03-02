<?php
//creo una clase conexion
class Conexion {
    //instancio las variables que usare en la clase al ser privadas son private pq no pueden ser utilizadas fuera de aqui
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;
//creo un metodo constructor para desarrollar la conexion
    public function __construct($host, $db, $user, $password, $charset = 'utf8') {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->password = $password;
        $this->charset = $charset;
    }
//creo la funcion conectar donde se va intentar crear una conexion
    public function conectar() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}

?>