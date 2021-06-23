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
    include "config/conexao.php";
?>

<div class="container" id="formulario">
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Relatório do Vendedor</h3>
    </div>
    <div class="card-body">
    <form name="filteay" action="relatorios/lisvendedor" method="POST">

    <div class="form-row">
            <div class="form-group col-md-4">
                <label for="vendedor"><b>Vendedor</b></label>
                <select name="vendedor" id="vendedor" class="vendedor js-states form-control">
                    <option value=""><b>Todos</b></option>
                    <?php
                        $consulta = $pdo->prepare("SELECT id,nome FROM usuario ORDER BY nome");
                        $consulta->execute();
                        while ($a = $consulta->fetch(PDO::FETCH_OBJ)) {

                            echo "<option value='$a->id'>$a->nome</option>";
                        }
                    ?>
                    </select>
            </div>
            <div class="form-group col-md-3">
                <label for="data"><b>Data Início</b></label>
                <div class="controls">
                    <input type="date" name="data1" class="form-control" required>
                </div>
            </div>
                <br>
            <div class="form-group col-md-3">
                <label for="data"><b>Data Final</b></label>
                <div class="controls">
                    <input type="date" name="data2" class="form-control" required>
                </div>
            </div>
            <div class="form-group col-md-2">
                <label><b>Pesquisar</b></label>
                <div class="controls">
                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i> Buscar</button>
                </div>
            </div> 
    </div>  
            
           
        </form>  
    </div>
</div><br>
    <a href="" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>
