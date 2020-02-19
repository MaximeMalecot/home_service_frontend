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
function connection(){
  var zone =
  document.getElementById('connect').innerHTML = zone;
  const request = new XMLHttpRequest();

  request.open('GET', 'getconnect.php');

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(affichage) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('connect').innerHTML = request.responseText ;
    }else {
      document.getElementById('connect').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send();
}
