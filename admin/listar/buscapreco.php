<?php
    //verificar se nao esta logado
    if (!isset ($_SESSION["dolce"]["id"])) {
        exit;
    }
    ?>
    <div class="container">
    <div class="card">
        <div class="card-header">
           <h3 class="float-left">Buscar Preço</h3>
        </div>
    <div class="card-body">
        
    <table class="table table-striped table-bordered table-hover" id="tb">
        <thead>
            <tr>
                <td>ID</td>
                <td>Status</td>
                <td>Nome </td>
                <td>Valor Unitario</td>
            </tr>
        </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM produto ORDER BY id ";
            
        $consulta = $pdo->prepare($sql);
        $consulta->execute();
        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
           
            //recuperar dados
            $id          = $dados->id;
            $status      = $dados->status;
            $titulo      = $dados->titulo;
            $valor       = $dados->valor;
            $valor       = number_format ($dados->valor,2,",",".");
            if ($status == 'A' ) {
                $status = "<span class='badge badge-success'>Ativo</span>";
            } else  {
                $status = "<span class='badge badge-danger'>Inativo</span>";
            }	
        
            echo "<tr>
            <td>$id</td>
            <td>$status</td>
            <td>$titulo </td>
            <td>R$ $valor</td>
        </tr>";    
        }    
        ?>
    </tbody>
  </table>
    </div>
    </div>
  <a href="paginas/home" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>     