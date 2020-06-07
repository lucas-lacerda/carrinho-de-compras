<?php
session_start();

require "header.php";
require "db.php";

$total = 0;

//adiciona produto 
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

if (isset($_GET['acao'])) {
    
    //Adiciona ao carrinho
    if ($_GET['acao'] == 'add') {
        $id = intval($_GET['id']);
        if (!isset($_SESSION['carrinho']['id'])) {
            $_SESSION['carrinho'][$id] = 1;
        } else {
            $_SESSION['carrinho'][$id] += 1;
        }
    }

    // Remove do carrinho
    if ($_GET['acao'] == 'del') {
        $id = intval($_GET['id']);
        if(isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
    }

    // Atualiza Quantidade
    if($_GET['acao'] == 'up') {
        if(!empty($_POST['prod']) && is_array($_POST['prod'])) {
            foreach($_POST['prod'] as $id => $qtd){
                $id = intval($id);
                $qtd = intval($qtd);
                if (!empty($qtd) || $qtd <> 0) {
                    $_SESSION['carrinho'][$id] = $qtd;
                } else {
                    unset($_SESSION['carrinho'][$id]);
                }
            }
        }
    }    

}


?>



<div class="container mt-5">
    <div class="row">
        <div class="col-md-9 "> 
            <form action="?acao=up" method="post">
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
                                $sql = "SELECT * FROM dividas WHERE id_divida={$id}";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();

                                $nome  = $row['descricao_divida'];
                                $preco = number_format($row['valor_divida'], 2, ',', '.');
                                $sub   = number_format($row['valor_divida'] * $qtd, 2, ',', '.');
                                $total += $row['valor_divida'] * $qtd;                          
                                                        
                            ?>
                            <tr>
                                <td width="10"><?=$row['id_divida']?></td>
                                <td width="244"><?=$nome?></td>
                                <td><input type="text" size="3" name="prod[<?=$id?>]" value="<?=$qtd?>" /></td>
                                <td width="89"><?=$preco?></td>
                                <td width="100"><?=$sub?></td>
                                <td width="64"><a href="?acao=del&id=<?=$id?>">Remove</a></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    
                        
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
                <h1><?=$total = number_format($total, 2, ',', '.');?></h1>
                <h5>Total</h5>
            </div>
        </div>

    </div>
</div>

