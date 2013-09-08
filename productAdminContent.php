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

function deleteProduct()
{
}

function showAllProducts()
{
}

/*
 * body:
 * if we come from user.php then $section is set otherwise false
 */
if(!isset($section))
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
    case 'delete':
        // 
        break;
    default:
        // show all
        break;
}