<?php

    abstract class AbstractManager
    {
        protected PDO $db;

        public function __construct()
        {

            

            $dbHost = $_ENV['DB_HOST'];
            $dbUser = $_ENV['DB_USER'];
            $dbPass = $_ENV['DB_PASS'];
            $dbName = $_ENV['DB_NAME'];
            $dbPort = $_ENV['DB_PORT'];

            $connexion = "mysql:host=".$dbHost.";port=".$dbPort.";charset=utf8;dbname=".$dbName;
            $this->db = new PDO(
                $connexion,
                $dbUser,
                $dbPass
            );
        }
    }
