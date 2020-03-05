function gotoCheckout(id){
  var stripe = Stripe('pk_test_Z3ctWJuVAUFJ4b3C5VJxnN5u002lvbMdIJ');
  console.log(stripe);
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
