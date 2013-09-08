<?php

/*
 * create user section functions
 */

function createProduct()
{
}

function updateProduct()
{
}

function tryToDeleteProduct()
{
    $id = getId();
    
    if(isset($id))
        deleteProduct($id);
    
    showAllProducts();    
}

function showAllProducts()
{
    $products =  getProducts();
    
    $count = count($products);
    for($i =0; $i<$count;$i++)
        printProduct($products[$i],$i);
    
}

function printProduct($product,$count)
{
    $id = $product['ID'];
    
    echo '<p id="product_'.$count.'">';
    echo '<h3>'.$product['name'].'</h3><br />';
    echo $product['description'].'<br />';
    echo $product['price'].'&euro;<br />';
    echo $product['productcode'].'<br />';
    echo $product['cat_name'].'<br />';
    
    echo '<div><a class="command" href="./productAdmin.php?section=tryToDelete&id='.$id.'">löschen</a> <a class="command" href="./productAdmin.php?section=update&id='.$id.'">bearbeiten</a></div>';
    
    echo '</p>';
}

function getId()
{
    if(isset($_GET['id']))
        return intval($_GET['id']);
    
    if(isset($_POST['id']))
        return intval($_POST['id']);
    
    
}


function getProducts()
{
    
    $connection = createDbConnection();
    $sqlQuery = "SELECT p.ID, p.name as name, p.description, p.picture, p.price, p.productcode, p.category_id as cat_id, c.name as cat_name FROM product p inner join category c on p.category_id = c.id";
    $result = mysql_query($sqlQuery,$connection);
    
    $products = array(); 
    $count=0;
    while($row = mysql_fetch_array($result))
        $products[$count++]= $row;
    
    mysql_free_result($result);      
    
    mysql_close($connection);
    
    return $products;
}

function getCategory()
{
    $connection = createDbConnection();
    $sqlQuery = "SELECT ID, name, description FROM category";
    $result = mysql_query($sqlQuery,$connection);
    
    $category = array(); 
    $count=0;
    while($row = mysql_fetch_array($result))
        $category[$count++]= $row;
    
    mysql_free_result($result);      
    
    mysql_close($connection);
    
    return $category;
}

function deleteProduct($id)
{
    $connection = createDbConnection();
    $sqlCommand = sprintf("DELETE FROM product WHERE ID = %d",$id);
    
    mysql_query($sqlCommand,$connection);
    mysql_close($connection);
}

/*
 * body:
 * if we come from user.php then $section is set otherwise false
 */
if(!isset($section) || !isUserAdmin())
{
    header("Location: ./index.php");
    exit;
}

switch($section)
{
    case 'create':
        // createProduct
        break;
    case 'update':
        // update product
        break;
    case 'tryToDelete':
            tryTodeleteProduct();
        break;
    default:
        showAllProducts();
        break;
}