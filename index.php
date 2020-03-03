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
            <span>
                <label for="fileInp">
                    <div class="choseFile"> Wybierz plik</div>
                </label>
                <span class="fileName " id="nameUploadFile"></span>
            </span>
            <button type="submit">Wyślij</button>
        </form>
        <p id="messageBox"></p>
        <progress id="uploadProgress"></progress>
        <script>initUpload("formFile", "messageBox", "uploadProgress", "nameUploadFile")</script>

    </body>

</html>
