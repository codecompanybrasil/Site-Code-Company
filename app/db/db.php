<?php
    class DB_Requests {
        public $pdo;
        public $conn_sql;

        function __construct() {
            $this->pdo = $this->connect();
        }

        public function connect() {
            $this->conn_sql = array(
                "hostname" => getenv('DB_HOST'),
                "user" => getenv('DB_USER'),
                "database" => getenv('DB_DATABASE'),
                "password" => getenv('DB_PASSWORD')
            );
            
            try {
                $pdo = new PDO("mysql:dbname=".$this->conn_sql["database"].";host=".$this->conn_sql["hostname"], $this->conn_sql["user"], $this->conn_sql["password"]);
            } catch (Exception $err) {
                echo $err;
                die();
            }

            return $pdo;
        }

        public function getUser($idUser) {
            $pdo = $this->connect();
            $query = $pdo->prepare("SELECT * FROM membros WHERE idUser = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            return $query->fetch();
        }

        public function getClient($idClient) {
            $pdo = $this->connect();
            $query = $pdo->prepare("SELECT idClient FROM freelancers WHERE idUser = :idUser");
            $query->bindValue(":idUser", $idClient);
            $query->execute();
            return $query->fetch();
        }

        public function minusProposta($idClient) {
            $pdo = $this->connect();
            $query = $pdo->prepare("SELECT propostas FROM freelancers HERE idUser = :idUser");
            $query->bindValue(":idUser", $idClient);
            $query->execute();
            $propostas = $query->fetchone();
            $query = $pdo->prepare("UPDATE freelancer SET propostas = :propostas WHERE idUser = :idUser");
            $query->bindValue(":propostas", $propostas - 1);
            $query->bindValue(":idUser", $idClient);
        }

        public function getClients($idUser) {
            $pdo = $this->connect();
            $query = $pdo->prepare("SELECT idClient FROM freelanceClient WHERE idUser = :idUser");
            $query->bindValue(":idUser", $idUser);
            $query->execute();
            return $query->fetch();
        }

        
    }
?>