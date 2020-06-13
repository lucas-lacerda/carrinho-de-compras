<?php
session_start();

require "header.php";
require "db.php";

require __DIR__."/vendor/autoload.php";
use App\Models\Carrinho;

$prod = new Carrinho();


?>



<div class="container mt-5">
    <div class="row">
        <div class="col-md-9 "> 
            <form action="app/Controllers/AtualizaQtdCart.php?acao=up" method="post">
                <table class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th width="10">ID</th>
                            <th width="244">Produto</th>
                            <th width="79">Quantidade</th>
                            <th width="89">Pre&ccedil;o</th>
                            <th width="100">SubTotal</th>
                            <th width="64">Remover</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php 
                            if(count($_SESSION['carrinho']) == 0) :
                        ?>
                            <tr><td class="text-center" colspan="6">Não há produto no carrinho</td></tr>
                        <?php else : 

                            $total = 0;
                            foreach($_SESSION['carrinho'] as $id => $qtd) :

                                $produtos = $prod->listaProdCart($id);
                                
                                foreach ($produtos as $produto) :
                                    $preco = number_format($produto->valor_divida, 2, ',', '.');
                                    $sub   = number_format($produto->valor_divida * $qtd, 2, ',', '.');
                                    $total += $produto->valor_divida * $qtd;     
                                                                          
                            ?>
                            <tr>
                                <td width="10"><?=$produto->id_divida?></td>
                                <td width="244"><?=$produto->descricao_divida?></td>
                                <td><input type="text" size="3" name="prod[<?=$id?>]" value="<?=$qtd?>" /></td>
                                <td width="89"><?=$preco?></td>
                                <td width="100"><?=$sub?></td>
                                <td width="64"><a href="app/Controllers/DeleteCart.php?acao=del&id=<?=$id?>">Remove</a></td>
                            </tr>
                        <?php endforeach;endforeach; endif; ?>
                    
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><button class="btn btn-primary">Atualizar Carrinho</button></td>
                            <td colspan="3" class="text-right"><a href="index.php">Continuar Comprando</a></td>
                        <tr>
                        
                    </tfoot>
                </table>
            </form>
        </div>
        <div class="col-md-3 " >
            <div class="card text-center p-5 sticky-top " style="top: 90px;">
                <h1>
                    <?php
                        $total = (!empty($total)) ? number_format($total, 2, ',', '.') : 0 ;
                        echo $total;
                    ?>
                </h1>
                <h5>Total</h5>
            </div>
        </div>

    </div>
</div>

