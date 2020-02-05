<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<main>
  <div class="container">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
      <li><a data-toggle="tab" href="#menu1" onclick="menu1()">Menu 1</a></li>
      <li><a data-toggle="tab" href="#menu2" onclick="menu2()">Menu 2</a></li>
      <li><a data-toggle="tab" href="#menu3" onclick="menu3()">Menu 3</a></li>
    </ul>

    <div class="tab-content">
      <div id="home" class="tab-pane fade in active">

      </div>
      <div id="menu1" class="tab-pane fade">

      </div>
      <div id="menu2" class="tab-pane fade">

      </div>
      <div id="menu3" class="tab-pane fade">

      </div>
  </div>
  <script type="text/javascript" src="js/script.js"></script>
</main>
</body>
</html>
