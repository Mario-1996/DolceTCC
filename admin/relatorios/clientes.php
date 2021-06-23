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
        <h3 class="float-left">Relatório de Clientes</h3>

    </div>
    <div class="card-body">

    	<table class="table table-hover table-bordered table-striped" id="tb">
    		<thead>
    			<tr>
    				<td>ID</td>
    				<td>Cliente</td>
    				<td>Celular</td>
    				<td>Endereço</td>
                    <td>Número</td>
                    <td>Comprou</td>
    			</tr>
    		</thead>
    		<tbody>
    			<?php
    				$sql = "SELECT count(c.nome) compras, c.nome, c.id, c.celular, c.endereco, c.numero 
                    from pedido p 
                    inner join cliente c on (c.id = p.cliente_id) 
                    group by c.nome, c.id, c.celular, c.endereco 
                    order by compras";
    			    $consulta = $pdo->prepare($sql);
    			    $consulta->execute();

    			    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
    			    	?>
    			    	<tr>
    			    		<td><?=$dados->id?></td>
    			    		<td><?=$dados->nome?></td>
    			    		<td><?=$dados->celular?></td>
    			    		<td><?=$dados->endereco?></td>
                            <td><?=$dados->numero?></td>
    			    		<td><?=$dados->compras?> Vezes</td>
    			    	</tr>
    			    	<?php
    			    }
    			?>
    		</tbody>
    	</table>


    </div> <!-- card-body -->
</div><br> <!-- card -->
    <a href="paginas/home" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>
