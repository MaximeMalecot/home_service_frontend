<?php
  echo "
  <form id=\"form_connect\" method=\"POST\" action=\"verif_connect.php\">
    <input type=\"email\" placeholder=\"Votre mail\" id=\"email\" class=\"form-control\" name=\"email\" oninput =\"cliquable()\"/>
    <input type=\"password\" placeholder=\"Votre mot de passe\" id=\"mdp\" class=\"form-control\" name=\"mdp\" oninput =\"cliquable()\"/>
    <input class=\"btn btn-primary\" type=\"submit\" id = 'formconnexion'  value=\"Se connecter\" />
  </form>";


?>
