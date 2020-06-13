<?php

namespace App\Models;
use App\Models\Carrinho;

class Loja extends Carrinho
{
    
    /**
     * Lista todos os produtos no carrinho
     *
     * @return void
     */
    public function produtosLoja()
    {
        $produtos = $this->conexao()->select('SELECT * FROM dividas');
        return $produtos;
    }
}