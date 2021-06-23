<?php
//verificar se não está logado
if (!isset($_SESSION["dolce"]["id"])) {
	exit;
}
?>
<div class="container">
<div class="card">
    <div class="card-header">
	<h3 class="float-left">Listar Modelo de Produto</h3>
	<div class="float-right">
		<a href="cadastro/modelo" class="btn btn-success">Novo Modelo</a>
		<a href="listar/modelo" class="btn btn-secondary">Listar Modelo</a>
	</div>
    </div>
    <div class="card-body">

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover" id="tb">
		<thead>
			<tr>
				<td>ID</td>
				<td>Nome </td>
				<td>Status </td>
				<td>Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			
			$sql = "select * from modelo
				order by modelo";
			$consulta = $pdo->prepare($sql);
			$consulta->execute();

			while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
				//separar os dados
				$id 	= $dados->id;
				$modelo	= $dados->modelo;
				$status	= $dados->status;
				if ($status == 'A' ) {
					$status = "<span class='badge badge-success'>Ativo</span>";
				} else  {
					$status = "<span class='badge badge-danger'>Inativo</span>";
				}	

				//mostrar na tela
				echo '<tr>
						<td>' . $id . '</td>
						<td>' . $modelo . '</td>
						<td><a href="javascript:alterar('.$id.')" '.$status.'</a></td>
						<td>
							<a href="cadastro/modelo/' . $id . '" class="btn btn-outline-success">
								<i class="fa fa-edit"></i>
							</a>

						</td>
					</tr>';
			}
			?>
		</tbody>
	</table>
	</div>
</div>

	<a href="paginas/home" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>
<script>
	//funcao para perguntar se deseja excluir
	//se sim direcionar para o endereco de exclusão

	function alterar( id ) {
		
		if (swal({
                        title: "Atenção.",
                        text: "Deseja realmente alterar o Status ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
					.then((willDelete) => {
                        if (willDelete) {
							location.href="alterar/modelo/"+id;
						} 
					})
		);
	}
</script>  