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
        <h3 class="float-left">Relatório de Produtos mais Vendidos</h3>
    </div>
    <div class="card-body">
    <form name="filteay" action="relatorios/lismaisvendidos" method="POST">

    <div class="form-row">
            <div class="form-group col-md-5">
                <label for="data"><b>Data Início</b></label>
                <div class="controls">
                    <input type="date" name="data1" class="form-control">
                </div>
            </div>
                <br>
            <div class="form-group col-md-5">
                <label for="data"><b>Data Final</b></label>
                <div class="controls">
                    <input type="date" name="data2" class="form-control">
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="data"><b>Pesquisar</b></label>
                <div class="controls">
                    <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i> Buscar</button>
                </div>
            </div>
    </div>  
    </form>
    </div>
</div>
    <a href="" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>
