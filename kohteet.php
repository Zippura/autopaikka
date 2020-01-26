<!DOCTYPE html>
<html>
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
  $stmt = $pdo->prepare("SELECT p.PysakointiAlue_id, p.Taloyhtio, p.Omistaja, p.Katuosoite, p.Postinumero, p.Laskutustili, po.Postitoimipaikka, e.EhdonSisalto
   FROM PysakointiAlue p
    LEFT OUTER JOIN Postinumerot po
      ON p.Postinumero = po. Postinumero
       LEFT OUTER JOIN Erityisehdot e
        ON p.Erityisehto_id = e.Erityisehto_id");
  $stmt->execute();
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(Exception $e) {
    echo 'Exception -> ';
    var_dump($e->getMessage());
  }
  
  try {
  $stmt = $pdo->prepare("SELECT EtuNimi, SukuNimi FROM Tyontekijat");
  $stmt->execute();
  $tyontekijat = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(Exception $e) {
      echo 'Exception -> ';
      var_dump($e->getMessage());
    }
  
  try {
  $stmt = $pdo->prepare("SELECT EhdonSisalto FROM Sopimusehdot");
  $stmt->execute();
  $sopimusehdot = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(Exception $e) {
      echo 'Exception -> ';
      var_dump($e->getMessage());
    }
  
  ?>
  
  <script type="text/javascript">
  function haeRivi(rivit, id) {
      for (const rivi of rivit) {
          if (rivi["PysakointiAlue_id"]==id) {
              return rivi;
          }
      };
  }
  $(document).ready(function() {
      var data = <?=json_encode($arr)?>;
      var sopeht = <?=json_encode($sopimusehdot)?>;
      $('#pysalue').change(function() {
          var valittuPysalue = $(this).children("option:selected").val();
          var rivi = haeRivi(data, valittuPysalue, sopeht);
          $('#omistaja').val(rivi["Omistaja"]);
          $('#katuos').val(rivi["Katuosoite"]);
          $('#postinro').val(rivi["Postinumero"]);
          $('#ptoimipaikka').val(rivi["Postitoimipaikka"]);
          $('#tilinro').val(rivi["Laskutustili"]);
          $('#erehdot').val(rivi["EhdonSisalto"]);
          $('#sopimusehdot').val(sopeht[0]["EhdonSisalto"]);
      });
      $('#pysalue').change();
  });
  
  </script>

<nav class="navbar navbar-default">
  <div class="container">
    <ul class="nav navbar-nav navbar-right">
		<li><a href="etusivu.php">Etusivu</a></li>
        <li><a href="autopaikka.php">Tulosta vuokrasopimus</a></li>
        <li><a href="ehdot.php">Muokkaa sopimusehtoja</a></li>
        <li class="active"><a href="kohteet.php">Muokkaa kohteita</a></li>
        <li><a href="kayttajat.php">Muokkaa käyttäjiä</a>
    </li>
    </ul>
    </div>
  </div>
</nav>
  
<div class="row">
  <div class="col-sm-2">
  </div>
  <div class="col-sm-10">
      <h3>Muokkaa kohteiden tietoja</h3>
  </div>
</div>
<br><br>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="pysalue" class="col-sm-2">Valitse taloyhtiö:</label>
  <div class="col-sm-6">
    <select id="pysalue" name="pysalue" class="custom-select">
      <?php foreach ($arr as $row): ?>
        <option value="<?=$row["PysakointiAlue_id"]?>"><?=$row["Taloyhtio"]?></option>
      <?php endforeach ?>   
    </select>
  </div>
  <div class="col-sm-1">
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="omistaja" class="col-sm-2">Omistaja:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="omistaja" name="omistaja">
  </div>
  <div class="col-sm-2">
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="katuos" class="col-sm-2">Katuosoite:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="katuos" name="katuos">
  </div>
  <div class="col-sm-2">
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="postinro" class="col-sm-2">Postinumero:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="postinro" name="postinro">
  </div>
  <div class="col-sm-2">
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="ptoimipaikka" class="col-sm-2">Postitoimipaikka:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="ptoimipaikka" name="ptoimipaikka">
  </div>
  <div class="col-sm-2">
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-2">
  </div>
  <label for="erehdot" class="col-sm-2 col-form-label">Erityisehdot:</label>
  <div class="col-sm-6">
    <textarea type="text" class="form-control" rows="3" id="erehdot" value="" name="erehdot"></textarea>
  </div>
  <div class="col-sm-2">
  </div>
</div>
<br><br>

<br><br>

<div class="row">
  <div class="col-sm-12">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10">
      <button type="button" class="btn btn-danger">Poista kohde</button>
      <button type="button" class="btn btn-success">Tallenna muutokset</button>
    </div>
  </div>
</div>
<br><br>

<hr>

<div class="row">
  <div class="col-sm-2">
  </div>
  <div class="col-sm-10">
      <h3>Lisää uusi kohde</h3>
  </div>
</div>
<br><br>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="omistaja" class="col-sm-2">Taloyhtiö:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="omistaja" name="omistaja">
  </div>
  <div class="col-sm-2">
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="omistaja" class="col-sm-2">Omistaja:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="omistaja" name="omistaja">
  </div>
  <div class="col-sm-2">
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="katuos" class="col-sm-2">Katuosoite:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="katuos" name="katuos">
  </div>
  <div class="col-sm-2">
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="postinro" class="col-sm-2">Postinumero:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="postinro" name="postinro">
  </div>
  <div class="col-sm-2">
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
  </div>
    <label for="ptoimipaikka" class="col-sm-2">Postitoimipaikka:</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="ptoimipaikka" name="ptoimipaikka">
  </div>
  <div class="col-sm-2">
  </div>
</div>

<div class="form-group row">
  <div class="col-sm-2">
  </div>
  <label for="erehdot" class="col-sm-2 col-form-label">Erityisehdot:</label>
  <div class="col-sm-6">
    <textarea type="text" class="form-control" rows="3" id="erehdot" value="" name="erehdot"></textarea>
  </div>
  <div class="col-sm-2">
  </div>
</div>
<br><br>

<div class="row">
  <div class="col-sm-12">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10">
      <button type="button" class="btn btn-success">Tallenna muutokset</button>
    </div>
  </div>
</div>
<br><br>

<footer class="container-fluid text-center">
	<p><strong>Web Design &copy; <i>Mira Louhe 2020</i></strong></p>
</div>

</body>
</html>