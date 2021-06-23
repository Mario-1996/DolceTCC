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

?>

<div class="container" id="listagem">
<div class="card">
    <div class="card-header">
    <h3 class="float-left">Relatório de Caixa</h3>
    </div>
    <div class="card-body">
    <form name="filteay" action="relatorios/caixa" method="POST">

    <div class="form-row">
            <div class="form-group col-md-5">
                <label for="data"><b>Data Início</b></label>
                <div class="controls">
                    <input type="date" name="data1" class="form-control" required>
                </div>
                <br>
            </div>
            <div class="form-group col-md-5">
                <label for="data"><b>Data Final</b></label>
                <div class="controls">
                    <input type="date" name="data2" class="form-control" required>
                </div>
            </div>
            <div class="form-group col-md-2">
            <label><b>Pesquisar</b></label>
            <div class="controls">
                <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"> Buscar</i></button>
            </div>
            </div>

    </div>    
    </form>
    </div>
</div><br>
    <a href="paginas/home" class="btn btn-outline-danger"><i class="fa fa-chevron-left"></i> Voltar</a>
</div>