<?php
//initialize class to export config var from file to attribute
Config::init();

class Config
{

    static private $array = array();

    /*
     * This method initialize basic method
     */
    static public function init()
    {
        self::loadBasicVar();
    }

    static function loadBasicVar()
    {
        self::$array = array_merge(self::$array, require "./config/confBasic.php");
    }

    static function get($name)
    {
        return self::$array[$name];
    }
    static function set($name, $value)
    {
        self::$array[$name] = $value;
    }
    static function exist($name)
    {
        return isset(self::$array[$name]);
    }
    public function __debugInfo()
    {
        echo htmlentities("DEBUGING INFO: class name <".__CLASS__.'>').'<br>';
        foreach(self::$array as $key => $value)
        {
            echo '['.$key.'] => '.$value.'<br>';
        }
    }
}
