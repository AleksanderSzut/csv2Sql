
<?php

session_start();

require_once "class/upload.class.php";
require_once "class/csv2sql.class.php";
require_once "class/db.class.php";

global $db;

$db = new db("localhost", "csv2sql", "root", "");

if(isset($_FILES['csvFile']))
{
    $uploadHand = new uploadCsv('csvFile');

    if($uploadHand->getErrno() == NULL)
    {
        $uploadHand->execute(0);

        $csvHand = new csv2sql\csv2sql;

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
<!DOCTYPE html>
<html>
    <head>
        <title> Dodawanie pliku </title>
    </head>
    <body>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="file" name="csvFile">
            <input type="submit" value="Wyślij plik">

        </form>

    </body>

</html>
