<?php

// Verificar se não está logado
if (!isset($_SESSION['dolce']['id'])) {
    exit;
}

// Query da listagem
$sql = "SELECT *, DATE_FORMAT(datanascimento, '%d/%m/%Y') datanascimento
        FROM cliente 
        ORDER BY id";	

$consulta = $pdo->prepare($sql);
$consulta->execute();

?>

<div class="container" id="listagem">
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Listar Clientes</h3>
        <div class="float-right">
        <a href="cadastro/cliente" class="btn btn-success">Novo Cliente</a>
        <a href="listar/cliente" class="btn btn-secondary">Listar Cliente</a>
    </div>
    </div>
    <div class="card-body">
    
    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" id="tb">
        <thead>
            <tr>
                <td>ID</td>
                <td>Nome</td>
                <td>Cpf</td>
                <td>E-mail</td>
                <td>Celular</td>
                <td>Status</td>
                <td>Opções</td>
                
				
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
                    <td><?= $dados->cpf ?></td>  
                    <td><?= $dados->email ?></td>
                    <td><?= $dados->celular ?></td>
                  
                    <td><a href="javascript:alterar(<?=$dados->id?>)" <?=$dados->status?> </a></td>
                    <td>
                        <a href="cadastro/cliente/<?= $dados->id ?>" title="Editar Cliente <?= $dados->nome ?>" 
                        class="btn btn-outline-success "><i class="fa fa-edit"></i></a>
                        <?php if ($_SESSION["dolce"]["idtipousuario"] == 1) {
                            echo '<button class="btn btn-outline-danger " title="Deletar Cliente '.$dados->nome.'"
                            onclick="excluir(<?= $dados->id ?>)"><i class="fa fa-trash"></i></button>';
                        }
                        ;?>
                       
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
        if (confirm(`Deseja mesmo excluir o cliente ${id}?`)) {
            // Direcionar para a exclusão
            location.href = `excluir/cliente/${id}`
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
							location.href="alterar/cliente/"+id;
						} 
					})
		);
	}
</script>