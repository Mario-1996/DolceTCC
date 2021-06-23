<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["dolce"]["id"] ) ){
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

  //iniciar as variaveis
  $modelo = "";

  //se nao existe o id
  if ( !isset ( $id ) ) $id = "";

  //verificar se existe um id
  if ( !empty ( $id ) ) {
  	//selecionar os dados do banco
  	$sql = "select * from modelo 
  		where id = ? limit 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(1, $id); 
  	$consulta->execute();
  	$dados  = $consulta->fetch(PDO::FETCH_OBJ);
	  if( empty($dados) || is_null($dados)) { 
        echo"<script>swal('Atenção','Não existe esse Modelo','warning',{
            button : false ,
            });setTimeout(() => { 
            history.back();
        }, 1000);</script>";
        exit; 
         
    }
  	//separar os dados
  	$id 	= $dados->id;
  	$modelo = $dados->modelo;

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

	<form name="formCadastro" method="post" action="salvar/modelo" data-parsley-validate>
	<div class="row">
        <div class="col-12 col-md-2">
			<label for="id">ID</label>
			<input type="text" name="id" id="id"
			class="form-control" readonly
			value="<?=$id;?>">
		</div>

		<div class="form-group col-md-2">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control" required data-parsley-required-message="Selecione uma opção"
                    value="<?=$status;?>">
                <option value="">Selecione</option>
                <option value="Ativo">Ativo</option>
                <option value="Inativo ">Inativo</option>
            </select>
            </div>
		<div class="col-12 col-md-6">
			<label for="modelo">Modelo de Produto</label>
			<input type="text" name="modelo" id="modelo"
			class="form-control" placeholder="Digite o Modelo" required
			data-parsley-required-message="Preencha este campo, por favor"
			value="<?=$modelo;?>">
		</div>
	</div>
	</div>
</div>
		<a href="" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>

		<button type="submit" class="btn btn-outline-success margin">
			<i class="fas fa-check"></i> Salvar
		</button>
	</form>
	

</div> <!-- container -->