<?php
    // die Datei inhalt.php
    
    if(isset($_GET['section'])) {
        switch($_GET['section']) {
            case "produkt":
                include "produkt.php";
                break;
				
            case "kategorie":
                include "kategorie.php";
                break;

            case "user":
                include "user.php";
                break;
				
            default:  // Wenn eine ungültige Section angegeben wurde
                    // sollen die News gezeigt werden
                include "home.php";
                break;
        }     
    } else {
        // wenn section nicht angegeben wurde
        // sollen die News angezeigt werden.
        include "home.php";
    }
?>