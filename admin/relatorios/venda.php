<?php
    if ( ! isset ( $_SESSION['dolce']['id'] ) ) exit;
	if ($_SESSION["dolce"]["idtipousuario"] == 2) {
		echo "<script>swal('Atenção','Acesso Negado','warning',{
			button : false ,
			});setTimeout(() => { 
			history.back();
		}, 1000);</script>";
		exit; 
	}
?>

<div class="container">
<div class="card">
    <div class="card-header">
    <h3 class="float-left">Relatório de Vendas por mês</h3>
    </div>
    <div class="card-body">

    	<table class="table table-hover table-bordered table-striped" id="tb">
    		<thead>
    			<tr>
    				<td>Mês</td>
    				<td>Ano</td>
    				<td>Valor Total</td>

    			</tr>
    		</thead>
    		<tbody>
    			<?php
    				$sql = "SELECT sum(pp.valor_unitario*pp.qtde) total, MONTH(p.data_hora) mes, YEAR(p.data_hora) ano
                     from pedido p 
                     inner join produto_pedido pp on (pp.pedido_id = p.pedido_id) 
                     GROUP by YEAR(p.data_hora), MONTH(p.data_hora) 
                     order by mes and ano";
    			    $consulta = $pdo->prepare($sql);
    			    $consulta->execute();

    			    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
    			    	?>
    			    	<tr>
    			    		<td><?=$dados->mes?></td>
    			    		<td><?=$dados->ano?></td>
                            <td>R$ <?=number_format($dados->total, 2, ",", ".")?></td>
    			    	</tr>
    			    	<?php
    			    }
    			?>
    		</tbody>
    	</table>


    </div> <!-- card-body -->
</div><br> <!-- card -->
    <a href="" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>
