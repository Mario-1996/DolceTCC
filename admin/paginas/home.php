<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["dolce"]["id"] ) ){
    exit;
  }
  include 'functions.php';
  

  $clientes = "SELECT count(id) clientes from cliente";
  $consulta = $pdo->prepare($clientes);
  $consulta->execute();
  $dados = $consulta->fetch(PDO::FETCH_OBJ);
  $clientes = $dados->clientes;

  $produtos = "SELECT count(id) produtos from produto";
  $consulta = $pdo->prepare($produtos);
  $consulta->execute();
  $dados = $consulta->fetch(PDO::FETCH_OBJ);
  $produtos = $dados->produtos;
  
  $mes = date("m");
  $sql = "SELECT sum(pp.valor_total) fatMensal from pedido p inner join produto_pedido pp on (item_id = p.pedido_id) where month(p.data_hora) = $mes";
  $consulta = $pdo->prepare($sql);
  $consulta->execute();
  $dados = $consulta->fetch(PDO::FETCH_OBJ);
  $faturamentoMensal = number_format($dados->fatMensal, 2, ",", ".");

  $sql = "SELECT sum(pp.valor_unitario*pp.qtde) total, MONTH(p.data_hora) mes, YEAR(p.data_hora) ano
   from pedido p 
   inner join produto_pedido pp on (pp.pedido_id = p.pedido_id) 
   order by ano";
  $consulta = $pdo->prepare($sql);
  $consulta->execute();

  while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {  
      $total = number_format($dados->total, 2, ",", ".");    
  }
?>
    <!-- Painel de Controle -->
<section id="dashboard">
    <div class="container">
    <?php  if ($_SESSION["dolce"]["idtipousuario"] == 1) {
      echo ' <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Faturamento Mensal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$'.$faturamentoMensal.'</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-800"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Faturamento Anual</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$'.$total.'</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-800"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Clientes Cadastrados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.$clientes.'</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-800"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Produtos Cadastrados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">'.$produtos.'</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cart-plus fa-2x text-gray-800"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';}?>

        <div class="row">
            <div class="col-xs-10 col-sm-6 col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                <a class="text-xs-center" href="listar/buscapreco">
                    <p><img class=" img-fluid" src="../arquivos/busca.png" alt="card image"></p>
                    <h4 class="card-title letra"><b>Buscar Preço</b></h4>    
                        <i class="fa fa-search"></i>               
                </a>    
                </div>
            </div>
            </div>

          

            <div class="col-xs-10 col-sm-6 col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <a class="text-xs-center" href="pedidos/pedido">
                    <p><img class=" img-fluid" src="../arquivos/fatura.png" alt="card image"></p>
                        <h4 class="card-title letra"><b>Pedido</b></h4>
                            <i class="fa fa-angle-up"></i>
                    </a>
                </div>
            </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                <a class="text-xs-center" href="listar/caixa">
                    <p><img class=" img-fluid" src="../arquivos/carrinho-de-compras.png" alt="card image"></p>
                    <h4 class="card-title letra"><b>Caixa</b></h4>
                        <i class="fa fa-angle-up"></i>
                </a>
                </div>
            </div>
            </div>
</section>

