<?php
    //verificar se nao esta logado
    if (!isset ($_SESSION["dolce"]["id"])) {
        exit;
    }
    ?>
    <div class="container">
    <div class="card">
    <div class="card-header">
    <h3 class="float-left">Listar Produtos</h3>
        <div class="float-right">
        <a href="cadastro/produto" class="btn btn-success">Novo Produto</a>
        <a href="listar/produto" class="btn btn-secondary">Listar Produtos</a>
    </div>
    </div>
    <div class="card-body">
  
    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" id="tb">
        <thead>
            <tr>
                <td>ID</td>
                <td>Foto</td>
                <td>Nome </td>
                <td>Data</td>
                <td>Valor</td>
                <td>Quantidade</td>
                <td>Status</td>
                <td>Opções</td>
           
            </tr>
        </thead>
    <tbody>
        <?php
            $sql = "SELECT *, DATE_FORMAT(data,'%d/%m/%Y') data FROM produto ORDER BY id ";
            
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
           
            //recuperar dados
            $id          = $dados->id;
            $status      = $dados->status;
            $titulo      = $dados->titulo;
            $foto        = $dados->foto;
            $valor       = $dados->valor;
            $valor       = number_format ($dados->valor,2,",",".");
            $quantidade  = $dados->quantidade;
            $data        = $dados->data;
            if ($status == 'A' ) {
                $status = "<span class='badge badge-success'>Ativo</span>";
            } else  {
                $status = "<span class='badge badge-danger'>Inativo</span>";
            }	
           

            $imagem = "fotos/".$foto."p.jpg";
            
            echo "<tr>
            <td>$id</td>
            <td>
                <img src='$imagem' width='40px'>            
            </td>
            <td>$titulo </td>
            <td>$data</td>
            <td>R$ $valor</td>
            <td>$quantidade</td>
            <td><a href='javascript:alterar($id)' $status</a></td>
            <td>
            <a href='cadastro/produto/$id' class='btn btn-outline-success'>
                <i class='fa fa-edit'></i>
            </a>
            <a href=\"javascript:excluir($id)\" class='btn btn-outline-danger'>
            <i class='fa fa-trash'></i> 
            </a>
            </td>
        </tr>";
        
        }    

        ?>
    </tbody>
  </table>
    </div>
    </div>
  <a href="paginas/home" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>  
<script>
     const excluir = (id) => {
        if (confirm(`Deseja mesmo excluir o Produto ${id}?`)) {
            // Direcionar para a exclusão
            location.href = `excluir/produto/${id}`
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
							location.href="alterar/produto/"+id;
						} 
					})
		);
	}

      
</script>      