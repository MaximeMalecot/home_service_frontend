function menu1(){
  var nouveau = "Menu1";
  document.getElementById('menu1').innerHTML = nouveau;
}
function menu2(){
  var nouveau = "Menu2";
  document.getElementById('menu2').innerHTML = nouveau;
}
function home(){
  var nouveau = "Home";
  document.getElementById('home').innerHTML = nouveau;
}

function register(){
    const request = new XMLHttpRequest();

    request.open('GET', 'inscription.php');

    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    request.onreadystatechange = function(register) {
      if(request.readyState === 4 && request.status == 200){
        document.getElementById('info').innerHTML = request.responseText ;
      }else {
        document.getElementById('info').innerHTML = '<span style="color:red">Erreur!</span>';
        ;
      }
    }
    request.send();
}

function sendaccount(){

}
