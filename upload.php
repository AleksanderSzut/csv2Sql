
<?php

session_start();

require_once "class/Config.class.php";
require_once "class/db.class.php";
require_once "class/upload.class.php";
require_once "class/csv2sql.class.php";


if(isset($_FILES['csvFile']))
{
    $uploadHand = new uploadCsv('csvFile');

    if($uploadHand->getErrno() == NULL)
    {
        $uploadHand->execute(UPLOAD_TO_JSON);

        $csvHand = new csv2sql;

        if($csvHand->parseCsv())
        {
            $csvHand->csvToArr();
            if($csvHand->dump2sql())
            {
                echo "Pomyślnie dodałem wszystkie wyniki do bazy danych";
            }

        }


    }
    else
    {
        echo $uploadHand->getErrText();
    }


}
else
    echo "Nie ma pliku";

?>