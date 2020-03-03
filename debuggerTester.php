<?php

    require_once "class/Config.class.php";
    require_once "class/db.class.php";

    class testDb
    {
        protected $dbConn;

        public function __construct()
        {
            $this->dbConn = db::getDbConn();

        }
    }

    new testDb();