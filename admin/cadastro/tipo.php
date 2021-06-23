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
  $tipo = "";

  //se nao existe o id
  if ( !isset ( $id ) ) $id = "";

  //verificar se existe um id
  if ( !empty ( $id ) ) {
  	//selecionar os dados do banco
  	$sql = "select * from tipo 
  		where id = ? limit 1";
  	$consulta = $pdo->prepare($sql);
  	$consulta->bindParam(1, $id); 
  	$consulta->execute();
  	$dados  = $consulta->fetch(PDO::FETCH_OBJ);
	  if( empty($dados) || is_null($dados)) { 
        echo"<script>swal('Atenção','Não existe esse Tipo de Produto','warning',{
            button : false ,
            });setTimeout(() => { 
            history.back();
        }, 1000);</script>";
        exit; 
         
    }

  	//separar os dados
  	$id 	= $dados->id;
  	$tipo 	= $dados->tipo;

  } 
?>
<div class="container">
<div class="card">
      <div class="card-header">
          <h3 class="float-left">Cadastro de Tipo de Produto</h3>
	<div class="float-right">
		<a href="cadastro/tipo" class="btn btn-success">Novo Tipo</a>
		<a href="listar/tipo" class="btn btn-secondary">Listar Tipo</a>
	</div>
	</div>
	<div class="card-body">

	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/tipo" data-parsley-validate>
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
		<label for="tipo">Tipo de Produto</label>
		<input type="text" name="tipo" id="tipo"
		class="form-control" placeholder="Digite o tipo" required
		data-parsley-required-message="Preencha este campo, por favor"
		value="<?=$tipo;?>">
	</div>
	</div>
	</div>
	</div>
		<a href="" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>

		<button type="submit" class="btn btn-outline-success margin">
			<i class="fas fa-check"></i> Salvar
		</button>

	</form>
	</div>

