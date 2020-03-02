<?php

    namespace db;

    class db
    {
        private static $instance;
        private $dbConn;

        private static function getInstance(){
            if (self::$instance == null){
                $className = __CLASS__;
                self::$instance = new $className;
            }

            return self::$instance;
        }

        /**
         *
         * @return DbConn
         */
        private static function initConnection(){
            $db = self::getInstance();

            $db->dbConn = new pdo('mysql:host='.Config::get('dbHost').';dbname='.Config::get('dbName'), Config::get('dbLogin'), Config::get('dbPass'));

            return $db;
        }

        /**
         * @return mysqli
         */
        public static function getDbConn()
        {
            try
            {
                $db = self::initConnection();
                return $db->dbConn;
            } catch (PDOException $ex) {
                echo "I was unable to open a connection to the database. " . $ex->getMessage();
                return null;
            }
        }
    }