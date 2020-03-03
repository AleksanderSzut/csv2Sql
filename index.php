<?php


?>
<!DOCTYPE html>
<html>

    <head>
        <script src="functionAssets.js"></script>
        <link rel="stylesheet" type="text/css" href="source/uploadFile.css">
    </head>
    <body>

        <form id="formFile">
            <input type="file" id="fileInp" name="csvFile">
            <label for="fileInp">
                <div class="choseFile"> Wybierz plik</div>

            </label>
            <button type="submit">Wyślij</button>
        </form>
        <p id="messageBox"></p>
        <progress id="uploadProgress"></progress>
        <script>initUpload("formFile", "messageBox", "uploadProgress")</script>

    </body>

</html>
