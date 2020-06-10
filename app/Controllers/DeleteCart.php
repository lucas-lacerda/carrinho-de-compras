<?php
session_start();

require __DIR__."/../../vendor/autoload.php";
use App\Models\Carrinho;

$prod = new Carrinho();
$prod->setIdProd($_GET['id']); 
$prod->parametro($_GET['acao'], $prod->getIdProd());