<?php
if (!isset($_SESSION["dolce"]["id"])) {
    exit;
} 
				
				$sql = "SELECT pd.*, c.nome nome, DATE_FORMAT(data_hora,'%d/%m/%Y') data 
				FROM pedido pd 
				LEFT JOIN cliente c on (c.id = pd.cliente_id) 
				WHERE pd.status = 'f' 				
				order by pd.pedido_id";
				$consulta = $pdo->prepare($sql);
				$consulta->execute();
			
?>
<div class="container" id="listagem">
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Pedidos em Aberto</h3>
    </div>
    <div class="card-body">
	<table class="table table-striped table-bordered table-hover" id="tb">
		<thead>
			<tr>
			<td><b>ID Pedido</b></td>
			<td><b>ID Cliente</b></td>	
			<td><b>Data</b></td>
			<td><b>Valor Total</b></td>
			<td><b>Opções</b></td>
			<td><b>Finalizar</b></td>
			</tr>
		</thead>
		<tbody>
		
            <?php foreach ($consulta->fetchAll(PDO::FETCH_OBJ) as $dados) : ?>
		
                <tr>
                    <td><?= $dados->pedido_id ?></td>
					<td><?= $dados->nome ?></td>
                    <td><?= $dados->data ?></td>  
                    <td>R$ <?= number_format($dados->total_bruto, 2, ",", '.') ?></td>
					<td>
						<button class="btn btn-outline-danger " title="Deletar Pedido <?= $dados->pedido_id ?>"
                         onclick="excluir(<?= $dados->pedido_id ?>)"><i class="fa fa-trash"></i></button>
					</td> 
					<td>
					<button onclick="crtz(<?=$dados->pedido_id?>)" type="button" class="btn btn-outline-success"> 
                                    <i class="fa fa-check"></i> 
                                    Finalizar 
                                </button>  
						
					</td> 
                </tr>
			
            <?php endforeach ?>
		
	</table>
	</div>
</div>
	<a href="pedidos/pedido" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>
<script>
    const excluir = (pedido_id) => {

        if (confirm(`Deseja realmete excluir o Pedido${pedido_id}?`)) {
            // Direcionar para a exclusão
            location.href = `excluir/pedido/${pedido_id}`
        }
    }

	  function crtz(pedido_id) {
       
            window.location.href="pedidos/checkout&pedido_id="+pedido_id;
    }
</script>
  