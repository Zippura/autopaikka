<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <title>Autopaikan vuokrasopimus</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="print.css">
  <link rel="stylesheet" type="text/css" href="autopaikka.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Allura|Arapey|Cardo|Covered+By+Your+Grace|Crimson+Text|Dancing+Script|Gentium+Basic|Great+Vibes|Libre+Baskerville|Meddon|Mr+De+Haviland|Old+Standard+TT|PT+Serif|Parisienne|Sacramento|Tangerine|Tinos" rel="stylesheet">
  <style>@page { size: A4 }</style>
</head>


<?php //css asettelumalli tulostusta varten
if ($_SERVER["REQUEST_METHOD"] == "POST") {//http:n post-metodilla siirtyy tiedot lomakkeelle otsikko-tiedoissa eli headereissa
    $omistaja = htmlentities($_POST["omistaja"]);
    $katuos = htmlentities($_POST["katuos"]);
    $postinro = htmlentities($_POST["postinro"]);
    $ptoimipaikka = htmlentities($_POST["ptoimipaikka"]);
    $tilinro = htmlentities($_POST["tilinro"]);
	$erehto = htmlentities($_POST["erehto"]);
	$yrnimi = htmlentities($_POST["yrnimi"]);
	$enimi = htmlentities($_POST["enimi"]);
	$snimi = htmlentities($_POST["snimi"]);
	$kosoite = htmlentities($_POST["kosoite"]);
	$postnro = htmlentities($_POST["postnro"]);
	$apnro = htmlentities($_POST["apnro"]);
	$vuokra = htmlentities($_POST["vuokra"]);
	$erehdot = htmlentities($_POST["erehdot"]);
	$valkaa = htmlentities($_POST["valkaa"]);
	$sopimusehdot = htmlentities($_POST["sopimusehdot"]);
	$pysalue = htmlentities($_POST["pysalue"]);
	$tyontekija = htmlentities($_POST["tyontekija"]);
	$kosoite = htmlentities($_POST["kosoite"]);
	$postnro = htmlentities($_POST["postnro"]);
	$email = htmlentities($_POST["email"]);
	$tunnus = htmlentities($_POST["tunnus"]);
	$puhnro = htmlentities($_POST["puhnro"]);
	$pvm = htmlentities($_POST["pvm"]);
	$lisatiedot = htmlentities($_POST["lisatiedot"]);
}
?>

<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
	<h1>Autopaikan vuokrasopimus</h1>
	<section id="taloyhtio">
		<p>
		 Autopaikan tiedot <br>
		 Omistaja: <?=$omistaja?><br>
		 Osoite: <?=$katuos?>, <?=$postinro?> <?=$ptoimipaikka?> <br>
		 Autopaikan nro: <?=$apnro?><br>
		 Autopaikan vuokra: <?=$vuokra?><br>
		 Vuokra alkaa: <?=$valkaa?>	<br>
		                               
		</p>
	</section>
	<section id="vuokralainen">
		<p>
		 Vuokralaisen tiedot <br>
		 Nimi: <?=$yrnimi?> <?=$enimi?> <?=$snimi?><br>
		 Osoite: <?=$kosoite?>, <?=$postnro?> <?=$postitmp?><br>
		 Sähköposti: <?=$email?> <br>
		 Puhelin: <?=$puhnro?> <br>
		 Henkilö- tai Y-tunnus: <?=$tunnus?>
		</p>
	</section>
	<section id="erehdot">
		<p class="smallprint"> 
		 Sopimuskohtaiset erityisehdot:<br>
		 <?=$erehdot?><br><br><br>
		</p>
	</section>
	<section id="lisatiedot">
		<p class="smallprint"> 
		 Sopimuskohtaiset lisätiedot:<br>
		 <?=$lisatiedot?><br>
		</p>
	</section>
	<section id="sopimusehdot">
		<p class="smallprint">
		 Sopimusehdot: <br>
		 <?=$sopimusehdot?><br>
		</p>
	</section>
	<section id="allek">
		<h4>Allekirjoitustiedot</h4>
	</section>
	<section id="pvm">
		<p> 
		 Paikka ja päivämäärä:<br>
		 <?=$pvm?><br>
		</p>
	</section>
	<section id="vuokr">
		<p> 
		<br><br>
		 <?=$enimi?> <?=$snimi?>
		</p>
	</section>
	<section id="tyontekija">
		<p>
		<br><br>
		 <?=$tyontekija?>
		</p>
	</section>
  </section>

  <footer class="container-fluid text-center">
  	<p><a href="index.php" class="btn btn-info">Palaa etusivulle</a></p>  

</body>

</html>
