<!-- die Datei top.php -->
<div id="top">	
	<a id="logo" href="index.php">pet4web</a>
	<?php include "suche.php";?>
	<ul>	
		<li><a href="index.php?section=produkt">Produkte</a></li>
		<li><a href="index.php?section=kategorie">Kategorien</a></li>
		<?php /* wenn user eingeloggt
			<li><a href="index.php?section=warenkorb">Warenkorb</a></li>
			*/
		?>	
		<?php /* wenn admin eingeloggt
			<li><a href="index.php?section=admin">Administrator</a></li>
			*/
		?>
		<li><a href="index.php?section=xxx">Login</a></li>
	</ul>
</div>