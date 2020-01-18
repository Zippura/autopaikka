<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
        <title>Autopaikan vuokrasopimus</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript"
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
    $('#pysalue').change(function() {
        var valittuPysalue = $(this).children("option:selected").val();
        var rivi = haeRivi(data, valittuPysalue);
        $('#omistaja').val(rivi["Omistaja"]);
        $('#katuos').val(rivi["Katuosoite"]);
        $('#postinro').val(rivi["Postinumero"]);
        $('#ptoimipaikka').val(rivi["Postitoimipaikka"]);
        $('#tilinro').val(rivi["Laskutustili"]);
        $('#erehto').val(rivi["EhdonSisalto"]);
    });
});

</script>

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
            <div class="col-6"><!--left side -->
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
                        <input type="text" class="form-control" id="omistaja">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="apnro" class="col-sm-6 col-form-label">Autopaikan numero:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="apnro">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="katuos" class="col-sm-6 col-form-label">Katuosoite:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="katuos">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postinro" class="col-sm-6 col-form-label">Postinumero:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="postinro">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ptoimipaikka" class="col-sm-6 col-form-label">Postitoimipaikka:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="ptoimipaikka">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sopalkaa" class="col-sm-6 col-form-label">Vuokrasopimus alkaa:</label>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <select name="Kuukausi" class="custom-select">
                                    <option value="tammikuu">Tammikuu</option>
                                    <option value="helmikuu">Helmikuu</option>
                                    <option value="maaliskuu">Maaliskuu</option>
                                    <option value="huhtikuu">Huhtikuu</option>
                                    <option value="toukokuu">Toukokuu</option>
                                    <option value="kesakuu">Kesäkuu</option>
                                    <option value="heinakuu">Heinäkuu</option>
                                    <option value="elokuu">Elokuu</option>
                                    <option value="syyskuu">Syyskuu</option>
                                    <option value="lokakuu">Lokakuu</option>
                                    <option value="marraskuu">Marraskuu</option>
                                    <option value="joulukuu">Joulukuu</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <select name="Vuosi" class="custom-select">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option> 
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tilinro" class="col-sm-6 col-form-label">Tilinumero:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="tilinro">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tyontekija" class="col-sm-6 col-form-label">Valitse työntekijä:</label>
                    <div class="col-sm-6">
                        <select id="tyontekija" name="tyontekija" class="custom-select">
                        <?php foreach ($tyontekijat as $row): ?>
                            <option value="<?=$row["Tyontekija_id"]?>"><?=$row["EtuNimi"]." ".$row["SukuNimi"]?></option>
                        <?php endforeach ?>  
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="vuokra" class="col-sm-6 col-form-label">Vuokra:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="vuokra">
                    </div>
                </div>                
            </div>
            <!--right side -->
            <div class="col-6">
            <div class="form-group row">
                    <label for="yrnimi" class="col-sm-6 col-form-label">Yrityksen nimi:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="yrnimi">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="enimi" class="col-sm-6 col-form-label">Etunimi:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="enimi">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="snimi" class="col-sm-6 col-form-label">Sukunimi:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="snimi">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kosoite" class="col-sm-6 col-form-label">Katuosoite:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="kosoite">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="postnro" class="col-sm-6 col-form-label">Postinumero:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="postnro" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="postitmp" class="col-sm-6 col-form-label">Postitoimipaikka:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="postitmp" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-6 col-form-label">Sähköposti:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="email" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tunnus" class="col-sm-6 col-form-label">Henkilö- tai Y-tunnus:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="tunnus" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="erehto" class="col-sm-6 col-form-label">Erityisehdot:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="erehto">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lisatiedot" class="col-sm-6 col-form-label">Lisätiedot:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="lisatiedot" value="">
                    </div>
                </div>
                <button type="submit" class="btn btn-info">Luo PDF</button>
                <button type="button" class="btn btn-danger">Palaa etusivulle</button>
            </div>
        </div>
    </form> 
</div>

</body>

</html>