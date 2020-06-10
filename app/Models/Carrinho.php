<?php 

namespace App\Models;
use App\DB\DB;


class Carrinho 
{
    protected $db;
    protected $parametro;
    protected $id_prod;
    protected $qtdProd;

    public function conexao() 
    {
        $db = new DB('mysql', 'localhost', 'receiv_devedores', 'root', '');
        return $db;
    }

    /**
     * Inicia a session para gerar o array do carrinho 
     */
    public function __construct()
    {
        if(!isset($_SESSION['carrinho'])) {
           return $_SESSION['carrinho'] = array();
        }
    }

    public function setIdProd($valor)
    {
        if (isset($valor)) {
            $this->id_prod = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
        } 
    }

    public function getIdProd()
    {
        return $this->id_prod;
    }

    public function setQtdProd($valor) 
    {
        if (isset($valor)) {
            $this->qtdProd = $valor;
        } else {
            $this->qtdProd = NULL;
        }
    }

    public function getQtdProd()
    {
        return $this->qtdProd;
    }

    /**
     * Pega o parametro da global e redireciona
     *
     * @param [type] $valor
     * @param [type] $id
     * @return void
     */
    public function parametro($valor, $id)
    {

        if($valor == 'add'){

            $this->addProduto($id);

        } else if($valor == 'del') {

            $this->removeProduto($id);

        } else if($valor == 'up') {

            $this->alteraQtdProduto($id);

        }

    }

    /**
     * Adiciona produto no carrinho
     *
     * @param [type] $id
     * @return void
     */
    private function addProduto($id)
    {
                   
        if (!isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id] = 1;
        } else {
            $_SESSION['carrinho'][$id] += 1;
        }

        $this->redireciona();

    }

    /**
     * Remove produto do carrinho
     *
     * @param [type] $id
     * @return void
     */
    private function removeProduto($id)
    {

        if(isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }

        $this->redireciona();

    }

    /**
     * Altera a quantidade de produtos do carrinho
     *
     * @param [type] $valor
     * @return void
     */
    public function alteraQtdProduto($valor)
    {

        if(!empty($valor) && is_array($valor)) {
            foreach($valor as $id => $qtd){
                $id = intval($id);
                $qtd = intval($qtd);
                if (!empty($qtd) || $qtd <> 0) {
                    $_SESSION['carrinho'][$id] = $qtd;
                } else {
                    unset($_SESSION['carrinho'][$id]);
                }
            }
        }
  
        $this->redireciona();

    }

    /**
     * Lista todos os produtos
     *
     * @return void
     */
    public function produtosLoja()
    {
        $produtos = $this->conexao()->select('SELECT * FROM dividas');
        return $produtos;
    }

    /**
     * Redireciona para a página do carrinho
     *
     * @return void
     */
    public function redireciona()
    {
        return header("Location: ../../carrinho.php");
    }


}