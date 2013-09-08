<?php
//require_once 'util.php';
/*
 * create user section functions
 */
function tryToAddProduct()
{
    $prodId = getId();
    $userId = $_SESSION['id'];    
    $connection = createDbConnection();
    
    $sqlQuery = sprintf("SELECT customer_ID, product_ID, quantity FROM cart WHERE product_ID=%d and customer_ID = %d",$prodId,$userId);    
    $result = mysql_query($sqlQuery,$connection);;
    
    $num = mysql_num_rows($result);    
    if($num == 1)
        $sqlCommand = sprintf("UPDATE cart SET quantity = quantity+1 WHERE customer_ID = %d and product_ID = %d",$userId,$prodId);
    else
        $sqlCommand = sprintf("INSERT into cart(customer_ID, product_ID, quantity) VALUES(%d, %d,1)",$userId,$prodId);
    
    mysql_query($sqlCommand,$connection);
    
    mysql_close($connection);    
    
    showCart();
}


function getCart()
{
    $connection = createDbConnection();
    
    $sqlQuery = "SELECT product.ID, product.name, product.price, cart.quantity FROM product ".
							"inner join cart on cart.product_id = product.id where customer_id = ".$_SESSION['id'];     
    
    $result = mysql_query($sqlQuery, $connection);
    $cart = array();
    $count = 0;
    while($row = mysql_fetch_array($result))
        $cart[$count++] = $row;
    
    mysql_free_result($result);    
    mysql_close($connection);
    
    return $cart;
}

function showCart()
{
    $cart = getCart();
    $count = count($cart);
    
    if($count >0)
    {
        echo '<form id="updateCart" action="./userCart.php?section=tryToUpdateCart" method="post">'; 
        
        $cart = getCart();
        $count = count($cart);
        
        for($i=0;$i<$count;$i++)
        {
            $c= $cart[$i];
            $id = $c['ID'];
            $name = $c['name'];
            $pices= $c['quantity'];
            
            echo '<fieldset>
                    <legend>'.$name.'</legend>
                    <label for="count_'.$id.'">Anzahl</label>
                    <input type="number" name="count_'.$id.'" value="'.$pices.'" maxlength="3"/>
                </fieldset>';
        }
        
        echo '<input type="submit" name="submit" id="submit" value="Warenkorb aktualisieren" />
        </form>';   
        
        echo '<a class="command" style="width:180px" href="./userCart.php?section=tryToBuyProducts">Waren kaufen</a>';
    }        
}

function tryToBuyProducts()
{
    $userId = $_SESSION['id'];    
    $connection = createDbConnection();
  
    $sqlCommand = sprintf("DELETE FROM cart WHERE customer_ID = %d",$userId);
    
    mysql_query($sqlCommand,$connection);
    
    mysql_close($connection);    
    
    echo '<h3>Aufgrund unserer Marktanalyse haben wir ihren Schritt schon vorhergesehen. Ihr Paket ist bereits unterwegs.</h3>';
}

function tryToUpdateCart()
{
    $cart = getCart();
    
    $count = count($cart);
    
    for($i=0;$i<$count;$i++)
    {
        $id = $cart[$i]['ID'];
        $name = sprintf("count_%s",$id);
        
        $value = getP($name);        
        if(isset($value))
            updateCart(intval($id),intval($value));
    }
    showCart();
}

function updateCart($id,$quantity)
{
    $userId = $_SESSION['id'];    
    $connection = createDbConnection();
    
    $sqlQuery = sprintf("SELECT customer_ID, product_ID, quantity FROM cart WHERE product_ID=%d and customer_ID = %d",$id,$userId);    
    $result = mysql_query($sqlQuery,$connection);;
    
    $num = mysql_num_rows($result);    
    if($num != 1)
        die("Ein update des Warenkorbs war nicht möglich!");
    
    if($quantity <=0)
        $sqlCommand = sprintf("DELETE FROM cart WHERE product_ID=%d and customer_ID = %d",$id,$userId);
    else
        $sqlCommand = sprintf("UPDATE cart SET quantity=%d WHERE product_ID=%d and customer_ID = %d",$quantity,$id,$userId);
    
    mysql_query($sqlCommand,$connection);
    
    mysql_close($connection);    
}

function getId()
{
    if(isset($_GET['id']))
        return intval($_GET['id']);
    
    if(isset($_POST['id']))
        return intval($_POST['id']);
    
    
}

/*
 * body:
 * if we come from user.php then $section is set otherwise false
 */
if(!isset($section) || !isUserLoggedIn())
{
    header("Location: ./index.php");
    exit;
}

switch($section)
{    
    case 'tryToAddProduct':
        tryToAddProduct();
        break;
    case 'tryToUpdateCart':
        tryToUpdateCart();
        break;
    case 'tryToBuyProducts':
        tryToBuyProducts();
        break;
    case 'showCart':                
    default:
        showCart();
        break;
}
