<?php
//verificar se não está logado
if (!isset($_SESSION["dolce"]["id"])) {
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

// iniciando as variaveis para evitar erros
$titulo = $data = $quantidade = $valor = $descricao = $tipo_id = $modelo_id  = $foto = "";


//se nao existe o id
if ( !isset ( $id ) ) $id = "";

//verificar se existe um id
if ( !empty ( $id ) ) {
	//selecionar os dados do banco
	$sql = "SELECT *,  date_format(data, '%d/%m/%Y') data FROM produto 
		WHERE id = ? LIMIT 1";
	$consulta = $pdo->prepare($sql);
	$consulta->bindParam(1, $id); 
	//$id - linha 255 do index.php
	$consulta->execute();
	$dados  = $consulta->fetch(PDO::FETCH_OBJ);
	if( empty($dados) || is_null($dados)) { 
        echo"<script>swal('Atenção','Não existe esse Produto','warning',{
            button : false ,
            });setTimeout(() => { 
            history.back();
        }, 1000);</script>";
        exit; 
         
    }

		//separar os dados
		$id 		= $dados->id;
		$titulo		= $dados->titulo;
		$data 		= $dados->data;
		$quantidade = $dados->quantidade;
		$valor		= $dados->valor;
		$descricao 	= $dados->descricao;
		$tipo_id 	= $dados->tipo_id;
		$modelo_id 	= $dados->modelo_id;
		$foto 		= $dados->foto;

		$imagem = "../fotos/".$foto."p.jpg"; 
	} 

?>

<div class="container">
<div class="card">
    <div class="card-header">
          <h3 class="float-left">Cadastro de Produto</h3>
			<div class="float-right">
				<a href="cadastro/produto" class="btn btn-success">Novo Produto</a>
				<a href="listar/produto" class="btn btn-secondary">Listar Produtos</a>
			</div>
		</div>
	<div class="card-body">
	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/produto" data-parsley-validate enctype="multipart/form-data">

	<div class="row">

	<div class="col-12 col-md-2">
		<label for="id">ID</label>
		<input type="text" name="id" id="id" readonly class="form-control" value="<?= $id; ?>">
	</div>

	<div class="form-group col-md-2">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control " required data-parsley-required-message= "Selecione uma opção" 
                    value="<?=$status;?>">
                <option value="">Selecione</option> 
                <option value="A">Ativo</option>
                <option value="I">Inativo</option>
            </select>
        </div>

	<div class="col-12 col-md-4">
		<label for="titulo">Nome do Produto</label>
		<input type="text" name="titulo" id="titulo" class="form-control"  placeholder="Digite o Nome"
		 required data-parsley-required-message="Por favor, preencha o nome" value="<?= $titulo; ?>">
	</div>

	<div class="col-12 col-md-2">
		<label for="tipo_id">Tipo de Produto</label>
		<select name="tipo_id" id="tipo_id" class="form-control"
		 required data-parsley-required-message="Selecione uma opção" value="<?= $tipo_id; ?>">
			<option value="<?= $tipo; ?>"></option>
			<?php
			$sql = "select id, tipo from tipo
			order by tipo";
			$consulta = $pdo->prepare($sql);
			$consulta->execute();

			while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
				//separar os dados
				$id 	= $d->id;
				$tipo 	= $d->tipo;

				echo '<option value="' . $id . '">' . $tipo . '</option>';
			}

			?>
		</select>
		<script type="text/javascript">
			$("#tipo_id").val(<?=$tipo_id;?>);
		</script>
	</div>

	<div class="col-12 col-md-2">
		<label for="modelo_id">Modelo de Produto</label>
		<select name="modelo_id" id="modelo_id" class="form-control" 
		required data-parsley-required-message="Selecione um Modelo" value="<?= $modelo_id; ?>">
			<option value="<?= $modelo; ?>"></option>
			<?php
			$sql = "select id, modelo from modelo 
				order by modelo";
			$consulta = $pdo->prepare($sql);
			$consulta->execute();

			while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
				//separar os dados
				$id 	= $d->id;
				$modelo = $d->modelo;
				echo '<option value="' . $id . '">' . $modelo . '</option>';
			}
			?>
		</select>

		<script type="text/javascript">
			$("#modelo_id").val(<?=$modelo_id;?>);
		</script>

		<?php 
			$fhoto = ' required data-parsley-required-message="Selecione uma foto"';

			if ( !empty ( $id ) ) $fhoto = '';
		
		?>
	</div>

	<div class="col-12 col-md-5">
		<label for=" foto">Foto do Produto</label>
		<input type="file" name="foto" id="foto" class="form-control " placeholder="escolha uma foto"
		required data-parsley-required-message="Selecione uma foto"  accept=".jpeg" value="<?=$fhoto;?>">

	</div>

	<div class="col-12 col-md-2">
		<label for="quantidade">Quantidade</label>
		<input type="number" name="quantidade" id="quantidade" placeholder="Digite a Qtde" required data-parsley-required-message="Preencha Quantidade" 
		class="form-control" value="<?= $quantidade ?>">
	</div>

	<div class="col-12 col-md-3">
		<label for="data">Data de Lançamento</label>
		<input type="text" name="data" id="data" placeholder="Digite a Data de lançamento" required data-parsley-required-message="Preencha Lançamento"
		 class="form-control" value="<?= $data ?>">
	</div>

	<div class="col-12 col-md-2">
		<label for="valor">Valor Unitario</label>
		<input type="text" name="valor" id="valor" placeholder="Digite o Valor" required data-parsley-required-message="Preencha Valor"
		 class="form-control" value="<?=$valor ?>">
	</div>

	<div class="col-12 col-md-12">
		<label for="descricao">Descrição do Produto</label>
		<textarea name="descricao" id="resumo" required data-parsley-required-message="Preencha Descrição" 
		class="form-control" value=""><?= $descricao?></textarea>
	</div><br>
	</div>
</div>
</div>
		<a href="paginas/home" class="btn btn-outline-danger margin"><i class="fa fa-chevron-left"></i> Voltar</a>

		<button type="submit" class="btn btn-outline-success margin">
			<i class="fas fa-check"></i> Salvar
		</button>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#resumo').summernote();
		$('#valor').maskMoney({
			thousands: ".",
			decimal: ","
		});
		$('#data').inputmask("99/99/9999");
	})
</script>