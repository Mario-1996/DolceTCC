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
$vendedor = $_POST['vendedor'];

if ($data1 > $data2) {
	echo "<script>alert('Período Inválido');history.back();</script>";
	exit;
} else {

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

?>


<div class="container" id="listagem">
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Relatório do Vendedor</h3>
    </div>
    <div class="card-body">
	<table class="table-bordered table-striped" id="tb">
	<h5><?php echo "Data $resultdata1" ?> - <?php echo $resultdata2 ?> </h5>
	<thead>
		<tr>
			<td><b>ID:</b></td>
			<td><b>Vendedor:</b></td>
            <td><b>Total Clientes:</b></td>
			<td><b>Total Vendas:</b></td>
		</tr>
	</thead>
	</div>

	<?php

		//conectar no banco
		include "config/conexao.php";
		//include "comunicacao/validaFunc.php";
		//selecionar todos os professores
	if (empty($vendedor)) {
		$sql = "SELECT * FROM usuario WHERE status = 'A' ";
		$consulta = $pdo->prepare($sql);
		$consulta->execute();

		if($consulta->rowCount() > 0) {
			$dadosCol = $consulta->fetchAll();

			$resultdados = array();

			foreach ($dadosCol as $listCol) {

				$id = $listCol['id'];

				$sql = "SELECT SUM(total_bruto) AS total_bruto, p.usuario_id, u.nome, count(cliente_id) cliente_id FROM pedido p INNER JOIN usuario u on(p.usuario_id = u.id) 
				WHERE p.usuario_id = ? ";
				$consulta = $pdo->prepare($sql);
				$consulta->bindParam(1, $id);
				$consulta->execute();

					$dados = $consulta->fetch(PDO::FETCH_OBJ);

					$resultdados[] = $array = array('usuario_id' => $dados->usuario_id, 'total_bruto' => $dados->total_bruto, 'nome' => $dados->nome, 'cliente_id' => $dados->cliente_id);

			}

		} else {
			echo '<script>alert("vazio");history.back();</script>';
		}

	}else {
		$sql = "SELECT SUM(total_bruto) AS total_bruto, p.usuario_id, u.nome, count(cliente_id) cliente_id FROM pedido p INNER JOIN usuario u on(p.usuario_id = u.id) 
		WHERE p.usuario_id = ? and p.data_hora BETWEEN ? AND ?
		order by p.usuario_id desc limit 0,10";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $vendedor);
		$consulta->bindParam(2, $data1);
		$consulta->bindParam(3, $data2);
		$consulta->execute();
		$resultdados = $consulta->fetchAll();
	}
		
			
		//$sql = "SELECT p.*, m.nome marca, c.categoria FROM produto p INNER JOIN marca m on(p.idmarca = m.idmarca) 
		//INNER JOIN categoria c ON (p.idcategoria = c.idcategoria)";

		foreach ($resultdados as $list) {
			$total_bruto = $list['total_bruto'];
			$total_bruto = number_format($total_bruto, 2, ",", '.');

			?> 
			<tr>
					<td><?php echo $list['usuario_id'];?></td>
                    <td><?php echo $list['nome'];?></td>
                    <td><?php echo $list['cliente_id'];?></td> 
                    <td>R$ <?php echo $total_bruto;?></td>
				</tr>
			<?php
			}
		}	
	?>	
	
	</table>
</div>
</div>
<br>
<a href="relatorios/vendedor" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>