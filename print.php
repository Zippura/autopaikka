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
}
?>

<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
	<h1>pok</h1>
	<section id="taloyhtio">
		<p>
			<?=$omistaja?><br>
			Kissakuja 4<br>
			00430 Helsinki
		</p>
	</section>
	<section id="vuokralainen">
		<p>
			Veikko Vuokralainen<br>
			Kerkkokuja 7<br>
			01550 Vantaa
		</p>
	</section>
	<section id="sopimustiedot">
		<p>
			Autopaikan numero: 32b<br>
			Vuokra: 102 €<br>
			Tilinumero: FI02 34543 000 3424<br>
			Sopimus alkoi 1.1.2020
		</p>
	</section>
	<section id="sopimusehdot">
		<p class="smallprint">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ut eros orci. Nam pretium condimentum nisl eget elementum. Suspendisse condimentum consequat sapien quis porta. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec eu urna rutrum, eleifend nisi at, maximus lectus. Vivamus vehicula enim felis, vitae mattis velit ornare dapibus.
		</p><p class="smallprint">
			Nulla erat quam, dapibus et imperdiet quis, aliquam vitae lectus. Cras sollicitudin aliquam leo. Nam nec vulputate elit. Mauris elementum volutpat nisl sit amet pellentesque. Cras vitae metus id risus auctor gravida. Duis purus ipsum, pulvinar ac bibendum eget, posuere non risus. Nullam dictum porttitor urna, non blandit sem elementum et. Aenean mattis urna ac arcu venenatis, non ultricies orci faucibus. Vivamus ac aliquam nunc, laoreet fermentum turpis. Nunc sagittis quam sed leo aliquet, non euismod dolor facilisis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur dignissim lorem volutpat leo porta, non suscipit mi congue. Aliquam at lacinia mi. Fusce gravida metus quis orci dictum, quis suscipit tellus ornare. Maecenas sollicitudin rutrum gravida. Donec tempor diam quis purus eleifend laoreet.
		</p><p class="smallprint">
			Vivamus sit amet pellentesque sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur vitae faucibus purus. Quisque nec rhoncus sapien, nec mattis mauris. Nam ipsum nisl, auctor id nulla quis, rhoncus iaculis mi. Donec eu risus vel lectus sollicitudin scelerisque. Duis tristique dignissim risus in porttitor. Donec ornare feugiat quam ac ullamcorper. Fusce congue sapien et dolor elementum molestie. Fusce bibendum vehicula arcu. In posuere dolor quis tempus feugiat. Sed eu mattis orci. Integer tristique imperdiet ligula, in facilisis neque rutrum et.
		</p><p class="smallprint">
			Etiam sit amet ex vel ligula ullamcorper placerat in ut nisi. Phasellus sapien mauris, molestie et ex sed, pretium gravida dui. Fusce malesuada sem at tellus dignissim, eu posuere metus imperdiet. Donec non nibh ac diam tincidunt dictum. Vestibulum vel leo fringilla, condimentum arcu eu, malesuada metus. Donec ac lobortis metus. Etiam non nisl in justo volutpat consequat eget vel neque. Cras consectetur quam eget rhoncus efficitur. Morbi dignissim posuere neque ac semper. Nunc maximus nunc metus, eget rutrum massa pulvinar sed. Donec in sem at orci dapibus ornare.
		</p><p class="smallprint">
			Proin ac ex urna. Suspendisse at placerat est. Sed varius enim et tellus vulputate bibendum. Fusce pulvinar ligula ut urna dictum pharetra. Etiam vel bibendum nibh. Sed id semper nisi. Morbi in lectus at sapien finibus congue. Integer nec facilisis nulla. Aliquam imperdiet tristique orci, quis luctus purus ullamcorper sagittis. Duis ex justo, pulvinar in tincidunt sit amet, blandit eu turpis.
		</p>
	</section>
  </section>

</body>

</html>
