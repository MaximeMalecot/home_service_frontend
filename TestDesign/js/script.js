function menu1(){
  const request = new XMLHttpRequest();

  request.open('GET', 'menu1.php');

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(menu1) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('menu1').innerHTML = request.responseText ;
    }else {
      document.getElementById('menu1').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send();
}
function abonnement(){
  const request = new XMLHttpRequest();

  request.open('GET', 'abonnement.php');

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(abonnement) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('abonnement').innerHTML = request.responseText ;
    }else {
      document.getElementById('abonnement').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send();
}
/*function home(){
  const request = new XMLHttpRequest();

  request.open('GET', 'home.php');

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(home) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('home').innerHTML = request.responseText ;
    }else {
      document.getElementById('home').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send();
}*/
function connection(){
  var zone = document.getElementById('connect').innerHTML;
  const request = new XMLHttpRequest();

  request.open('GET', 'getconnect.php');

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(connection) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('connect').innerHTML = request.responseText ;
    }else {
      document.getElementById('connect').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send();
}
