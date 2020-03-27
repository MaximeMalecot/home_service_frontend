function gotoCheckout(id){
  var stripe = Stripe('pk_test_Z3ctWJuVAUFJ4b3C5VJxnN5u002lvbMdIJ');
  stripe.redirectToCheckout({
    // Make the id field from the Checkout Session creation API response
    // available to this file, so you can provide it as parameter here
    // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
    sessionId: id
  }).then(function (result) {
    // If `redirectToCheckout` fails due to a browser or network
    // error, display the localized error message to your customer
    // using `result.error.message`.
  });
}
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

  request.open('GET', 'abonnement.php?');

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

function verifconnect(){

    const request = new XMLHttpRequest();
    let mail =  document.getElementById('mail').value;
    let mdp = document.getElementById('mdp').value;

    console.log(mail);
    console.log(mdp);
    request.open('POST', 'verif_connect.php', true);

    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    request.onreadystatechange = function(reserve) {
      if(request.readyState === 4 && request.status == 200){
        document.getElementById('connect').innerHTML = request.responseText ;
      }else {
        document.getElementById('connect').innerHTML = '<span style="color:red">Il y a eu une erreur dans la connection veuillez réessayer ultérieurement!</span>';
        ;
      }
    }
    request.send("mail=" + mail + "&mdp=" + mdp);
}

function cancelco(){
  const request = new XMLHttpRequest();

  request.open('GET', 'connect_zone.php');
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

function reserve(id,categorie){
  const request = new XMLHttpRequest();

  request.open('POST', 'reserve.php', true);

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(reserve) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('prestationcontent').innerHTML = request.responseText ;
    }else {
      document.getElementById('prestationcontent').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send("id=" + id + "&nom=" + categorie);
}

function getabo(id){
  const request = new XMLHttpRequest();

  request.open('GET', 'abonnement_information.php?id=' + id);

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(getabo) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('abonnements').innerHTML = request.responseText ;
    }else {
      document.getElementById('abonnements').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send();
}

function select_type(){
  if (document.getElementById('type').value == 1){
    document.getElementById('input_date_fin').style.visibility="hidden";
  }
  else{
    document.getElementById('input_date_fin').style.visibility="visible";
  }
}

function select_langue(){
  const request = new XMLHttpRequest();
  var langue = document.getElementById('langue').value;

  request.open('GET', 'index.php?langue=' + langue);

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(getabo) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementsByTagName('html').innerHTML = request.responseText ;
    }else {
      document.getElementsByTagName('html').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send();

}

function addsuppl(){
  if(document.getElementById('supplement').checked == true){
    document.getElementById('input_spec').style.visibility="visible";
  }
  else{
    document.getElementById('input_spec').style.visibility="hidden";
  }
}

function getcost(id,categorie){
  const request = new XMLHttpRequest();

  let type = document.getElementById('type').value;
  let heure =  document.getElementById('heure').value;
  let date_debut = document.getElementById('date_debut').value;
  let date_fin = document.getElementById('date_fin').value;

  if(document.getElementById('supplement').checked == true){
    var supplement = document.getElementById('spec').value;
  }
  else{
    var supplement = "aucun";
  }
  console.log(supplement);
  request.open('POST', 'verifcostpresta.php', true);

  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

  request.onreadystatechange = function(getcost) {
    if(request.readyState === 4 && request.status == 200){
      document.getElementById('finalpresta').innerHTML = request.responseText ;
    }else {
      document.getElementById('finalpresta').innerHTML = '<span style="color:red">Erreur!</span>';
      ;
    }
  }
  request.send("type=" + type + "&heure=" + heure + "&date_debut=" + date_debut + "&date_fin=" + date_fin + "&supplement=" + supplement + "&nom=" + categorie + "&id=" + id);
}

function takepresta(idprestation,idprestataire,cout,ville){
  console.log("oui");
}
