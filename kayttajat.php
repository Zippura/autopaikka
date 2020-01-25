<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kohteet</title>
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
  
  try {
  $stmt = $pdo->prepare("SELECT Tyontekija_id, EtuNimi, SukuNimi, Email, Puhelin FROM Tyontekijat");
  $stmt->execute();
  $tyontekijat = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(Exception $e) {
      echo 'Exception -> ';
      var_dump($e->getMessage());
    }
  
  ?>
  
  <script type="text/javascript">
  function haeRivi(rivit, id) {
      for (const rivi of rivit) {
          if (rivi["Tyontekija_id"]==id) {
              return rivi;
          }
      };
  }
  $(document).ready(function() {
      var data = <?=json_encode($tyontekijat)?>;
      $('#tyontekijat').change(function() {
          var valittuTyontekija = $(this).children("option:selected").val();
          var rivi = haeRivi(data, valittuTyontekija);
          $('#etunimi').val(rivi["EtuNimi"]);
          $('#sukunimi').val(rivi["SukuNimi"]);
          $('#puhelin').val(rivi["Puhelin"]);
          $('#sposti').val(rivi["Email"]);
      });
  });
  
  </script>

<nav class="navbar navbar-default">
  <div class="container">
      <ul class="nav navbar-nav navbar-right">
		<li><a href="etusivu.php">Etusivu</a></li>
        <li><a href="autopaikka.php">Tulosta vuokrasopimus</a></li>
        <li><a href="ehdot.php">Muokkaa sopimusehtoja</a></li>
        <li><a href="kohteet.php">Muokkaa kohteita</a></li>
        <li class="active"><a href="kayttajat.php">Muokkaa käyttäjiä</a></li>
      </ul>
  </div>
</nav>
  
<div class="row">
  <div class="col-sm-1">
  </div>
  <div class="col-sm-11">
      <h3>Muokkaa käyttäjien tietoja</h3>
  </div>
</div>
<br><br>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="tyontekijat" class="col-sm-3">Valitse käyttäjä:</label>
  <div class="col-sm-6">
    <select id="tyontekijat" name="tyontekijat" class="custom-select">
      <?php foreach ($tyontekijat as $row): ?>
        <option value="<?=$row["Tyontekija_id"]?>"><?=$row["EtuNimi"]?> <?=$row["SukuNimi"]?></option>
      <?php endforeach ?>   
    </select>
  </div>
  <div class="col-sm-1">
  </div>
</div>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="etunimi" class="col-sm-3">Etunimi:</label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="etunimi" name="etunimi">
  </div>
  <div class="col-sm-1">
  </div>
</div>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="sukunimi" class="col-sm-3">Sukunimi:</label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="sukunimi" name="sukunimi">
  </div>
  <div class="col-sm-1">
  </div>
</div>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="puhelin" class="col-sm-3">Puhelinnumero:</label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="puhelin" name="puhelin">
  </div>
  <div class="col-sm-1">
  </div>
</div>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="sposti" class="col-sm-3">Sähköposti:</label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="sposti" name="sposti">
  </div>
  <div class="col-sm-1">
  </div>
</div>
<br><br>

<div class="row">
  <div class="col-sm-12">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
      <button type="button" class="btn btn-danger">Tallenna muutokset</button>
    </div>
  </div>
</div>
<br><br>

<hr>

<div class="row">
  <div class="col-sm-1">
  </div>
  <div class="col-sm-11">
      <h3>Lisää uusi käyttäjä</h3>
  </div>
</div>
<br><br>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="enimi" class="col-sm-3">Etunimi:</label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="enimi" name="enimi">
  </div>
  <div class="col-sm-1">
  </div>
</div>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="snimi" class="col-sm-3">Sukunimi:</label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="snimi" name="snimi">
  </div>
  <div class="col-sm-1">
  </div>
</div>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="puhnro" class="col-sm-3">Puhelinnumero:</label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="puhnro" name="puhnro">
  </div>
  <div class="col-sm-1">
  </div>
</div>

<div class="row">
  <div class="col-sm-1">
  </div>
    <label for="email" class="col-sm-3">Sähköposti:</label>
  <div class="col-sm-7">
    <input type="text" class="form-control" id="sposti" name="sposti">
  </div>
  <div class="col-sm-1">
  </div>
</div>
<br><br>

<div class="row">
  <div class="col-sm-12">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
      <button type="button" class="btn btn-danger">Tallenna muutokset</button>
    </div>
  </div>
</div>
<br><br>

<footer class="container-fluid text-center">
	<p><strong>Web Design &copy; <i>Mira Louhe 2020</i></strong></p>
</div>

</body>
</html>