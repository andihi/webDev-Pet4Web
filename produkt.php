<?php
    include 'dbconnection.php';
    $connection = createDbConnection();
	
	if (!isset($_GET['ID']))	{
		$sqlQuery =sprintf("SELECT ID, name, description, picture, price, productcode, category_ID FROM product"); 
	} else	{
		$sqlQuery =sprintf("SELECT ID, name, description, picture, price, productcode, category_ID FROM product where ID = ".$_GET['ID']); 
	}	
    
    $result = mysql_query($sqlQuery, $connection);
    
    if (!$result)
    {
        $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
        $message .= 'Gesamte Abfrage: ' . $sqlQuery;
        die($message);
    }	
	
	if (!isset($_GET['ID']))	{
	
		while($row = mysql_fetch_array($result))	{
			echo '<table id="produkte">';
			echo '<tr>';
			echo '<td><a href="index.php?section=produkt&ID='.$row['ID'].'">'.$row['name'].'</a></td>';
			echo '<td>'.$row['description'].'</td>';
			echo '<td>'.$row['price'].'&euro;</td>';
			echo '<td>'.$row['productcode'].'</td>';
			echo '<td>'.$row['category_ID'].'</td>';
		}
	} else {
	
		while($row = mysql_fetch_array($result))	{

			echo $row['ID']."</br>";
			echo $row['name']."</br>";
			echo $row['description']."</br>";
			echo $row['price']."</br>";
			echo $row['productcode']."</br>";
		
		}
	}
    mysql_free_result($result);
    mysql_close($connection); 

?>

</table>