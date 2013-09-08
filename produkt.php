<?php
    require_once 'util.php';

    $connection = createDbConnection();
	
	// if GET passed an ID: only 1 product is shown
	// if GET passed an Category-ID: only the products of the category are shown
	// if GET passed an search: only the products with matched productname are shown
	// else all products are shown
	
	if (!isset($_GET['id']))
	{
		if (!isset($_GET['catid']))
		{
			if(!isset($_GET['search']))
			{			
				$sqlQuery ="SELECT product.ID, product.name, product.description, product.picture, product.price, product.productcode, category.name as cat_name FROM product ".
									"inner join category on product.category_id = category.id"; 
			} else
			{
				$sqlQuery = "SELECT product.ID, product.name, product.description, product.picture, product.price, product.productcode, category.name as cat_name FROM product ".
								"inner join category on product.category_id = category.id where UPPER(product.name) like UPPER('%".$_GET['search']."%')"; 
			}
		} else
		{
			$sqlQuery = "SELECT product.ID, product.name, product.description, product.picture, product.price, product.productcode, category.name as cat_name FROM product ".
								"inner join category on product.category_id = category.id where category_ID = ".$_GET['catid']; 
		}
	} else
	{
		$sqlQuery = "SELECT product.ID, product.name, product.description, product.picture, product.price, product.productcode, category.name as cat_name FROM product ".
								"inner join category on product.category_id = category.id where product.ID = ".$_GET['id']; 
	}	
    
    $result = mysql_query($sqlQuery, $connection);
    
    if (!$result)
    {
        $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
        $message .= 'Gesamte Abfrage: ' . $sqlQuery;
        die($message);
    }	

		while($row = mysql_fetch_array($result))
		{
			echo '<p id="product">';
			echo '<a href="index.php?section=product&id='.$row['ID'].'">'.$row['name'].'</a><br />';
			echo $row['description'].'<br />';
			echo $row['price'].'&euro;<br />';
			echo $row['productcode'].'<br />';
			echo $row['cat_name'].'<br />';
			if (isUserLoggedIn())
			{
				echo '<a href="userCart.php?section=tryToAddProduct&id='.$row['ID'].'">kaufen</a><br />';
			}
			echo '</p>';
		}

    mysql_free_result($result);
    mysql_close($connection); 

?>