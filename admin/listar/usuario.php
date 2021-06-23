<?php

// Verificar se não está logado
if (!isset($_SESSION['dolce']['id'])) {
    exit;
}

$sql = "SELECT * FROM usuario ORDER BY id ";


$consulta = $pdo->prepare($sql);
$consulta->execute();

?>

<div class="container">
<div class="card">
    <div class="card-header">
    <h3 class="float-left">Listar Usuários</h3>
    <div class="float-right">
        <a href="cadastro/usuario" class="btn btn-success">Novo Usuário</a>
        <a href="listar/usuario" class="btn btn-secondary">Listar Usuário</a>
    </div>
		</div>
	<div class="card-body">

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" id="tb">
        <thead>
            <tr>
                <td><i class=""></i><b> ID</b></td>
                <td><i class=""></i><b> Nome</b></td>
                <td><i class=""></i><b> Celular</b></td>
                <td><i class=""></i><b> Email</b></td>
                <td><i class=""></i><b> Status</b></td>
                <td><i class=""></i><b> Opções</b></td>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($consulta->fetchAll(PDO::FETCH_OBJ) as $dados) : ?>

            <?php if ($dados->status == 'A' ) {
               $dados->status = "<span class='badge badge-success'>Ativo</span>";
            } else {
                $dados->status = "<span class='badge badge-danger'>Inativo</span>";
            }?>
                
                <tr>
                    <td><?= $dados->id ?></td>
                    <td><?= $dados->nome ?></td>
                    <td><?= $dados->celular ?></td>
                    <td><?= $dados->email ?></td>
                    <td><a href="javascript:alterar(<?=$dados->id?>)" <?=$dados->status?> </a></td>
                    <td>
                        <a href="cadastro/usuario/<?= $dados->id ?>" title="Editar Usúario <?= $dados->id ?>" 
                        class="btn btn-outline-success "><i class="fa fa-edit"></i> </a>
                        <button class="btn btn-outline-danger " title="Deletar Usuário <?= $dados->id ?>"
                         onclick="excluir(<?= $dados->id ?>)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>
</div>

    <a href="paginas/home" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>

<script>
    const excluir = (id) => {

        if (confirm(`Deseja realmete excluir o Usuário ${id}?`)) {
            // Direcionar para a exclusão
            location.href = `excluir/usuario/${id}`
        }
    }

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
							location.href="alterar/usuario/"+id;
						} 
					})
		);
	}
</script>