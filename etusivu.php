<!DOCTYPE html>
<html>
<head>
  <title>Etusivu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="autopaikka.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Allura|Arapey|Cardo|Covered+By+Your+Grace|Crimson+Text|Dancing+Script|Gentium+Basic|Great+Vibes|Libre+Baskerville|Meddon|Mr+De+Haviland|Old+Standard+TT|PT+Serif|Parisienne|Sacramento|Tangerine|Tinos" rel="stylesheet">
</head>
<body>

<?php

$config = parse_ini_file($_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/../pdo.ini");
 
#$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['dbname']);
$dsn = "mysql:host=" . $config['server'] . ";dbname=" . $config['dbname'] . ";charset=utf8mb4";
#$dsn = "mysql:host=localhost;dbname=myDatabase;charset=utf8mb4";
$options = [
  PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
];
try {
  $pdo = new PDO($dsn, $config['username'], $config['password'], $options);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (Exception $e) {
  error_log($e->getMessage());
  exit('Database connection failed'); //connection failed
}
?>

<nav class="navbar navbar-default">
  <div class="container">
    <ul class="nav navbar-nav navbar-right">
		<li class="active"><a href="index.html">Etusivu</a></li>
        <li><a href="autopaikka.php">Tulosta vuokrasopimus</a></li>
        <li><a href="ehdot.php">Muokkaa sopimusehtoja</a></li>
        <li><a href="kohteet.php">Muokkaa kohteita</a></li>
        <li><a href="kayttajat.php">Muokkaa käyttäjiä</a>
    </li>
    </ul>
  </div>
</nav>
  
<div class="row">  
  <div class="col-sm-12">
    <div class="col-sm-1">
    </div>
  <div class="col-sm-10">
    <h3>Tervetuloa autopaikkavuokrasopimusten tulostusjärjestelmään!</h3>
  </div>
  <div class="col-sm-1">
  </div>
</div>
</div>
<br><hr><br>

<div class="row">
  <div class="col-sm-12">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
      <h4>Vuokrasopimuksen tulostaminen:</h4>
      <p>Voit tulostaa uuden vuokrasopimuksen klikkaamalla <a href="autopaikka.php">"Vuokrasopimuksen tulostaminen"</a>. 
      </p>
      <p>Huomioithan, että järjestelmä ei tallenna vuokrasopimuksia eikä autopaikan vuokranneiden 
        asiakkaiden tietoja, joten tallennathan tulostamasi autopaikan vuokrasopimuksen pdf-tiedoston 
        suoraan omalle työasemallesi.
      </p>
    </div>
    <div class="col-sm-1">
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-sm-12">
  <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
      <h4>Sopimusehtojen muokkaus:</h4>
      <p>Pääset muokkaamaan, poistamaan tai lisäämään vuokrasopimusten yleisiä sopimusehtoja
      klikkaamalla <a href="ehdot.php">"Muokkaa ehtoja"</a>. 
      </p>
    </div>
    <div class="col-sm-1">
    </div>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-sm-12">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
      <h4>Kohteiden muokkaus:</h4>
      <p>Pääset muokkaamaan, poistamaan tai lisäämään autopaikkoihin ja kohteisiin liittyviä lisätietoja  
        sekä erityisehtoja klikkaamalla <a href="kohteet.php">"Muokkaa kohteita"</a>. 
      </p>
    </div>
    <div class="col-sm-1">
    </div>
  </div>
</div><br>

<footer class="container-fluid text-center">
	<p><strong>Web Design &copy; <i>Mira Louhe 2020</i></strong></p>
</div>


</body>
</html>
