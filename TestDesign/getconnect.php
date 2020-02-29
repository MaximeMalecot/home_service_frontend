<?php
  echo "
  <form id=\"form_connect\" method=\"POST\" action=\"verif_connect.php\">
    <input type=\"mail\" placeholder=\"Votre mail\" id=\"mail\" class=\"form-control\" name=\"mail\" oninput =\"cliquable()\"/>
    <input type=\"password\" placeholder=\"Votre mot de passe\" id=\"mdp\" class=\"form-control\" name=\"mdp\" oninput =\"cliquable()\"/>
    <input class=\"btn btn-primary\" type=\"submit\" id = 'formconnexion'  value=\"Se connecter\" />
  </form>";


?>
