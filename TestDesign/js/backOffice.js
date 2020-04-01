function displayInput(form){
  var form = document.getElementById(form);
  form.style.display = '';
}
function hideInput(form){
  var form = document.getElementById(form);
  form.style.display = 'none';
}
function modifyAbo(id){
  var nom = document.getElementById('inputNom'+id).value;
  var cout = document.getElementById('inputCout'+id).value;
  var nb_heure = document.getElementById('inputNb'+id).value;
  var temps = document.getElementById('inputTemps'+id).value;
  var heure_debut = document.getElementById('inputHD'+id).value;
  var heure_fin = document.getElementById('inputHF'+id).value;

  const request = new XMLHttpRequest();

  request.open('POST','backOffice/changeAbo.php');

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(modifyAbo) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('Abos').innerHTML = request.responseText ;
    }else {
      document.getElementById('Abos').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }

  request.send("id=" + id + "&nom=" + nom + "&cout=" + cout + "&nb_heure=" + nb_heure + "&temps=" + temps + "&heure_debut=" + heure_debut +"&heure_fin=" + heure_fin);
}

function deleteSous(id){

  const request = new XMLHttpRequest();
  request.open('POST','backOffice/changeSous.php');

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(modifySous) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('Souscriptions').innerHTML = request.responseText ;
    }else {
      document.getElementById('Souscriptions').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }

  request.send("id=" + id);
}
