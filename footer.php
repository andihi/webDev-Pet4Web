<!-- die Datei footer.php -->
<div id="user">
Angemeldet:
<?php
require_once 'util.php';


if(isUserLoggedIn() &&  isset($_SESSION['firstname']) && isset($_SESSION['lastname']))
{
    $name = '<a href="index.php?section=user">'.$_SESSION['firstname'].' '.$_SESSION['lastname'].'</a>';
}
else
    $name = '<a href="login.php?section=user">GAST</a>';

print($name);

?></a>
</div>
<div id="copyright">&copy; pet4web 2013</div>