<?php


    class db
    {
        private $pdo;
        public function __construct($host, $dbName, $userName, $userPass)
        {
            try
            {
                $this->pdo = new pdo('mysql:host='.$host.';dbname='.$dbName, $userName, $userPass);
            }
            catch (PDOException $errno)
            {
                die("Bład połączenie z bazą danych. Numer błędu: ".$errno->getCode());
            }
        }

        /**
         * @return pdo
         */
        public function getPdo()
        {
            return $this->pdo;
        }
    }