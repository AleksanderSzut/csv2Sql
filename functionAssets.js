
let form, inputFile, submitForm, uploadProgress, message;


function initUpload(formID, messageID, progressBarID)
{
    form = document.getElementById(formID);
    inputFile = form.childNodes[1];
    submitForm = form.childNodes[2];
    uploadProgress = document.getElementById(progressBarID);
    message = document.getElementById(messageID);

    console.log(inputFile);

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
            inputFile.disabled = true;
        };

        xhr.upload.onprogress = function (e) {
            uploadProgress.value = e.loaded;
            uploadProgress.max = e.total;
        };

        xhr.upload.onloadend = function(e) {
            uploadProgress.classList.remove('visible');
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