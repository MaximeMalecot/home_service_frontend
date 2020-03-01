function prestation(){
  const request = new XMLHttpRequest();

  request.open('GET', 'prestation.php');

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(prestation) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('prestation').innerHTML = request.responseText ;
    }else {
      document.getElementById('prestation').innerHTML = '<span style="color:red">Erreur!</span>';
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
function home(){
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
}

function prestationcontent(name)
{
  const request = new XMLHttpRequest();

  request.open('GET', 'prestationcontent.php?nom=' + name);

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(prestationcontent) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('prestationcontent').innerHTML = request.responseText ;
    }else {
      document.getElementById('prestationcontent').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send();
}

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
