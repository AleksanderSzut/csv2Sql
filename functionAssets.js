
let form, inputFile, submitForm, uploadProgress, message, nameUploadFile;


function initUpload(formID, messageID, progressBarID, nameUploadFileID)
{
    form = document.getElementById(formID);
    inputFile = form.childNodes[1];
    submitForm = form.childNodes[2];
    uploadProgress = document.getElementById(progressBarID);
    message = document.getElementById(messageID);
    nameUploadFile = document.getElementById(nameUploadFileID);


    inputFile.addEventListener('change', function () {
        let nameFile = inputFile.files.item(0).name;

        if(nameFile != null)
        {
            nameUploadFile.classList.add("active");
            nameUploadFile.textContent = nameFile;
        }
        else
        {
            nameUploadFile.classList.add("active");
            nameUploadFile.textContent = "";

        }
    });

    form.addEventListener('submit', function (e) {

        e.preventDefault();
        let xhr = new XMLHttpRequest(),
            formData = new FormData();

        formData.append('csvFile', inputFile.files[0]);

        xhr.upload.onloadstart = function(e){

            uploadProgress.classList.add('visible');
            uploadProgress.value = 0;
            uploadProgress.max = e.total;
            message.textContent = 'wysyłanie pliku...';
            form.classList.add("disable");
        };

        xhr.upload.onprogress = function (e) {
            uploadProgress.value = e.loaded;
            uploadProgress.max = e.total;
        };

        xhr.upload.onloadend = function(e) {
            uploadProgress.classList.remove('visible');
            form.classList.remove('disable');
            message.textContent = 'Ukończono';
            inputFile.disabled = false;
        };

        xhr.onload = function () {
            message.textContent = 'Odpowiedź serwera:  ' + xhr.responseText;
        };

        xhr.open("POST", "upload.php", true);
        xhr.send(formData);
    });
}