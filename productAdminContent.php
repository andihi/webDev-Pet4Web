<?php
//require_once 'util.php';
/*
 * create user section functions
 */

function createProduct()
{
}

function updateProduct()
{
    $id = getId();   
    
    if(!isset($id))
    {
        header("Location: ./productAdmin.php");
        exit;
    }
        
    $product = getProduct($id);
    showProductForUpdate($product);
}

function showProductForUpdate($product)
{
    echo '<form id="updateProductForm" action="./productAdmin.php?section=tryToUpdateProduct" method="post">
    <input type="hidden" name="id" value="'.$product['ID'].'" />
	<section>				
        <div>
			<label for="productName" >Produktname</label>
            <input id="productName" type="text" name="productName" value="'.$product['name'].'"  />
        </div>
        <div>
            <label for="productDescription" >Beschreibung</label>
            <textarea id="productDescription" type=text cols="90" rows="20"  name="productDescription">'.$product['description'].'</textarea>
        </div>
        <div>
            <label for="productPrice" >Preis</label>
            <input id="productPrice" type="text" name="productPrice" value="'.$product['price'].'" />
        </div>
        <div>            
            <label for="productCode" >Produktcode</label>
            <input id="productCode" type="text" name="productCode" value="'.$product['productcode'].'" />
        </div>
        <div>
            <label for="category">Kategorie</label>
            <select name="category">';
    $categories = getCategories();
    $catCount = count($categories);
    
    for($i=0;$i<$catCount;$i++)
    {
        $cat = $categories[$i];
        if($product['cat_id'] == $cat['ID'])
            echo '<option value="'.$cat['ID'].'" selected>'.$cat['name'].'</option>';
        else
            echo '<option value="'.$cat['ID'].'">'.$cat['name'].'</option>';
    }
    
    echo '  </select>
        </div>		
	</section>	
	<input type="submit" name="submit" id="submit" value="change settings" />
</form>';
}

function tryToUpdateProduct()
{
    $id = getId();
    if(!isset($id))
    {
        header("Location: ./productAdmin.php");
        exit;
    }
    setProductChanges();
}

function setProductChanges()
{
    $id = getId();
    $name = getP('productName');
    $descr = getP('productDescription');
    $price = getP('productPrice');
    $code = getP('productCode');
    $cat = intval(getP('category'));
    
    $connection = createDbConnection();
    
    $sqlCommand = sprintf("UPDATE product SET
    name = '%s',
    description='%s',
    productcode='%s',
    price=%f,
    category_ID=%d
    where ID = %d",mysql_real_escape_string($name),mysql_real_escape_string($descr),mysql_real_escape_string($code),$price,$cat,$id);
       
    mysql_query($sqlCommand,$connection);    
    mysql_close($connection);
    showAllProducts();
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

function getP($name)
{
    if(isset($_POST[$name]))
        return $_POST[$name];
    else
        return null;
}

function getProduct($id)
{
    $connection = createDbConnection();
    $sqlQuery = sprintf("SELECT p.ID, p.name as name, p.description, p.picture, p.price, p.productcode, p.category_id as cat_id, c.name as cat_name
    FROM product p
    inner join category c on p.category_id = c.id
    WHERE p.ID = '%d'",$id);
    
    $result = mysql_query($sqlQuery,$connection);
    
    $num = mysql_num_rows($result);
    
    if($num != 1)
        return null;
    
    $product = mysql_fetch_array($result);
    
    mysql_free_result($result);          
    mysql_close($connection);
    
    return $product;
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

function getCategories()
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
        updateProduct();
        break;
    case 'tryToUpdateProduct':
            tryToUpdateProduct();
        break;
    case 'tryToDelete':
            tryToDeleteProduct();
        break;
    default:
        showAllProducts();
        break;
}