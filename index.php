<?php
session_start();

require "header.php";
require "db.php";

$sql = "SELECT * FROM dividas";
$result = $conn->query($sql);

?>

  <!-- Page Content -->
  <div class="container mt-5">

    <div class="row">

      
      <div class="col-lg-8 offset-2">

        <div class="row">

          <?php 
          
          foreach ($result as $lista) :

          ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src=" <?="http://placehold.it/700x400?text=".$lista["id_divida"]?>" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#"><?=$lista["descricao_divida"];?></a>
                </h4>
                <h5><?=$lista['valor_divida'];?></h5>
                <a class="p-3" href="carrinho.php?acao=add&id=<?=$lista['id_divida']?>">Comprar</a>
                
              </div>
              
            </div>
          </div>
          <?php endforeach;?>

        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

 <?php require "footer.php"; ?>