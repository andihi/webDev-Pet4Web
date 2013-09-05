<?php
    require_once 'util.php';

    $connection = createDbConnection();
	
	// if GET passed an ID: only 1 categorie is shown
	// if GET passed an search: only the categories with matched categoryname are shown
	// else all categories are shown
	
	if (!isset($_GET['ID']))
	{
		if(!isset($_GET['search']))
		{			
			$sqlQuery ="SELECT category.ID, category.name, category.description, count(*) as count_products FROM category ".
								"left outer join product on product.category_id = category.id group by category.ID, category.name, category.description"; 
		} else
		{
			$sqlQuery = "SELECT category.ID, category.name, category.description, count(*) as count_products FROM category ".
								"left outer join product on product.category_id = category.id ".
								"where UPPER(category.name) like UPPER('%".$_GET['search']."%') ".
								"group by category.ID, category.name, category.description"; 
		}
	} else
	{
		$sqlQuery = "SELECT category.ID, category.name, category.description, count(*) as count_products FROM category ".
								"left outer join product on product.category_id = category.id ".
								" where category.ID = ".$_GET['ID']." ".
								"group by category.ID, category.name, category.description"; 
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
		echo '<p id="category">';
		echo '<a href="index.php?section=product&catid='.$row['ID'].'">'.$row['name'].'</a><br />';
		echo $row['description'].'<br />';
		echo 'Anzahl Produkte: '.$row['count_products'].'<br />';
		echo '</p>';
	}
    mysql_free_result($result);
    mysql_close($connection); 

?>