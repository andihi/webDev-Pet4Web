<!-- die Datei suche.php -->
<form id="index.php?section=produkt">
<input type="hidden" name="section" value="produkt" />
<input type="text" size="30" name="search" value="<?php if (isset($_GET['search'])) { echo $_GET['search']; } ?>" />
<input type="submit" value="OK" />
</form>