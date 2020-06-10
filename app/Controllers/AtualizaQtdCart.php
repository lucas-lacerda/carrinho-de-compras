<?php
session_start();

require __DIR__."/../../vendor/autoload.php";
use App\Models\Carrinho;

$prod = new Carrinho();
$prod->setQtdProd($_POST['prod']); 
$prod->parametro( $_GET['acao'], $prod->getQtdProd() );