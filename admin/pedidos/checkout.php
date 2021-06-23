<?php
include 'config/conexao.php';

$pedido_id = $_GET['pedido_id'];

$sql = "SELECT p.*,
                    u.nome as usuario,
                    p.total_liquido as valor,
                    c.nome as cliente
            FROM pedido p 
            LEFT JOIN cliente c ON c.id = p.cliente_id   
            LEFT JOIN usuario u on u.id = p.usuario_id
            WHERE
                p.pedido_id = $pedido_id
            ";

$dados = $pdo->prepare($sql);
$dados->execute();
$d = $dados->fetchAll();

?>
<div class="container-fluid" >
<div class="card">
    <div class="card-header">
    <h2 class="text-center text-black">Checkout Pedido </h2>
    </div><br>
    <div class="card-body row">
    <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters ">
                        <div class="col mr-2">
                            <div class="text-black">
                            <h2 class="text-center"> Pedido  </h2>
                           </div>
                            <div class="text-black">
                                <h4>  Data: <?php echo date('d/m/Y', strtotime($d[0]['data_hora'])) ?> </h4>
                                <h4>  Vendedor: <?php echo  $d[0]['usuario']   ?> </h4>
                                <h4> Cliente: <?php echo  $d[0]['cliente']   ?> </h4>
                                <h4>  Pedido: #<?php echo $pedido_id ?> </h4>
                                <h4>  Valor: R$ <?php echo  number_format($d[0]['valor'], 2, ',', '.')  ?> </h4>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-black">
                                <h2> Pagamento</h2>
                            </div>
                            
                            <label for="pagamento_id">  </label>
                    <select required class="form-control" id="pagamento_id" name="pagamento_id">
                        <option value=""> Selecione.. </option>
                        <?php
                        $sql = "SELECT * FROM pagamento";
                        $dadosTP = $pdo->prepare($sql);
                        $dadosTP->execute();
                        while ($dados3 = $dadosTP->fetch(PDO::FETCH_OBJ)) {
                            $idpgto = $dados3->pagamento_id;
                            $nome = $dados3->forma;
                            echo "<option value='$idpgto'> $nome </option>";
                        }
                        ?>
                    </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <div class="card-body ">
      <p class="text-center"> <b> PRODUTOS DO PEDIDO </b> </p>

            <table id="table" class="table table-striped">
                <thead>
                    <tr style="font-weight:bold">
                        <td> Produto </td>
                        <td> Val. Unit. </td>
                        <td> Qtde </td>
                        <td> Val. Total. </td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "select 
                                        i.*, concat(i.produto_id,' - ',p.titulo) as produto
                                     from produto_pedido i 
                                     left join produto p on p.id = i.produto_id
                                     where i.pedido_id = $pedido_id
                                     ";

                    $dadosCarrinho = $pdo->prepare($sql2);
                    $dadosCarrinho->execute();

                    $valor_final = $qtde_final = 0;
                    while ($dados2 = $dadosCarrinho->fetch(PDO::FETCH_OBJ)) {
                        $produto = $dados2->produto;
                        $qtd = $dados2->qtde;
                        $val_unitario = $dados2->valor_unitario;
                        $val_total = $dados2->valor_total;
                        $valor_final += $val_total;
                        $qtde_final += $qtd;
                        echo "
                                <tr>
                                    <td> " . $produto . " </td>
                                    <td> " . number_format($val_unitario, 2, ',', '.') . " </td>
                                    <td> " . $qtd . " </td>
                                    <td> " . number_format($val_total, 2, ',', '.') . " </td> 
                                </tr>
                                ";
                    }
                    echo "
                            <tr style='font-weight: bold'>
                                <td> Total: </td>
                                <td> </td>
                                <td> " . $qtde_final . " </td>
                                <td>" . number_format($valor_final, 2, ',', '.') . " </td>
                            </tr>
                        ";
                    ?>
                </tbody>
            </table>

        </div>
        </div>
        <a href="listar/pedido" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>
        <button type="button" class="btn btn-outline-success margin" onclick="finalizaPedido()"><i class="fa fa-check"></i> Finalizar </button>
            
</div> <br>

<script>

    function finalizaPedido() {

        var pedido_id = <?php echo $_GET['pedido_id'] ?>;
        var pagamento_id = document.getElementById('pagamento_id').value;
         
            $.ajax({
                url:'config/funcoes.php?acao=finalizaPedido&pedido_id='+pedido_id+'&pagamento_id='+ pagamento_id,
                async:true,
                success: function(result){
                        if ( parseInt(result) == 1 ){
                            swal("Sucesso.", 'Pedido finalizado com sucesso!', 'success');
                            setTimeout(function() {
                                window.location.href = "listar/caixa";
                            }, 1000);
                        } else {
                            alert('Algo deu errado.');
                        }
                }
            })
    }
</script>