<!-- die Datei top.php -->
<div id="top">	
	<a id="logo" href="index.php">pet4web</a>
	<?php include "search.php";?>
	<ul id="menu">	
		<li><a href="index.php?section=product">Produkte</a></li>
		<li><a href="index.php?section=category">Kategorien</a></li>
		<?php 
			if (isUserLoggedIn())	{// wenn user eingeloggt
				echo '<li><a href="index.php?section=cart">Warenkorb</a></li>';
				echo '<li><a href="index.php?section=logout">Logout</a></li>';
			} else 
				echo '<li><a href="index.php?section=user">Login</a></li>';
		?>	
		
		<?php /* wenn admin eingeloggt
			<li><a href="index.php?section=admin">Administrator</a></li>
			*/
		?>
	</ul>
</div>