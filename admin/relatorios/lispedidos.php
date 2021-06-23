<?php

	if ( !isset ( $pagina ) ) {
		echo "<h1>Acesso negado</h1>";
		exit;
	}
	if ($_SESSION["dolce"]["idtipousuario"] == 2) {
		echo "<script>swal('Atenção','Acesso Negado','warning',{
			button : false ,
			});setTimeout(() => { 
			history.back();
		}, 1000);</script>";
		exit; 
	}

$data1 = $_POST['data1'];
$data2 = $_POST['data2'];

if ($data1 > $data2) {
	echo "<script>alert('Período Inválido');history.back();</script>";
	exit;
} else {

	if (!empty ($data1) && !empty($data2)) {
	$resultdata1 = explode("-", $data1);
						  $dia = $resultdata1[2];
                          $mes = $resultdata1[1];
				          $ano = $resultdata1[0];
			$resultdata1 = $dia . "/" . $mes . "/" . $ano;
	$resultdata2 = explode("-", $data2);
			$dia = $resultdata2[2];
			$mes = $resultdata2[1];
			$ano = $resultdata2[0];
$resultdata2 = $dia . "/" . $mes . "/" . $ano;
	}
}
?>


<div class="container" id="listagem">
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Relatorio de Pedido</h3>
    </div>
    <div class="card-body">
	<table class="table table-striped table-bordered table-hover" id="tb">
	
	<h5> <?php if ( !empty ($data1) && !empty($data2) ) { echo "Data $resultdata1" ?> - <?php echo $resultdata2; }?></h5>		
	<thead>
			<tr>
				<td><b>Id do Pedido</b></td>
				<td><b>Vendedor</b></td>
				<td><b>Cliente</b></td>
				<td><b>Data</b></td>
				<td><b>Baixa</b></td>
				<td><b>Valor Total</b></td>
				<td><b>Opçôes</b></td>
			</tr>
		</thead>
		</div>

		<?php

			//conectar no banco
			include "config/conexao.php";

			if (!empty ($data1) && !empty($data2)) {

			//selecionar todos os
			$sql = "SELECT p.pedido_id,p.data_hora,DATE_FORMAT(datahora_baixa,'%d/%m/%Y') datahora_baixa, p.total_bruto, u.nome nomeusu, c.nome
			FROM pedido p 
			INNER JOIN usuario u ON(p.usuario_id = u.id)
			INNER JOIN  cliente c ON (p.cliente_id = c.id) 
			where p.data_hora  between ? and ?";
			}

			$consulta = $pdo->prepare($sql);
			$consulta->bindParam(1, $data1);
			$consulta->bindParam(2, $data2);
			$consulta->execute();
			
			while ( $dados = $consulta->fetch(PDO::FETCH_OBJ)) {
				
				$pedido_id          = $dados->pedido_id;
				$nomeusu         = $dados->nomeusu;
				$nome         = $dados->nome;
				$datahora_baixa = $dados->datahora_baixa;
				$data_hora = $dados->data_hora;
				$data_hora = explode("-", $data_hora);
							$dia = $data_hora[2];
							$mes = $data_hora[1];
							$ano = $data_hora[0];
					$data_hora = $dia . "/" . $mes . "/" . $ano;
					$total_bruto = $dados->total_bruto;
					$total_bruto = number_format($total_bruto, 2, ",", '.');
					
				echo "<tr>
						<td>$pedido_id</td>
						<td>$nomeusu</td>
						<td>$nome</td>
						<td>$data_hora</td>
						<td>$datahora_baixa</td>
						<td>R$ $total_bruto</td>
						<td>
						<a href='listar/lispedido/$dados->pedido_id' class='btn btn-outline-primary'
						 title='Detalhes do Pedido $dados->pedido_id '>
						<i class='fa fa-search'></i>
					</td> 
					</tr>";
			}
		
		?>
		
	</table>
</div>
</div>
	<br>
	<a href="relatorios/pedidos" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>