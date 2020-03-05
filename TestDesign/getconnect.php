<?php
  echo "
  <form id=\"form_connect\" method=\"POST\">
    <input type=\"mail\" placeholder=\"Votre mail\" id=\"mail\" class=\"form-control\" name=\"mail\"/>
    <input type=\"password\" placeholder=\"Votre mot de passe\" id=\"mdp\" class=\"form-control\" name=\"mdp\"/>
    <input class=\"btn btn-primary\" id = 'formconnexion'  onclick=\"verifconnect()\"value=\"Se connecter\" />
    <button class=\"btn btn-primary\" onclick=\"cancelco()\" id='cancelco'>Annuler</button>
  </form>";


?>
