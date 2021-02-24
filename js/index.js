
function validateRegisterForm(){
  let usernameMinLength = 3;
  let usernameMaxLength = 50;
  let emailMinLength = 0;
  let emailMaxLength = 40;
  let passwordMinLength = 5;
  let passwordMaxLength = 15;
  let errorElement = document.getElementById("registerError");
  errorElement.innerHTML="";
  let hata = false;

  let usernameElement = document.getElementsByName("registerUsername")[0];
  let username = usernameElement.value;
  if (username == null || username == "") {
    return; // Hata
  }
  else if(username.length < usernameMinLength || username.length > usernameMaxLength){ // Çok kısa veya Çok uzun ise
    errorElement.innerHTML = ''+
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
        'Kullanıcı adı '+usernameMinLength+' ile '+usernameMaxLength+' karakter arasında olmak zorundadır.'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
        '</button>'+
      '</div>';
      hata = true;
  }

  let emailElement = document.getElementsByName("registerEmail")[0];
  let email = emailElement.value;
  if (email == null || email == "") {
    return; // Hata
  }
  else if(email.length > emailMaxLength){ // Çok uzun ise
    errorElement.innerHTML += ''+
    '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
      'Email '+emailMaxLength+' karakterden uzun olamaz.'+
      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
        '<span aria-hidden="true">&times;</span>'+
      '</button>'+
    '</div>';
    hata = true;
  }

  let passwordElement = document.getElementsByName("registerPassword")[0];
  let password = passwordElement.value;
  if (password == null || password == "") {
    return; // Hata
  }
  else if(password.length < passwordMinLength || password.length > passwordMaxLength){ // Çok kısa veya Çok uzun ise
    errorElement.innerHTML += ''+
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
        'Şifre '+passwordMinLength+' ile '+passwordMaxLength+' karakter arasında olmak zorundadır.'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
        '</button>'+
      '</div>';
      hata = true;
  }

  if (hata == false) {
    // Success
    let form = document.getElementById("registerForm");
    form.submit();
  }
}

function validateLoginForm(){

  let emailElement = document.getElementById("loginEmail");
  let email = emailElement.value;
  if (email == null || email == "") {
      return;
  }

  let passwordElement = document.getElementById("loginPassword");
  let password = passwordElement.value;
  if (password == null || password == "") {
      return;
  }

  let form = document.getElementById("loginForm");
  form.submit();
}
