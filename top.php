<!-- die Datei top.php -->
<div id="top">	
	<a id="logo" href="index.php">pet4web</a>
	<?php include "search.php";?>
	<ul id="menu">	
		<li><a href="index.php?section=product">Produkte</a></li>
		<li><a href="index.php?section=category">Kategorien</a></li>
		<?php 
			if (isUserLoggedIn())
            {   // wenn user eingeloggt
				echo '<li><a href="userCart.php">Warenkorb</a></li>';
				echo '<li><a href="user.php?section=logout">Logout</a></li>';
                
                if(isUserAdmin())
                    echo '<li><a href="productAdmin.php">Produktadministration</a></li>';
			}
            else
                echo '<li><a href="user.php?section=logIn">Login</a></li>';
		?>	
		
		<?php /* wenn admin eingeloggt
			<li><a href="index.php?section=admin">Administrator</a></li>
			*/
		?>
	</ul>
</div>