<!-- die Datei search.php -->
<div id="search">
	<form id="index.php?section=product">
	<input type="hidden" name="section" value="product" />
	<input type="text" size="30" name="search" value=
	<?php
	if (isset($_GET['search'])) {
		echo '"'.$_GET['search'].'"';
	} else	{
		echo '"Suche..."';
	}
	?> />
	<input type="submit" value="OK" style="display:none"/>
	</form>
</div>