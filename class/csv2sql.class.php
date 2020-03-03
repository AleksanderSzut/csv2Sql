<?php



class csv2sql
{

    private $csvJson, $csvArr, $dbConn;

    public function __construct()
    {
        $this->dbConn = db::getDbConn();
    }

    public function csvToArr()
    {
        $json = $this->csvJson;

        $arrCsv = json_decode($json);

        $this->csvArr = $arrCsv;
    }

    public function getSchoolByRspo($rspo)
    {
        $pdo = $this->dbConn;

        $statement = $pdo->query("SELECT * FROM szkplacowki WHERE rspo='$rspo'");

        if($statement->rowCount() > 0)
            $row = $statement->fetch();
        else
            $row = FALSE;
        return $row;
    }
    public function deleteSchoolByRspo($rspo)
    {
        $pdo = $this->dbConn;

        if($pdo->query("DELETE FROM szkplacowki WHERE rspo='$rspo'"))
            return TRUE;
        else
            return FALSE;
    }
    public function addSchool($schoolRow)
    {
        $pdo = $this->dbConn;

        $keys = "";
        $i = 0;
        foreach ($schoolRow as $key => $value)
        {
            $i++;
            $keys .= ', :'.$key;
        }
        $keys = substr($keys, 2);

        $sqlQuery = "
INSERT INTO 
szkplacowki(rspo, typ, nazPlc, adrUlc, adrNrb, adrNrl, adrKod, adrMsc, terKod, terMsc, terGmi, telPra, faxPra, emlPra, wwwPra, wojew, powiat, gmina, regon, nip, pubPlc, katOdb, spcPlc, dyrektor, orgNaz, orgTyp, orgWoj, orgPow, orgGmi, datAdd, datDel) 
VALUES($keys)";

        $statement = $pdo->prepare($sqlQuery);

        $i=0;
        foreach ($schoolRow as $key => $value)
        {
            $i++;
            $statement->bindValue(':'.$key, $value);
        }

        if($statement->execute())
            return true;
        else
        {
            return false;

        }
    }

    public function dump2sql()
    {
        $csvArr = $this->csvArr;

        unset($csvArr[0]);

        $allOk = TRUE;

        foreach($csvArr as $key => $values)
        {
            $valueArr = explode(';', $values);
            $execValue =[];

            foreach($valueArr as $keyString => $value)
            {
                $value = str_replace('"', '', $value);

                $nameVal = $this->index2SqlName($keyString);
                if($nameVal == NULL)
                    break;
                $execValue[$nameVal] = $value;
            }

            $schoolRow = $this->getSchoolByRspo($execValue['rspo']);

            if($schoolRow != FALSE)
               $this->deleteSchoolByRspo($execValue['rspo']);

            if(!$this->addSchool($execValue))
            {
                echo '<span style="color:red;">Nie dodano wartosci numer:'.$execValue['rspo'].'</span><br>';
                $allOk = false;
            }
         }

        return $allOk;
    }

    public function index2SqlName($index)
    {   // co tu robimy
        $arrayName = [
            "rspo",
            "typ",//"Typ"
            "nazPlc",//"Nazwa"
            "adrUlc",//"Ulica"
            "adrNrb",//"numer budynku",
            "adrNrl",//"Numer lokalu",
            "adrKod",//"Kod pocztowy",
            "adrMsc",//"Miejscowość",
            "terKod",//'Kod terytorialny ulica',
            "terMsc",//'Kod terytorialny miejscowosc',
            "terGmi",//'Kod terytorialny gmina',
            "telPra",//'Telefon',
            "faxPra",//"Faks",
            "emlPra",//"email",
            "wwwPra",//"strona www",
            "wojew", //"wojewodztwo",
            "powiat",//"powiat",
            "gmina",//"Gmina",
            "regon",//"Regon",
            "nip",//"NIP",
            "pubPlc", //"Publiczność status",
            "katOdb", //"Katergoria uczniów",
            "spcPlc", //"Specyfikacja placówki",
            "dyrektor", //"Imie i nazwisko Dyrektora",
            "orgNaz", //"Nazwa organu prowadzącego",
            "orgTyp",//"Typ organu prowadzącego",
            "orgWoj",//"Województwo organy prowadzącego",
            "orgPow", //"Powiat organu prowadzącego",
            "orgGmi",//"Gmina organu prowadzącego",
            "datAdd", //"Data założenia",
            "dataDel", //"Data likwidacji",
            NULL,//"Miejsce w strukturze",
            NULL,//"Typ podmiotu nadrzędnego",
            NULL,//"RSPO podmiotu nadrzędnego",
            NULL,//"Nazwa podmiotu nadrzędnego",
            NULL,//"Liczba uczniów"
        ];

        return $arrayName[$index];
    }



    public function parseCsv()
    {
        if(isset($_SESSION['csvFile']))
            $this->csvJson = $_SESSION['csvFile'];
        else
            return false;
        return true;

    }

    /**
     * @return bool;
     * */

    public function sessFileExist()
    {
        return isset($_SESSION['csvFile']);
    }



}