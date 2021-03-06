<?php


// abstract method implement in abstract factory

define("UPLOAD_TO_JSON", 0);
define("UPLOAD_TO_FILE", 1);


abstract class upload
{
    protected $maxSize, $tmp_name, $errno;

    /**
     * //check error and correctness extension
     * @return bool
     * @param $fileHandName string //handler name tmp file
     * @param $acceptExt array // handler array accepted extension
     */
    public function __construct($fileHandName, $acceptExt)
    {
        if(isset($_FILES[$fileHandName]))
        {
            $file = $_FILES[$fileHandName];

            if(in_array(pathinfo($file['name'], PATHINFO_EXTENSION), $acceptExt))
            {
                $this->maxSize = $file['size'];
                $this->tmp_name = $file['tmp_name'];

                return true;
            }
            else
                $this->errno = 2;
        }
        else
            $this->errno = 1;
        return false;
    }

    /**
     * require method execute
     * @return bool;
    */
    abstract public function execute();

    /**
     * @return int
     */

    public function getErrno()
    {
        return $this->errno;
    }
    /**
     *  @return string
     */

    public function getErrText()
    {
        switch($this->errno)
        {
            case 1:
                return  "Nie ma pliku";
                break;
            case 2:
                return "Złe rozszerzenie";
                break;
            case 3:
                return "Nie można przenieść pliku";
                break;
            default:
                return "Nie znany błąd";
        }
    }
}

//you can more exception for upload. But class need construct with hand to parent construct and execute method
class uploadCsv extends upload
{
    /**
     * @param string $fileHandName name of input file in form
     */
    public function __construct($fileHandName)
    {
        parent::__construct($fileHandName, array('csv'));
    }

    /**
     * @param $typeEx int with this we chose saving type
     * @return void
     * this method convert to json and save to sess or save to file in server
     * */
    public function execute($typeEx = 0 )
    {
        switch ($typeEx) {
            case 0: //to sess
                $_SESSION['csvFile'] = json_encode(file($this->tmp_name));
                break;
            case 1: //to file
                rename($this->tmp_name, "csv/" . date('U'));
                break;
        }
    }
}