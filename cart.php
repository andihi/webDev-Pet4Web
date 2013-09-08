<?php
    require_once 'util.php';

    $connection = createDbConnection();
	
	// wenn kein User eingeloggt, wird auf die Login-Seite verwiesen.	
	if (!isUserLoggedIn())	{
		header("Location: ./index.php?section=user");
		exit;
	}
	
	// wenn eine ID (produktID) übergeben wird, wird diese dem Warenkorb hinzugefügt
	if (isset($_GET['id']))	{
		$sqlQuery = "INSERT INTO cart (customer_id, product_id, quantity) ".
								"VALUES (".$_SESSION['id'].",".$_GET['id'].", 1)".
									"ON DUPLICATE KEY UPDATE quantity = quantity + 1";		
		$result = mysql_query($sqlQuery, $connection);
		if (!$result)
		{
			$message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
			$message .= 'Gesamte Abfrage: ' . $sqlQuery;
			die($message);
		}	
									
	}
		    
	$sqlQuery = "SELECT product.ID, product.name, product.price, cart.quantity FROM product ".
							"inner join cart on cart.product_id = product.id where customer_id = ".$_SESSION['id']; 
			
    $result = mysql_query($sqlQuery, $connection);
    
    if (!$result)
    {
        $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
        $message .= 'Gesamte Abfrage: ' . $sqlQuery;
        die($message);
    }	   
	
	while($row = mysql_fetch_array($result))	{
		echo '<p id="warenkorb">';
		echo '<a href="index.php?section=product&ID='.$row['ID'].'">'.$row['name'].'</a><br />';
		echo 'Anzahl: '.$row['quantity'].'<br /><br />';
		echo '</p>';
	}
		
	// TODO form to clear cart
	echo '<input class="command" type="button" value="Zur Kasse gehen" />';
    mysql_free_result($result);
    mysql_close($connection); 

?>