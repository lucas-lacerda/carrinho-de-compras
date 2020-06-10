<?php

require 'Db.php';

$db = new Db('mysql', 'localhost', 'php-intermediario', 'root', '');

//$func = $db->select('SELECT * FROM funcionarios WHERE id < :id', ['id' => 5]);

//$id = $db->insert('funcionarios', [
//    'nome' => 'Ana Pereira da Silva',
//    'email' => 'ana2@gmail.com',
//    'endereco' => 'Rua Teste4, 500',
//    'telefone' => '11 9999-9999'
//]);

//echo 'O id:' . $id;

//echo $db->update('funcionarios', [
//    'nome' => 'Rosangela Faria',
//    'email' => 'ro@gmail.com'
//], 'id=12');

echo $db->delete('funcionarios', 'id=12');

$func = $db->select('SELECT * FROM funcionarios');

var_dump($func);
