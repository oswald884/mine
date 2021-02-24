
function getProfImage(){
  let fileInputElement = document.getElementById("fileProf");

  if (!fileInputElement.value) {
    return;
  }

  let file = fileInputElement.files[0];
  let fileName = file.name;
  let parcala = fileName.split('.');
  let extension = parcala[parcala.length -1];
  extension = extension.toLowerCase();

  if(extension != "png" && extension != "jpg" && extension != "jpeg"){
    // Uygun olmayan dosya formatı
    alert("Uygun olmayan dosya formatı. (png, jpg veya jpeg)");
  }
  else{
    let form = document.getElementById("profImageForm");
    form.submit();
  }
}
