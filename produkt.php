<?php
    require_once 'util.php';

    $connection = createDbConnection();
	
	// if GET passed an ID: only 1 product is shown
	// if GET passed an Category-ID: only the products of the category are shown
	// if GET passed an search: only the products with matched productname are shown
	// else all products are shown
	
	if (!isset($_GET['ID']))	{
		if (!isset($_GET['catid']))	{
			if(!isset($_GET['search']))	{			
				$sqlQuery ="SELECT product.ID, product.name, product.description, product.picture, product.price, product.productcode, category.name as cat_name FROM product ".
									"inner join category on product.category_id = category.id"; 
			} else	{
				$sqlQuery = "SELECT product.ID, product.name, product.description, product.picture, product.price, product.productcode, category.name as cat_name FROM product ".
								"inner join category on product.category_id = category.id where UPPER(product.name) like UPPER('%".$_GET['search']."%')"; 
			}
		} else	{
			$sqlQuery = "SELECT product.ID, product.name, product.description, product.picture, product.price, product.productcode, category.name as cat_name FROM product ".
								"inner join category on product.category_id = category.id where category_ID = ".$_GET['catid']; 
		}
	} else	{
		$sqlQuery = "SELECT product.ID, product.name, product.description, product.picture, product.price, product.productcode, product.category_ID ".
							"FROM product where product.ID = ".$_GET['ID']; 
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
			echo '<td>'.$row['cat_name'].'</td>';
			echo '</tr>';
		}
	} else {
	
		while($row = mysql_fetch_array($result))	{

			echo $row['ID'].'</br>';
			echo $row['name'].'</br>';
			echo $row['description'].'</br>';
			echo $row['price'].'</br>';
			echo $row['productcode'].'</br>';
		
		}
	}
    mysql_free_result($result);
    mysql_close($connection); 

?>

</table>