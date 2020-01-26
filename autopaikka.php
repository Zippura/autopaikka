<!DOCTYPE html>

<html>

<head>
  <title>Uusi vuokrasopimus</title>
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
        <li class="active"><a href="autopaikka.php">Tulosta vuokrasopimus</a></li>
        <li><a href="ehdot.php">Muokkaa sopimusehtoja</a></li>
        <li><a href="kohteet.php">Muokkaa kohteita</a></li>
        <li><a href="kayttajat.php">Muokkaa käyttäjiä</a></li>
      </ul>
    </div>
</nav>

    <br>
    <div class="container text-center">
        <div class="col-sm-12">
            <h2>Uusi vuokrasopimus</h2>
        </div>
    </div>
    <hr><br>

<div class="container">
    <form action="print.php" method="post">
        <div class="row">
            <div class="col-6">
                <div class="form-group row">
                    <label for="pysalue" class="col-sm-6 col-form-label">Valitse taloyhtiö:</label>
                    <div class="col-sm-6">
                        <select id="pysalue" name="pysalue" class="custom-select">
                        <?php foreach ($arr as $row): ?>
                        <option value="<?=$row["PysakointiAlue_id"]?>"><?=$row["Taloyhtio"]?></option>
                        <?php endforeach ?>   
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="omistaja" class="col-sm-6 col-form-label">Omistaja:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="omistaja" name="omistaja">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="apnro" class="col-sm-6 col-form-label">Autopaikan numero:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="apnro" name="apnro">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="katuos" class="col-sm-6 col-form-label">Katuosoite:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="katuos" name="katuos">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postinro" class="col-sm-6 col-form-label">Postinumero:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="postinro" name="postinro">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ptoimipaikka" class="col-sm-6 col-form-label">Postitoimipaikka:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="ptoimipaikka" name="ptoimipaikka">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="valkaa" class="col-sm-6 col-form-label">Vuokrasopimus alkaa:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="valkaa" name="valkaa">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tyontekija" class="col-sm-6 col-form-label">Työntekijän nimi:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="tyontekija" name="tyontekija">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="vuokra" class="col-sm-6 col-form-label">Vuokra:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="vuokra" name="vuokra">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pvm" class="col-sm-6 col-form-label">Paikka ja päivämäärä:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="pvm" value="" name="pvm">
                    </div>
                </div>                
            </div>
           <br>
           <h4>Vuokralaisen tiedot</h4>
           <hr>
            <div class="col-6">
            <div class="form-group row">
                    <label for="yrnimi" class="col-sm-6 col-form-label">Yrityksen nimi:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="yrnimi" name="yrnimi">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="enimi" class="col-sm-6 col-form-label">Etunimi:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="enimi" name="enimi">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="snimi" class="col-sm-6 col-form-label">Sukunimi:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="snimi" name="snimi">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kosoite" class="col-sm-6 col-form-label">Katuosoite:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="kosoite" name="kosoite">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="postnro" class="col-sm-6 col-form-label">Postinumero:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="postnro" value="" name="postnro">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="postitmp" class="col-sm-6 col-form-label">Postitoimipaikka:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="postitmp" value="" name="postitmp">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-6 col-form-label">Sähköposti:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="email" value="" name="email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="puhnro" class="col-sm-6 col-form-label">Puhelin:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="puhnro" value="" name="puhnro">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tunnus" class="col-sm-6 col-form-label">Henkilö- tai Y-tunnus:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="tunnus" value="" name="tunnus">
                    </div>
                </div>
                <br>
                <h4>Lisätiedot ja sopimusehdot</h4>
                <hr>
                <div class="form-group row">
                    <label for="erehdot" class="col-sm-3 col-form-label">Erityisehdot:</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" rows="3" id="erehdot" value="" name="erehdot"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lisatiedot" class="col-sm-3 col-form-label">Lisätiedot:</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" rows="3" id="lisatiedot" value="" name="lisatiedot"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sopimusehdot" class="col-sm-3 col-form-label">Sopimusehdot:</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" rows="20" id="sopimusehdot" value="" name="sopimusehdot"></textarea>
                    </div>
                </div>
                <br><hr><br>
                <button type="submit" class="btn btn-info">Tulosta PDF</button>
            </div>
        </div>
    </form> 
</div>
<br><br>

<footer class="container-fluid text-center">
	<p><strong>Web Design &copy; <i>Mira Louhe 2020</i></strong></p>
</div>

</body>

</html>