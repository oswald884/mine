
function validateShareForm(){
  let form = document.getElementById("shareForm");
  let imgPlace = document.getElementById("imgChosen");

  // Resim seçilmiş mi kontrol et
  let imageElement = document.getElementById("imgFile");

  form.submit();
}

function getImage(){
  let imgPlace = document.getElementById("imgChosen");
  let imageElement = document.getElementById("imgFile");
  if (!imageElement.value) {
    return;
  }
  let errorElement = document.getElementById("errorDiv");

  let file = imageElement.files[0];
  let fileName = file.name;
  let parcala = fileName.split('.');
  let extension = parcala[parcala.length -1];
  extension = extension.toLowerCase();

  if(extension != "png" && extension != "jpg" && extension != "jpeg"){
    // Uygun olmayan dosya formatı
    errorElement.innerHTML = ''+
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
        'Uygun olmayan dosya tipi. (Sadece png, jpg ve jpeg olabilir.)'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
        '</button>'+
      '</div>';
      imageElement.value="";
  }
  else{
    var tmppath = URL.createObjectURL(file);
    imgPlace.src = tmppath;
  }
}
