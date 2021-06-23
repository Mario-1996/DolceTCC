<?php
include 'config/conexao.php';

//$pedido_id = $_GET['id'];

$sql = "SELECT p.*,
                    u.nome as usuario,
                    p.total_liquido as valor,
                    c.nome as cliente
            FROM pedido p 
            INNER JOIN cliente c ON c.id = p.cliente_id   
            INNER JOIN usuario u on u.id = p.usuario_id
            WHERE
                p.pedido_id = $id
            ";

$dados = $pdo->prepare($sql);
$dados->execute();
$d = $dados->fetchAll();

//var_dump($sql);

?>


<div class="container" id="listagem">
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Detalhes Pedidos</h3>
    </div>
    <div class="card-body">
			<table class="table table-striped table-bordered table-hover" id="tb">
                <thead>
                    <tr>
						<td> ID pedido </td>
                        <td> Vendedor </td>
						<td> Cliente </td>
						<td> Produto </td>
                        <td> Val Unit. </td>
                        <td> Qtde </td>
                        <td> Val Pacote </td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2 = "select 
                                        i.*, concat(i.produto_id,' - ',p.titulo) as produto
                                     from produto_pedido i 
                                     inner join produto p on p.id = i.produto_id
                                     where i.pedido_id = $id
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
                                    <td> " . $id . " </td>
									<td> " .  $d[0]['usuario'] . " </td>
									<td> " . $d[0]['cliente'] . " </td>
									<td> " . $produto . " </td>
                                    <td> " . number_format($val_unitario, 2, ',', '.') . " </td>
                                    <td> " . $qtd . " </td>
                                    <td> " . number_format($val_total, 2, ',', '.') . " </td> 
                                </tr>
                                ";
                    }
                  
                    ?>
                </tbody>
            </table>

        </div>
</div>
	<a href="relatorios/pedidos" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>