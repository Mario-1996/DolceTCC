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
        <h3 class="float-left">Relatório de Produtos mais Vendidos</h3>
    </div>
    <div class="card-body">
	<table class="table table-striped table-bordered table-hover" id="tb">
	<h5><?php if ( !empty ($data1) && !empty($data2) ) { echo "Data $resultdata1" ?> - <?php echo $resultdata2; }?></h5>
	<thead>
		<tr>
			<td><b>Produto</b></td>
			<td><b>Quantidade Vendida</b></td>
		</tr>
	</thead>
	

	<?php

		//conectar no banco
		include "config/conexao.php";
	
		if (!empty ($data1) && !empty($data2)) {

		//selecionar todos os 
		$sql = "SELECT SUM(qtde) AS qtde, p.titulo FROM produto_pedido it
		INNER JOIN produto p on it.produto_id = p.id
		INNER JOIN pedido pe on pe.pedido_id = it.pedido_id
		where pe.data_hora between ? and ?
		GROUP BY it.produto_id order by it.qtde";

		} else {

		$sql = "SELECT SUM(qtde) AS qtde, p.titulo FROM produto_pedido it INNER JOIN produto p on(it.produto_id = p.id)
		GROUP BY it.id order by it.qtde ";
		
		}

		
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $data1);
		$consulta->bindParam(2, $data2);
		$consulta->execute();
		//listar todos os professores
		while ( $dados = $consulta->fetch(PDO::FETCH_OBJ)) {
			//separar os dados
			$titulo    = $dados->titulo;
            $qtde      = $dados->qtde;
				  
			//formar uma linha da tabela
			echo "<tr>
					<td>$titulo</td>
                    <td>$qtde Unidades</td>
				</tr>";
		}	
	?>

	</table>
	</div>
</div>
<br>
<a href="relatorios/maisVendidos" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>
