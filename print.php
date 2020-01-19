<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <title>Autopaikan vuokrasopimus</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
  <link rel="stylesheet" href="print.css">
  <style>@page { size: A4 }</style>
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
	$erehto = htmlentities($_POST["erehto"]);
	$valkaa = htmlentities($_POST["valkaa"]);
	$sopimusehdot = htmlentities($_POST["sopimusehdot"]);
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
		<?=$omistaja?><br>
		<?=$katuos?><br>
		<?=$postinro?>
		</p>
	</section>
	<section id="vuokralainen">
		<p>
		<?=$yrnimi?><br>
		<?=$enimi?><br>
		<?=$snimi?><br>
		<?=$kosoite?>
		<?=$postnro?>
		</p>
	</section>
	<section id="sopimustiedot">
		<p>
		<?=$apnro?><br>
		<?=$vuokra?><br>
		<?=$tilinro?><br>
		<?=$valkaa?>	
		</p>
	</section>
	<section id="sopimusehdot">
		<p class="smallprint">
		<?php foreach ($sopimusehdot as $row): ?>
            <input value="<?$row["Sopimusehdot"]?>"><?=$row["EhdonSisalto"]?>
        <?php endforeach ?>  </p>
		</p>
	</section>
	<section id="erehdot">
		<p class="smallprint"> 
		Sopimuskohtaiset erityisehdot:<br>
		<?=$erehto?><br>
		</p>
	</section>
  </section>

</body>

</html>
