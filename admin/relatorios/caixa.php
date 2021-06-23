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

<div class="container">
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Relatório do Caixa</h3>

    </div>
    <div class="card-body">

    	<table class="table table-hover table-bordered table-striped" id="tb">
		<h5> <?php if ( !empty ($data1) && !empty($data2) ) { echo "Data $resultdata1" ?> - <?php echo $resultdata2; }?></h5>
    		<thead>
    			<tr>
    				<td>ID</td>
    				<td>Usuário</td>
    				<td>Data</td>
    				<td>Saldo Inicial</td>
                    <td>Saldo Final</td>
                    <td>Fechamento</td>
    			</tr>
    		</thead>
    		<tbody>
    			<?php
				include "config/conexao.php";

				if (!empty ($data1) && !empty($data2)) {

    				$sql = "SELECT p.*,  DATE_FORMAT(data,'%d/%m/%Y') data, date_format(datahora_fechamento, '%d/%m/%y - %H:%i') fechamento, c.nome
                    from caixa p 
                    inner join usuario c on (c.id = p.usuario_id) 
                    where p.data  between ? and ?";
				}
    			    $consulta = $pdo->prepare($sql);
					$consulta->bindParam(1, $data1);
					$consulta->bindParam(2, $data2);
    			    $consulta->execute();

    			    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {
    			    	?>
    			    	<tr>
    			    		<td><?=$dados->idcaixa?></td>
    			    		<td><?=$dados->nome?></td>
                            <td><?=$dados->data?></td>
                            <td><?=number_format ($dados->saldo_inicial,2,",",".");?></td>
                            <td><?=number_format ($dados->saldo_atual,2,",",".");?></td>
                            <td><?=$dados->fechamento?></td>
    			    	</tr>
    			    	<?php
    			    }
    			?>
    		</tbody>
    	</table>


    </div> <!-- card-body -->
</div><br> <!-- card -->
    <a href="relatorios/liscaixa" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>
